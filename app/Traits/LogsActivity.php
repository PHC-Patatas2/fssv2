<?php
namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public function logActivity($action, $entityType = null, $entityId = null, $description = null)
    {
        $username = Auth::user() ? Auth::user()->name : 'System';
        ActivityLog::create([
            'username' => $username,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'description' => $description,
        ]);
    }
}
