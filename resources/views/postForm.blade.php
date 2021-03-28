@extends('layouts.mainLayout')
@section('content')

    <!-- Post Content Column -->
    <div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4">{{ $post->title }}</h1>

        <!-- Author -->
        <p class="lead">
            <a class="text-info" href="{{ route('showUser', $post->user->name) }}">{{ $post->user->name }}</a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p>
            @auth
                @if ($post->user->id === Auth::user()->id)
                    <a class="btn btn-success" href="{{ route('edit', $post->id) }}"
                       role="button"><img
                            src="<?= asset('img/icons8-edit-100.png') ?>" height="20" alt="edit button"></a>
                    <a class="btn btn-danger"
                       href="{{ route('delete', $post->id) }}" role="button"
                       onclick="return confirm('Jesteś pewien?')" title="Skasuj"><i
                            class="fa fa-trash-o"></i>
                        <img src="<?= asset('img/icons8-remove-128.png') ?>" height="20"
                             alt="delete button"></a>
                @endif
            @endauth
            Dodano {{ $post->created_at }}
            @if($post->created_at != $post->updated_at)
                <i>Edytowano {{ $post->updated_at }}</i>
            @endif
        </p>

        <!-- Preview Image -->
        @if ($post->post_image)
            <hr>
            <a href="{{ asset($post->post_image) }}" class="card-img-top" data-lightbox="photos">
                <img class="img-fluid" src="{{ asset($post->post_image) }}" alt="Obraz">
            </a>
        @endif

        <hr>

        <!-- Post Content -->
        <p>{{ $post->message }}</p>

        <hr>

        <!-- Add comment -->
        @auth
            <div class="card my-4">
                <h5 class="card-header">Dodaj komentarz</h5>
                <!-- Display errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('storeComment', $post->id) }}" id="comment-form" method="POST"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('message')?'has-error':'' }}" id="roles_box">
                            <label for="message"></label><textarea class="form-control" name="message" id="message"
                                                                   cols="40" rows="5"
                                                                   placeholder="Komenatrz"
                                                                   required minlength="10"
                                                                   maxlength="500"
                                                                   title="Dodaj komentarz, min. 10, max. 500 znaków.">{{ old('message') }}</textarea><br/>
                            <input id="comment_image" type="file" class="form-control" name="comment_image"
                                   title="Max. 300x400, min. 50x50">
                        </div>

                        <button type="submit" class="btn btn-success">Dodaj</button>
                    </form>
                </div>
            </div>
        @else
            <p>
                <a class="btn-link" href="{{ route('login') }}">Zaloguj się</a> lub<a class="btn-link"
                                                                                      href="{{ route('register') }}">
                    załóż konto</a>, żeby móc komentować posty!
            </p>
            <hr>
        @endauth

    <!-- Count comments -->
        <p>
            <i>Liczba komentarzy pod postem: {{ $post->getCommentsCountAttribute() }}</i>
        </p>

        <!-- Comments -->
        @foreach($post->comment as $com)
            <div class="media mb-4">
                @if($com->user->user_image)
                    <img class="d-flex mr-3 rounded-circle" src="{{ asset($com->user->user_image) }}" alt="User picture"
                         height="45"
                         width="45">
                @else
                    <img class="d-flex mr-3 rounded-circle" src="{{ asset('/img/user-alt-512.png') }}"
                         alt="User picture"
                         height="45"
                         width="45">
                @endif
                <div class="media-body">
                    <h5 class="mt-0"><a class="text-info"
                                        href="{{ route('showUser', $com->user->name) }}">{{ $com->user->name }}</a></h5>
                    @auth
                        @if ($com->user->id === Auth::user()->id)
                            <a class="btn btn-success btn-sm" href="{{ route('editComment', $com->id) }}" role="button">Edytuj</a>
                            <a class="btn btn-danger btn-sm"
                               href="{{ route('deleteComment', ['name' => $post->title, 'id' => $com]) }}" role="button"
                               onclick="return confirm('Jesteś pewien?')" title="Skasuj"><i class="fa fa-trash-o"></i>
                                Usuń</a>
                        @endif
                    @endauth
                    <p>Dodano {{ $com->created_at }}
                        @if($com->created_at != $com->updated_at)
                            <i>Edytowano {{ $com->updated_at }}</i>
                        @endif
                    </p>
                    {{ $com->message }}
                    @if($com->comment_image)
                        <a href="{{ asset($com->comment_image) }}" class="d-flex mr-3" data-lightbox="photos">
                            <img class="img-fluid" src="{{ asset($com->comment_image) }}" alt="Obraz" height="250"
                                 width="250">
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

@endsection
