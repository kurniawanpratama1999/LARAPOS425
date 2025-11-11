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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('restrict');

            $table->string('code')->unique();
            $table->enum('payment', ['CASH', 'DEBIT','CREDIT', 'QRIS']);
            $table->enum('payment_tool',['ATM', 'EDC'])->nullable();
            $table->enum('payment_detail', ['BRI', 'MANDIRI', 'BNI', 'BCA', 'BSI', 'CIMB NIAGA', 'Lainnya'])->nullable();
            $table->integer('quantities');
            $table->decimal('subtotal', 10,2);
            $table->decimal('tax', 10,2);
            $table->decimal('discount', 10,2)->default(0);
            $table->decimal('total', 12,2);
            $table->timestamps();
        });

        Schema::create('order_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                    ->constrained('orders')
                    ->onDelete('cascade');

            $table->foreignId('product_id')
                  ->constrained('products')
                  ->onDelete('restrict');

            $table->decimal('price', 10,2);
            $table->integer('quantity');
            $table->decimal('subtotal', 10,2);
            $table->decimal('tax', 10,2);
            $table->decimal('discount', 10,2)->default(0);
            $table->decimal('total', 12,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_details');
    }
};
