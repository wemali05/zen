<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('pdf_title');
            $table->string('pdf_name')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('snippet_title');
            $table->text('snippet_content');
            $table->string('link_title');
            $table->string('link');
            $table->boolean('open_tab')->default(0);

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
        Schema::dropIfExists('resources');
    }
}
