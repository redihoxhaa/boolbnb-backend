<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('assets/images/logo-favicon.svg') }}" id="favicon">

    <title>@yield('title')</title>

    <!-- Fontawesome 6 cdn -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css'
        integrity='sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=='
        crossorigin='anonymous' referrerpolicy='no-referrer' />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- Tom tom --}}
    <link rel="stylesheet" type="text/css"
        href="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css">
    <link rel="stylesheet" type="text/css"
        href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps.css" />
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js">
    </script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js">
    </script>

    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps-web.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>

    <style>
        .pic-container {
            width: 130px;
        }

        .nav-element {
            width: fit-content !important;
        }

        .collapse-button {
            left: 50%;
            top: -20px;
            transform: translate(50%)
        }


        .navbar-toggler-custom {
            border: none;
            box-shadow: none;
            outline: none;
            background-color: none;
        }

        .nav-item {

            border-radius: 6px !important;

            a {
                color: rgb(167, 167, 167);

                i {
                    color: rgb(167, 167, 167);
                }
            }

        }

        .nav-item:hover i,
        .nav-item:hover a {
            color: black;
        }

        .active-route {
            color: black !important;

            i {
                color: black !important;
            }
        }

        .sidebar-height-custom {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            margin-top: 70px;
        }

        .opened {
            margin-top: 320px;
            transition: all 0.3s ease-in-out;
        }

        .user-photo-container {
            width: 40px;
            height: 40px;
            border: 2px solid lightgray;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
        }

        .user-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }


        @media only screen and (min-width:768px) {
            .custom-sidebar {
                max-width: 200px;
                border-right: 1px solid #E8E8E8;
            }

            .margin-fixed-custom {
                margin-left: 200px;
            }
        }
    </style>

    <div id="app">

        {{-- Header --}}
        <header class="navbar sticky-top header flex-md-nowrap px-3 py-3 border-header">
            <div class="row justify-content-between position-relative collapse-button">
                <span
                    class="navbar-toggler-icon navbar-toggler-custom position-absolute d-md-none collapsed border-0 mt-2"
                    data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
                    aria-expanded="false" aria-label="Toggle navigation"></span>
            </div>

            {{-- Navbar --}}
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <div class="nav-element ms-2">
                    {{-- Logo --}}
                    <div class="pic-container">
                        <a href="http://localhost:5173/"><img class="w-100"
                                src="{{ asset('assets/images/logo-black.svg') }}" alt=""></a>
                    </div>
                </div>

                <div class="nav-element d-flex gap-3 align-items-center ms-2">

                    @if (auth()->check() && auth()->user()->user_photo)
                        <div class="user-photo-container">
                            <img src="{{ asset('storage/' . Auth::user()->user_photo) }}" class="user-photo"
                                alt="User Photo">
                        </div>
                    @endif

                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>



            </div>
        </header>

        {{-- Main --}}
        <div>
            <div>
                {{-- SidebarMenu --}}
                <nav id="sidebarMenu"
                    class="col-12 col-md-3 d-md-block d-none custom-sidebar sidebar collapse sidebar-height-custom">
                    <div class="position-sticky pt-3">
                        <ul class="nav flex-column">
                            <li
                                class="nav-item d-flex justify-content-center justify-content-md-start px-0 mx-4 text-nowrap">
                                <a class="nav-link d-flex gap-4 align-items-center px-3" href="http://localhost:5173/">
                                    <i class="fa-solid fa-house fa-lg fa-fw"></i> Homepage
                                </a>
                            </li>
                            <li
                                class="nav-item d-flex justify-content-center justify-content-md-start px-0 mx-4 text-nowrap  ">
                                <a class="nav-link d-flex gap-4 align-items-center px-3 {{ Route::currentRouteName() == 'admin.dashboard' ? 'active-route' : '' }}"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="fa-solid fa-tachometer-alt fa-lg fa-fw"></i> Dashboard
                                </a>
                            </li>
                            <li
                                class="nav-item d-flex justify-content-center justify-content-md-start px-0 mx-4 text-nowrap  ">
                                <a class="nav-link d-flex gap-4 align-items-center px-3 {{ in_array(Route::currentRouteName(), ['admin.apartments.index', 'admin.apartments.show', 'admin.apartments.edit', 'admin.apartments.create']) ? 'active-route' : '' }}"
                                    href="{{ route('admin.apartments.index') }}">
                                    <i class="fa-solid fa-list fa-lg fa-fw"></i> Apartments
                                </a>
                            </li>
                            <li
                                class="nav-item d-flex justify-content-center justify-content-md-start px-0 mx-4 text-nowrap ">
                                <a class="nav-link d-flex gap-4 align-items-center px-3  {{ Route::currentRouteName() == 'admin.messages.index' ? 'active-route' : '' }}"
                                    href="{{ route('admin.messages.index') }}">
                                    <i class="fa-solid fa-envelope fa-lg fa-fw"></i> Messages
                                </a>
                            </li>
                            <li
                                class="nav-item d-flex justify-content-center justify-content-md-start px-0 mx-4 text-nowrap ">
                                <a class="nav-link d-flex gap-4 align-items-center px-3  {{ Route::currentRouteName() == 'admin.analytics.index' ? 'active-route' : '' }}"
                                    href="{{ route('admin.analytics.index') }}">
                                    <i class="fa-solid fa-chart-simple fa-lg fa-fw"></i> Analytics
                                </a>
                            </li>
                        </ul>


                    </div>
                </nav>

                {{-- Main --}}
                <main class="margin-fixed-custom">
                    @yield('content')
                </main>

            </div>
        </div>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const collapseButton = document.querySelector("[data-bs-target='#sidebarMenu']");
            const marginFixedCustom = document.querySelector(".margin-fixed-custom");
            const sidebarMenu = document.getElementById("sidebarMenu");

            collapseButton.addEventListener("click", function() {
                marginFixedCustom.classList.toggle("opened");
                sidebarMenu.classList.toggle("d-none");
            });
        });

        function scrollToTop() {
            window.scrollTo(0, 0);
        }

        // Event listener for button click
        document.querySelector("[data-bs-target='#sidebarMenu']").addEventListener('click', scrollToTop);
    </script>
</body>

</html>
