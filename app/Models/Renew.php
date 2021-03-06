<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Renew extends Model
{
    protected $fillable = [
        'house_id',
        'contract_old',//旧合同第一页
        'contract_new',//新合同第一页
        'recovery',//收回
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
