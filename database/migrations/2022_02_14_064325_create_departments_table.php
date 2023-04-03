<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();

            $table->string('title')->unique();
            $table->string('logo_path', 2048)->nullable();
            $table->string('short_code',10);
            $table->integer('delay_threshhold')->default(5)->nullable();
            $table->integer('file_year')->nullable();
            $table->integer('file_month')->nullable();
            $table->integer('file_date')->nullable();
            $table->integer('file_counter')->nullable();
            $table->tinyInteger('system_installed')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
