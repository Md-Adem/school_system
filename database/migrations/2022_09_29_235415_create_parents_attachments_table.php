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
        Schema::create('parents_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file_name')->nullable();
            $table->bigInteger('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('my_parents')->onDelete('cascade');
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
        Schema::dropIfExists('parents_attachments');
    }
};
