  @extends('layouts.app')

  @section('content')
    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-12">

          <!-- Title -->
          <h1 class="mt-4">{{ $article->title }}</h1>

          <!-- Author -->
          <i class="lead">
            par {{ $article->user->firstname }} le {{ Carbon\Carbon::parse($article->created_at)->isoFormat('LL') }}
          </>

          <hr>

          <!-- Preview Image -->
          <img class="img-fluid rounded" src="http://placehold.it/1080x300" alt="">

          <hr>

          <!-- Post Content -->
          <p class="lead">{{$article->full_text}}</p>

          <hr>

        </div>

    </div>
    <!-- /.container -->
  @endsection
