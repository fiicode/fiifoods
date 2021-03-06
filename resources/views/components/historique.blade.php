@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title"><i class="pe-7s-box1"></i><span class="label label-primary"> Tous les achats</span></h4>
                </div>
                <div class="content">
                    <table class="table table-hover table-striped" id="orderTable">
                        <thead>
                        <th>ID</th>
                        <th>N°</th>
                        <th>Produits</th>
                        <th>Qtt</th>
                        <th>Unité</th>
                        <th>Px Achat</th>
                        <th>Mtt</th>
                        <th>Rest</th>
                        <th>Fournisseurs</th>
                        <th>Crée le</th>
                        <th>User</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($achats as $achat)
                            <tr>
                                <td>{{$achat->id}}</td>
                                <td>{{$achat->code}}</td>
                                <td>{{$achat->foodsName->foodsName}}</td>
                                <td>{{$achat->qtt}}</td>
                                <td>{{get_unite($achat->foodsName->foodsName)}}</td>
                                <td>{{number_format($achat->priceOfPurchase)}}</td>
                                <td>{{number_format($achat->priceOfPurchase * $achat->qtt)}}</td>
                                <td class="text-danger">{{number_format($achat->reste)}}</td>
                                <td>{{get_founisseur_name($achat->fournisseur_id)}}</td>
                                <td>{{$achat->created_at->format('d/m/Y H:i')}}</td>
                                <td>{{$achat->user->username}}</td>
                                <td>
                                    <a href="{{route('achats.show', ['achat' => $achat])}}" class="btn btn-xs btn-primary btn-simple" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('achats.edit', ['achat' => $achat])}}" data-toggle="tooltip" data-placement="left" rel="tooltip" title="Supprimer" class="btn btn-danger btn-xs delete btn-simple" data-method="DELETE" data-confirm="Etes-vous sûr"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4><i class="pe-7s-cart"></i> <span class="label label-danger">Toutes les ventes</span></h4>
                    {{--<a href="#" class="btn btn-primary pull-right"><i class="fa fa-flask"></i> Toutes les factures</a>--}}
                    {{--<form action="" method="post">--}}
                    {{--@csrf--}}
                    {{--<div class="col-md-5 pull-right">--}}
                    {{--<div class="col-md-3">--}}
                    {{--<div class="controls">--}}
                    {{--<div class="input-prepend input-group">--}}
                    {{--<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>--}}
                    {{--<input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="{{Date('m')}}/01/{{Date('Y')}} - {{Date('m')}}/{{'01'}}/{{Date('Y')}}" />--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-1 pull-right">--}}
                    {{--<button type="submit" class="btn btn-group-xs pull-right btn-primary"><i class="fa fa-flask"></i> Filtrer</button>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</form>--}}
                    {{--<div class="clearfix"></div>--}}
                </div>
                <div class="content">
                    <table class="table table-hover table-striped" id="factureTable">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>N°</th>
                            <th>Produits</th>
                            <th>Qtt</th>
                            <th>Unité</th>
                            <th>P V</th>
                            <th>Mtt</th>
                            <th>Rest</th>
                            <th>Client</th>
                            <th>Crée le</th>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ventes as $vente)
                            <tr>
                                <td>{{$vente->id}}</td>
                                <td>{{$vente->factureNum}}</td>
                                <td>{{$vente->foodsName->foodsName}}</td>
                                <td>{{$vente->qtt}}</td>
                                <td>{{get_unite($vente->foodsName->foodsName)}}</td>
                                <td>{{number_format($vente->pu)}}</td>
                                <td>{{number_format($vente->pu * $vente->qtt)}}</td>
                                <td class="text-danger">{{number_format($vente->reste)}}</td>
                                <td>{{get_client_name($vente->client_id)}}</td>
                                <td>{{$vente->created_at->format('d/m/Y H:i')}}</td>
                                <td>{{$vente->user->username}}</td>
                                <td>
                                    <a href="{{route('ventes.show', ['vente' => $vente])}}" class="btn btn-xs btn-primary btn-simple" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('ventes.edit', ['vente' => $vente])}}" data-toggle="tooltip" data-placement="left" rel="tooltip" title="Supprimer" class="btn btn-danger btn-xs delete btn-simple" data-method="DELETE" data-confirm="Etes-vous sûr"><i class="fa fa-trash"></i></a>
                                    <a href="{{route('print', ['id' => $vente->id])}}" target="_blank" data-toggle="tooltip" data-placement="left" rel="tooltip" title="Imprimer" class="btn btn-default btn-xs btn-simple"><i class="fa fa-print"></i></a>
                                </td>
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
            $('#orderTable').DataTable()
        })
        $(function () {
            $('#factureTable').DataTable()
        })
        
    </script>

@stop