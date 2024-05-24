@extends('templates.base')

@section('content')

<section class="bg-white dark:bg-gray-900">
  <div class="py-8 px-4 mx-auto max-w-lg lg:py-16 border-4 flex flex-col">
    <img class="w-40 h-40 mb-4 rounded-full mx-auto" src="{{$user->image_url}}" alt="Rounded avatar">
      <h2 class="mb-2 text-xl font-semibold leading-none text-gray-900 md:text-2xl dark:text-white text-center">{{strtoupper($user->fullName())}}</h2>
      <div class="mx-auto">
          <dl class="flex items-center space-x-6">
              <div>
                  <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Gender</dt>
                  <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{$user->gender == 0 ? 'Male':'Female'}}</dd>
              </div>
              <div>
                  <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Email</dt>
                  <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{$user->email}}</dd>
              </div>
              <div>
                <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Phone</dt>
                <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">+91 {{$user->phone}}</dd>
            </div>
          </dl>
          <dl>
            <dt class="mb-2 font-semibold leading-none text-gray-900 dark:text-white">Address</dt>
            <dd class="mb-4 font-light text-gray-500 sm:mb-5 dark:text-gray-400">{{$address->address_line_1}}<a href="/address/{{$address->id}}/edit"><svg aria-hidden="true" class="mr-1 -ml-1 w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg></a></dd>

        </dl>

      </div>
  </div>
</section>


@endsection
