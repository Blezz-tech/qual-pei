<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css\bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css\main.css') }}">
    <title>Авоська</title>
</head>

<body>
    <div>
        <div class="bg-primary">
            <div class="container">
                <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="">
                            <img src="{{ asset('img\3.png') }}" width="30" height="24" alt="">
                        </a>
                        <a class="navbar-brand" href="{{ route('home') }}">Главная</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                @guest
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('regform') }}">Регистрация</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('loginform') }}">Вход</a>
                                    </li>
                                @endguest
                                @auth
                                    @if (!Auth::user()->is_admin)
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('user.orders.index') }}">Мои
                                                заказы</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('user.orders.create') }}">Заказать</a>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('admin.orders.all') }}">Все заявки</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('admin.products.index') }}">Все
                                                продукты</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="{{ route('admin.products.create') }}">Создать
                                                продукт</a>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{ route('logout') }}">Выйти</a>
                                    </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="container">
            @if (session('info'))
                <div class="alert alert-success" role="alert">
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mt-3">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="container">
        <footer class="py-2 mt-2">
            <p class="text-center text-body-secondary">&copy; 2023 Company, Inc</p>
        </footer>
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
