<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reader');
            $table->text('commment');
            $table->integer('rating');
            $table->timestamps();
        });
        Schema::table('feedback', function (Blueprint $table) {
            // cascade deletion with the related row
            $table->integer('article_id')->unsigned()->index();
            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('cascade');
            //end of cascade deletion
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
