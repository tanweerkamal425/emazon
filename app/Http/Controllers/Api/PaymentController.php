<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\VarDumper\Caster\ProxyManagerCaster;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PaymentController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $items = request('items') ? request('items') : 10;
        $id = request('id');
        $status = request('is_active');
        $payments = Payment::query();

        if ($id) {
            $payments->where('id', $id);
        }
        if ($status) {
            $payments->where('status', $status - 1);
        }

        $payments = $payments->orderBy('id', 'desc')->paginate($items);

        return PaymentResource::collection($payments);
    }

    public function show(Request $request, int $id): JsonResource
    {
        $payment = Payment::query();
        $payment = $payment->where('id', $id)->with('user')->first();
        if (is_null($payment)) {
            throw new NotFoundResourceException("Payment with ID '$id' does not exist");
        }

        return new PaymentResource($payment);
    }
}
