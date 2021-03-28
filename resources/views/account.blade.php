@extends('layouts.mainLayout')
@section('content')
    <div class="col-md-8">
        <h1 class="my-4">
            @if($user->user_image != NULL)
                <img class="rounded-circle" src="{{ asset($user->user_image) }}" alt="User picture" height="45"
                     width="45">
            @else
                <img class="rounded-circle" src="{{ asset('/img/user-alt-512.png') }}" alt="User picture"
                     height="45"
                     width="45">
            @endif
            <small>Profil użytkownika</small>
            {{ $user->name }}
            @auth
                @if ($user->id == Auth::user()->id)
                    <a class="btn btn-success" href="{{ route('editUser', $user->name) }}" role="button"><img
                            src="<?= asset('img/icons8-edit-100.png') ?>" height="20" alt="edit button"></a>
                    <a class="btn btn-danger float-none" href="{{ route('deleteUser', $user) }}" role="button"
                       onclick="return confirm('Jesteś pewien?')" title="Skasuj"><i class="fa fa-trash-o"></i>
                        <img src="<?= asset('img/icons8-remove-128.png') ?>" height="20" alt="delete button"></a>
                @endif
            @endauth
        </h1>
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="accountTable" class="table table-striped table-bordered">
                    <tbody>
                    <tr>
                        <th scope="row">Nazwa użytkownika:</th>
                        <td class="text-center">{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Płeć:</th>
                        <td class="text-center">{{ $user->gender->name }}</td>
                    </tr>
                    <tr>
                        <th scope="row">O mnie:</th>
                        <td class="text-center">
                            @if($user->about == NULL)
                                brak informacji
                            @else
                                {{ $user->about }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" colspan="1">Liczba postów:</th>
                        <td class="text-center">{{ $user->getPostsCountAttribute() }}</td>
                    </tr>
                    <tr>
                        <th scope="row">Liczba komentarzy:</th>
                        <td class="text-center">{{ $user->getCommentsCountAttribute() }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
