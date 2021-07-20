<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Cacahuarte')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Vendor CSS Files -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" type="text/css" href="{{ mix('css/bootstrap.min.css')}}">

  <!-- Template Main CSS File -->
  <link href="{{ mix('css/login.css')}}" rel="stylesheet">
</head>

<body class="text-center">
    <main class="form-signin">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <img src="/img/Cacahuarte1.png" alt="" width="300" height="300">
            <h1 class="h3 mb-3 fw-normal"> {{ __('Login') }} | administra tu pagina</h1>
            <label for="inputEmail" class="visually-hidden">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email"  id="inputEmail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Usuario" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <label for="inputPassword" class="visually-hidden" >{{ __('Password') }}</label>
            <input id="password" type="password" id="inputPassword" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Contraseña" required autocomplete="current-password">
            @error('password')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror

            <div class="checkbox mb-3">
              <label class="form-check-label" for="remember">
                 <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
              </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary"  type="submit">Ingresar</button>
            {{-- @if (Route::has('password.request'))
              <a class="btn btn-link" href="{{ route('password.request') }}">
                  {{ __('Recordar Contraseña?') }}
              </a>
            @endif --}}
            <p class="mt-5 mb-3 ">&copy; TorrenteSoftware.com 2021</p>
        </form>
    </main>
</body>
</html>