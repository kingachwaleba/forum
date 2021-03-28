@extends('layouts.mainLayout')
@section('content')
    <div class="col-md-8">

        <h1 class="my-4">Twoje posty
        </h1>
        <div class="col-md-12">
            @if($user->getPostsCountAttribute() !== 0)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <th>Tytuł</th>
                        <th>Dodano</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                        </thead>
                        <tbody>
                        @foreach($user->post as $post)
                            <tr>
                                <td><a class="text-info"
                                       href="{{ route('postForm',  ['id' => $post->id, 'title' => $post->title]) }}">{{ $post->title }}</a></td>
                                <td class="text-center">{{ $post->created_at }}</td>
                                <td class="text-center"><a class="btn btn-success"
                                                           href="{{ route('edit', $post->id) }}"
                                                           role="button"><img
                                            src="<?= asset('img/icons8-edit-100.png') ?>" height="20"
                                            alt="edit button"></a>
                                </td>
                                <td class="text-center"><a class="btn btn-danger"
                                                           href="{{ route('delete', $post->id) }}" role="button"
                                                           onclick="return confirm('Jesteś pewien?')"
                                                           title="Skasuj"><i
                                            class="fa fa-trash-o"></i>
                                        <img src="<?= asset('img/icons8-remove-128.png') ?>" height="20"
                                             alt="delete button"></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p><i><a class="text-info" href="{{ route('showUser', Auth::user()->name) }}">{{ $user->name }}</a>
                        - nie masz jeszcze postów. <br/>
                        Kliknij w <a class="text-info" href="{{ route('addPost') }}">link</a> i dodaj pierwszy post!</i>
                </p>
            @endif
        </div>
    </div>
@endsection
