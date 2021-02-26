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
    {{-- <php $client = session('client') ?> --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                <h4 class="title text-center"><i class=""></i> <span class="label label-primary">Information détailées sur le client :   {{$client->nom}}</span></h4>
                </div>
                <div class="content">
                    <p><strong>Nom : </strong> {{$client->nom}} </p>
                    <p><strong>Contact : </strong> {{$client->phone}} </p>
                    <p><strong>Solde : </strong> <span class="label label-danger">{{get_client_solde($client->id)}} </p>
                    <p><strong>Date d'enregistrement : </strong> {{$client->created_at->format('d/m/y H:m:s')}} </p>
                    <p><strong>User : </strong> {{$client->user->username}} </p>

                </div>
            </div>
        </div>
    </div>
   
@stop