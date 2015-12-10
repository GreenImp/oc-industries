<?php namespace GreenImp\Industries\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateIndustriesTable extends Migration
{

    public function up()
    {
        Schema::create('greenimp_industries_industries', function($table)
        {
          $table->engine = 'InnoDB';
          $table->increments('id');
          $table->string('name');
          $table->string('url_slug', 255);
          $table->longText('description')->nullable();
          $table->integer('sort_order')->unsigned()->nullable();
          $table->boolean('active')->default(false);
          $table->timestamps();

          /**
           * Indexes
           */
          $table->unique('url_slug');
          $table->index('sort_order');
          $table->index('active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('greenimp_industries_industries');
    }

}
