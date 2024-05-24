@extends('templates.base')

@section('content')



<style>
    input[type=number] {
    margin: 8px;
}
</style>

<div class="container mx-auto mt-10 dark:bg-gray-800">
    @include('flash.success')
    @include('flash.message')
    @include('flash.error')
    @include('flash.warning')
    <div class="flex shadow-md my-10">
        <div class="w-3/4 bg-white px-10 py-10 dark:bg-gray-900">
            <div class="flex justify-between border-b pb-8">
            <h1 class="font-semibold text-2xl text-gray-100">Order Detail</h1>
            </div>
            <div class="flex mt-10 mb-5">
            <h3 class="font-semibold text-gray-600 text-lg uppercase w-2/5 dark:text-gray-100">Product Details</h3>
            <h3 class="font-semibold text-center text-gray-600 text-lg uppercase w-1/5 text-center dark:text-gray-100">Quantity</h3>
            <h3 class="font-semibold text-center text-gray-600 text-lg uppercase w-1/5 text-center dark:text-gray-100">Price</h3>
            <h3 class="font-semibold text-center text-gray-600 text-lg uppercase w-1/5 text-center dark:text-gray-100">Discount</h3>
            <h3 class="font-semibold text-center text-gray-600 text-lg uppercase w-1/5 text-center dark:text-gray-100">Total</h3>
            </div>
            @php
                $total_items = 0;
                $total_cost_sp = 0;
                $total_cost_mp = 0;
            @endphp
            @foreach($order_items as $oi)
            @php
                $total_items += $oi->qty;
                $total_cost_sp += $oi->product->price_sp * $total_items;
                $total_cost_mp += $oi->product->price_mp * $total_items;
            @endphp

            <div class="flex items-center hover:bg-gray-700 -mx-8 px-6 py-5 bg-gray-800">
                <div class="flex w-2/5"> <!-- product -->
                    <div class="w-20">
                    <a href="/products/{{$oi->product->slug}}">
                        <img class="h-24" src="{{$oi->product->image_url}}" alt="{{$oi->product->title}}">
                        </div>
                        <div class="flex flex-col justify-between ml-4 flex-grow">
                        <span class="hover:text-indigo-700 font-bold text-sm dark:text-white">{{$oi->product->title}}</span>
                        {{-- <div class="flex justify-start items-center gap-x-8">
                            <p class="mt-1 text-sm text-gray-200">
                                Color - {{ $oi->color->color }}
                            </p>
                            <div class="w-8 h-4 inline-block -ml-4" style="background-color: #{{$oi->color->code}}"></div>
                        </div>
                        <p class="mt-1 text-sm text-gray-200">
                            Size - {{$oi->size->size}}
                        </p> --}}

                    </a>
                    <!-- <span class="text-red-500 text-xs">Apple</span> -->
                    {{-- <form method="post" action="/cart/{{$oi->id}}">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="font-semibold hover:text-red-500 text-gray-500 text-xs dark:text-gray-200">Remove</button>
                    </form> --}}
                    </div>
                </div>

                <div class="flex justify-center w-1/5">
                    <!-- <button class="qty-incr-btn">
                        <svg class="fill-current text-gray-600 w-3" viewBox="0 0 448 512"><path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
                        </svg>
                    </button> -->

                    <form action="/cart/{id}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="flex justify-center items-center">
                            <input type="hidden" name="cart_item_id" value="{{ $oi->id }}">
                            <input disabled class="mx-2 border text-center w-20 dark:bg-gray-800 dark:text-white text-xl" name="qty"   type="text" min="1" max="5" value="{{$oi->qty}}">
                            {{-- <button class="text-gray-500 hover:text-blue-700 border-x border-y px-1 py-0.5 hover:border-blue-700 border-gray-200 dark:text-gray-300" type="submit">Add qty</button> --}}
                        </div>
                    </form>


                    <!-- <button class="qty-dcr-btn">
                        <svg class="fill-current text-gray-600 w-3" viewBox="0 0 448 512">
                        <path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
                        </svg>
                    </button> -->
                </div>
                <span style="text-decoration: line-through" class="text-center w-1/5 font-semibold text-lg dark:text-white">&#8377;&nbsp;{{number_format($oi->product->price_mp)}}</span>
                <span class="text-center w-1/5 font-semibold text-lg dark:text-white">&#8377;&nbsp;{{number_format($oi->product->price_sp)}}</span>
                @php
                    $discount_percent = round(($oi->product->price_mp - $oi->product->price_sp)/ $oi->product->price_mp * 100, 2);
                @endphp
                <span class="text-center w-1/5 font-semibold text-green-500 text-lg">{{$discount_percent}}%</span>
                <span class="text-center w-1/5 font-semibold text-xl dark:text-white">&#8377;&nbsp;{{number_format($total_cost_sp)}}</span>
                </div>
                @endforeach

                <a href="/products" class="flex font-semibold text-indigo-600 text-sm mt-10">

                <svg class="fill-current mr-2 text-indigo-600 w-4" viewBox="0 0 448 512"><path d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"/></svg>
                Continue Shopping
                </a>
            </div>


        <div id="summary" class="w-1/4 px-8 py-10 dark:bg-gray-900">
            <h1 class="font-semibold text-2xl border-b pb-8 dark:text-white">Order Summary</h1>
            <div class="flex justify-between mt-10 mb-5">
                <span class="font-semibold text-sm uppercase dark:text-white">Item(s) {{$total_items}}</span>
            </div>

            <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                <p>Gross total</p>
                <p>&#x20B9;{{ number_format($order->gross_total) }}</p>
            </div>
            <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                <p>Sub total</p>
                <p>&#x20B9;{{ number_format($order->sub_total) }}</p>
            </div>
            <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                <p>Discount</p>
                <p>&#x20B9;{{ number_format($order->discount) }}</p>
            </div>

            <!-- <div>
            <label class="font-medium inline-block mb-3 text-sm uppercase">Shipping</label>
            <select class="block p-2 text-gray-600 w-full text-sm">
                <option>Standard shipping - $10.00</option>
            </select>
            </div> -->
            {{-- @if (is_null($order->applied_coupon_id)) --}}
            {{-- <div class="py-10">
                <form action="{{ route('cart.apply-coupon') }}" method="post">
                    @csrf
                    <label for="promo" class="font-semibold inline-block mb-3 text-sm uppercase dark:text-white">Coupon Code</label>
                    <input required type="text" id="promo" name="coupon" value="{{request('coupon')}}" placeholder="Enter your code" class="p-2 mb-2 text-sm w-full dark:bg-gray-800 dark:text-white">
                    <button class="bg-red-500 hover:bg-red-600 px-5 py-2 text-sm text-white uppercase">Apply</button>
                </form>
            </div> --}}
                {{-- <form action="/cart/remove-coupon" method="post">
                    @csrf
                    <div class="flex justify-between text-base font-medium text-gray-500">
                        <p>Coupon Details:</p>
                        <button type="submit" class="text-red-900">X</button>
                    </div>
                </form>
                    <div class="flex justify-between text-base font-medium text-green-500">
                        <p>Code: </p>
                        <p>{{$order->coupon->coupon}}</p>
                    </div>
                    <div class="flex justify-between text-base font-medium text-green-500">
                        <p>Discount </p>
                        <p>{{$order->coupon->value}}%</p>
                    </div>
                    <div class="flex justify-between text-base font-medium text-green-500">
                        <p> Coupon Discount</p>
                        <p>&#x20B9;{{ number_format($coupon_discount) }}</p>
                    </div>

                <form action="/cart/remove-coupon" method="post">
                    @csrf
                    <div class="max-w-sm p-6 mt-8 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Coupon Details</h5>
                        <div class="flex justify-between text-base font-medium text-green-500">
                        <p>Code: </p>
                        <input type="hidden" value="{{$order->coupon->id}}">
                        <p>{{$order->coupon->coupon}}</p>
                        </div>
                        <div class="flex justify-between text-base font-medium text-green-500">
                            <p>Discount </p>
                            <p>{{$order->coupon->value}}%</p>
                        </div>
                        <div class="flex justify-between text-base font-medium text-green-500">
                            <p> Coupon Discount</p>
                            <p>&#x20B9;{{ number_format($coupon_discount) }}</p>
                        </div>
                        <button type="submit" class="inline-flex items-center mt-4 px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            Remove Coupon
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </button>
                    </div>
                </form>

            @endif --}}

            <div class="border-t mt-8">
            <div class="flex font-semibold justify-between py-6 text-sm uppercase">
                <span class="dark:text-white text-2xl">Total</span>
                <span class="dark:text-white text-2xl">&#8377;&nbsp;{{ number_format($order->amount) }}</span>
            </div>
            <p class="text-green-400 text-lg -mt-4 mb-4">You saved &#8377; {{number_format($order->discount)}}</p>
            {{-- <form action="{{ route('order.store') }}" method="post" class="mt-6">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">
                    Place Order
                </button>
            </form> --}}
            </div>
        </div>

        </div>
    </div>
@endSection
