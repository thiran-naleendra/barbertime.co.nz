<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Barber extends Model
{
    protected $fillable = [
        'name',
        'image_path',
        'is_active',
        'sort_order',
        'work_start_time',
        'work_end_time',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    public function getWorkingHoursLabelAttribute(): string
    {
        return substr((string) $this->work_start_time, 0, 5) . ' - ' . substr((string) $this->work_end_time, 0, 5);
    }
}
