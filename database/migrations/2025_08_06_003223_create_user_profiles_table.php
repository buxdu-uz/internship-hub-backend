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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->unsignedBigInteger('university_code')->nullable()->index();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('surname');
            $table->string('phone')->unique()->nullable();
            $table->string('birth')->nullable();
            $table->enum('sex',['male','female','other'])->nullable();
            $table->string('passport_number')->unique()->nullable();
            $table->string('passport_pinfl')->unique()->nullable();
            $table->string('avatar')->nullable();
            $table->string('organization')->nullable();
            $table->text('bio')->nullable();

//            $table->foreign('university_code')
//                ->references('code')
//                ->on('universities')
//                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
