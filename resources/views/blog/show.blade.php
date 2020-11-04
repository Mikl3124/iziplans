  @extends('layouts.app')
  @section('title', "https://iziplans.s3.eu-west-3.amazonaws.com/documents/{{$article->filename}}")
  @section('image', $article->intro_text)
  @section('meta_description', $article->intro_text)
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
          <div class="card mt-5 sticky-top">
            <div class="card-body">
              <img class="card-img-top" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-logo.png" alt="iziplans">
              <p class="card-text">Trouvez le professionnel idéal pour votre projet.</p>
              <div class="text-center">
                <a class="btn btn-primary" href="http://">Vous avez besoin de plans?</a>
                @if (Auth::user()->role === 'admin')
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">
                    Supprimer
                  </button>
                  <a class="btn btn-secondary" href="http://">Modifier</a>
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
