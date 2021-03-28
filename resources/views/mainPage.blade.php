@extends('layouts.mainLayout')
@section('content')
    <!-- Page Content -->

    <!-- Blog Entries Column -->

    <div class="col-md-8">

        <h1 class="my-4">Strona główna <small>Zobacz wszystkie posty</small>
        </h1>

        @if(DB::table('posts')->count() == 0)
            <h3 class="card-title">Brak postów!</h3>
        @else
        <!-- Blog Post -->
            @foreach($posts as $post)
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">{{ $post->title }}</h2>
                        <p class="card-text" id="post_message{{ $post->id }}">
                            <script>
                                var message = '{{ $post->message }}';
                                var id = '{{ $post->id }}';
                                var result = message.slice(0, 100) + '...';
                                document.getElementById('post_message' + id).innerHTML = result;
                            </script>
                        </p>
                        <a href="{{ route('postForm',  ['id' => $post->id, 'title' => $post->title]) }}" class="btn btn-success">Dowiedz się więcej
                            &rarr;</a>
                    </div>
                    <div class="card-footer text-muted">
                        Dodano {{ $post->created_at }} przez
                        <a class="text-info"
                           href="{{ route('showUser', $post->user->name) }}">{{ $post->user->name }}</a>
                    </div>
                </div>
        @endforeach
    @endif
    <!-- Pagination -->
        <div class="pagination justify-content-center mb-4">
            {{ $posts->links() }}
        </div>
    </div>

@endsection
