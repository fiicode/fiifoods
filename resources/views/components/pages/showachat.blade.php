@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')
{{-- <php $achat = session('achat') ?> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h3 class="title text-center"><i class=""></i><span class="label label-primary"> Information détailées sur le produit : {{get_foodsName($achat->foods_name_id)}} </span></h3>
                </div>
                <div class="content">
                    <p><strong>ID : </strong> {{$achat->id}} </p>
                    <p><strong>N° Commande : </strong> {{$achat->code}} </p>
                    <p><strong>Produit : </strong> {{get_foodsName($achat->foods_name_id)}} </p>
                    <p><strong>Quantité : </strong>{{$achat->qtt}} </p>
                    <p><strong>Prix d'achat : </strong> {{$achat->priceOfPurchase}} </p>
                    <p><strong>Prix de vente : </strong> {{$achat->sellingPrice}} </p>
                    <p><strong>Fournisseurs : </strong>{{get_founisseur_name($achat->fournisseur_id)}} </p>
                    {{-- <p><strong>Reste : </strong class="text-danger">{{number_format($achat->reste)}} </p> --}}
                    <p><strong>User : </strong> {{$achat->user->username}} </p>
                    <p><strong>Date d'enregistrement : </strong> {{$achat->created_at->format('d/m/Y H:m:s')}} </p>                     
                               
                </div>
            </div>
        </div> 
    </div>
    
@stop
@section('scripts')
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
@stop
