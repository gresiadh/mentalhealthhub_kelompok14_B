<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
          $table->id(); // Primary key
            $table->unsignedBigInteger('sender_id'); // ID pengirim
            $table->unsignedBigInteger('receiver_id'); // ID penerima
            $table->text('message')->nullable(); // Isi pesan (nullable jika hanya gambar)
            $table->string('attachment')->nullable(); // Path file/gambar
            $table->timestamps(); // Timestamps created_at & updated_at

            // Foreign key constraints
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chats');
    }
}
