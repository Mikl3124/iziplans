
@extends('layouts.app')

@section('content')

  <!-- Tiny Editor  -->
  <script src='https://cdn.tiny.cloud/1/d4edgvbtpkw4b8z1qtao2khy8em9ljzsbjmjp77n255jrnhf/tinymce/5/tinymce.min.js' referrerpolicy="origin">
  </script>

  <script>
    tinymce.init({
      language : "fr_FR",
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      height : "580"
    });
  </script>

  <div class="container mt-5">
      <textarea>
        Veuillez écrire le texte...
      </textarea>
  </div>



@endsection
