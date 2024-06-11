<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Konekt\PdfInvoice\InvoicePrinter;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class OrderController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $items = request('items') ? request('items') : 10;

        $orders = Order::query();

        $status = (int) $request->input('is_active');
        $amount = (int) $request->input('amount');
        $discount = (int) $request->input('discount');

        if ($status) {
            $orders->where('status', $status - 1);
        }
        if ($v = request('id')) {
            $orders->where('id', $v);
        }
        if ($v = request('amount')) {
            $orders->orderBy('amount', $v == 1 ? 'asc' : 'desc');
        }

        if ($v = request('discount')) {
            $orders->orderBy('discount', $v == 1 ? 'asc' : 'desc');
        }

        if (!$amount) {
            $orders->orderBy('id', 'desc');
        }

        $orders = $orders->with('orderItems')->paginate($items);

        return OrderResource::collection($orders);
    }

    public function show(Request $request, int $id)
    {
        $order = Order::find($id);
        if (is_null($order)) {
            throw new NotFoundResourceException("Order with ID '$id' does not exist");
        }

        $user = $order->user()->first();
        $order_items = $order->orderItems()->get();

        $data = [
            'order' =>  $order,
            'user'  =>  $user,
            'order_items'   =>  $order_items
        ];

        return $data;
    }
}
