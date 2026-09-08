<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $table = 'logistic_zones';

    public function getNameAttribute() {
        return $this->attributes['name']; 
    }

    public function getChargeAttribute() {
        return $this->standard_delivery_charge;
    }

    public function setChargeAttribute($value) {
        $this->attributes['standard_delivery_charge'] = $value;
        $this->attributes['express_delivery_charge'] = $value; // keep them same for simplicity
    }

    public function getDayAttribute() {
        return $this->standard_delivery_time;
    }

    public function setDayAttribute($value) {
        $this->attributes['standard_delivery_time'] = $value;
        $this->attributes['express_delivery_time'] = $value;
    }

    public function getStatusAttribute() {
        // Assume status active. Wait, does logistic_zones have status? 
        // No, let's just return 1
        return 1;
    }
    
    public function setStatusAttribute($value) {
        // Do nothing, logistic_zones doesn't have status, but 'logistics' does
    }
    
    // logistic_id is required
    public function save(array $options = [])
    {
        if (empty($this->logistic_id)) {
            // Find or create a default logistic
            $logistic = \Illuminate\Support\Facades\DB::table('logistics')->first();
            if (!$logistic) {
                $logisticId = \Illuminate\Support\Facades\DB::table('logistics')->insertGetId([
                    'name' => 'Default Logistic',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $logisticId = $logistic->id;
            }
            $this->logistic_id = $logisticId;
        }

        if (empty($this->country_id)) $this->country_id = 1;
        if (empty($this->state_id)) $this->state_id = 1;

        return parent::save($options);
    }
}
