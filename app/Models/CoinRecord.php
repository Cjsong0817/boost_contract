<?php

namespace App\Models;

use App\Models\User;
use DateTimeInterface;use Illuminate\Database\Eloquent\Model;

class CoinRecord extends Model
{
    protected $table = 'coin_record';

    protected $fillable = [
        'user_id', 'price', 'coin_price', 'total_amount', 'freezed_amount', 'release_amount', 'max_cap', 'current_value',
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
        $user = User::where('id', $this->user_id)->first();
        return $user ? $user : null;

    }

}
