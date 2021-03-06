<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('store');
    }

    public function index(Request $request)
    {
        $this->setWith('user');
        return parent::index($request);
    }

    public function store(Request $request)
    {
        $result = $request->user()->visits()->create($request->only([
            'numbers',//访客数量
            'name',//姓名
            'phone',//电话
            'intention',//意向程度 1高 2中 3低
            'remark',//其他原因
        ]));
        return $this->success($result);
    }
}
