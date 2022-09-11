<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger( 'column_id' );
            $table->string('name');
            $table->string('tag');
            $table->string('description');
            $table->dateTime('estimated_date');
            $table->integer('order')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign( 'column_id' )->references( 'id' )->on( 'columns' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}
