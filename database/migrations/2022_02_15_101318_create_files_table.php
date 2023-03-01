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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_no',32);
            $table->enum('file_type',['New', 'Copy',])->default('New');
            $table->string('title',200);
            $table->text('description')->nullable();
            $table->enum('status',['Under Process', 'Closed',])->default('Under Process');
            $table->text('attachments')->nullable();
            $table->integer('department_id');
            $table->integer('curr_department_id')->nullable();
            $table->dateTime('curr_received_date')->nullable();
            $table->dateTime('delay_after_date')->nullable();
            $table->integer('no_of_attachments')->nullable();
            $table->integer('copy_of')->nullable();

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
        Schema::dropIfExists('files');
    }
};
