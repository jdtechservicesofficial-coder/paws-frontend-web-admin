<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingViserTables extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('languages')) {
            Schema::create('languages', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('code')->nullable();
                $table->tinyInteger('is_default')->default(0);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('pages')) {
            Schema::table('pages', function (Blueprint $table) {
                if (!Schema::hasColumn('pages', 'tempname')) {
                    $table->string('tempname')->nullable();
                }
                if (!Schema::hasColumn('pages', 'secs')) {
                    $table->text('secs')->nullable();
                }
            });
        }

        if (!Schema::hasTable('frontends')) {
            Schema::create('frontends', function (Blueprint $table) {
                $table->id();
                $table->string('data_keys')->nullable();
                $table->text('data_values')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('general_settings')) {
            Schema::create('general_settings', function (Blueprint $table) {
                $table->id();
                $table->string('site_name')->nullable();
                $table->string('cur_text')->nullable();
                $table->string('cur_sym')->nullable();
                $table->string('email_from')->nullable();
                $table->string('active_template')->nullable();
                $table->tinyInteger('force_ssl')->default(0);
                $table->tinyInteger('secure_password')->default(0);
                $table->tinyInteger('agree')->default(0);
                $table->tinyInteger('registration')->default(0);
                $table->timestamps();
            });

            \DB::table('general_settings')->insert([
                'site_name' => 'Pawlly',
                'cur_text' => 'USD',
                'cur_sym' => '$',
                'active_template' => 'basic',
            ]);
        }
    }

    public function down()
    {
        // Don't drop anything in down() to prevent data loss
    }
}
