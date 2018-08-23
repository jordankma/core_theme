<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dhcd')->create('dhcd_banner', function (Blueprint $table) {
            $table->increments('banner_id');
            $table->string("create_by")->nullable();
            $table->string("name");
            $table->string("alias");
            $table->string("desc")->nullable();
            $table->string("image");
            $table->string("link")->nullable();
            $table->integer("count_view",false,true)->comment('số lượng người click')->nullable();
            $table->integer("position", false, true)->comment('vi tri banner')->default('0');
            $table->integer("priority", false, true)->comment('thứ tự ưu tiên')->default('1');
            $table->datetime("close_at")->comment('han hien thị banner');
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_banner');
    }
}
