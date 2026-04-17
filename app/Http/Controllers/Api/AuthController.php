<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'role' => 'required|string|in:customer,employee,dealer',
            'consumer_id' => 'nullable|string',
            'service_address' => 'required_if:role,customer|string|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $otp = rand(1000, 9999);
        $password = $request->password ?: bin2hex(random_bytes(8));

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower(trim($request->email)),
            'phone' => $request->phone,
            'password' => Hash::make($password),
            'consumer_id' => $request->consumer_id,
            'service_address' => $request->service_address,
            'otp' => $otp,
            'is_verified' => false,
            'status' => 'pending'
        ]);

        $role = \Spatie\Permission\Models\Role::where('name', $request->role)->where('guard_name', 'api')->first();
        if ($role) {
            $user->assignRole($role);
        }

        // Notify Admins
        $admins = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->get();
        foreach ($admins as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->id,
                'title' => 'New ' . ucfirst($request->role) . ' Registered',
                'description' => "A new {$request->role} named {$user->name} has registered.",
                'type' => 'alert',
            ]);
        }

        // Send OTP via Mail
        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {
            // Silently fail or log if mail server not configured
        }

        return response()->json([
            'message' => 'Registration successful. Please verify the 4-digit OTP sent to your email.',
            'email' => $user->email
        ], 201);
    }

    public function sendLoginOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();
        $otp = rand(1000, 9999);
        
        $user->otp = $otp;
        $user->save();
        Log::info('Login OTP generated', ['email' => $user->email, 'otp' => $otp]);

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {}

        return response()->json([
            'message' => 'OTP sent successfully.',
            'email' => $user->email
        ], 200);
    }

    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $email = strtolower(trim($request->email));
        $user = User::where('email', $email)->first();
        $otp = rand(1000, 9999);
        
        $user->otp = $otp;
        $user->save();

        try {
            Mail::to($user->email)->send(new SendOtpMail($otp));
        } catch (\Exception $e) {}

        return response()->json([
            'message' => 'A new OTP has been sent to your email.',
            'email' => $user->email
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $email = strtolower(trim($request->email));
        $otp = trim($request->otp);

        Log::info('Verifying OTP', ['email' => $email, 'otp' => $otp]);

        $user = User::where('email', $email)->where('otp', $otp)->first();

        if (!$user) {
            Log::warning('OTP Verification Failed', ['email' => $email, 'otp' => $otp]);
            return response()->json(['message' => 'Invalid OTP or email.'], 401);
        }

        $user->is_verified = true;
        $user->otp = null; // Clear OTP after verification
        $user->status = 'active';
        $user->save();

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'OTP verified successfully.',
            'token' => $token,
            'user' => $user->load('roles')
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = auth('api')->user();

        if (!$user->is_verified) {
            // Resend OTP if not verified
            $otp = rand(1000, 9999);
            $user->otp = $otp;
            $user->save();
            
            try {
                Mail::to($user->email)->send(new SendOtpMail($otp));
            } catch (\Exception $e) {}

            return response()->json([
                'message' => 'Account not verified. A new OTP has been sent to your email.',
                'needs_verification' => true,
                'email' => $user->email
            ], 403);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth('api')->user()->load('roles'));
    }

    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'service_address' => 'nullable|string',
            'consumer_id' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->name) $user->name = $request->name;
        if ($request->phone) $user->phone = $request->phone;
        if ($request->service_address) $user->service_address = $request->service_address;
        if ($request->consumer_id) $user->consumer_id = $request->consumer_id;

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('uploads/profile');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file->move($path, $filename);
            $user->profile_picture = 'uploads/profile/' . $filename;
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user->load('roles')
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()->load('roles')
        ]);
    }
}
