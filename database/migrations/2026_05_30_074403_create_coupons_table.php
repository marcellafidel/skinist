<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['percent', 'fixed']); // persen atau nominal
            $table->decimal('value', 10, 2); // nilai diskon
            $table->decimal('min_purchase', 10, 2)->default(0); // minimal belanja
            $table->integer('max_uses')->default(100); // maksimal penggunaan
            $table->integer('used_count')->default(0); // sudah dipakai berapa kali
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};