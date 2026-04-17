<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NotificationSetting;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\RouteHandle;

class NotificationSettingController extends Controller
{
    use RouteHandle;
    
    protected $notificationService;
    
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    
    public function index()
    {
        $settings = NotificationSetting::all();
        
        return view($this->getRoutePrefix() .'.notifications.index', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'settings' => 'required|array'
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->settings as $id => $data) {
                $setting = NotificationSetting::findOrFail($id);
                
                // Debugging ke liye log
                Log::info('Updating setting:', [
                    'id' => $id,
                    'data' => $data
                ]);
                
                $setting->update([
                    'alert_trigger' => $data['alert_trigger'] ?? $setting->alert_trigger,
                    'recipient' => $data['recipient'] ?? $setting->recipient,
                    'frequency' => $data['frequency'] ?? $setting->frequency,
                    'is_active' => isset($data['is_active']) ? 1 : 0
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update notification settings: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update settings: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Show test notification form
     */
    public function showTestForm()
    {
        $triggers = [
            'Document Overdue',
            'Document Approval Required',
            'System Maintenance'
        ];
        
        $channels = [
            'database' => 'Database Notification',
            'mail' => 'Email',
            'mail,database' => 'Both Email & Database'
        ];
        
        $recipientTypes = [
            'Admin User' => 'Admin Users',
            'Super Admin' => 'Super Admin',
            'Document Manager' => 'Document Managers',
            'All Users' => 'All Users'
        ];
        
        return view($this->getRoutePrefix() .'.notifications.test', compact('triggers', 'channels', 'recipientTypes'));
    }
    
    /**
     * Send test notification from UI
     */
    public function sendTestNotification(Request $request)
    {
        $request->validate([
            'trigger' => 'required|string',
            'channels' => 'required|string',
            'recipient_type' => 'required|string',
            'test_email' => 'nullable|email'
        ]);
        
        // Prepare test data
        $testData = [
            'document_id' => rand(100, 999),
            'document_title' => 'Test Document - ' . now()->format('Y-m-d H:i:s'),
            'due_date' => now()->addDays(7)->format('Y-m-d'),
            'test_mode' => true,
            'trigger' => $request->trigger,
            'channels' => $request->channels
        ];
        
        // Add extra data based on trigger
        switch ($request->trigger) {
            case 'Document Approval Required':
                $testData['submitted_by'] = 'Test User';
                $testData['url'] = url('/documents/test');
                break;
                
            case 'System Maintenance':
                $testData['schedule_time'] = now()->addDay()->format('Y-m-d H:i:s');
                $testData['duration'] = '2 hours';
                $testData['impact'] = 'Service will be temporarily unavailable';
                break;
        }
        
        // Send notification
        $result = $this->notificationService->testNotification(
            $request->trigger, 
            $request->test_email
        );
        
        if ($result['success']) {
            // Also send to specific channels
            if (str_contains($request->channels, 'mail')) {
                // Email sending logic here
                Log::info("Test email would be sent to: " . ($request->test_email ?: 'configured recipients'));
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Test notification sent successfully!',
                'data' => $testData
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to send test notification: ' . $result['message']
        ], 500);
    }
    
  
    public function testNotification(Request $request)
    {
        $request->validate([
            'trigger' => 'required|string',
            'test_email' => 'nullable|email'
        ]);
        
        $result = $this->notificationService->testNotification(
            $request->trigger,
            $request->test_email
        );
        
        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => $result['data']
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => $result['message']
        ], 500);
    }

    public function testForm()
    {
        return view($this->getRoutePrefix() . '.notifications.test');
    }
}