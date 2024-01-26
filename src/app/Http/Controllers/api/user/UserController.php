<?php

namespace App\Http\Controllers\api\user;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Controllers\Controller;
use App\Notifications\NewPassword;
use App\Notifications\DeleteUser;
use App\Models\User;
use App\Models\DeletionToken;
use App\helper\helper;
use Config;
use Auth;
use Validator;

class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'email' => 'required|email|unique:users',
            'password' => 'required|safe_password',
            'name' => 'required|string',
            'mobile' => 'required|string|min:10|max:15|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $newuser = new User();
        $newuser->name = $request->json('name');
        $newuser->email = $request->json('email');
        $newuser->password = Hash::make($request->json('password'));
        $newuser->mobile = $request->json('mobile');
        $newuser->type = "3";
        $newuser->login_type = "email";
        $newuser->image = "default.png";
        $newuser->is_available = "1";
        $newuser->is_verified = "1";
        $newuser->wallet = 0;
        $newuser->save();

        $token = $newuser->createToken('authToken')->plainTextToken;
        $newuser->token = $token;

        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $newuser], 200);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $user = User::where('email', $request->json('email'))->first();

        // if (!$user || !Hash::check($request->json('password'), $user->password)) {
        //     return response()->json(['message' => 'Invalid credentials'], 401);
        // }

        if($user->is_available != '1'){
            return response()->json(['message' => 'User blocked'], 423);
        }

        $user->tokens()->delete();
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    public function details(Request $request): JsonResponse
    {
        $user = Auth::user();
        $properties = [
            'id',
            'name',
            'email',
            'mobile',
            'location',
            'account_holder',
            'iban',
            'bank_name',
            'image',
            'login_type',
            'google_id',
            'type',
            'is_verified',
            'is_available'
        ];
        
        $filteredUser = new \stdClass();
        
        foreach ($properties as $property) {
            $filteredUser->{$property} = $user->{$property};
        }

        if($filteredUser->image == 'default.png') {
            $filteredUser->image = url(env('ASSETPATHURL') . 'storage/admin-assets/images/about/default.png');
        } else {
            $filteredUser->image = url(env('ASSETPATHURL') . 'storage/admin-assets/images/profile/' . $user->image);
        }
        
        return response()->json($filteredUser, 200);
    }
    
    public function googleAuthorization(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'id_token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $client = new \Google_Client();
        $payload = $client->verifyIdToken($request->json('id_token'));
        if ($payload) {
            $email = $payload['email'];

            $user = User::where('email', $email)->first();
            if ($user) {
                $token = $user->createToken('authToken')->plainTextToken;
            } else {
                $new_user = new User();
                $new_user->name = $payload['name'];
                $new_user->email = $email;
                $new_user->type = "3";
                $new_user->login_type = "google";
                $new_user->image = "default.png";
                $new_user->is_available = "1";
                $new_user->is_verified = "1";
                $new_user->wallet = 0;
                $new_user->save();

                $token = $new_user->createToken('authToken')->plainTextToken;
            }

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        } else {
            return response()->json(['message' => 'Could not verifiy identity'], 401);
        }
    }

    public function forgotPassword(Request $request): JsonResponse
    {   
        $validator = Validator::make($request->json()->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->json('email'))->first();

        if (!$user || $user->is_available != '1') {
            return response()->json(['message' => 'User not found'], 404);
        }
        
        try {
            $randomPassword = Str::random(16);
            $user->notify(new NewPassword($user->name, $randomPassword));

            $user->password = Hash::make($randomPassword);
            $user->save();

            return response()->json(['message' => 'Email sent'], 200);
        } catch (Throwable $e) {
            return response()->json(['message' => trans('messages.wrong')], 500);
        }
    }
    
    public function update(Request $request): JsonResponse
    {
        $user = User::find(Auth::user()->id);
        $validator = Validator::make($request->json()->all(), [
            'name' => 'sometimes|string',
            'mobile' => 'sometimes|string|min:10|max:15|unique:users,mobile,' . $user->id,
            'location' => 'sometimes|string',
            'account_holder' => 'sometimes|string',
            'iban' => 'sometimes|alpha_num|max:34',
            'bank_name' => 'sometimes|string',
            'image' => 'sometimes|base64image',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        $fieldsToUpdate = ['name', 'mobile', 'location', 'account_holder', 'iban', 'bank_name'];

        foreach ($fieldsToUpdate as $field) {
            if ($request->json()->has($field)) {
                $user->$field = $request->json($field);
            }
        }
        $user->save();

        if ($request->json()->has('image')) {
            $base64Image = $request->json('image');
            $decodedImage = base64_decode(preg_replace('/^data:image\/(\w+);base64,/', '', $base64Image));
            if ($decodedImage === false) {
                return response()->json(['status' => 0, 'message' => 'Could not save image'], 207);
            }
            $imageInfo = getimagesizefromstring($decodedImage);
            if ($imageInfo === false) {
                return response()->json(['status' => 0, 'message' => 'Could not save image'], 207);
            }
            
            $fileExtension = image_type_to_extension($imageInfo[2], false);
            $filename = 'profile-' . Str::uuid() . '.' . Str::slug($fileExtension);
            $path = storage_path("app/public/admin-assets/images/profile/{$filename}");
            file_put_contents($path, $decodedImage);
            $user->image = $filename;
            $user->save();
        }

        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $user = Auth::user();
        $validator = Validator::make($request->json()->all(), $request->rules());

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }
    
        $user->password = Hash::make($request->json('new_password'));
        $user->save();

        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }

    public function initiateDeletion(Request $request): JsonResponse
    {
        $user = Auth::user();
        $token = Str::random(64);
        $expiresAt = now()->addHours(24);

        $deletionToken = DeletionToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'expires_at' => $expiresAt,
        ]);

        $user->notify(new DeleteUser($user->name, $token));

        return response()->json(['status' => 1, 'message' => 'To delete your Lendr account, click on the link we’ll sent you on your email.'], 200);
    }
}
