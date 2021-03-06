<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = [
        'goods',//物品
        'purpose',//'用途'
        'date',//归还日期'
        'images',//物品图片
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
