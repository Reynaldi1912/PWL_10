<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaMatakuliah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_matakuliah', function (Blueprint $table) {
            $table->id();
            $table->string('mahasiswa_id',20);
            $table->unsignedBigInteger('matakuliah_id');
            $table->char('nilai', 2);
            $table->foreign('mahasiswa_id')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->foreign('matakuliah_id')->references('id')->on('matakuliah')->onDelete('cascade');
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
        Schema::dropIfExists('mahasiswa_matakuliah');
    }
}
