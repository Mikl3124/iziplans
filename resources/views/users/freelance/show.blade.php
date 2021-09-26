@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-body row">
            <div class="col-md-2 col-sm-12 text-center">
                <img class="mr-3 mt-4 rounded profil-avatar" src={{ Auth::user()->avatar }}>

            </div>
            <div class="col-md-8 col-sm-12 my-3 text-center">
                @if(Auth::user()->pseudo)
                    <h2 class="my-auto">{{ Auth::user()->pseudo }}</h2>
                @else
                    <h2 class="my-auto">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h2>
                @endif
                
            <p><em>Membre depuis le {{Carbon\Carbon::parse($user->created_at)->isoFormat('LL')}}</em></p>
            </div>
            <div class="col-md-2 col-sm-12 my-3 text-center">
                @if ( !empty(Auth::user()) && Auth::user()->id === Auth::user()->id)
                    <a href="{{ route('profil-edit', Auth::user()) }}" class="btn btn-primary">Modifier mon profil</a>
                @endif
            </div>

        </div>

    </div>

@auth
    {{-- ------------ Si l'utilisateur est Freelance / Son abonnement ----------- --}}
    @if(Auth::user()->role === 'freelance')
        <div class="card mt-5">
            <div class="card-body row">
                <div class="col-md-12 col-sm-12 my-3 text-center">
                    <h2 class="my-auto">Votre abonnement</h2>
                    <p>Status: {{ $subscription->stripe_status }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 text-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#invoiceModal">
                        Mes factures
                    </button>
                </div>
                <div class="col-md-6 text-center">
                    @if ($subscription->stripe_status === 'canceled')
                        <form action="{{ route('resume-subscription') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success"></i>Réactiver l'abonnement</button>
                        </form>
                    @elseif ($subscription->stripe_status === 'active')
                    <button type="button" class="btn btn-danger mb-5" data-toggle="modal" data-target="#ununscribeModal">
                        Me désabonner
                    </button>
                    @elseif (($subscription->stripe_status === null))
                        <button type="submit" class="btn btn-success"></i>Voir les abonnements </button>
                    @endif
                </div>
            </div>

        </div>

    @endif
@endauth


<!-- Modal désinscription-->
<div class="modal fade" id="ununscribeModal" tabindex="-1" role="dialog" aria-labelledby="ununscribeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ununscribeModalLabel">Supression de l'abonnement</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Attention, vous êtes sur le point de vous désabonner, vous ne pourrez répondre à plus aucune offre à partir du .....
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
          <form action="{{ route('cancel-subscription') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-danger"></i>Confirmer</button>
        </form>
        </div>
      </div>
    </div>
</div>

<!-- Modal Invoices-->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="invoiceModalLabel">Mes factures</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                                <td>{{ $invoice->total() }}</td>
                                <td><a href="/user/invoice/{{ $invoice->id }}">Télécharger</a></td>
                            </tr>
                        <tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
