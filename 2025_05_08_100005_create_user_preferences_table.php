<?php

     use Illuminate\Database\Migrations\Migration;
     use Illuminate\Database\Schema\Blueprint;
     use Illuminate\Support\Facades\Schema;

     return new class extends Migration
     {
         public function up(): void
         {
             Schema::create('user_preferences', function (Blueprint $table) {
                 $table->id();
                 $table->string('session_id');
                 $table->decimal('min_budget', 8, 2)->nullable();
                 $table->decimal('max_budget', 8, 2)->nullable();
                 $table->timestamps();
             });
         }

         public function down(): void
         {
             Schema::dropIfExists('user_preferences');
         }
     };