{{-- <p>Hello Foods</p> --}}
@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header"> Information détailées sur le produit : {{get_foodsName($achat->foods_name_id)}} </span></h3>
                </div>
                    <h3 class="title text-center"><i class=""></i><span class="label label-primary"> 
                <div class="content">
                    <p><strong>FoodsName : </strong> {{$foods_name->foodsName}} </p>
                    <p><strong>Unité : </strong> {{get_unite($foods_name->foodsName)}} </p>
                    <p><strong>Inventaire : </strong> {{$foods_name->inventaire > 0 ? 'Oui' : 'Non'}} </p>
                    <p><strong>User : </strong> {{$foods_name->user->username}} </p>
                    <p><strong>Date d'enregistrement : </strong> {{$foods_name->created_at->format('d/m/Y H:m:s')}} </p>                     
                
                </div>
            </div>
        </div> 
    </div>
@stop
@section('scripts')
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
@stop