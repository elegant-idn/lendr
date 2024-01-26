<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductImage;
use Carbon\Carbon;
use Validator;

class OrderController extends Controller
{
    // Get the orders with products that I lended
    public function getMyOrders(Request $request): JsonResponse
    {
        $user = Auth::user();
        $myOrders = Order::with(['product.product_image'])
            ->where('user_id', $user->id)
            ->get();

        $myOrdersArray = [];

        foreach ($myOrders as $order) {
            $startDate = $order->start_date;
            $endDate = $order->end_date;
            $daysDiff = (new Carbon($startDate))->diffInDays(new Carbon($endDate)) + 1;

            $tempOrder = [
                'name' => $order->product->title,
                'price' => $order->product->raw_per_day_price,
                'photo' => $order->product->product_image->image,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'rented_days' => $daysDiff,
                'total_price' => $order->total_amount,
            ];

            array_push($myOrdersArray, $tempOrder);
        }

        return response()->json(['my_orders' => $myOrdersArray], 200);
    }

    // Get the orders with my products
    public function getMyProductOrders(Request $request): JsonResponse
    {
        $user = Auth::user();
        $myOrders = Order::join('product', 'orders.product_id', '=', 'product.id')
            ->where('product.vendor_id', $user->id)
            ->get();


        $myOrdersArray = [];

        foreach ($myOrders as $myOrder) {
            $startDate = Carbon::parse($myOrder->start_date);
            $endDate = Carbon::parse($myOrder->end_date);
            $product_image = ProductImage::find($myOrder->product_id);
            $daysDiff = $startDate->diffInDays($endDate) + 1;
            $product = $myOrder->product;

            if ($product) {

                $tempMyOrder = [
                    'name' => $myOrder->product->title,
                    'price' => $product->raw_per_day_price,
                    'photo' => $product_image->image,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'rented_days' => $daysDiff,
                    'total_price' => $myOrder->total_amount,
                ];

                array_push($myOrdersArray, $tempMyOrder);
            }
        }

        return response()->json(['my_product_orders' => $myOrdersArray], 200);
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
                $subQuery->whereBetween('orders.start_date', [$request->json('start_date'), $request->json('end_date')])
                         ->orWhereBetween('orders.end_date', [$request->json('start_date'), $request->json('end_date')])
                         ->orWhere(function ($subQuery) use ($request) {
                             $subQuery->where('orders.start_date', '<', $request->json('start_date'))
                                      ->where('orders.end_date', '>', $request->json('end_date'));
                         });
            })
            ->where(function ($subQuery) {
                $subQuery->where('orders.status', 'Succeeded')
                         ->orWhere('orders.created_at', '>', now()->subMinutes(30));
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

        $lendRequest = Order::find($request->json('lend_request_id'));

        if (!$lendRequest) {
            return response()->json(['error' => 'Lend request not found.'], 404);
        }

        Order::where('id', $request->json('lend_request_id'))
            ->update([
                'status' => 'Succeeded',
                'accepted_at' => Carbon::now()->toDateTimeString()
            ]);

        return response()->json(['message' => 'Lend request accepted successfully.']);
    }
}
