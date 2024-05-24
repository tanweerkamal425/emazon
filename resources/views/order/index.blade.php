@extends('templates.base')

@section('content')
<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Razorpay Order ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Amount
                </th>
                <th scope="col" class="px-6 py-3">
                    Gross total
                </th>
                <th scope="col" class="px-6 py-3">
                    Sub total
                </th>
                <th scope="col" class="px-6 py-3">
                    Discount
                </th>
                <th scope="col" class="px-6 py-3">
                    User ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Applied Coupon ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Created At
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $o)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$o->id}}
                </th>
                <td class="px-6 py-4">
                    {{$o->rzp_order_id}}
                </td>
                <td class="px-6 py-4">
                    {{$o->amount}}
                </td>
                <td class="px-6 py-4">
                    {{$o->gross_total}}
                </td>
                <td class="px-6 py-4">
                    {{$o->sub_total}}
                </td>
                <td class="px-6 py-4">
                    {{$o->discount}}
                </td>
                <td class="px-6 py-4">
                    {{$o->user_id}}
                </td>
                <td class="px-6 py-4">
                    {{$o->applied_coupon_id}}
                </td>
                <td class="px-6 py-4">
                    {{$o->status}}
                </td>
                <td class="px-6 py-4">
                    {{$o->created_at}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
