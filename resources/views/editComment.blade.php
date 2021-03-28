@extends('layouts.mainLayout')
@section('content')
    <div class="col-md-8">
        <!-- Post Form -->
        <div class="card my-4">
            <h5 class="card-header">Edytuj komentarz</h5>
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
                <form action="{{ route('updateComment', $comment->id) }}" id="comment-form" method="POST"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PUT">
                    <div class="form-group {{ $errors->has('message')?'has-error':'' }}" id="roles_box">
                        <label for="message"></label><textarea class="form-control" name="message" id="message"
                                                               cols="40" rows="5"
                                                               placeholder="Komentarz" title="Edytuj komentarz, min. 10, max. 500 znaków."
                                                               required required minlength="10"
                                                               maxlength="500">{{ old('title') ? old('title') : $comment->message }}</textarea><br/>
                        <input id="comment_image" type="file" class="form-control" name="comment_image" title="Max. 300x400, min. 50x50">
                    </div>
                    @if ($comment->comment_image)
                        <a class="btn btn-danger" href="{{ route('deleteCommentPicture', $comment->id) }}" role="button"
                           onclick="return confirm('Jesteś pewien?')" title="Skasuj"><i class="fa fa-trash-o"></i>
                            <i class="fa fa-trash-o"></i>
                            <img src="<?= asset('img/icons8-remove-128.png') ?>" height="20"
                                 alt="delete button"></a>
                        <code>{{ $comment->comment_image }}</code>
                    @endif
                    <hr>
                    <button type="submit" class="btn btn-success">Edytuj</button>
                </form>
            </div>
        </div>
    </div>
@endsection
