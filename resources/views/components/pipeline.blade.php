@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="card ">
                <div class="header">
                    <h4 class="title"><span class="label label-primary">{{get_commande_all()}}</span> <i class="fa fa-ship"></i> Total Commande</h4>
                    <p class="category">Montant Total Commade effectué</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card ">
                <div class="header">
                    <h4 class="title"><span class="label label-primary">{{get_stock_all()}}</span> <i class="pe-7s-server"></i> Total Stock</h4>
                    <p class="category">Montant Total de Stok effectué</p>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card ">
                <div class="header">
                    <h4 class="title"><span class="label label-info">{{get_sale_all()}}</span> <i class="pe-7s-coffee"></i> Total Vente</h4>
                    <p class="category">Montant Total de Vente effectué</p>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="col-md-6">
                <div class="card ">
                    <div class="header">
                        <h4 class="title"><span class="label label-success">{{get_int_all()}}</span> <i class="pe-7s-diamond"></i> Interêt</h4>
                        <p class="category">Montant Total d'Interêt effectué</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card ">
                    <div class="header">
                        <h4 class="title"><span class="label label-danger">{{get_credit_all()}}</span> <i class="pe-7s-cloud-upload"></i> Solde</h4>
                        <p class="category">Montant Total de Solde effectué</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">

                <div class="header">
                    <h4 class="title"></span><i class="pe-7s-display1"></i> <span class="label label-info">Vente journalier</span></h4>
                </div>
                <div class="content">
                    <form action="{{route('recherche')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="">Du</label>
                                <input type="date" class="form-control" name="du" value="{{Date('Y-m')}}-01">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Au</label>
                                <input type="date" class="form-control" name="au" value="{{Date('Y-m-d')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <br>
                                <button class="btn btn-primary btn-fill">Chercher</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h4 class="title"></span><i class="pe-7s-display1"></i> Status de vente le <span class="label label-info">{{Date('d M Y')}}</span></h4>
                </div>
                <div class="content">
                    <div class="content">
                        <div class="footer">
                            <div class="legend">
                                <div class="col-md-12">
                                    <div class="col-md-8">
                                        <i class="fa fa-circle text-info"></i> Vente <span class="label label-info">{{session('du')}}</span> au <span class="label label-info">{{session('au')}}</span>:
                                    </div>
                                    <div class="col-md-4">
                                        <h3>{{session('vente')}} </h3>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-8">
                                        <i class="fa fa-circle text-danger"></i> Interet <span class="label label-info">{{session('du')}}</span> au <span class="label label-info">{{session('au')}}</span>:
                                    </div>
                                    <div class="col-md-4">
                                        <h3>{{session('interet')}}</h3>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
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