<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'address',
        'customer_id',
        'city_id',
        'state_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public static function rulesStore()
    {
        return [
            'address' => 'required',
            'customer_id' => 'required|integer|exists:customers,id',
            'city_id' => 'required|integer|exists:cities,id',
            'state_id' => 'required|integer|exists:states,id',
        ];
    }

    public static function rulesUpdate($id)
    {
        return [
            'address' => 'sometimes|required',
            'customer_id' => 'sometimes|required|integer|exists:customers,id',
            'city_id' => 'sometimes|required|integer|exists:cities,id',
            'state_id' => 'sometimes|required|integer|exists:states,id',
        ];
    }
}
