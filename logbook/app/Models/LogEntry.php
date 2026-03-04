<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'severity',
        'logged_at',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
    ];

    // Available severity levels
    public static function severities(): array
    {
        return ['info', 'warning', 'error', 'critical'];
    }

    // Available categories
    public static function categories(): array
    {
        return ['General', 'Maintenance', 'Incident', 'Observation', 'Task', 'Other'];
    }

    // Severity badge color helper
    public function severityColor(): string
    {
        return match ($this->severity) {
            'info'     => 'blue',
            'warning'  => 'yellow',
            'error'    => 'red',
            'critical' => 'purple',
            default    => 'gray',
        };
    }
}
