<?php
use App\Services\ActivityLogService;

if (!function_exists('activity_log')) {

    /**
     * Log system activities for users and staff
     *
     * @param string $action
     * @param string $module
     * @param array|null $details
     * @return void
     */
    function activity_log(string $action, string $module, ?array $details = null): void
    {
        ActivityLogService::log($action, $module, $details);
    }

}