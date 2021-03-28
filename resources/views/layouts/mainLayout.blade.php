<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('layouts.partials.head')

</head>

<body>

@include('layouts.partials.navbar')

<div id="page-content" class="container">
    <div class="row">

    @yield('content')

    <!-- Sidebar Widgets Column -->
        <div class="col-md-4">
            @include('layouts.partials.sidebar')
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->

@include('layouts.partials.footer')

@include('layouts.partials.footer-scripts')

</body>
</html>
