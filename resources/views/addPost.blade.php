@extends('layouts.mainLayout')
@section('content')
    <div class="col-md-8">
        <!-- Post Form -->
        <div class="card my-4">
            <h5 class="card-header">Dodaj Post</h5>
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
                <form action="{{ route('store') }}" id="post-form" method="POST"
                      enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('message')?'has-error':'' }}" id="roles_box">
                        <label for="title">Tytuł</label><textarea class="form-control" name="title" id="title" cols="40" rows="1" placeholder="Tytuł"
                                                             required minlength="10" maxlength="100" title="Dodaj tytuł, min. 10, max. 100 znaków.">{{ old('title') }}</textarea><br/>
                        <label for="message">Post</label><textarea class="form-control" name="message" id="message" cols="40" rows="20" placeholder="Post"
                                                               required minlength="50" maxlength="2000" title="Dodaj post, min. 50, max. 2000 znaków.">{{ old('message') }}</textarea><br/>
                        <label for="post_image">Zdjęcie</label><input id="post_image" type="file" class="form-control" name="post_image" title="Max. 500x500, min. 100x100">
                    </div>
                    <button type="submit" class="btn btn-success">Dodaj</button>
                </form>
            </div>
        </div>
    </div>
@endsection

