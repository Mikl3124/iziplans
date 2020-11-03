  @extends('layouts.app')

  @section('content')
    <!-- Page Content -->
    <div class="container">

      <div class="row">
        <!-- Post Content Column -->
        <div class="col-md-9 col-sm-12">
          <h1 class="mt-4">{{ $article->title }}</h1>
          <i>
            par {{ $article->user->firstname }} le {{ Carbon\Carbon::parse($article->created_at)->isoFormat('LL') }}
          </i>
          <hr>

          <!-- Preview Image -->
          <img class="img-fluid rounded" src="https://iziplans.s3.eu-west-3.amazonaws.com/documents/{{ $article->filename }}" alt="{{ $article->title }}">

          <hr>

          <!-- Post Content -->
          {!! $article->full_text !!}

          <hr>

        </div>
        <div class="col-md-3 col-sm-12">
          <div class="card mt-4">
            <div class="card-body">
              <h5 class="card-title">Card title</h5>
              <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <div class="text-center">
                @if (Auth::user()->role === 'admin')
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                    Supprimer
                  </button>
                  <a class="btn btn-secondary" href="http://">Modifier</a>
                @else
                  <a class="btn btn-success" href="http://">Besoin de plans?</a>
                @endif

              </div>

            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.container -->

    <!-- Modal Article Delete-->
<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Attention</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Etes-vous sûr de vouloir supprimer cet article?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
        <a class="btn btn-danger" href="{{ route('article.delete', Str::slug($article->url)) }}">Supprimer</a>
      </div>
    </div>
  </div>
</div>
  @endsection
