<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->dateTime('donation_date');
            $table->foreignId('donor_id')->constrained('donors')->onDelete('cascade');
            $table->foreignId('donation_type_id')->constrained('donation_types')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('payment_method'); // Tunai, Transfer Bank, QRIS, E-Wallet
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Petugas Input
            $table->string('status')->default('Selesai'); // Draft, Selesai, Dibatalkan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
