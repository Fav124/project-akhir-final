<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait HasActivityLog
{
    public static function bootHasActivityLog()
    {
        static::created(function ($model) {
            $model->logActivity('created', "Membuat " . $model->getActivityDescription());
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            // Remove timestamps and common fields from changes display if needed
            unset($changes['updated_at']);
            
            if (!empty($changes)) {
                $model->logActivity('updated', "Memperbarui " . $model->getActivityDescription(), $changes);
            }
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted', "Menghapus " . $model->getActivityDescription());
        });
    }

    public function logActivity($action, $description, $details = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'description' => $description,
            'details' => $details
        ]);
    }

    /**
     * Override this in models for better description
     */
    public function getActivityDescription(): string
    {
        return class_basename($this) . " #{$this->id}";
    }
}
