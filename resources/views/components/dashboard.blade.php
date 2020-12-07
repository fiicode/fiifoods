@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="card ">
                        <div class="header">
                            <h4 class="title"><i class="fa fa-circle text-info"></i> <span class="label label-info">{{get_sale_today()}}</span><i class="pe-7s-coffee"></i> Vente</h4>
                            <p class="category">Total Vente Aujourd'hui {{Date('d M Y')}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card ">
                        <div class="header">
                            <h4 class="title"><i class="fa fa-circle text-success"></i> <span class="label label-success">{{get_int_today()}}</span> Interêt</h4>
                            <p class="category">Total Interêt Aujourd'hui {{Date('d M Y')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card ">
                        <div class="header">
                            <h4 class="title"><i class="fa fa-circle text-primary"></i> <span class="label label-primary">{{get_commande_today()}}</span><i class="fa fa-ship"></i> Commande</h4>
                            <p class="category">Total Commade Aujourd'hui {{Date('d M Y')}}</p>
                        </div>
                    </div>
                </div>
            
                <div class="col-md-6 ">
                    <form action="{{ route('rechercheData') }}" method="POST" class="form-inline m-5">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="search" class="form-control @error('search') is-invalid @enderror" id="search" placeholder="Rechercher">
                            {{-- @error('search') --}}
                                <div class="invalid-feedback" id="search"> {{$errors->first('search')}}</div>
                            {{-- @enderror --}}
                        </div>
                        <button type="submit" class="btn btn-primary btn-fill m-3">Rechercher</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                @if((!$searchs->isEmpty() > 0))
                    <div class="card ">
                        <div class="header">  
                            <p class="title font-weight-bold"><i class="fa fa-search"></i>  <span class="text-lg font-weight-bold">Les dernières recherches</span></p>
                                <p class="category"> {{Date('d M Y')}}</p>  
                        </div>
                        <div class="content">
                            <ul>
                                @foreach($searchs as $search)
                                    <li>{{$search->search }}</li> {{-- recupere moi le title seulement et pour le lien recupere le id  --}}
                                @endforeach
                            </ul>
                        
                        </div>      
                    </div>      
                @else
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <strong>{{ "Désolé aucune recherche n'a été efectué pour le moment" }}!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>  
    @if(Session::has('achats') || Session::has('clients') || Session::has('depenses') || 
        Session::has('factures') || Session::has('foods_names') || Session::has('fournisseurs')  || 
        Session::has('membres') || Session::has('options') || Session::has('orders') || 
        Session::has('ventes'))
    
        {{-- <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                      <h4 class="title"></span><i class="pe-7s-cart"></i> Liste des Ventes<span class="label label-info">{{Date('d M Y')}}</span></h4>
                        <p class="category">Total Crédits Aujourd'hui <span class="label label-danger">{{get_credit_today()}}</span></p>
                    </div>
                    <div class="content">
                        <table class="table table-hover table-striped" id="sale">
                            <thead>
                                <th>Description</th>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach(session('achats') as $achat)
                                        <td>{{$achat->id}}</td>
                                    @endforeach             
                                    @foreach(session('clients') as $client)
                                        <td>{{$client->id}}</td>
                                    @endforeach
                                    @foreach(session('achats') as $achat)
                                        <td>{{$achat->id}}</td>
                                    @endforeach
                                    @foreach(session('depenses') as $depense)
                                        <td>{{$depense->id}}</td>
                                    @endforeach
                                    @foreach(session('factures') as $facture)
                                        <td>{{$facture->id}}</td>
                                    @endforeach
                                    @foreach(session('foods_name') as $foods_name)
                                        <td>{{$foods_name->id}}</td>
                                    @endforeach 
                                    @foreach(session('fournisseurs') as $fournisseur)
                                        <td>{{$fournisseur->id}}</td>
                                    @endforeach 
                                    @foreach(session('membres') as $membre)
                                        <td>{{$membre->id}}</td>
                                    @endforeach
                                    @foreach(session('options') as $option)
                                        <td>{{$option->id}}</td>
                                    @endforeach
                                    @foreach(session('orders') as $order)
                                        <td>{{$order->id}}</td>
                                    @endforeach
                                    @foreach(session('ventes') as $vente)
                                        <td>{{$vente->id}}</td>
                                    @endforeach
                                
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
         --}}
    @endif 

  
    {{-- {{isset(session('achats')) ? dd(session('achats')) :  "La variable n'existe pas "}} --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h4 class="title"></span><i class="pe-7s-cart"></i> Liste des Ventes<span class="label label-info">{{Date('d M Y')}}</span></h4>
                    <p class="category">Total Crédits Aujourd'hui <span class="label label-danger">{{get_credit_today()}}</span></p>
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
                        <th>Stock</th>
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
                            <td><span class="label label-primary">{{$key}}</span></td>
                            @endif
                            <td><span class="label label-info">{{get_total_foods($stock)}}</span></td>
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
        });

    </script>
@stop