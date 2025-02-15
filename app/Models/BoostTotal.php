<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class BoostTotal extends Model
{
    protected $table = 'boost_total';

    protected $fillable = [
        'user_id',
        'btotal',
        'utotal',
        'total_pledge',
        'remark',
    ];
    protected $appends = [
        'user',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s');
    }
    public function getUserAttribute()
    {
        $bank = User::where('id', $this->user_id)->first();
        return $bank ? $bank : null;

    }
}
