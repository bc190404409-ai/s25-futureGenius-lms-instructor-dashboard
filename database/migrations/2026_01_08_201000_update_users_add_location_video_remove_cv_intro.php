<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('province')->nullable()->after('city');
            $table->string('street')->nullable()->after('province');
            $table->string('video_url')->nullable()->after('linkedIn_url');

            // Drop old file columns
            if (Schema::hasColumn('users', 'cv_file')) {
                $table->dropColumn('cv_file');
            }
            if (Schema::hasColumn('users', 'intro_video')) {
                $table->dropColumn('intro_video');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cv_file')->nullable()->after('city');
            $table->string('intro_video')->nullable()->after('cv_file');

            $table->dropColumn(['province', 'street', 'video_url']);
        });
    }
};
