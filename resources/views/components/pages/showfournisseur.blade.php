@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
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
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                <h4 class="title text-center"><i class=""></i> <span class="label label-primary">Information détailées sur le fournisseur :   {{$fournisseur->nom}}</span></h4>
                </div>
                <div class="content">
                    <p><strong>Nom : </strong>{{$fournisseur->nom}} </p>
                    <p><strong>Contact : </strong> {{$fournisseur->phone}} </p>
                    <p><strong>Solde : </strong> <span class="label label-danger">{{get_client_solde($fournisseur->id)}} </p>
                    <p><strong>Date d'enregistrement : </strong> {{$fournisseur->created_at->format('d/m/y H:m:s')}} </p>
                    <p><strong>User : </strong> {{$fournisseur->user->username}} </p>
                </div>
            </div>
        </div>
    </div>
   
@stop
