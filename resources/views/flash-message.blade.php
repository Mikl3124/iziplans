@if (session('success'))
<div class="alert alert-success alert-block text-center">
  <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('success') !!}
</div>
@endif
@if (session('error'))
<div class="alert alert-danger alert-block text-center">
  <button type="button" class="close" data-dismiss="alert">×</button>
        {!! session('error') !!}
</div>
@endif
@if (session('warning'))
<div class="alert alert-warning alert-block text-center">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {!! session('warning') !!}
</div>
@endif
@if (session('info'))
<div class="alert alert-info alert-block text-center">
  <button type="button" class="close" data-dismiss="alert">×</button>
  {!! session('info') !!}
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger text-center">
  <button type="button" class="close" data-dismiss="alert">×</button>
  Une erreur est survenue
</div>
@endif