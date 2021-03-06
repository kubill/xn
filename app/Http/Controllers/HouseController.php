<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class HouseController extends ApiController
{
    public function index(Request $request)
    {
        $this->checkPar($request, [
            'category_id' => 'required'
        ]);
        $category_id = $request->input('category_id');
        $layout_id = $request->input('layout_id');
        $result = House::query()
            ->where('category_id', $category_id)
            ->when($layout_id, function ($query) use ($layout_id) {
                $query->where('layout_id', $layout_id);
            })
            ->get();
        return $this->success($result);
    }

    public function tenants(House $house)
    {
        return $this->success($house->tenants()->get());
    }

    public function indexAdmin(Request $request)
    {
        $q = $request->input('q');//后台 select 联动需要
        return House::query()
            ->where('category_id', $q)
            ->where('status', 0)
            ->get();
    }
}
