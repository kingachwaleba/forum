@extends('layouts.mainLayout')
@section('content')
    <div class="col-md-8">
        <h1 class="my-4">
            @if($user->user_image != NULL)
                <img class="rounded-circle" src="{{ asset($user->user_image) }}" alt="User picture" height="45"
                     width="45">
            @endif
            <small>Profil użytkownika</small>
            {{ $user->name }}
            @if ($user->id == Auth::user()->id)
                <a class="btn btn-danger float-none" href="{{ route('deleteUser', $user) }}" role="button"
                   onclick="return confirm('Jesteś pewien?')" title="Skasuj"><i class="fa fa-trash-o"></i>
                    <img src="<?= asset('img/icons8-remove-128.png') ?>" height="20" alt="delete button"></a>
            @endif
        </h1>
        <div class="col-md-12">
            <form action="{{ route('updateUser', $user->id) }}" id="post-form" method="POST"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                <div class="form-group {{ $errors->has('message')?'has-error':'' }}" id="roles_box">
                    <div class="table-responsive">
                        <table id="accountTable" class="table table-striped table-bordered">
                            <tbody>
                            <tr>
                                <th scope="row">Nazwa użytkownika:</th>
                                <td class="text-center">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           pattern="^(?=.*[A-Za-z0-9]$)[A-Za-z][A-Za-z\d.-]{4,8}$"
                                           name="name" placeholder="Login"
                                           value="{{ old('name') ? old('name') : $user->name }}" required
                                           autocomplete="name" autofocus minlength="5" maxlength="8"
                                           title="Proszę podać login. Może zawierać zarówno cyfry, jak i litery, musi zaczynać się od litery, od 5 do 8 znaków.">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Płeć:</th>
                                <td class="text-left">
                                    @if($user->gender_id == 1)
                                        <input type="radio" name="gender_id" value="1" title="Wybierz swoją płeć."
                                               checked="checked">Mężczyzna
                                        <input type="radio" name="gender_id" value="2" title="Wybierz swoją płeć.">
                                        Kobieta<br/>
                                    @else
                                        <input type="radio" name="gender_id" value="1" title="Wybierz swoją płeć.">
                                        Mężczyzna
                                        <input type="radio" name="gender_id" value="2" title="Wybierz swoją płeć."
                                               checked="checked">Kobieta<br/>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">O mnie:</th>
                                <td class="text-center">
                                    <input type="text" name="about" id="about"
                                           class="form-control @error('about') is-invalid @enderror"
                                           placeholder="O mnie" minlength="5" maxlength="100"
                                           value="{{ old('about') ? old('about') : $user->about }}"
                                           title="Możesz podać swój opis, min. 5, max 100 znaków.">{{ $user->about }}
                                    @error('about')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Zdjecie profilowe:</th>
                                <td class="text-left">
                                    <input id="user_image" type="file" class="form-control @error('user_image') is-invalid @enderror" name="user_image" title="Max. 300x200, min. 50x50">
                                    @if ($user->user_image)
                                        <hr>
                                        <a class="btn btn-danger" href="{{ route('deleteUserPicture', $user->id) }}"
                                           role="button"
                                           onclick="return confirm('Jesteś pewien?')" title="Skasuj"><i
                                                class="fa fa-trash-o"></i>
                                            <i class="fa fa-trash-o"></i>
                                            <img src="<?= asset('img/icons8-remove-128.png') ?>" height="20"
                                                 alt="delete button"></a>
                                        <code>{{ $user->user_image }}</code>
                                    @endif
                                    @error('user_image')
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Edytuj</button>
            </form>
        </div>
        <br/>
    </div>
@endsection

