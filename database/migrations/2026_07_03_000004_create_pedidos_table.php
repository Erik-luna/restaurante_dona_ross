<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('tipo', ['online', 'local'])->default('online');
            $table->enum('estado', ['pendiente', 'confirmado', 'preparando', 'enviado', 'entregado', 'cancelado'])->default('pendiente');
            $table->decimal('total', 10, 2);
            $table->string('direccion_entrega')->nullable();
            $table->string('telefono_contacto', 20)->nullable();
            $table->text('notas')->nullable();
            $table->foreignId('atendido_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('pedido_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('producto_id')->constrained('productos')->cascadeOnDelete();
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedido_items');
        Schema::dropIfExists('pedidos');
    }
};
