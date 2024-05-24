@extends('templates.base')

@section('content')

    <!-- <section>
        <div class="flex items-center justify-start w-1 max-w-screen-lg border-gray-200 bg-gray-100 gap-x-4 gap-y-4 ml-32">
            <div>Geans</div>
            <div>Shirts</div>
            <div>Shoes</div>
        </div>
    </section> -->

    @include('flash.success')
    <div class="bg-white dark:bg-gray-900">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <h2 class="sr-only">Products</h2>
            <!-- search bar -->

            <div class="flex justify-between items-center">

                    <form method='get' action="" class="flex w-2/3 items-center">
                        <div class="relative w-full mb-16 flex justify-between items-center gap-2">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2"/>
                                </svg>
                            </div>
                            <input type="text" name="q" value="{{request('q')}}" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search product name...">
                            <select name="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0" disabled selected>Category</option>
                            @foreach ($categories as $c)
                                <option
                                    value="{{ $c->id }}"
                                    {{ request('category_id') == $c->id ? 'selected' : '' }}
                                >
                                    {{ $c->name }}
                                </option>
                            @endforeach
                            </select>
                            <select name="price_order" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/3 ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="0" disabled selected>Sort by price</option>
                                <option
                                    value="1"
                                    {{ request('price_order') == 1 ? 'selected' : '' }}
                                >
                                    Low to high
                                </option>
                                <option
                                    value="2"
                                    {{ request('price_order') == 2 ? 'selected' : '' }}
                                >
                                    High to low
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="p-2.5 ms-2 mb-16 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </form>
                </div>




            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
            @foreach($products as $p)
                @php
                    $discount_percent = round((($p->price_mp - $p->price_sp) / $p->price_mp) * 100, 2);
                @endphp
                <a href="/products/{{$p->slug}}" class="group hover:bg-gray-700">
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                    <img src="{{$p->image_url}}" loading="lazy" alt="{{$p->title}}" class="h-full w-full object-cover object-center group-hover:opacity-75">
                    </div>
                    <h3 class="mt-4 text-lg text-white">{{$p->title}}</h3>
                    <span class="mt-1 text-xl font-medium text-white">&#x20B9;&nbsp;{{number_format($p->price_sp)}}</span>
                    <span>&nbsp;&nbsp;</span>
                    <span class="mt-1 text-lg font-medium text-white line-through">&#x20B9;&nbsp;{{number_format($p->price_mp)}}</span>
                    <span>&nbsp;&nbsp;</span>
                    <span class="text-green-500 mt-1 text-lg font-medium text-gray-900">{{$discount_percent}}% off</span>
                </a>
            @endforeach

            <!-- More products... -->
            </div>

        </div>
    </div>

    <div class="flex items-center justify-between border-t border-gray-800 bg-white dark:bg-gray-800 px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
            <p class="text-sm text-white">
                Showing
                <span class="font-medium">1</span>
                to
                <span class="font-medium">10</span>
                of
                <span class="font-medium">97</span>
                results
            </p>
            </div>
            <div>
            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm dark:bg-gray-800 border-gray-800" aria-label="Pagination">
                @if ($products->currentPage() != 1)
                <a href="{{ $products->currentPage() == 1 ? 'disabled:opacity-75' : $products->url($products->currentPage() - 1) }}" class="{{($products->currentPage() == 1) ? 'disabled:opacity-75' : ''}} relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-indigo-500 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Previous</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                </svg>
                </a>
                @endif
                <!-- Current: "z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600", Default: "text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0" -->
            @for($i = 1; $i <= $products->lastPage(); $i++)
                @if ($i == $products->currentPage())
                <a href="{{ route('product.index') }}?page={{ $i }}" aria-current="page" class="relative z-10 inline-flex items-center bg-indigo-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ $i }}
                </a>
                @else
                <a href="{{ route('product.index') }}?page={{ $i }}" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-gray-300 hover:bg-indigo-500 focus:z-20 focus:outline-offset-0">
                    {{ $i }}
                </a>
                @endif
            @endfor

                @if ($products->currentPage() != $products->lastPage())
                <a href="{{ $products->url($products->currentPage() + 1) }}" class="{($products->currentPage() == $products->lastPage()) ? 'disabled:opacity-75' : ''}} relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-indigo-500 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Next</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                </svg>
                </a>
                @endif
            </nav>
            </div>
        </div>
    </div>
    <script>
        console.log('js code');
    </script>
@endSection
