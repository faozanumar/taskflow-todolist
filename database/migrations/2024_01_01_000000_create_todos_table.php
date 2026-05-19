<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id();
            $table->string('judul');                          // TextField
            $table->text('deskripsi')->nullable();            // TextField multiline
            $table->string('kategori');                       // Dropdown
            $table->string('prioritas');                      // RadioButton
            $table->json('tags')->nullable();                 // CheckBox (multiple)
            $table->boolean('is_penting')->default(false);   // Switch/Toggle
            $table->date('tanggal_deadline');                 // Date picker
            $table->string('status')->default('belum');      // Dropdown status
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
