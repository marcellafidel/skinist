<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_number',
        'total_price',
        'status',
        'shipping_address',
        'tracking_number',
        'payment_proof',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class)->orderBy('created_at', 'asc');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'Menunggu Pembayaran',
            'paid'      => 'Pembayaran Diterima',
            'shipped'   => 'Sedang Dikirim',
            'delivered' => 'Pesanan Diterima',
            'cancelled' => 'Dibatalkan',
            default     => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'   => '#F59E0B',
            'paid'      => '#3B82F6',
            'shipped'   => '#8B5CF6',
            'delivered' => '#10B981',
            'cancelled' => '#EF4444',
            default     => '#6B7280',
        };
    }

    public function isCancellable(): bool
    {
        return $this->status === 'pending';
    }

    public function addStatusHistory(string $status, ?string $note = null, ?int $changedBy = null): void
    {
        $this->statusHistories()->create([
            'status'     => $status,
            'note'       => $note,
            'changed_by' => $changedBy,
        ]);

        $this->notifyUser($status);
    }

    protected function notifyUser(string $status): void
    {
        $messages = [
            'pending'   => 'Pesananmu sedang menunggu pembayaran.',
            'paid'      => 'Pembayaranmu telah dikonfirmasi! Pesanan akan segera diproses.',
            'shipped'   => 'Pesananmu sedang dalam pengiriman.',
            'delivered' => 'Pesananmu telah diterima. Terima kasih telah berbelanja!',
            'cancelled' => 'Pesananmu telah dibatalkan.',
        ];

        \App\Models\Notification::create([
            'user_id' => $this->user_id,
            'title'   => 'Update Pesanan ' . $this->invoice_number,
            'message' => $messages[$status] ?? 'Status pesananmu telah diperbarui.',
            'type'    => 'order',
            'is_read' => false,
        ]);
    }
}