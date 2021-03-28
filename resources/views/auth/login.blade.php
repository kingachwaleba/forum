@extends('layouts.mainLayout')
@section('content')

    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
            <div class="card-body">
                <h5 class="card-title text-center">{{ __('Login') }}</h5>
                <form class="form-signin" method="POST" action="{{ route('login') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-label-group">
                        <label for="email">{{ __('Adres email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" placeholder="Adres email" value="{{ old('email') }}" required
                               autocomplete="email" autofocus title="Proszę podać adres email.">

{{--                        @error('email')--}}
{{--                        <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                        @enderror--}}
                    </div>

                    <div class="form-label-group">
                        <label for="password">{{ __('Hasło') }}</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password" placeholder="Hasło">

{{--                        @error('password')--}}
{{--                        <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                        @enderror--}}
                    </div>

                    <hr>

                    <p><i>Nie masz konta?</i>
                        <a class="text-info"" href="{{ route('register') }}">Zarejestruj się!</a>
                    </p>

                    <button type="submit" class="btn btn-lg btn-dark btn-block text-uppercase">
                        {{ __('ZALOGUJ SIĘ') }}
                    </button>

                </form>
            </div>
        </div>
    </div>
@endsection


