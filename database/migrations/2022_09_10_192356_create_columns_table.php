<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('columns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger( 'project_id' );
            $table->string('name');
            $table->integer('order')->default(1);
            $table->time('time')->default('01:00:00');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign( 'project_id' )->references( 'id' )->on( 'projects' );
            $table->unique(['project_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('columns');
    }
}
