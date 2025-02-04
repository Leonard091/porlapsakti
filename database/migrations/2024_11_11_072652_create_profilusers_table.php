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
        Schema::create('profilusers', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pj')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_wa')->nullable();
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });

        Schema::table('profilusers', function ($table) {

            $table->foreign('user_id', 'fk_user_id')
            ->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profilusers');
    }
};
