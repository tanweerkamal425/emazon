@extends('templates.base')

@section('content')


<section class="bg-gray-50 dark:bg-gray-900">
    @include('flash.success')
    @include('flash.message')
    @include('flash.error')
    @include('flash.warning')
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0 dark:bg-gray-900">
        <a href="/" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
            Emazon
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-2xl xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Create an address
                </h1>
                {{-- {{(dd($errors->messages()))}} --}}
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-800">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                {{-- @include('error') --}}
                <form class="space-y-4 md:space-y-6" action="/address" method="post">
                    @csrf
                    <div class="flex items-center gap-x-4">
                        <div class="sm:col-span-2 flex-1">
                            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                            <input type="text" name="title" value="{{request('title')}}" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="work address, home address, etc...." required="">
                            @error('title')
                            <span class="text-red-400">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                        <div class="sm:col-span-2 flex-1">
                            <label for="full_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full name</label>
                            <input type="text" name="full_name" id="full_name" value="{{request('full_name')}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter las name..." required="">
                            @error('full_name')
                            <span class="text-red-400">
                                {{$message}}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                        <input type="text" name="phone" id="phone" value="{{request('phone')}}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" max="10" placeholder="e.g, 9331234567" required="">
                        @error('phone')
                        <span class="text-red-400">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address Line 1</label>
                        <textarea id="address" rows="4" name="address_line_1" value="{{request('address_line_1')}}" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your address..."></textarea>
                        @error('address_line_1')
                        <span class="text-red-400">
                            {{$message}}
                        </span>
                        @enderror

                    </div>
                    <div>
                        <label for="town_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Town ID</label>
                        <input type="text" name="town_id" id="town_id" value="{{request('town_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" max="10" placeholder="e.g, 1, 2, 3..." required="">
                        @error('town_id')
                        <span class="text-red-400">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <div>
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User ID</label>
                        <input type="text" name="user_id" id="user_id" value="{{request('user_id')}}" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" max="10" placeholder="e.g, 1, 2, 3..." required="">
                        @error('user_id')
                        <span class="text-red-400">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create an account</button>
                    {{-- <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Already have an account? <a href="{{route('auth.login')}}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login here</a>
                    </p> --}}
                </form>
            </div>
        </div>
    </div>
</section>


@endsection
