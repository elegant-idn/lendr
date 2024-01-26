<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Carbon\Carbon;
use Validator;

class ProductController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'per_day_price' => 'required|numeric',
            'contact_name' => 'required',
            'contact_mobile' => 'required|string|min:10|max:15',
            'contact_email' => 'required|email',
            'contact_location' => 'required',
            'service_image.*' => 'sometimes|base64image',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $check_slug = Product::where('slug', Str::slug($request->json('title'), '-'))->first();
        if (!empty($check_slug)) {
            $last_id = Product::select('id')->orderByDesc('id')->first();
            $slug = Str::slug($request->json('title') . ' ' . $last_id->id, '-');
        } else {
            $slug = Str::slug($request->json('title'), '-');
        }
        $newProduct = new Product();
        $newProduct->vendor_id = Auth::user()->id;
        $newProduct->title = $request->json('title');
        $newProduct->description = $request->json('description');
        $newProduct->additional_details = '';
        $newProduct->slug = $slug;
        $newProduct->category_id = $request->json('category_id');
        $newProduct->per_day_price = $request->json('per_day_price');
        $newProduct->minimum_booking_hour = 24;
        $newProduct->contact_name = $request->json('contact_name');
        $newProduct->contact_mobile = $request->json('contact_mobile');
        $newProduct->contact_email = $request->json('contact_email');
        $newProduct->contact_location = $request->json('contact_location');
        $newProduct->tax = '0';
        $newProduct->is_available = 0;
        $newProduct->save();

        if ($request->json()->has('service_image')) {
            $this->updateProductImages($newProduct->id, $request->json('service_image'));
        }
        $product_with_images = Product::with('product_image_api')->find($newProduct->id);
        return response()->json($product_with_images, 201);
    }

    public function update(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'product_id' => 'required|exists:product,id',
            'title' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'per_day_price' => 'required|numeric',
            'contact_name' => 'required|string',
            'contact_mobile' => 'required|string|min:10|max:15',
            'contact_location' => 'required|string',
            'service_image.*' => 'required|base64image',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();
        $product = Product::find($request->json('product_id'));

        if($product->vendor_id != $user->id){
            return response()->json(['status' => 0, 'message' => 'This is not one of your products'], 401);
        }

        $product->update([
            'title' => $request->json('title'),
            'category_id' => $request->json('category_id'),
            'description' => $request->json('description'),
            'per_day_price' => $request->json('per_day_price'),
            'contact_name' => $request->json('contact_name'),
            'contact_mobile' => $request->json('contact_mobile'),
            'contact_location' => $request->json('contact_location'),
            'is_available' => 0
        ]);

        if ($request->json()->has('service_image')) {
            ProductImage::where('product_id', $product->id)->delete();
            $this->updateProductImages($product->id, $request->json('service_image'));
        }

        return response()->json(['status' => 1, 'message' => 'Product updated successfully']);
    }

    // TODO
    // public function details(Request $request)
    // {
    //     if ($request->product_id == "") {
    //         return response()->json(["status" => 0, "message" => trans('messages.product_id_required')], 400);
    //     }

    //     $product = Product::with('category_info', 'fetures_info', 'multi_image_api')->where('is_available', 1)->whereNot('is_deleted', 1)->where('id', $request->product_id)->first();

    //     $relatedproducts = Product::with('category_info', 'fetures_info', 'product_image_api')->where('is_available', 1)->whereNot('is_deleted', 1)->whereNot('id', $request->product_id)->get();
        
    //     return response()->json(["status" => 1, "message" => trans('messages.success'), 'product' =>  $product, 'relatedproducts' =>  $relatedproducts], 200);
    // }

    public function list(Request $request): JsonResponse
    {
        $products = Product::with('category_info', 'fetures_info', 'product_image_api')->where('is_available', 1)->whereNot('is_deleted', 1);

        $products = $products->get();
        if (empty($products)) {
            return response()->json(["status" => 1, "message" => trans('messages.no_data')], 200);
        }
        return response()->json(['products' =>  $products], 200);
    }

    public function getFavourite(Request $request): JsonResponse
    {
        $user = Auth::user();

        return response()->json(['products' => $user->favorite_products()->with('product_image_api')->where('is_available', 1)->whereNot('is_deleted', 1)->get()], 200);
    }
    
    public function setFavourite(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'product_id' => 'required|exists:product,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();
        $product_id = $request->json('product_id');

        if (!$user->favorite_products()->where('product_id', $product_id)->exists()) {
            Product::where('id', $product_id)->increment('favourites');
            $user->favorite_products()->syncWithoutDetaching([$product_id]);

            return response()->json(['status' => 1, 'message' => 'Product marked as favorite'], 200);
        }

        return response()->json(['status' => 0, 'message' => 'Product is already in favorites'], 200);
    }

    public function deleteFavourite(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();
        $product_id = $request->json('product_id');

        if ($user->favorite_products()->where('product_id', $product_id)->exists()) {
            Product::where('id', $product_id)->decrement('favourites');
            $user->favorite_products()->detach($product_id);

            return response()->json(['status' => 1, 'message' => 'Product not marked as favorite anymore'], 200);
        }
        return response()->json(['status' => 0, 'message' => 'Product is not in favorites'], 200);
    }

    public function getViewed(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'products_number' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();
        $products_number = $request->products_number ?? 6;

        $viewed_products = $user->viewed_products()
                            ->where('is_available', 1)
                            ->whereNot('is_deleted', 1)
                            ->groupBy('product_id')
                            ->orderByPivot('created_at', 'desc')
                            ->with('product_image_api')
                            ->take($products_number)
                            ->get();

        return response()->json(['products' => $viewed_products], 200);
    }

    public function setViewed(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'product_id' => 'required|exists:product,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $user = Auth::user();
        $product_id = $request->json('product_id');
        $last_viewed_product = $user->viewed_products()->withPivot('created_at')->latest('pivot_created_at')->first();

        if(!$user->viewed_products()->where('product_id', $product_id)->exists()) {
            Product::where('id', $product_id)->increment('views');
        }

        if (!$last_viewed_product || $last_viewed_product->id != $product_id) {
            $user->viewed_products()->attach($product_id);
            return response()->json(['status' => 1, 'message' => 'Product marked as viewed'], 200);
        }
        return response()->json(['status' => 0, 'message' => 'The product is already the last viewed product'], 200);
    }

    public function getRecommended(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'products_number' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $user = Auth::user();
        $products_number = $request->products_number ?? 6;

        $categories = $user->viewed_products()
                    ->where('is_available', 1)
                    ->whereNot('is_deleted', 1)
                    ->select('category_id')
                    ->groupBy('category_id')
                    ->pluck('category_id');

        if ($categories->isEmpty()) {
            $random_products = Product::with('product_image_api')
                                ->inRandomOrder()
                                ->where('is_available', 1)
                                ->whereNot('is_deleted', 1)
                                ->take($products_number)
                                ->get();
        } else {
            $random_products = Product::with('product_image_api')
                                ->where('is_available', 1)
                                ->whereNot('is_deleted', 1)
                                ->whereIn('category_id', $categories)
                                ->inRandomOrder()
                                ->take($products_number)
                                ->get();
        }
    
        return response()->json(['products' => $random_products], 200);
    }

    public function createLendRequest(Request $request): JsonResponse
    {
        $delivery_options = implode(',', array_values(config('delivery.options')));

        $validator = Validator::make($request->json()->all(), [
            'product_id' => 'required|exists:product,id',
            'delivery_preference' => 'required|in:' . $delivery_options,
            'state' => 'required_if:delivery_preference,1',
            'city' => 'required_if:delivery_preference,1',
            'address' => 'required_if:delivery_preference,1',
            'zip' => 'sometimes|regex:/^\d{5}(-\d{4})?$/',
            'contact_name' => 'required_if:delivery_preference,1',
            'contact_mobile' => 'required_if:delivery_preference,1|string|min:10|max:15',
            'contact_email' => 'sometimes|email',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $product = Product::find($request->json('product_id'));

        $overlaps = $product->requested_by_users()
        ->where(function ($query) use ($request) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->whereBetween('user_lent_products.start_date', [$request->json('start_date'), $request->json('end_date')])
                         ->orWhereBetween('user_lent_products.end_date', [$request->json('start_date'), $request->json('end_date')])
                         ->orWhere(function ($subQuery) use ($request) {
                             $subQuery->where('user_lent_products.start_date', '<', $request->json('start_date'))
                                      ->where('user_lent_products.end_date', '>', $request->json('end_date'));
                         });
            })
            ->where(function ($subQuery) {
                $subQuery->where('user_lent_products.accepted', 1)
                         ->orWhere('user_lent_products.created_at', '>', now()->subMinutes(30));
            });
        })
        ->exists();

        if ($overlaps) {
            return response()->json(['error' => 'The requested date range overlaps with an existing lend request.'], 409);
        }

        $startDate = Carbon::parse($request->json('start_date'));
        $endDate = Carbon::parse($request->json('end_date'));

        $daysDiff = $startDate->diffInDays($endDate) + 1;
        $totalAmount = $daysDiff * $product->per_day_price;
        $totalProductAmount = $daysDiff * $product->raw_per_day_price;
        $totalCommissionAmount = $daysDiff * $product->per_day_commission;

        $user = Auth::user();
        $user->requested_products()->attach($request->json('product_id'), [
            'delivery_preference' => $request->json('delivery_preference'),
            'state' => $request->json('delivery_preference') == 1 ? $request->json('state') : null,
            'city' => $request->json('delivery_preference') == 1 ? $request->json('city') : null,
            'address' => $request->json('delivery_preference') == 1 ? $request->json('address') : null,
            'zip' => $request->json('delivery_preference') == 1 ? $request->json('zip') : null,
            'contact_name' => $request->json('delivery_preference') == 1 ?  $request->json('contact_name') : null,
            'contact_mobile' => $request->json('delivery_preference') == 1 ?  $request->json('contact_mobile') : null,
            'contact_email' => $request->json('delivery_preference') == 1 ?  $request->json('contact_email') : null,
            'start_date' => $request->json('start_date'),
            'end_date' => $request->json('end_date'),
            'total_amount' => $totalAmount,
            'total_product_amount' => $totalProductAmount,
            'total_commission_amount' => $totalCommissionAmount
        ]);

        $lend_request_object = $user->requested_products()
                            ->newPivotStatement()
                            ->where('user_id', $user->id)
                            ->where('product_id', $request->json('product_id'))
                            ->where('start_date', $request->json('start_date'))
                            ->where('end_date', $request->json('end_date'))
                            ->orderBy('created_at', 'desc')
                            ->first();

        return response()->json($lend_request_object, 200);
    }

    public function acceptLendRequest(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'lend_request_id' => 'required|exists:user_lent_products,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $lendRequest = DB::table('user_lent_products')->find($request->json('lend_request_id'));

        if (!$lendRequest) {
            return response()->json(['error' => 'Lend request not found.'], 404);
        }

        DB::table('user_lent_products')->where('id', $request->json('lend_request_id'))->update(['accepted' => 1, 'accepted_at' => Carbon::now()->toDateTimeString()]);

        return response()->json(['message' => 'Lend request accepted successfully.']);
    }

    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'sometimes|numeric',
            'search_term' => 'sometimes|string',
            'contact_location' => 'sometimes|string',
            'min_per_day_price' => 'sometimes|numeric',
            'max_per_day_price' => 'sometimes|numeric',
            'sort' => 'sometimes|in:newest,cheapest,most_expensive'
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $query = Product::select('product.*')
            ->join('settings', 'settings.id', '=', DB::raw(1))
            ->where('is_available', 1)
            ->whereNot('is_deleted', 1);
    
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    
        if ($request->filled('search_term')) {
            $query->where('title', 'like', '%' . $request->search_term . '%');
        }
    
        if ($request->filled('contact_location')) {
            $query->where('contact_location', 'like', '%' . $request->contact_location . '%');
        }
    
        $query->whereRaw('
            CASE 
                WHEN settings.commission_type = 1 THEN per_day_price + (per_day_price * settings.commission_value / 100)
                WHEN settings.commission_type = 2 THEN per_day_price + settings.commission_value
                ELSE per_day_price
            END BETWEEN ? AND ?',
            [$request->min_per_day_price ?? 0, $request->max_per_day_price ?? PHP_INT_MAX]
        );
        
        $sortColumn = 'created_at';
        $sortDirection = 'asc';
        
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'cheapest':
                    $sortColumn = 'per_day_price';
                    break;
        
                case 'most_expensive':
                    $sortColumn = 'per_day_price';
                    $sortDirection = 'desc';
                    break;
        
                case 'newest':
                    $sortColumn = 'created_at';
                    $sortDirection = 'desc';
                    break;
            }
        }
    
        $products = $query->orderBy($sortColumn, $sortDirection)->with('product_image_api')->get();
    
        return response()->json(['products' => $products], 200);
    }

    public function getPersonal(Request $request): JsonResponse
    {
        $user = Auth::user();
        $products = Product::where('vendor_id', $user->id)->with('product_image_api')->get();
        return response()->json(['products' =>  $products], 200);
    }

    public function deactivatePersonal(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'product_id' => 'required|exists:product,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();

        $product = Product::find($request->json('product_id'));
        if($product->vendor_id != $user->id){
            return response()->json(['status' => 0, 'message' => 'This is not one of your products'], 401);
        }

        $product->update(['is_deleted' => 1]);
        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }

    public function activatePersonal(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'product_id' => 'required|exists:product,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = Auth::user();

        $product = Product::find($request->json('product_id'));
        if($product->vendor_id != $user->id){
            return response()->json(['status' => 0, 'message' => 'This is not one of your products'], 401);
        }

        $product->update(['is_deleted' => 0, 'is_available' => 0]);
        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }

    protected function updateProductImages($productId, $base64Images)
    {
        foreach ($base64Images as $base64Image) {
            $decodedImage = base64_decode(preg_replace('/^data:image\/(\w+);base64,/', '', $base64Image));
            if ($decodedImage === false) {
                return response()->json(['status' => 0, 'message' => 'Could not save image'], 207);
            }
            $imageInfo = getimagesizefromstring($decodedImage);
            if ($imageInfo === false) {
                return response()->json(['status' => 0, 'message' => 'Could not save image'], 207);
            }

            $fileExtension = image_type_to_extension($imageInfo[2], false);
            $filename = 'product-' . Str::uuid() . '.' . Str::slug($fileExtension);
            $path = storage_path("app/public/admin-assets/images/product/{$filename}");
            file_put_contents($path, $decodedImage);
            $image = new ProductImage();
            $image->product_id = $productId;
            $image->image = $filename;
            $image->save();
        }
    }
}
