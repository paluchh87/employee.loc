<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Employee</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?<?php echo time(); ?>" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    {{--<script src="{{ asset('js/jquery.js') }}"></script>--}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>--}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <script src="{{ asset('js/tree.js') }}?<?php echo time(); ?>"></script>
    <script src="{{ asset('js/sorting-search.js') }}?<?php echo time(); ?>"></script>
    <script src="{{ asset('js/modal-windows.js') }}?<?php echo time(); ?>"></script>

    <script type="text/javascript" src="{{asset('js/bootstrap-filestyle.min.js')}}"></script>

</head>

<body>

<div class="container-fluid">

    <div class="row justify-content-center align-items-center">

        <a class="nav-link" href="{{ route('employee.index') }}">Table View</a>
        <a class="nav-link" href="{{ route('tree.tree') }}">Tree View</a>
        <a class="nav-link" href="{{ route('tree.lazy') }}">Lazy Tree View</a>
        <a class="nav-link" href="{{ route('tree.edit') }}">Edit (only form)</a>

        @guest

            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>

            @if (Route::has('register'))
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif
        @else
            <a class="nav-link" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        @endguest


    </div>

@yield('content')

</body>
</html>