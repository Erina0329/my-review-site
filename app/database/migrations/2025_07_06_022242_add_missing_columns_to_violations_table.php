<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('violations', function (Blueprint $table) {
            $table->unsignedBigInteger('review_id')->after('id');
            $table->unsignedBigInteger('user_id')->after('review_id');
            $table->string('reason', 500)->nullable()->after('user_id');

            // 外部キー制約
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('violations', function (Blueprint $table) {
            $table->dropForeign(['review_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['review_id', 'user_id', 'reason']);
        });
    }

};
