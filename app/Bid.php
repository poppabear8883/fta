<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getDatetimeAttribute($value) {
        if(auth()->check()) {
            $timezone = auth()->user()->timezone;
            return Carbon::createFromFormat('Y-m-d H:i:s', $value)->setTimezone($timezone)->format('Y-m-d H:i:s');
        }

        return $value;
    }
}
