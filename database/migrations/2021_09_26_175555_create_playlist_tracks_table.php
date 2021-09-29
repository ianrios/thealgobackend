<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaylistTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlist_tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->constrained();
            $table->foreignId('track_id')->constrained();
            $table->integer('order');
            $table->integer('preference');
            $table->double('play_count', 8, 2);
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
        Schema::dropIfExists('playlist_tracks');
    }
}
