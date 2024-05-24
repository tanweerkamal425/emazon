<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP verification</title>
</head>

<body>
    {{-- @include('flash.error') --}}
    <section class="bg-gray-50 dark:bg-gray-900">
        <form action="/auth/verify" method="post">
            @csrf
            <input type="hidden" name="id" value="{{$user->id}}">
            <input type="hidden" name="password" value="{{$password}}">

            <label for="otp">OTP</label>
            <input id="otp" name="otp" type="text">
            @error('otp')
            <span class="text-red-400">
                {{$message}}
            </span>
            @enderror
            <button type="submit">Send</button>
        </form>
    </section>
</body>
</html>
