<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'role',
        'action',
        'module',
        'target_type',
        'target_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity.
     */
    public static function log(array $data): self
    {
        $request = request();
        
        return static::create([
            'user_id' => auth()->id(),
            'role' => auth()->user()?->role?->name ?? 'guest',
            'action' => $data['action'] ?? 'created',
            'module' => $data['module'],
            'target_type' => $data['target_type'] ?? null,
            'target_id' => $data['target_id'] ?? null,
            'description' => $data['description'] ?? '',
            'old_values' => $data['old_values'] ?? null,
            'new_values' => $data['new_values'] ?? null,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }

    /**
     * Log a creation activity.
     */
    public static function logCreated(string $module, string $description, ?Model $target = null): self
    {
        return static::log([
            'action' => 'created',
            'module' => $module,
            'target_type' => $target ? get_class($target) : null,
            'target_id' => $target?->id,
            'description' => $description,
            'new_values' => $target?->getAttributes(),
        ]);
    }

    /**
     * Log an update activity.
     */
    public static function logUpdated(string $module, string $description, Model $target, array $oldValues): self
    {
        return static::log([
            'action' => 'updated',
            'module' => $module,
            'target_type' => get_class($target),
            'target_id' => $target->id,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $target->getAttributes(),
        ]);
    }

    /**
     * Log a deletion activity.
     */
    public static function logDeleted(string $module, string $description, ?Model $target = null): self
    {
        return static::log([
            'action' => 'deleted',
            'module' => $module,
            'target_type' => $target ? get_class($target) : null,
            'target_id' => $target?->id,
            'description' => $description,
            'old_values' => $target?->getAttributes(),
        ]);
    }

    /**
     * Log an approval/rejection activity.
     */
    public static function logApproval(string $module, string $action, string $description, Model $target): self
    {
        return static::log([
            'action' => $action,
            'module' => $module,
            'target_type' => get_class($target),
            'target_id' => $target->id,
            'description' => $description,
            'new_values' => $target->fresh()?->getAttributes(),
        ]);
    }

    /**
     * Log an export activity.
     */
    public static function logExport(string $module, string $format): self
    {
        return static::log([
            'action' => 'export',
            'module' => $module,
            'description' => "Mengekspor {$module} ke format {$format}",
        ]);
    }

    /**
     * Scope untuk filter module.
     */
    public function scopeModule($query, string $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope untuk filter action.
     */
    public function scopeAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope untuk filter tanggal.
     */
    public function scopeDateRange($query, $startDate, $endDate = null)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate ?? now()]);
    }

    /**
     * Scope untuk search.
     */
    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('description', 'like', "%{$search}%")
              ->orWhere('module', 'like', "%{$search}%")
              ->orWhere('action', 'like', "%{$search}%");
        });
    }
}
