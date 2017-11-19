<?php namespace GreenImp\Industries\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateIndustryApplicationProductModeTable extends Migration
{
  public function up()
  {
    Schema::create('greenimp_industries_application_product_mode', function($table)
    {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->integer('application_id')->unsigned();
      $table->integer('product_id')->unsigned();
      $table->integer('product_mode_id')->unsigned()->nullable();
      $table->timestamps();

      /**
       * Foreign keys
       */
      $table->foreign('application_id', 'application_product_mode_application_id_foreign')
            ->references('id')
            ->on('greenimp_industries_applications')
            ->onUpdate('cascade')
            ->onDelete('cascade');

      $table->foreign('product_id', 'application_product_product_id_foreign')
            ->references('id')
            ->on('greenimp_telcoproducts_products')
            ->onUpdate('cascade')
            ->onDelete('cascade');

      $table->foreign('product_mode_id', 'application_product_mode_mode_id_foreign')
            ->references('id')
            ->on('greenimp_telcoproducts_product_modes')
            ->onUpdate('cascade')
            ->onDelete('cascade');
    });
  }

  public function down()
  {
    Schema::dropIfExists('greenimp_industries_application_product_mode');
  }
}
