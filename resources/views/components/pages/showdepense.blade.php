@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title text-center"><i class=""></i><span class="label label-primary">Information détailées sur la dépense : {{$depense->description}}</span>  </h4>
                </div>
                <div class="content">
                    <p><strong>Description : </strong> {{$depense->description}} </p>
                    <p><strong>Montant : </strong> {{number_format($depense->montant)}} </p>
                    <p><strong>Motif : </strong> {{get_option_name($depense->motif)}} </p>
                    <p><strong>Entité : </strong> {{get_option_name($depense->entite)}} </p>
                    <p><strong>Date d'enregistrement : </strong> {{$depense->created_at->format('d/m/Y H:i:s')}} </p>
                    <p><strong>User : </strong> {{$depense->user->username}} </p>                              
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
@stop