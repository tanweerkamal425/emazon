@extends('templates.base')

@section('content')

<div class="relative overflow-x-auto">
    <table class="w-2/3 mt-8 mx-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{$user->fullname()}}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-500">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <a href="/order">Orders</a>
                </th>
                {{-- <td class="px-6 py-4">
                    Silver
                </td> --}}
            </tr>
            {{-- <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-500">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <a href="/address">Address</a>
                </th>
            </tr> --}}
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-500">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <a href="/user/{{auth()->user()->id}}/account">Account</a>
                </th>
                {{-- <td class="px-6 py-4">
                    Silver
                </td> --}}
            </tr>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-500">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <a href="/user/{{auth()->user()->id}}/profile">Profile</a>
                </th>
                {{-- <td class="px-6 py-4">
                    Silver
                </td> --}}
            </tr>
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-500">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <form action="{{ route('auth.logout') }}" method="post">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </th>
                {{-- <td class="px-6 py-4">
                    Silver
                </td> --}}
            </tr>
        </tbody>
    </table>
</div>
@endSection
