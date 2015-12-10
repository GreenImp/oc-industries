<?php namespace GreenImp\Industries\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateIndustryApplicationsTable extends Migration
{

    public function up()
    {
        Schema::create('greenimp_industries_applications', function($table)
        {
          $table->engine = 'InnoDB';
          $table->increments('id');
          $table->integer('industry_id')->unsigned();
          $table->string('name');
          $table->longText('description')->nullable();
          $table->boolean('active')->default(false);
          $table->timestamps();

          /**
           * Indexes
           */
          $table->index('active');

          /**
           * Foreign keys
           */
          $table->foreign('industry_id')
                ->references('id')
                ->on('greenimp_industries_industries')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('greenimp_industries_applications');
    }

}
