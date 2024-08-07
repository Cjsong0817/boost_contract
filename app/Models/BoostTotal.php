<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class RequestFollow extends Model
{
    protected $table = 'follow_request';

    protected $fillable = [
        'user_id',
        'request_type',
        'status',
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
