<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class ActivityLogService
{
    /**
     * Log a user activity
     *
     * @param string $action
     * @param string|null $module
     * @param array|null $details
     * @return void
     */
    public static function log(string $action, ?string $module = null, ?array $details = null): void
    {
        try {

            if (!Auth::check()) {
                return;
            }

            $user = Auth::user();

            // Skip logging for admin if required
            if ($user->role === 'admin') {
                return;
            }

            ActivityLog::create([
                'user_id'    => $user->id,
                'action'     => $action,
                'module'     => $module,
                'details'    => $details,
                'ip_address' => request()->ip(),
                'device'     => substr(request()->userAgent(), 0, 255),
            ]);

        } catch (Throwable $e) {

            // Prevent activity logging from breaking the application
            Log::error('Activity logging failed', [
                'action' => $action,
                'error'  => $e->getMessage(),
            ]);

        }
    }
}