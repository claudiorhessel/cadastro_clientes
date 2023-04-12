<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'abbr',
    ];

    public function city()
    {
        return $this->hasMany(City::class);
    }

    public static function rules()
    {
        return [
            'name' => 'required',
            'abbr' => 'required',
        ];
    }

}
