<?php

namespace App\Models;

use App\Rules\ValidCPFRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'full_name',
        'cpf',
        'birtdate',
        'gender',
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public static function rulesStore()
    {
        return [
            'full_name' => 'required',
            'birtdate' => 'required|before:now|date_format:Y-m-d',
            'cpf' => ['required', 'unique:customers,cpf,NULL,id,deleted_at,NULL', new ValidCPFRule()],
            'gender' => 'required|in:M,F',
        ];
    }

    public static function rulesUpdate($id)
    {
        return [
            'birtdate' => 'sometimes|before:now|date_format:Y-m-d',
            'cpf' => [
                'sometimes',
                'unique:customers,deleted_at,NULL',
                Rule::unique('customers')->ignore($id),
                new ValidCPFRule()
            ],
            'gender' => 'sometimes|required|in:M,F',
        ];
    }
}
