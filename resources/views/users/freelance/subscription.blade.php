@extends('layouts.app')

@section('content')

@auth
<div class="container">
    {{-- ------------ Si l'utilisateur est Freelance / Son abonnement ----------- --}}
    @if(Auth::user()->role === 'freelance')
        <div class="card mt-5">
            <h2 class="my-3 text-center">Votre abonnement</h2>
            <div class="card-body row">
                
                <div class="col-3">

                </div>
                <div class="col-md-6 col-sm-12 my-3">
                    
                    {{-- -------------- Abonnement Annulé --------------- --}}
                    @if (Auth::user()->subscription('abonnement')->cancelled())
                        <p><i class="fas fa-redo"></i> Renouvellement automatique: Désactivé</p>
                        <p><i class="far fa-calendar-alt"></i> Vous pouvez répondre aux offres jusqu'au : {{ $date_end }}</p>
                    @elseif( (Auth::user()->subscription('abonnement')->active()))
                        <p><i class="fas fa-redo"></i> Renouvellement automatique: Activé</p>
                        <p><i class="far fa-calendar-alt"></i> Prochaine échéance : {{ $nextPayment }}</p>
                        {{ Auth::user()->subscription('abonnement')->ends_at }}
                    @endif
                </div>
                <div class="col-3">
                    
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-6 text-center mb-3">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#invoiceModal">
                        Mes factures
                    </button>
                </div>
                <div class="col-md-6 text-center">
                    @if (Auth::user()->subscription('abonnement')->cancelled())
                        <form action="{{ route('resume-subscription') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success"></i>Réactiver l'abonnement</button>
                        </form>
                    @elseif ($subscription->stripe_status === 'active')
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ununscribeModal">
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

</div>

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
          Attention, vous êtes sur le point de supprimer le renouvellement automatique, vous ne pourrez plus répondre aux offres à partir du {{ $nextPayment }}.
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
                        @if($invoices->count() === 0)
                            <p><em>Aucune facture disponible</em></p>
                        @else                  
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td>{{ Carbon\Carbon::parse($invoice->date())->isoFormat('LL') }}</td>
                                    <td>{{ $invoice->total() }}</td>
                                    <td><a href="/user/invoice/{{ $invoice->id }}">Télécharger</a></td>
                                </tr>
                            <tr>
                            @endforeach
                        @endif
                    </tbody>
                  </table>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
