<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ProjectBoard') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="theme-light bg-page text-default">
    <div id="app">
        <nav class="bg-header">
            <div class="container mx-auto">
                <div class="flex justify-between items-center py-2">
                    <!-- Left Side Of Navbar -->

                    <div class="flex items-center flex-no-shrink mr-6">
                            <a href="{{ url('/projects') }}"class="font-semibold text-red-600 text-xl tracking-tight no-underline visited:text-red-600">
                                {{ config('app.name', 'ProjectBoard') }}
                            </a>
                    </div>

                    <!-- Right Side Of Navbar -->


                    <div class="flex items-center ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <a class="text-default focus:outline-none text-sm mr-3 no-underline" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                <a class="text-default focus:outline-none text-sm mr-3 no-underline" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        @else

                            <theme-switcher></theme-switcher>
                            
                            <dropdown>
                                <template slot="trigger">                              
                                    <button class="flex items-center text-default focus:outline-none text-sm mr-3">
                                        <img width="35"
                                         class="rounded-full mr-3"
                                         src="{{ gravatar_url(auth()->user()->email) }}">
                                        {{ auth()->user()->name }}
                                    </button>
                                </template>
                                    <a class="dropdown-menu-item " href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                            </dropdown>    
                            
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="container mx-auto mx-auto py-4 ">
            @yield('content')
        </main>
    </div>
</body>
</html>
