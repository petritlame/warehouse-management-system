<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('invoice_id')->nullable();
            $table->unsignedInteger('makina_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('agent_id');
            $table->text('data');
            $table->text('product_name');
            $table->text('agent_name');
            $table->integer('sasia');
            $table->float('cmim_blerje');
            $table->float('cmim_shitje');
            $table->float('total');
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
        Schema::dropIfExists('invoices_item');
    }
}
