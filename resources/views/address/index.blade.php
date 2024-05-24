@extends('templates.base')

@section('content')

<div>
    @include('flash.success')
    @include('flash.message')
    @include('flash.error')
    @include('flash.warning')
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <h1 class="ml-64 text-white text-lg">Your addresses</h1>
    <table class="w-2/3 mx-auto mt-10 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Full name
                </th>
                <th scope="col" class="px-6 py-3">
                    Phone
                </th>
                <th scope="col" class="px-6 py-3">
                    Address
                </th>
                <th scope="col" class="px-6 py-3">
                    Town ID
                </th>
                <th scope="col" class="px-6 py-3">
                    User ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Options
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($addresses as $a)
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <a href="/address/{{$a->id}}">{{$a->id}}</a>
                </th>
                <td class="px-6 py-4">
                    {{$a->title}}
                </td>
                <td class="px-6 py-4">
                    {{$a->full_name}}
                </td>
                <td class="px-6 py-4">
                    {{$a->phone}}
                </td>
                <td class="px-6 py-4">
                    {{$a->address_line_1}}
                </td>
                <td class="px-6 py-4">
                    {{$a->town_id}}
                </td>
                <td class="px-6 py-4">
                    {{$a->user_id}}
                </td>
                <td class="px-6 py-4">
                    <a href="/address/{{$a->id}}/edit"class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                </td>
                <td class="px-6 py-4">
                    <a href="/address/{{$a->id}}/delete"class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Delete</a>
                </td>
            </tr>
            @endForeach
        </tbody>
    </table>
    <div class="mx-auto w-32">
        <a href="/address/create" class="text-blue-500 hover:text-blue-700 underline">Add address</a>
    </div>

</div>
{{-- <a href="/user/{{auth()->user()->id}}/addresses/create" class="mt-20 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create address</a> --}}
</div>


@endsection
