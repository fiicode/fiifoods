@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title"><i class="fa fa-cicle text-primary"></i><span class="label label-info">{{ number_format($commande) }} </span></h4>
                    <p class="category">Total Commande</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title"><i class="fa fa-cicle text-primary"></i><span class="label label-info">{{ number_format($vente) }} </span></h4>
                    <p class="category">Total Vente</p>
                </div>
            </div>
        </div>
    </div>

@stop
@section('scripts')
    <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.bootstrap.min.js')}}"></script>
@stop
@section('notification')
    <script>
        $(function () {
            $('#sale').DataTable()
        })
        $(function () {
            $('#dashboard').DataTable()
        })
        
    </script>
@stop