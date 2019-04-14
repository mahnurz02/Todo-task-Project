<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Todo') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://Fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/4.0.0/lumen/bootstrap.min.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    @yield('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel top-navbar">
            <div class="container">
                @guest
                @else
                    <a class="navbar-brand top-a" href="{{ url('/') }}">
                        <b>{{ config('app.name', 'Todo') }}</b>
                    </a>
                    <a class="navbar-brand top-a" href="{{ route('tasks.index') }}">
                                   Todos
                    </a>
                    <a class="navbar-brand top-a catmodal-btn" data-toggle="modal" data-target="#catmodal">
                                   Category
                    </a>
                    <a class="navbar-brand top-a" href="{{ route('logout') }}">Log out</a>
                @endguest   
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link top-a" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link top-a" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            {{--<li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>--}}
                        @endguest
                    </ul>
                </div>

                <div id="catmodal" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Add Category</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                          </div>
                          <div class="modal-body">
                            <input type="text" name="category" class="category form-control" required placeholder="Add category">
                            <span class="error-fields" style="display: none; color: red;"></span>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-primary add-cat">Submit</button>
                          </div>
                        </div>

                      </div>
                    </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).on("click",".catmodal-btn",function(e) {
            $('.error-fields').css({'display':'none'});
        });
        $(document).on("click",".add-cat",function(e) {
           
            if(($('.category').val() == '')){
                $('.error-fields').html('Povide category');
                $('.error-fields').css({'display':'block'});
              }
            else{
                e.preventDefault();
                $.ajax({ 

                        url: "{{route('category.store')}}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            name: $('.category').val(),
                        },
                        success: function(result) {
                            $('#catmodal').modal('toggle');
                            alert('Category added succesfully');
                            location.reload();
                        }
                });
            }
        });
    </script>
    @yield('js')

</body>
</html>
