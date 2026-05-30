<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'value', 'min_purchase', 'max_uses', 'used_count', 'is_active', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid($totalPrice)
    {
        if (!$this->is_active) return false;
        if ($this->used_count >= $this->max_uses) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($totalPrice < $this->min_purchase) return false;
        return true;
    }

    public function calculateDiscount($totalPrice)
    {
        if ($this->type === 'percent') {
            return $totalPrice * ($this->value / 100);
        }
        return min($this->value, $totalPrice);
    }
}