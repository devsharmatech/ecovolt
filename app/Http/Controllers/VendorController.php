<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
use App\RouteHandle;
use Illuminate\Support\Facades\Log;

class VendorController extends Controller
{
    use RouteHandle;
    
    public function index()
    {
        $users = User::role('vendor')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
       
        return view($this->getRoutePrefix() .'.vendor.index', compact('users'));
    }

    public function create()
    {
        return view($this->getRoutePrefix() .'.vendor.create');
    }

    public function store(Request $request)
    {
        Log::info('📥 Vendor Store Request:', $request->all());
        
        $validated = $request->validate([
            // Personal Information
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Business Information
            'business_name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:50',
            'pan_number' => 'nullable|string|max:50',
            
            // Business Address
            'business_address' => 'nullable|string',
            'business_city' => 'nullable|string|max:100',
            'business_state' => 'nullable|string|max:100',
            'business_pincode' => 'nullable|digits:6',

            // Bank Details
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'account_holder_name' => 'nullable|string|max:255',
            
            // Documents
            'aadhar_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pan_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'gst_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bank_passbook' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            
            // Other
            'business_description' => 'nullable|string',
        ]);

        // Handle file uploads
        $fileFields = ['profile_picture', 'aadhar_card', 'pan_card', 'gst_certificate', 'bank_passbook'];
        
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                try {
                    $path = $request->file($field)->store('vendors/' . $field, 'public');
                    $validated[$field] = $path;
                    Log::info("📄 {$field} saved:", ['path' => $path]);
                } catch (\Exception $e) {
                    Log::error("❌ {$field} upload error: " . $e->getMessage());
                    return back()->withErrors([$field => 'File upload failed.'])->withInput();
                }
            } else {
                $validated[$field] = null;
            }
        }

        // Prepare user data
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'gender' => $validated['gender'],
            'profile_picture' => $validated['profile_picture'],
            'status' => 'active',
            
            // Business fields
            'business_name' => $validated['business_name'],
            'business_type' => $validated['business_type'] ?? null,
            'gst_number' => $validated['gst_number'] ?? null,
            'pan_number' => $validated['pan_number'] ?? null,
            'business_address' => $validated['business_address'] ?? null,
            'business_city' => $validated['business_city'] ?? null,
            'business_state' => $validated['business_state'] ?? null,
            'business_pincode' => $validated['business_pincode'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'account_number' => $validated['account_number'] ?? null,
            'ifsc_code' => $validated['ifsc_code'] ?? null,
            'account_holder_name' => $validated['account_holder_name'] ?? null,
            'aadhar_card' => $validated['aadhar_card'] ?? null,
            'pan_card' => $validated['pan_card'] ?? null,
            'gst_certificate' => $validated['gst_certificate'] ?? null,
            'bank_passbook' => $validated['bank_passbook'] ?? null,
            'business_description' => $validated['business_description'] ?? null,
            'verification_status' => 'pending',
        ];

        Log::info('📝 Final user data for vendor:', $userData);

        try {
            $user = User::create($userData);
            $user->assignRole('vendor');
            Log::info('✅ Vendor created:', ['id' => $user->id, 'email' => $user->email]);
        } catch (\Exception $e) {
            Log::error('❌ Database error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Database error: ' . $e->getMessage()])->withInput();
        }

        // Send welcome email
        try {
            Mail::to($user->email)->send(new WelcomeUserMail($user, $request->password));
            Log::info('📧 Welcome email sent to vendor: ' . $user->email);
        } catch (\Exception $e) {
            Log::error('❌ Email sending failed: ' . $e->getMessage());
        }

        return redirect()->route($this->getRoutePrefix() .'.vendors.index')
            ->with('success', 'Vendor created successfully' . (isset($e) ? ' but email could not be sent.' : ' and welcome email sent.'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view($this->getRoutePrefix() .'.vendor.edit', compact('user'));
    }

   public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        Log::info('📥 Vendor Update Request for ID ' . $user->id . ':', $request->all());
        
        $validated = $request->validate([
            // Personal Information
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'gender' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Business Information
            'business_name' => 'required|string|max:255',
            'business_type' => 'nullable|string|max:255',
            'gst_number' => 'nullable|string|max:50',
            'pan_number' => 'nullable|string|max:50',
            
            // Business Address
            'business_address' => 'nullable|string',
            'business_city' => 'nullable|string|max:100',
            'business_state' => 'nullable|string|max:100',
            'business_pincode' => 'nullable|string|max:10',
            
            // Bank Details
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:50',
            'ifsc_code' => 'nullable|string|max:20',
            'account_holder_name' => 'nullable|string|max:255',
            
            // Documents
            'aadhar_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pan_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'gst_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'bank_passbook' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            
            // Status
            'status' => 'required|in:active,inactive',
            
            // Other
            'business_description' => 'nullable|string',
        ]);
       

        // Handle file uploads
        $fileFields = [
            'profile_picture' => 'vendors/profile_pictures',
            'aadhar_card' => 'vendors/documents/aadhar',
            'pan_card' => 'vendors/documents/pan',
            'gst_certificate' => 'vendors/documents/gst',
            'bank_passbook' => 'vendors/documents/bank'
        ];
        
        $updateData = [
            'name' => $validated['name'],
            // Email को form से न लें - original email ही रखें
            'email' => $user->email, // यहाँ original email रखें
            'phone' => $validated['phone'],
            'gender' => $validated['gender'],
            'status' => $validated['status'],
            'business_name' => $validated['business_name'],
            'business_type' => $validated['business_type'] ?? null,
            'gst_number' => $validated['gst_number'] ?? null,
            'pan_number' => $validated['pan_number'] ?? null,
            'business_address' => $validated['business_address'] ?? null,
            'business_city' => $validated['business_city'] ?? null,
            'business_state' => $validated['business_state'] ?? null,
            'business_pincode' => $validated['business_pincode'] ?? null,
            'bank_name' => $validated['bank_name'] ?? null,
            'account_number' => $validated['account_number'] ?? null,
            'ifsc_code' => $validated['ifsc_code'] ?? null,
            'account_holder_name' => $validated['account_holder_name'] ?? null,
            'business_description' => $validated['business_description'] ?? null,
        ];

        foreach ($fileFields as $field => $folder) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                if ($user->$field) {
                    Storage::disk('public')->delete($user->$field);
                }
                
                // Upload new file
                $path = $request->file($field)->store($folder, 'public');
                $updateData[$field] = $path;
                Log::info("📄 {$field} updated:", ['path' => $path]);
            }
        }

        // Handle profile picture removal
        if ($request->has('remove_profile_picture') && $request->remove_profile_picture == '1') {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $updateData['profile_picture'] = null;
        }

        Log::info('📝 Update data for vendor:', $updateData);

        $user->update($updateData);

        return redirect()->route($this->getRoutePrefix() .'.vendors.index')
            ->with('success', 'Vendor updated successfully.');
    }

    public function show($id)
    {
       $user = User::findOrFail($id);
        return view($this->getRoutePrefix() .'.vendor.show', compact('user'));
    }

    public function destroy(User $user)
    {

        $fileFields = ['profile_picture', 'aadhar_card', 'pan_card', 'gst_certificate', 'bank_passbook'];
            
        foreach ($fileFields as $field) {
            if ($user->$field) {
                Storage::disk('public')->delete($user->$field);
            }
        }

        $user->delete();

        return redirect()->route($this->getRoutePrefix() .'.vendors.index')
            ->with('success', 'Vendor deleted successfully.');
    }


    // public function updateStatus(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);

    //     $request->validate([
    //         'status' => 'required|in:active,inactive'
    //     ]);

    //     // Status update
    //     $user->status = $request->status;
    //     $user->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Status updated successfully.'
    //     ]);
    // }


    public function verify(Request $request, User $user)
    {
        $request->validate([
            'verification_status' => 'required|in:verified,rejected',
            'verification_notes' => 'nullable|string'
        ]);

        $user->update([
            'verification_status' => $request->verification_status,
            'verification_notes' => $request->verification_notes
        ]);

        return redirect()->back()->with('success', 'Vendor verification status updated.');
    }
}