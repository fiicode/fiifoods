@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert.css')}}">
    <style>
        .autocomplete-suggestions {
            border: 1px solid #e4e4e4;
            background: #F4F4F4;
            cursor: default;
            overflow: auto
        }
        .autocomplete-suggestion {
            padding: 2px 5px;
            font-size: 1.2em;
            white-space: nowrap;
            overflow: hidden
        }
        .autocomplete-selected {
            background: #f0f0f0
        }
        .autocomplete-suggestions strong {
            font-weight: normal;
            color: #3399ff;
            font-weight: bolder
        }
    </style>
@stop
@section('content')
    <?php $achat = session('achat') ?>
    <?php $unite = session('unite') ?>
    <?php $ptds = session('produit') ?>
    @if(Session::has('achats'))
        <?php $achats = session('achats') ?>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: #FFF">
                <div class="header">
                    @if($achat)
                    <h4 class="title text-primary"><i class="fa fa-ship text-primary"></i> Modification Commade N°{{$achat->code}}</h4>
                    @else
                        <h4 class="title"><i class="fa fa-ship text-success"></i ><span class="label label-primary"> Nouvelle Commade</span></h4>
                    @endif
                </div>
                <div class="content">
                    @if($achat)
                    <form action="{{route('achats.update', ['achat' => $achat])}}" method="post">
                        {{method_field('PATCH')}}
                    @else
                    <form action="{{route('achats.store')}}" method="post">
                    @endif
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group {{$errors->has('nom') ? 'has-error' : ''}}">
                                        <label for="">Nom Founisseur</label>
                                        @if($achat)
                                        <input type="text" class="form-control" placeholder="Ex. Amadou" name="nom" id="nom" value="{{old('nom')? old('name') : get_founisseur_name($achat->fournisseur_id)}}">
                                        @else
                                        <input type="text" class="form-control" placeholder="Ex. Amadou" name="nom" id="nom" value="{{old('nom')}}">
                                        @endif
                                    </div>
                                    @if($errors->has('nom'))
                                        <span class="text-danger">
                                        <p style="font-size: 11px">{{$errors->first('nom')}}</p>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-1" id="founisseurPhone">
                                    <div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
                                        <label for="">Téléphone</label>
                                        @if($achat)
                                        <input type="text" class="form-control" placeholder="623 964 837" name="phone" id="phone" value="{{old('phone') ? old('phone') : get_founisseur_phone($achat->fournisseur_id)}}">
                                        @else
                                        <input type="text" class="form-control" placeholder="623 964 837" name="phone" id="phone" value="{{old('phone')}}">
                                        @endif
                                    </div>
                                    @if($errors->has('phone'))
                                        <span class="text-danger">
                                        <p style="font-size: 11px">{{$errors->first('phone')}}</p>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Produit</label>
                                        <select class="form-control select2" name="foodsName" id="foodsName">
                                            @foreach($produits as $produit)
                                                @if($achat)
                                                <option {{$produit->id == $achat->foods_name_id ? 'selected' : ''}} value="{{$produit->id}}">{{$produit->foodsName}}</option>
                                                @else
                                                <option value="{{$produit->id}}">{{$produit->foodsName}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group {{$errors->has('qtt') ? 'has-error' : ''}}">
                                        <label for="">Quantité</label>
                                        @if($achat)
                                        <input type="number" class="form-control" placeholder="Quantité" name="qtt" value="{{old('qtt')? old('qtt'): $achat->qtt}}" required>
                                        @else
                                        <input type="number" class="form-control" placeholder="Quantité" name="qtt" value="{{old('qtt')}}" required>
                                        @endif
                                    </div>
                                    @if($errors->has('qtt'))
                                        <span class="text-danger">
                                            <p style="font-size: 11px">{{$errors->first('qtt')}}</p>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group {{$errors->has('prixAchat') ? 'has-error' : ''}}">
                                        <label for="">Prix d'achat</label>
                                        @if($achat)
                                        <input type="text" class="form-control" placeholder="Prix Achat" name="prixAchat" value="{{old('prixAchat')? old('prixAchat') : $achat->priceOfPurchase}}" required>
                                        @else
                                        <input type="text" class="form-control" placeholder="Prix Achat" name="prixAchat" value="{{old('prixAchat')}}" required>
                                        @endif
                                    </div>
                                    @if($errors->has('prixAchat'))
                                        <span class="text-danger">
                                            <p style="font-size: 11px">{{$errors->first('prixAchat')}}</p>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group {{$errors->has('prixVente') ? 'has-error' : ''}}">
                                        <label for="">Px Vente</label>
                                        @if($achat)
                                        <input type="text" class="form-control" placeholder="Prix Vente" name="prixVente" value="{{old('prixVente') ? old('prixVente') : $achat->sellingPrice}}">
                                        @else
                                        <input type="text" class="form-control" placeholder="Prix Vente" name="prixVente" value="{{old('prixVente')}}">
                                        @endif
                                    </div>
                                    @if($errors->has('prixVente'))
                                        <span class="text-danger">
                                            <p style="font-size: 11px">{{$errors->first('prixVente')}}</p>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group {{$errors->has('paye') ? 'has-error' : ''}}">
                                        <label for="">Payé?</label>
                                        @if($achat)
                                        <input type="text" class="form-control" placeholder="Payé" name="paye" value="{{old('paye') ? old('paye') : $achat->paye}}">
                                        @else
                                        <input type="text" class="form-control" placeholder="Payé" name="paye" value="{{old('paye')}}">
                                        @endif
                                    </div>
                                    @if($errors->has('paye'))
                                        <span class="text-danger">
                                            <p style="font-size: 11px">{{$errors->first('paye')}}</p>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group {{$errors->has('orderId') ? 'has-error' : ''}}">
                                        <label for="">N°CMD</label>
                                        @if($achat)
                                        <input type="text" class="form-control" placeholder="CM01" name="orderId" value="{{old('orderId') ? old('orderId') : $achat->code }}">
                                        @else
                                        <input type="text" class="form-control" placeholder="CM01" name="orderId" value="{{old('orderId') ? old('orderId') : 'C' . get_cmd_num() }}">
                                        @endif
                                    </div>
                                    @if($errors->has('orderId'))
                                        <span class="text-danger">
                                            <p style="font-size: 11px">{{$errors->first('orderId')}}</p>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-1">
                                    <br>
                                    @if($achat)
                                    <button type="submit" class="btn btn-primary btn-xs" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></button>
                                    <a href="{{route('achats.index')}}" class="btn btn-danger btn-xs" rel="tooltip" title="Fermer"><i class="fa fa-close"></i></a>
                                    @else
                                    <button type="submit" class="btn btn-primary" rel="tooltip" title="Enregister"><i class="fa fa-save"></i></button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title"><i class="pe-7s-box1"></i><span class="label label-primary"> Tous les achats</span>  <a href="{{route('achats')}}" class="btn btn-info btn-fill pull-right btn-xs"><i class="fa fa-flask"></i> Tous les achats</a></h4>
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
                            <th>MTT</th>
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
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    @if($unite)
                    <h5 class="title text-primary">Modification de {{$unite->name}}</h5>
                    @else
                        <h5 class="title"><span class="label label-primary">Ajouter une unité</span></h5>
                    @endif
                </div>
                <div class="content">
                    @if($unite)
                        <form action="{{route('option.update', ['option' => $unite])}}" method="post">
                        {{method_field('PATCH')}}
                    @else
                    <form action="{{route('option.store')}}" method="post">
                    @endif
                        @csrf
                        <input type="hidden" name="unite" value="unite">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{$errors->has('product_name') ? 'has-error' : ''}}">
                                        @if($unite)
                                            <input type="text" class="form-control" placeholder="Ex: PCS" name="product_name" value="{{old('product_name') ?? $unite->name}}" required>
                                        @else
                                            <input type="text" class="form-control" placeholder="Ex: PCS" name="product_name" value="{{old('product_name')}}" required>
                                        @endif
                                    </div>
                                    @if($errors->has('product_name'))
                                        <span class="text-danger">
                                        <p style="font-size: 11px">{{$errors->first('product_name')}}</p>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if($unite)
                                    <button type="submit" class="btn btn-primary btn-fill" rel="tooltip" title="Modifer"><i class="fa fa-edit"></i></button>
                                    <a href="{{route('achats.index')}}" class="btn btn-danger btn-fill" rel="tooltip" title="Fermer"><i class="fa fa-close"></i></a>
                                    @else
                                    <button type="submit" class="btn btn-info btn-fill" rel="tooltip" title="Enregister"><i class="fa fa-save"></i>Enregistrer</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    @if($ptds)
                    <h5 class="title text-primary">Modification de {{$ptds->foodsName}}</h5>
                    @else
                        <h5 class="title"><span class="label label-primary">Ajouter un Produit</span></h5>
                    @endif
                </div>
                <div class="content">
                    @if($ptds)
                    <form action="{{route('foodsName.update', ['foodsName' => $ptds])}}" method="post">
                        {{method_field('PATCH')}}
                    @else
                    <form action="{{route('foodsName.store')}}" method="post">
                    @endif
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group {{$errors->has('foodsName') ? 'has-error' : ''}}">
                                        @if($ptds)
                                        <input type="text" class="form-control" placeholder="Ex. Fataya" name="foodsName" value="{{old('foodsName') ? old('foodsName') : $ptds->foodsName}}" required>
                                        @else
                                        <input type="text" class="form-control" placeholder="Ex. Fataya" name="foodsName" value="{{old('foodsName')}}" required>
                                        @endif
                                    </div>
                                    @if($errors->has('foodsName'))
                                        <span class="text-danger">
                                        <p style="font-size: 11px">{{$errors->first('foodsName')}}</p>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            @if($ptds)
                                            <input id="checkbox5" type="checkbox" name="inventaire" {{$ptds->inventaire ? 'checked' : ''}}>
                                            <label for="checkbox5">Inventaire?</label>
                                            @else
                                            <input id="checkbox5" type="checkbox" name="inventaire">
                                            <label for="checkbox5">Inventaire?</label>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control" name="unite">
                                            @foreach($options as $option)
                                                @if($ptds)
                                                    <option {{$ptds->id == $option->id ? 'selected' : ''}} value="{{$option->id}}">{{$option->name}}</option>
                                                @else
                                                    <option value="{{$option->id}}">{{$option->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    @if($ptds)
                                    <button type="submit" class="btn btn-primary btn-fill" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></button>
                                    <a href="{{route('achats.index')}}" class="btn btn-danger btn-fill" rel="tooltip" title="Ferme"><i class="fa fa-close"></i></a>
                                    @else
                                    <button type="submit" class="btn btn-info btn-fill pull-right" rel="tooltip" title="Enregister"><i class="fa fa-save"></i>Enregistrer</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="header">
                    <h4 class="title"><span class="label label-primary">Toutes les unités</span></h4>
                </div>
                <div class="content">
                    <table class="table table-hover table-striped" id="uniteTable">
                        <thead>
                        <th>name</th>
                        <th>Le</th>
                        <th>User</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($options as $unite)
                                <tr>
                                    <td>{{$unite->name}}</td>
                                    <td>{{$unite->created_at->format('d/m/y')}}</td>
                                    <td>{{$unite->user->username}}</td>
                                    <td>
                                        <a href="{{route('option.show', ['option' => $unite])}}" class="btn btn-xs btn-primary btn-simple" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></a>
                                        <a href="{{route('option.edit', ['option' => $unite])}}" data-toggle="tooltip" data-placement="left" rel="tooltip" title="Supprimer" class="btn btn-danger btn-xs delete btn-simple" data-method="DELETE" data-confirm="Etes-vous sûr"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="header">
                    <h4 class="title"><span class="label label-primary">Tous les produits</span></h4>
                </div>
                <div class="content">
                    <table class="table table-hover table-striped" id="produitTable">
                        <thead>
                            <th>Nom</th>
                            <th>Unité</th>
                            <th>ITR</th>
                            <th>Le</th>
                            <th>User</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($produits as $produit)
                                <tr>
                                    <td>{{$produit->foodsName}}</td>
                                    <td>{{get_unite($produit->foodsName)}}</td>
                                    <td>{{$produit->inventaire ? 'Oui' : 'Non'}}</td>
                                    <td>{{$produit->created_at->format('d/m/y')}}</td>
                                    <td>{{$produit->user->username}}</td>
                                    <td>
                                        <a href="{{route('foodsName.show', ['foodsName' => $produit])}}" class="btn btn-xs btn-primary btn-simple" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></a>
                                        <a href="{{route('foodsName.edit', ['foodsName' => $produit])}}" data-toggle="tooltip" data-placement="left" rel="tooltip" title="Supprimer" class="btn btn-danger btn-xs delete btn-simple" data-method="DELETE" data-confirm="Etes-vous sûr"><i class="fa fa-trash"></i></a>
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
    <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/js/getter-edit-sweet-alert.js')}}"></script>
    <script src="{{asset('assets/js/jquery.autocomplete.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            var founisseur = <?= $fournisseurs; ?>;
            $('#nom').autocomplete({
                lookup: founisseur,
                transformResult: function(response) {
                    return {
                        suggestions: $.map(response.myData, function(dataItem) {
                            return { value: dataItem.valueField, data: dataItem.dataField };
                        })
                    };
                }
            });

            //L'autocompletion de la recherche instantanné
            $('#nom').mouseover(function(){
                var query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        method: 'POST',
                        url: '{{route('fournisseurPhone.phone', ['id' => 1]) }}',
                        data: {
                            _token: '{{ Session::token() }}',
                            _method: "PATCH",
                            query: query
                        }
                    }).done(function (msg) {
                        var phone = $('#founisseurPhone').find('[name="phone"]')[0];
                        phone.value = msg['fournisseur'];
                    });
                }
            });
        });
    </script>
@stop
@section('notification')
    <script>
        $('#foodsName').on('click', function () {
            var article = $('form').find('[name="foodsName"]')[0];
            var pu = $('form').find('[name="prixAchat"]')[0];
            var pv = $('form').find('[name="prixVente"]')[0];
            $.ajax({
                method: 'GET',
                url: '{{ route('price', ['foods' => 1]) }}',
                data: {
                    _token: '{{ Session::token() }}',
                    foodsId: article.value
                }
            }).done(function (msg) {
                var prixAchat = msg['pu'];
                var prixVente = msg['pv'];
                // if (prixAchat > 0) {
                    pu.value = prixAchat;
                // }
                // if (prixVente > 0) {
                    pv.value = prixVente;
                // }
            });
        });

        $(function () {
            $('#orderTable').DataTable()
        })
        $(function () {
            $('#uniteTable').DataTable()
        })
        $(function () {
            $('#produitTable').DataTable()
        })
        function notification(type, message) {
            $(document).ready(function(){

                demo.initChartist();

                $.notify({
                    icon: 'pe-7s-bell',
                    message: type === 'success' ?
                        "<b>Notification</b><br> <i class='fa fa-hand-o-right'></i> " + message :
                        "<b>Notification</b><br> <i class='fa fa-hand-o-right'></i> " + message

                },{
                    type: type === 'success' ? 'success' : 'warning',
                    timer: 3000,
                    placement: {
                        from: 'top',
                        align: 'center'
                    }
                });

            });

        }
    </script>


    @if(Session::has('success-option'))
        <script type="text/javascript">
            notification('success', 'Option créée ');
        </script>
    @endif
    @if(Session::has('error-option'))
    <script type="text/javascript">
        notification('warning', 'Option éxiste déjà.');
    </script>
    @endif
    @if(Session::has('success-foodsName'))
        <script type="text/javascript">
            notification('success', 'Produit Créé');
        </script>
    @endif
    @if(Session::has('error-foodsName'))
        <script type="text/javascript">
            notification('warning', 'Produit existe déjà mais les options sont modifié');
        </script>
    @endif
    @if(Session::has('success-commande'))
        <script type="text/javascript">
            notification('success', 'Commande Créée');
        </script>
    @endif
    @if(Session::has('error-commande'))
        <script type="text/javascript">
            notification('warning', 'Commande existe déjà');
        </script>
    @endif
    @if(Session::has('supression-commande'))
        <script type="text/javascript">
            notification('danger', 'Commande suprimée');
        </script>
    @endif
    @if(Session::has('modification-commande'))
        <script type="text/javascript">
            notification('success', 'Commande modifiée');
        </script>
    @endif
    @if(Session::has('modification-option'))
        <script type="text/javascript">
            notification('success', 'Option modifiée');
        </script>
    @endif
    @if(Session::has('supression-option'))
        <script type="text/javascript">
            notification('danger', 'Option suprimée');
        </script>
    @endif
    @if(Session::has('supression-produit'))
        <script type="text/javascript">
            notification('danger', 'Produit suprimé');
        </script>
    @endif
    @if(Session::has('modification-foodsName'))
        <script type="text/javascript">
            notification('success', 'Produit modifié');
        </script>
    @endif
@stop