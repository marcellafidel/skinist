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
        'shipping_courier',
        'shipping_cost',
        'tracking_number',
        'payment_proof',
        'payment_method',
    ];

    /**
     * Daftar kurir yang tersedia beserta nama tampilan, estimasi, dan tarifnya.
     */
    public static function couriers(): array
    {
        return [
            'jne' => ['name' => 'JNE Reguler', 'eta' => '3-4 hari', 'cost' => 15000],
            'jnt' => ['name' => 'J&T Express', 'eta' => '2-3 hari', 'cost' => 13000],
            'sicepat' => ['name' => 'SiCepat Reguler', 'eta' => '2-4 hari', 'cost' => 12000],
        ];
    }

    public function getCourierNameAttribute(): string
    {
        return self::couriers()[$this->shipping_courier]['name'] ?? '-';
    }

    /**
     * Daftar metode pembayaran yang tersedia beserta detail tujuannya.
     */
    public static function paymentMethods(): array
    {
        return [
            'bca' => [
                'name' => 'Transfer Bank BCA',
                'icon' => '🏦',
                'detail' => 'BCA — 1234567890 a/n Skinist Store',
            ],
            'bni' => [
                'name' => 'Transfer Bank BNI',
                'icon' => '🏦',
                'detail' => 'BNI — 0987654321 a/n Skinist Store',
            ],
            'bri' => [
                'name' => 'Transfer Bank BRI',
                'icon' => '🏦',
                'detail' => 'BRI — 5566778899 a/n Skinist Store',
            ],
            'mandiri' => [
                'name' => 'Transfer Bank Mandiri',
                'icon' => '🏦',
                'detail' => 'Mandiri — 1122334455 a/n Skinist Store',
            ],
            'ewallet' => [
                'name' => 'E-Wallet (DANA/OVO/GoPay)',
                'icon' => '📱',
                'detail' => 'DANA/OVO/GoPay — 081234567890 a/n Skinist Store',
            ],
        ];
    }

    public function getPaymentMethodNameAttribute(): string
    {
        return self::paymentMethods()[$this->payment_method]['name'] ?? '-';
    }

    public function getPaymentMethodDetailAttribute(): string
    {
        return self::paymentMethods()[$this->payment_method]['detail'] ?? '-';
    }

    public function getPaymentMethodIconAttribute(): string
    {
        return self::paymentMethods()[$this->payment_method]['icon'] ?? '🏦';
    }

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