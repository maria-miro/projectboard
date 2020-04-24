@extends('layouts.app')

@section('content')

<div class="py-20"
>
  <div class="container mx-auto px-6">
    <h2 class="text-4xl font-bold mb-8">
        Welcome to ProjectBoard!
    </h2>
    <h3 class="text-2xl mb-5 text-gray-200">
        You can create your own projects here if you register and login     
    </h3>    
    <div class="mb-8">
        <button class="button mr-2" onclick="window.location.href='/login'">{{ __('Login') }}</button>
        <button class="button mr-2" onclick="window.location.href='/register'">{{ __('Register') }}</button>
    </div>
    <h3 class="text-2xl mb-5 text-gray-200">
        Or you can view demo     
    </h3>
    <button type="submit" class="button mr-2" onclick="window.location.href='/login-guest'">Demo</button>

  </div>
</div> 
    
@endsection
