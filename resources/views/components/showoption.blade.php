@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')

                                   
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h3 class="title text-center"><i class=""></i><span class="label label-primary"> Information détailées sur l'option : {{$option->name}} </span></h3>
                </div>
                <div class="content">
                    <p><strong>Nom : </strong> {{$option->name}} </p>
                    <p><strong>Motif : </strong> {{$option->motif}} </p>
                    <p><strong>Date d'enregistrement : </strong> {{$option->created_at->format('d/m/Y H:i:s')}} </p>
                   
                </div>
            </div>
        </div> 
    </div>

@stop
@section('scripts')
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
@stop