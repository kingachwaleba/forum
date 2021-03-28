@extends('layouts.mainLayout')
@section('content')

    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
            <div class="card-body">
                <h5 class="card-title text-center">{{ __('Zarejestruj się') }}</h5>

                <div class="card-body">
                    <form class="form-signin" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-label-group">
                            <label for="name">{{ __('Login') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   pattern="^(?=.*[A-Za-z0-9]$)[A-Za-z][A-Za-z\d.-]{4,8}$"
                                   name="name" placeholder="Login" value="{{ old('name') }}" required
                                   autocomplete="name" autofocus minlength="5" maxlength="8"
                                   title="Proszę podać login. Może zawierać zarówno cyfry, litery, jak i znak -, musi zaczynać się od litery, od 5 do 8 znaków.">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-label-group">
                            <label for="email">{{ __('Adres email') }}</label>
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                                   pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$"
                                   name="email" placeholder="Adres email" value="{{ old('email') }}" required
                                   autocomplete="email" title="Proszę podać adres email.">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-label-group">
                            <label for="password">{{ __('Hasło') }}</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" name="password"
                                   placeholder="Hasło" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$"
                                   required autocomplete="new-password"
                                   title="Proszę podać hasło. Co najmniej jedna mała litera, wielka litera i jedna cyfra, min. 8 znaków.">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <div class="form-label-group">
                            <label for="password-confirm">{{ __('Potwierdź hasło') }}</label>
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation"
                                   placeholder="Ponowne hasło" required autocomplete="new-password"
                                   title="Proszę podać ponownie hasło.">
                            <br/>
                        </div>

                        <div class="form-label-group">
                            <label for="gender_id">{{ __('Płeć') }}</label><br/>
                            @if (old('gender_id') == 1)
                                <input type="radio" class="form @error('gender_id') is-invalid @enderror"
                                       name="gender_id" value="1" title="Wybierz swoją płeć." checked="checked"/>
                                Mężczyzna
                                <input type="radio" class="form @error('gender_id') is-invalid @enderror"
                                       name="gender_id" value="2" title="Wybierz swoją płeć."/>Kobieta<br/>

                            @elseif (old('gender_id') == 2)
                                <input type="radio" class="form @error('gender_id') is-invalid @enderror"
                                       name="gender_id" value="1" title="Wybierz swoją płeć."/>Mężczyzna
                                <input type="radio" class="form @error('gender_id') is-invalid @enderror"
                                       name="gender_id" value="2" title="Wybierz swoją płeć." checked="checked"/>Kobieta
                                <br/>
                            @else
                                <input type="radio" class="form @error('gender_id') is-invalid @enderror"
                                       name="gender_id" value="1" title="Wybierz swoją płeć."/>Mężczyzna
                                <input type="radio" class="form @error('gender_id') is-invalid @enderror"
                                       name="gender_id" value="2" title="Wybierz swoją płeć."/>Kobieta
                                <br/>
                            @endif


                            @error('gender_id')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <hr>

                        <p><i>Masz już konto?</i>
                            <a class="text-info" href="{{ route('login') }}">Zaloguj się!</a>
                        </p>

                        <button type="submit" class="btn btn-lg btn-dark btn-block text-uppercase">
                            {{ __('ZAREJESTRUJ SIĘ') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
