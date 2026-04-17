<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Add this
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
use App\RouteHandle;

class UserController extends Controller
{
    use RouteHandle;
    
    public function index(Request $request)
    {
        $roles = Role::all();

        $requestedRole = $request->query('role', 'user');

        $users = User::whereHas('roles', function($q) use ($requestedRole) {
            $q->where('name', $requestedRole);
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $roleColors = [
            'admin' => 'danger',
            'vendor' => 'warning',
            'user' => 'info',
        ];

        return view($this->getRoutePrefix() .'.users.index', compact('users', 'roleColors', 'requestedRole'));
    }

    public function create(Request $request)
    {
        $requestedRole = $request->query('role', 'user');

        $prefix = 'USR-';
        if ($requestedRole === 'Accounts') {
            $prefix = 'ACC-';
        } elseif ($requestedRole === 'Dealer') {
            $prefix = 'DEA-';
        } elseif ($requestedRole === 'Employee') {
            $prefix = 'EMP-';
        } elseif ($requestedRole === 'Customer') {
            $prefix = 'CUS-';
        }

        $lastUser = User::where('user_code', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        if ($lastUser && preg_match('/' . $prefix . '(\d+)/', $lastUser->user_code, $matches)) {
            $nextIdNum = intval($matches[1]) + 1;
        } else {
            $nextIdNum = 1;
        }
        $nextId = $prefix . str_pad($nextIdNum, 3, '0', STR_PAD_LEFT);

        return view($this->getRoutePrefix() .'.users.create', compact('requestedRole', 'nextId'));
    }

    public function store(Request $request)
    {
        Log::info('📥 FORM SUBMIT DATA:', $request->all());
        Log::info('📁 FILE UPLOADED:', ['has_file' => $request->hasFile('profile_picture')]);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'locality' => 'nullable|string', 
            'gender' => 'nullable|in:male,female,other',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // Dealer Specific Fields Validation
            'business_name' => 'nullable|string|max:255',
            'business_type' => 'nullable|string|max:100',
            'gst_number' => 'nullable|string|max:50',
            'pan_number' => 'nullable|string|max:50',
            'business_address' => 'nullable|string',
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'ifsc_code' => 'nullable|string|max:50',
            'account_holder_name' => 'nullable|string|max:255',
        ]);

        Log::info('✅ VALIDATED DATA:', $validated);

        // Save plain password before hashing
        $plainPassword = $request->password;
        
        // Profile Picture Handle
        if ($request->hasFile('profile_picture')) {
            try {
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $validated['profile_picture'] = $path;
                Log::info('📸 Profile Picture Saved:', ['path' => $path]);
            } catch (\Exception $e) {
                Log::error('❌ Profile Picture Error: ' . $e->getMessage());
                return back()->withErrors(['profile_picture' => 'Image upload failed.'])->withInput();
            }
        }

        // ✅ IMPORTANT: Ensure all nullable fields are present in the array
        $dataToStore = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'locality' => $validated['locality'] ?? null,
            'profile_picture' => $validated['profile_picture'] ?? null,
            'status' => 'active',
            // Default mapping
            'business_name' => $validated['business_name'] ?? null,
            'business_type' => $validated['business_type'] ?? null,
            'gst_number' => $validated['gst_number'] ?? null,
            'pan_number' => $validated['pan_number'] ?? null,
            'business_address' => $validated['business_address'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'account_number' => $validated['account_number'] ?? null,
            'ifsc_code' => $validated['ifsc_code'] ?? null,
            'account_holder_name' => $validated['account_holder_name'] ?? null,
        ];

        // Generate user_code based on role directly
        $roleToAssign = $request->input('role', 'user');
        $prefix = 'USR-';
        if ($roleToAssign === 'Accounts') {
            $prefix = 'ACC-';
        } elseif ($roleToAssign === 'Dealer') {
            $prefix = 'DEA-';
        } elseif ($roleToAssign === 'Employee') {
            $prefix = 'EMP-';
        } elseif ($roleToAssign === 'Customer') {
            $prefix = 'CUS-';
        }

        $lastUser = User::where('user_code', 'like', $prefix . '%')->orderBy('id', 'desc')->first();
        if ($lastUser && preg_match('/' . $prefix . '(\d+)/', $lastUser->user_code, $matches)) {
            $nextIdNum = intval($matches[1]) + 1;
        } else {
            $nextIdNum = 1;
        }
        $dataToStore['user_code'] = $prefix . str_pad($nextIdNum, 3, '0', STR_PAD_LEFT);


        try {
            $user = User::create($dataToStore);
            Log::info('✅ USER CREATED:', ['id' => $user->id, 'email' => $user->email]);
        } catch (\Exception $e) {
            Log::error('❌ DATABASE ERROR: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Database error: ' . $e->getMessage()])->withInput();
        }

        // Assign dynamically requested role, bypassing Spatie strict guards
        $roleToAssign = $request->input('role', 'user');
        $roleInfo = Role::where('name', $roleToAssign)->first();
        if ($roleInfo) {
            $user->roles()->attach($roleInfo);
        } else {
            $user->assignRole('user'); // fallback
        }

        // Send welcome email
        $emailSent = false;
        try {
            Mail::to($user->email)->send(new WelcomeUserMail($user, $plainPassword));
            $emailSent = true;
            Log::info('📧 Email sent successfully to: ' . $user->email);
        } catch (\Exception $e) {
            Log::error('❌ Email sending failed: ' . $e->getMessage());
            $emailSent = false;
        }

        $successMessage = 'User created successfully';
        if ($emailSent) {
            $successMessage .= ' and welcome email sent.';
        } else {
            $successMessage .= ' but email could not be sent.';
        }

        return redirect()->route($this->getRoutePrefix() .'.users.index', ['role' => $roleToAssign])
            ->with('success', $successMessage);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'locality' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Prepare update data
        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'locality' => $validated['locality'] ?? null,
        ];

        // Profile Picture Handle
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $updateData['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        // Password Handle
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $updateData['password'] = Hash::make($request->password);
        }
        $user->update($updateData);


        $roleName = $user->roles->first() ? $user->roles->first()->name : 'user';

        return redirect()->route($this->getRoutePrefix() .'.users.index', ['role' => $roleName])
            ->with('success', 'User updated successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $roleName = $user->roles->first() ? $user->roles->first()->name : 'user';
        return view($this->getRoutePrefix() .'.users.edit', compact('user', 'roles', 'roleName'));
    }

    

    public function destroy(User $user)
    {
        $roleName = $user->roles->first() ? $user->roles->first()->name : 'user';
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }
        $user->delete();

        return redirect()->route($this->getRoutePrefix() .'.users.index', ['role' => $roleName])->with('success', 'User deleted successfully.');
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $user->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.'
        ]);
    }

    public function show(User $user)
    {
        $roleName = $user->roles->first() ? $user->roles->first()->name : 'user';
        return view($this->getRoutePrefix() .'.users.show', compact('user', 'roleName'));
    }
}