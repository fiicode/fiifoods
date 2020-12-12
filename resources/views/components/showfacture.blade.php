@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')

    <div class="row">
       <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title text-center"><i class=""></i><span class="label label-primary">Information détailées sur la facture </span>  </h4>
                </div>
                <div class="content">
                    <p><strong>Numéro de la facture : </strong> {{$facture->factureNum}} </p>
                    <p><strong>Date d'enregistrement : </strong> {{$facture->created_at}} </p>
                </div>
            </div>
        </div> 
    </div>

@stop
@section('scripts')
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
@stop