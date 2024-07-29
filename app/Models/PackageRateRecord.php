<?php

namespace App\Models;

use DateTimeInterface;use Illuminate\Database\Eloquent\Model;

class PackageRateRecord extends Model
{
    protected $table = 'package_rate_record';

    protected $fillable = [
        'package_type_id',
        'rates',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
    protected $appends = [

    ];

}
