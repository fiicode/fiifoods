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
                    <h3 class="title text-center"><i class=""></i><span class="label label-primary"> Information détailées sur le produit : {{ $foods_name->foodsName }} </span></h3>
                </div>
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
