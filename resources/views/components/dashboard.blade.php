@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')

        <div class="row">
            <div class="col-md-4">
                <div class="card ">
                    <div class="header">
                        <h4 class="title"><i class="fa fa-circle text-info"></i> <span class="label label-info">{{get_sale_today()}}</span><i class="pe-7s-coffee"></i> Vente</h4>
                        <p class="category">Total Vente Aujourd'hui {{Date('d M Y')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card ">
                    <div class="header">
                        <h4 class="title"><i class="fa fa-circle text-success"></i> <span class="label label-success">{{'0'}}</span> Interêt</h4>
                        <p class="category">Total Interêt Aujourd'hui {{Date('d M Y')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card ">
                    <div class="header">
                        <h4 class="title"><i class="fa fa-circle text-primary"></i> <span class="label label-primary">{{get_commande_today()}}</span><i class="fa fa-coffee"></i> Commande</h4>
                        <p class="category">Total Commade Aujourd'hui {{Date('d M Y')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">

                    <div class="header">
                        <h4 class="title"></span><i class="pe-7s-cart"></i> Liste des Ventes<span class="label label-info">{{Date('d M Y')}}</span></h4>
                        <p class="category">Total Crédits <span class="label label-danger">{{get_credit_today()}}</span></p>
                    </div>
                    <div class="content">
                        <table class="table table-hover table-striped" id="sale">
                            <thead>
                                <th>Produist</th>
                                <th>Quantité</th>
                                <th>Montant</th>
                            </thead>
                            <tbody>
                            @foreach($ventes as $vente=>$key)
                                <tr>
                                    <td>{{$vente}}</td>
                                    @foreach($key as $value=>$k)
                                    <td>{{$value}}</td>
                                    <td>{{number_format($k)}}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="header">
                        <h4 class="title"><i class="pe-7s-display1"></i> Stock</h4>
                        <p class="category">24 Hours performance</p>
                    </div>
                    <div class="content">

                        <table class="table table-hover table-striped" id="dashboard">
                            <thead>
                            <th>Produit</th>
                            <th>Prix d'achat</th>
                            <th>Reste</th>
                            <th>Total</th>
                            </thead>
                            <tbody>
                            @foreach($stocks as $stock=>$key)
                            <tr>
                                <td>{{get_foodsName($stock)}}</td>
                                <td>{{get_prix_achat($stock)}}</td>
                                @if($key < 0)
                                <td><span class="label label-danger">{{$key}}</span></td>
                                @else
                                <td><span class="label label-success">{{$key}}</span></td>
                                @endif
                                <td><span class="label label-primary">{{get_total_foods($stock)}}</span></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
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