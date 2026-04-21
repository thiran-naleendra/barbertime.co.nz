<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'service_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'barber_name',
        'booking_start_at',
        'notes',
        'status',
        'booking_fee',
        'currency',
    ];

    protected $casts = [
        'booking_start_at' => 'datetime',
        'booking_fee' => 'decimal:2',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function getServicePriceAttribute(): float
    {
        return (float) ($this->service?->price ?? 0);
    }

    public function getTotalCostAttribute(): float
    {
        return $this->service_price + (float) $this->booking_fee;
    }

    public function getRemainingBalanceAttribute(): float
    {
        // If booking_fee is a deposit (paid later), remaining = service price
        // If you want remaining = total - booking_fee (deposit), use:
        // return max(0, $this->total_cost - (float) $this->booking_fee);

        return $this->service_price;
    }
}
