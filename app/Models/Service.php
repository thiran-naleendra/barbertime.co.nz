<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_minutes',
        'is_active',
        'image_path', // ✅ added
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // ✅ Optional helper: $service->image_url
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) return null;
        return Storage::url($this->image_path); // /storage/services/xxx.jpg
    }
}
