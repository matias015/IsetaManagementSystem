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
        Schema::table('alumnos', function (Blueprint $table) {
            
            $table->string('password')->default(0);
            $table->integer('verificado')->default(0);
            $table->string('token_verificacion')->default(0);
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnos', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->dropColumn('verificado');
            $table->dropColumn('token_verificacion');
            $table->dropRememberToken();
        });
    }
};
