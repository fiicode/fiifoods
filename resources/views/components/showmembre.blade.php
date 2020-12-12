@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title"><i class=""></i><span class="label label-primary">Information détailées sur le membre : {{$membre->nom}}</span>  <a href="{{route('achats')}}" class="btn btn-info btn-fill pull-right btn-xs"><i class="fa fa-flask"></i> Toutes les achats</a></h4>
                </div>
                <div class="content">
                    < <p><strong>Nom : </strong> {{$membre->nom}}</p>
                    <p><strong>Contact : </strong> {{$membre->phone}} </p>
                    <p><strong>Date d'enregistrement : </strong> {{$membre->created_at->format('d/m/y H:m:s')}} </p>
                </div>
            </div>
        </div> 
    </div>

@stop
@section('scripts')
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
@stop