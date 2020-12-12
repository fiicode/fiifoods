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
                        <div class="form-group mb-3">
                            <input type="text" name="search" class="form-control @error('search') is-invalid @enderror mb-5" id="search" placeholder="Rechercher">
                            {{-- @error('search') --}}
                                <div class="invalid-feedback" id="search"> {{$errors->first('search')}}</div>
                            {{-- @enderror --}}
                        </div>
                        <button type="submit" class="btn btn-primary btn-fill m-3">Rechercher</button><br><br>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                @if((!$searchs->isEmpty() > 0))
                    <div class="card ">
                        <div class="header">  
                            <h4 class="title"><i class="fa fa-search"></i> <span class="label label-primary">Les dernières recherches </span></h4>
                            <p class="category"> {{Date('d M Y')}}</p>  
                        </div>
                        <div class="content">
                            <ul>
                                @foreach($searchs as $search)
                                    <li>{{$search->search }}</li> 
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
                                <th>Montant</th>
                                <th>Le </th>
                            </tr>
                            {{-- <th>Montant</th>
                            <th>Produist</th>
                            <th>Quantité</th>
                            <th>Montant</th>
                            <th>Montant</th> --}}
                        </thead>
                        <tbody>
                                @foreach(session('foods_names') as $foods_name)
                                    <tr>
                                   
                                        <td>Foods</td>
                                        <td><a href="{{route('showfoods', ['foods_name' => $foods_name])}}">{{$foods_name->foodsName}}</a></td>
                                       <td><a href="">Null</a></td>                                        
                                        <td><a href="{{route('showfoods', ['foods_name' => $foods_name])}}">{{$foods_name->created_at}}</a></td>
                                       {{-- <td><a href="">Null</a></td> --}}
                                          {{--<td><a href="">Null</a></td>
                                        <td><a href="">Null</a></td>
                                        <td><a href="">Null</a></td>
                                        <td><a href="">Null</a></td> --}}
                                      {{-- <td><a href="">{{get_prix_achat($stock)}}</a></td>  --}}

                                    </tr>    
                                @endforeach  
                                @foreach(session('achats') as $achat)
                                    <tr>
                                        <td>Achats</td>
                                        <td><a href="{{ route('showachat', ['achat' => $achat])}}">{{get_foodsName($achat->foods_name_id)}}</a></td>                                                         
                                        <td><a href="{{route('showachat', ['achat' => $achat])}}">{{$achat->priceOfPurchase}}</a></td>                                 
                                        <td><a href="{{route('showachat', ['achat' => $achat])}}">{{$achat->created_at}}</a></td>
                                        {{-- <td><a href="">{{$achat->sellingPrice}}</a></td>
                                        <th>{{$achat->mntTotalAchat}}</th> --}}
                                        {{-- <td><a href="">{{$achat->code}}</a></td>
                                        <td><a href="">Null</a></td>
                                        <td><a href="">{{$achat->qtt}}</a></td> --}}

                                    </tr>    
                                @endforeach  

                                @foreach(session('clients') as $client)
                                    <tr>
                                        <td>Clients</td>
                                        <td><a href="{{route('showclient', ['client' => $client])}}">{{$client->nom}}</a></td>                                        
                                        <td><a href="{{route('showclient', ['client' => $client])}}">{{$client->phone}}</a></td>                                    
                                        <td><a href="{{route('showclient', ['client' => $client])}}">{{$client->created_at}}</a></td>
                                        {{-- <td><a href="">{{$client->email}}</a></td> --}}
                                    </tr>    
                                @endforeach  

                                @foreach(session('fournisseurs') as $fournisseur)
                                    <tr>
                                        <td>Fournisseurs</td>
                                        <td><a href="{{route('showfournisseur', ['fournisseur' => $fournisseur])}}">{{$fournisseur->nom}}</a></td>                                        
                                        <td><a href="{{route('showfournisseur', ['fournisseur' => $fournisseur])}}">{{$fournisseur->phone}}</a></td>                                    
                                        <td><a href="{{route('showfournisseur', ['fournisseur' => $fournisseur])}}">{{$fournisseur->created_at}}</a></td>
                                        {{-- <td><a href="">{{$client->email}}</a></td>  --}}
                                    </tr>    
                                @endforeach

                                @foreach(session('ventes') as $vente)
                                    <tr>
                                        <td>Ventes</td>
                                        <td><a href="{{route('showvente', ['vente' => $vente])}}">{{get_foodsName($vente->foods_name_id)}}</a></td>                                        
                                        <td><a href="{{route('showvente', ['vente' => $vente])}}">{{$vente->pu}}</a></td>                                        
                                        <td><a href="{{route('showvente', ['vente' => $vente])}}">{{$vente->created_at}}</a></td>
                                        {{-- <td><a href="">{{$vente->mtt}}</a></td> --}}
                                        {{-- <td><a href="">Null</a></td>
                                        <td><a href="">{{$vente->factureNum}}</a></td>
                                        <td><a href="">{{$vente->qtt}}</a></td> --}}
                                        {{-- <td><a href="">Null</a></td> --}}
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
                                        <td><a href="{{route('showoption', ['option' => $option])}}">{{$option->motif}}</a></td>
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

        $(function () {
            $('#recherche').DataTable()
        });

    </script>
@stop