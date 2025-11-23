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
            $table->unsignedBigInteger('medical_record_id');
            $table->string('file_path');   // storage path
            $table->string('file_name');   // original file name
            $table->string('file_type')->nullable(); // pdf, jpeg, png etc
            $table->integer('file_size')->nullable(); // in KB
            $table->timestamps();

            $table->foreign('medical_record_id')
                ->references('id')
                ->on('medical_records')
                ->onDelete('cascade'); // delete files when record is deleted
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
