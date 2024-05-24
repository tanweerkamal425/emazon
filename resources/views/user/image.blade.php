@extends('templates.base')

@section('content')


<section class="bg-gray-50 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0 dark:bg-gray-900">
        <a href="/" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
            <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
            Emazon
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-2xl xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Upload user image
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
                {{-- {{auth()->user()->id}} --}}
                <form class="space-y-4 md:space-y-6" action="/user/{{auth()->user()->id}}/upload" method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="image_url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload image</label>
                        <input type="file" name="image_url" id="image_url" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" max="10" required="">
                        @error('image_url')
                        <span class="text-red-400">
                            {{$message}}
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Upload</button>
                    {{-- <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Already have an account? <a href="{{route('auth.login')}}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login here</a>
                    </p> --}}
                </form>
            </div>
        </div>
    </div>
</section>


@endsection
