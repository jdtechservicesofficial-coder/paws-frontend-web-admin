<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

Schema::table('general_settings', function (Blueprint $table) {
    if (!Schema::hasColumn('general_settings', 'kv')) {
        $table->tinyInteger('kv')->default(0);
    }
    if (!Schema::hasColumn('general_settings', 'ev')) {
        $table->tinyInteger('ev')->default(0);
    }
    if (!Schema::hasColumn('general_settings', 'en')) {
        $table->tinyInteger('en')->default(0);
    }
    if (!Schema::hasColumn('general_settings', 'sv')) {
        $table->tinyInteger('sv')->default(0);
    }
    if (!Schema::hasColumn('general_settings', 'sn')) {
        $table->tinyInteger('sn')->default(0);
    }
    if (!Schema::hasColumn('general_settings', 'pn')) {
        $table->tinyInteger('pn')->default(0);
    }
    if (!Schema::hasColumn('general_settings', 'mail_config')) {
        $table->text('mail_config')->nullable();
    }
    if (!Schema::hasColumn('general_settings', 'sms_config')) {
        $table->text('sms_config')->nullable();
    }
    if (!Schema::hasColumn('general_settings', 'global_shortcodes')) {
        $table->text('global_shortcodes')->nullable();
    }
});

$mail_config = '{"name":"php","host":"smtp.mailtrap.io","port":"2525","enc":"tls","username":"your_username","password":"your_password"}';
$sms_config = '{"name":"clickatell","clickatell":{"api_key":""},"infobip":{"username":"","password":""},"message_bird":{"api_key":""},"nexmo":{"api_key":"","api_secret":""},"sms_broadcast":{"username":"","password":""},"twilio":{"account_sid":"","auth_token":"","from":""},"text_magic":{"username":"","apiv2_key":""},"custom":{"method":"get","url":"","headers":{"name":"","value":""},"body":{"name":"","value":""}}}';
$global_shortcodes = '{"site_name":"site_name","site_currency":"site_currency","currency_symbol":"currency_symbol"}';

DB::table('general_settings')->update([
    'mail_config' => $mail_config,
    'sms_config' => $sms_config,
    'global_shortcodes' => $global_shortcodes,
    'en' => 1,
    'ev' => 1,
    'sn' => 1,
    'sv' => 1,
    'pn' => 1
]);

echo "Done\n";
