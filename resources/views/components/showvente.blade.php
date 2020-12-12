@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert.css')}}">


    <style>
        .autocomplete-suggestions {
            border: 1px solid #e4e4e4;
            background: #F4F4F4;
            cursor: default;
            overflow: auto
        }
        .autocomplete-suggestion {
            padding: 2px 5px;
            font-size: 1.2em;
            white-space: nowrap;
            overflow: hidden
        }
        .autocomplete-selected {
            background: #f0f0f0
        }
        .autocomplete-suggestions strong {
            font-weight: normal;
            color: #3399ff;
            font-weight: bolder
        }
    </style>
@stop
@section('content')
    {{-- <php $vente = session('vente') ?>
    @if(Session::has('ventes'))
        <php $ventes = session('ventes') ?>
    @endif --}}


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h3 class="title text-center"><i class=""></i><span class="label label-primary"> Information détailées sur le produit {{$vente->foodsName->foodsName}} </span></h3>
                </div>
                <div class="content">
                    <p><strong>N° Facture : </strong> {{$vente->factureNum}}</p>
                    <p><strong>Produit : </strong> {{$vente->foodsName->foodsName}} </p>
                    <p><strong>Quantité : </strong> {{$vente->qtt}}</p>
                    <p><strong> P V Unité : </strong> {{number_format($vente->pu)}} </p>
                    <p><strong>Montant total : </strong> {{number_format($vente->pu * $vente->qtt)}} </p>
                    <p><strong>Client : </strong>{{get_client_name($vente->client_id)}} </p>
                    <p><strong>User : </strong> {{$vente->user->username}} </p>
                    <p><strong>Date d'enregistrement : </strong> {{$vente->created_at->format('d/m/Y H:i:s')}} </p>                     

                </div>
            </div>
        </div>
    </div>
@stop