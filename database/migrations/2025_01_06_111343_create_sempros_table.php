<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sempros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id');
            $table->unsignedBigInteger('dosen_pembimbing_id');
            $table->unsignedBigInteger('dosen_penguji_id');
            
            $table->date('tanggal');
            $table->time('jam');
            $table->string('ruang');
            
            $table->enum('status', [
                'dijadwalkan', 
                'berlangsung', 
                'selesai', 
                'ditunda'
            ])->default('dijadwalkan');
            
            $table->text('catatan')->nullable();

            $table->foreign('proposal_id')
                ->references('id')
                ->on('proposals')
                ->onDelete('cascade');
            
            $table->foreign('dosen_pembimbing_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->foreign('dosen_penguji_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sempros');
    }
};