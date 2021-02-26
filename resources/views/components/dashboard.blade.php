@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
@stop
@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="row">
                @if(Auth::user()->id == 1 || Auth::user()->id == 2 || access_sell() || access_anal())
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title"><i class="fa fa-circle text-info"></i> <span class="label label-info">{{get_sale_today()}}</span><i class="pe-7s-coffee"></i> Vente</h4>
                                <p class="category">Total Vente Aujourd'hui {{Date('d M Y')}}</p>
                            </div>
                        </div>
                    </div>
                    @if(access_sell() && Auth::user()->id != 2 && !(access_sell() && access_anal() && access_order()) && !(access_sell() && access_anal() ))
                        <div class="col-md-6">
                            <form action="{{ route('rechercheData') }}" method="POST" class="form-inline m-5">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" name="search" class="form-control @error('search') is-invalid @enderror mb-5" id="search" placeholder="Rechercher">
                                    @if($errors->has('search'))
                                        <span class="text-danger">
                                            <p style="font-size: 11px">{{$errors->first('search')}}</p>
                                        </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary btn-fill m-3">Rechercher</button><br><br>
                            </form>
                        </div>
                    @endif
                @endif
                
                @if(Auth::user()->id == 1 || Auth::user()->id == 2 || (access_order() && access_anal() && access_sell()))
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title"><i class="fa fa-circle text-success"></i> <span class="label label-success">{{get_int_today()}}</span> Interêt</h4>
                                <p class="category">Total Interêt Aujourd'hui {{Date('d M Y')}}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                @if(Auth::user()->id == 1 || Auth::user()->id == 2 || access_order() || access_anal())
                    <div class="col-md-6">
                        <div class="card ">
                            <div class="header">
                                <h4 class="title"><i class="fa fa-circle text-primary"></i> <span class="label label-primary">{{get_commande_today()}}</span><i class="fa fa-ship"></i> Commande</h4>
                                <p class="category">Total Commade Aujourd'hui {{Date('d M Y')}}</p>
                            </div>
                        </div>
                    </div>
               
                    <div class="col-md-6">
                        <form action="{{ route('rechercheData') }}" method="POST" class="form-inline m-5">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" name="search" class="form-control" id="search" placeholder="Rechercher">
                                @if($errors->has('search'))
                                    <span class="text-danger">
                                        <p style="font-size: 11px">{{$errors->first('search')}}</p>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary btn-fill m-3">Rechercher</button><br><br>
                        </form>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                @if(($searchs->count() != 0))
                    <div class="card ">
                        <div class="header">  
                            <h4 class="title"><i class="fa fa-search"></i> <span class="label label-primary">Recherches récentes</span></h4>
                            <p class="category"> {{Date('d M Y')}}</p>  
                        </div>
                        <div class="content">
                            <ul>
                                @foreach($searchs as $search)
                                    <li><a href="#">{{$search->search}}</a>{{"   ". $search->created_at->format('d-M-Y H:i')}}</li> 
                                @endforeach
                            </ul>
                        
                        </div>      
                    </div>      
                @else
                    <div class="card ">
                        <div class="header">  
                            <h4 class="title"><i class="fa fa-search"></i> <span class="label label-primary">Les dernières recherches </span></h4>
                            <p class="category"> {{Date('d M Y')}}</p>  
                        </div>
                        <div class="content">
                            <div class="alert alert-info" role="alert"> 
                                <strong >{{ "Désolé aucune recherche n'a été efectué pour le moment" }} !</strong>
                            </div>
                           
                        </div>
                    </div>      
                @endif
            </div> 
        </div>
    </div>  

    @if(Session::has('achats') || Session::has('ventes') || Session::has('foods_names') ||
        Session::has('clients') || Session::has('depenses') || Session::has('factures') || 
        Session::has('foods_names') || Session::has('fournisseurs') ||Session::has('membres') || 
        Session::has('options') || Session::has('orders') 
    )
    
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                      <h4 class="title text-center"></span><i class="fa fa-search"></i> Resultat de recherche </h4>
                    </div>
                     <div class="content">
                    <table class="table table-hover table-striped" id="recherche">
                        <thead>
                            <tr>
                                <th>Champ</th>
                                <th>Description</th>
                                <th>Détails</th>
                                <th>Ajouter Le</th>
                            </tr>
                           
                        </thead>
                        <tbody>
                                @foreach(session('foods_names') as $foods_name)
                                    <tr>
                                        <td>Foods</td>
                                        <td><a href="{{route('showfoods', ['foods_name' => $foods_name])}}">{{$foods_name->foodsName}}</a></td>
                                        <td>Null</td>                                        
                                        <td><a href="{{route('showfoods', ['foods_name' => $foods_name])}}">{{$foods_name->created_at}}</a></td>
                                    </tr>    
                                @endforeach  
                                @foreach(session('achats') as $achat)
                                    <tr>
                                        <td>Achats</td>
                                        <td><a href="{{ route('showachat', ['achat' => $achat])}}">{{get_foodsName($achat->foods_name_id)}}</a></td>                                                         
                                        <td><a href="{{route('showachat', ['achat' => $achat])}}">{{$achat->priceOfPurchase}}</a></td>                                 
                                        <td><a href="{{route('showachat', ['achat' => $achat])}}">{{$achat->created_at}}</a></td>
                                    </tr>    
                                @endforeach  

                                @foreach(session('clients') as $client)
                                    <tr>
                                        <td>Clients</td>
                                        <td><a href="{{route('showclient', ['client' => $client])}}">{{$client->nom}}</a></td>                                        
                                        <td><a href="{{route('showclient', ['client' => $client])}}">{{$client->phone}}</a></td>                                    
                                        <td><a href="{{route('showclient', ['client' => $client])}}">{{$client->created_at}}</a></td>
                                    </tr>    
                                @endforeach  

                                @foreach(session('fournisseurs') as $fournisseur)
                                    <tr>
                                        <td>Fournisseurs</td>
                                        <td><a href="{{route('showfournisseur', ['fournisseur' => $fournisseur])}}">{{$fournisseur->nom}}</a></td>                                        
                                        <td><a href="{{route('showfournisseur', ['fournisseur' => $fournisseur])}}">{{$fournisseur->phone}}</a></td>                                    
                                        <td><a href="{{route('showfournisseur', ['fournisseur' => $fournisseur])}}">{{$fournisseur->created_at}}</a></td>
                                    </tr>    
                                @endforeach

                                @foreach(session('ventes') as $vente)
                                    <tr>
                                        <td>Ventes</td>
                                        <td><a href="{{route('showvente', ['vente' => $vente])}}">{{get_foodsName($vente->foods_name_id)}}</a></td>                                        
                                        <td><a href="{{route('showvente', ['vente' => $vente])}}">{{$vente->pu}}</a></td>                                        
                                        <td><a href="{{route('showvente', ['vente' => $vente])}}">{{$vente->created_at}}</a></td>
                                    </tr>    
                                @endforeach  

                                @foreach(session('depenses') as $depense)
                                    <tr>
                                        <td>Depenses</td>
                                        <td><a href="{{route('showdepense', ['depense' => $depense])}}">{{$depense->description}}</a></td>
                                        <td><a href="{{route('showdepense', ['depense' => $depense])}}">{{$depense->montant}}</a></td>                                        
                                        <td><a href="{{route('showdepense', ['depense' => $depense])}}">{{$depense->created_at}}</a></td>
                                        {{-- <td><a href="">{{$client->email}}</a></td> --}}

                                    </tr>    
                                @endforeach  

                                @foreach(session('factures') as $facture)
                                    <tr>
                                    <td><a href="{{route('showfacture', ['facture' => $facture])}}">{{$facture->factureNum}}</a></td>                                        
                                        <td><a href="{{route('showfacture', ['facture' => $facture])}}">{{$facture->user_id}}</a></td>                                     
                                        <td><a href="{{route('showfacture', ['facture' => $facture])}}">{{$facture->created_at}}</a></td>
                                        {{-- <td><a href="">{{$client->email}}</a></td> --}}
                                    </tr>    
                                @endforeach  

                                @foreach(session('membres') as $membre)
                                    <tr>
                                        <td>Membres</td>
                                        <td><a href="{{route('showmembre', ['membre' => $membre])}}">{{$membre->nom}}</a></td>                                        
                                        <td><a href="{{route('showmembre', ['membre' => $membre])}}">{{$membre->phone}}</a></td>
                                        <td><a href="{{route('showmembre', ['membre' => $membre])}}">{{$membre->created_at}}</a></td>
                                    </tr>    
                                @endforeach  
                                    
                                @foreach(session('options') as $option)
                                    <tr>
                                        <td>Options</td>
                                        <td><a href="{{route('showoption', ['option' => $option])}}">{{$option->name}}</a></td>                                        
                                        <td><a href="{{route('showoption', ['option' => $option])}}">{{$option->unite}}</a></td>
                                        <td><a href="{{route('showoption', ['option' => $option])}}">{{$option->created_at}}</a></td>
                                    </tr>    
                                @endforeach  

                                @foreach(session('orders') as $order)
                                    <tr>
                                        <td>Orders</td>
                                        <td><a href="{{route('showorder', ['order' => $order])}}">{{$order->orderNum}}</a></td>                                        
                                        <td><a href="{{route('showorder', ['order' => $order])}}">{{$order->user_id}}</a></td>
                                        <td><a href="{{route('showorder', ['order' => $order])}}">{{$order->created_at}}</a></td>
                                    </tr>    
                                @endforeach  

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><br>
    @endif

    @if(Auth::user()->id == 1 || Auth::user()->id == 2 || access_sell() || access_anal())
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
                                <th>Produits</th>
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
                            @if(Auth::user()->id == 1 || Auth::user()->id == 2 || access_order() || access_anal())
                                <th>Prix d'achat</th>
                            @endif
                            <th>Stock</th>
                            <th>Total</th>
                            </thead>
                            <tbody>
                                @foreach($stocks as $stock=>$key)
                                <tr>
                                    <td>{{get_foodsName($stock)}}</td>
                                    @if(Auth::user()->id == 1 || access_order() || access_anal())
                                        <td>{{get_prix_achat($stock)}}</td>                                  
                                    @endif
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
    
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        <h4 class="title"><i class="pe-7s-display1"></i> Stock</h4>
                        <p class="category">24 Hours performance</p>
                    </div>
                    <div class="content">

                        <table class="table table-hover table-striped" id="dashboard">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    @if(Auth::user()->id == 1 || Auth::user()->id == 2  || access_order() || access_anal())
                                        <th>Prix d'achat</th>
                                    @endif
                                    <th>Stock</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stocks as $stock=>$key)
                                <tr>
                                    <td>{{get_foodsName($stock)}}</td>
                                    @if(Auth::user()->id == 1 || Auth::user()->id == 2  || access_order() || access_anal())
                                        <td>{{get_prix_achat($stock)}}</td>                                  
                                    @endif
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
    @endif

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

        $(function () {
            $('#recherche').DataTable()
        });

    </script>
@stop