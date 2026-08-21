<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    protected $table = 'pawf_notification_templates';

    protected $casts = [
        'shortcodes' => 'object'
    ];

}
