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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('project_user', function (Blueprint $table) {
            $table->unsignedBigInteger( 'project_id' );
            $table->unsignedBigInteger( 'user_id' );
            $table->primary( [ 'user_id', 'project_id' ] );
            $table->timestamps();
            $table->softDeletes();
            $table->foreign( 'project_id' )->references( 'id' )->on( 'projects' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' );
        });

        Schema::create('columns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('order')->default(1);
            $table->time('time')->default('01:00:00');
            $table->unsignedBigInteger( 'project_id' );
            $table->timestamps();
            $table->softDeletes();
            $table->foreign( 'project_id' )->references( 'id' )->on( 'projects' );
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
