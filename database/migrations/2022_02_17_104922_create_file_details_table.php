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
        Schema::create('file_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('file_id');
            $table->string('type',50);
            $table->integer('by_department_id');
            $table->integer('ref_department_id')->nullable();
            $table->integer('no_of_attachments')->nullable();
            $table->string('ref_file_detail')->nullable();
            $table->text('attachments')->nullable();
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
        Schema::dropIfExists('file_details');
    }
};
