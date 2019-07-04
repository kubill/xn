<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use App\Services\WechatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends ApiController
{
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with('item.house.layout')
            ->paginate(20);
        return $this->success($orders);
    }

    public function store(Request $request, OrderService $orderService, WechatService $wechatService)
    {
        $user = $request->user();
        User::query()->where('id', $user->id)->update($request->only([
            'name',
            'tel'
        ]));

        $house_ids = explode(',', $request->input('house_id'));
        $houses = House::query()->whereIn('id', $house_ids)->get();
        foreach ($houses as $house) {
            if (!$house->status) {
                return $this->error($house, '房子已租出！');
            }
        }

        //创建订单
        $order = $orderService->store($user, $house_ids);

        //微信那边下单
        $notify = config('wechat.payment.default.notify_url');
        $open_id = $request->user()->open_id;
        $total_fee = $order->total_amount * 100;
        if (!app()->environment('production')) {//如果不是生产环境，微信的沙箱环境 支付金额必须位 101 和 102 也就是 1.01 元和 1.02 元
            $total_fee = 101;
        }
        $config = $wechatService->order($order->no, $total_fee, '鑫南支付中心-房租支付', $open_id, $notify);
        if (!$config) {//微信下单失败  删除原来订单 并把房子状态设置为可以出租
            $order->delete();
            House::query()->whereIn('id', $house_ids)->update(['status' => 1]);
        }

        return $config ? $this->success($config) : $this->error([], '微信支付签名验证失败');
    }
}
