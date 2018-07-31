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
    <?php $fournisseur = session('fournisseur') ?>
    <?php $client = session('client') ?>
    <?php $fournisseurtVersemnt = session('fournisseurtVersemnt') ?>
    <?php $clientVersemnt = session('clientVersemnt') ?>
    <div class="row">
        @if($clientVersemnt || $fournisseurtVersemnt)
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    @if($fournisseurtVersemnt)
                        <h5 class="title text-primary"><i class="fa fa-cart-arrow-down text-primary"></i> <span class="label label-success">Versement pour le fournisseur {{$fournisseurtVersemnt->nom}}</span></h5>
                    @elseif($clientVersemnt)
                        <h4 class="title text-primary"><i class="fa fa-cart-arrow-down text-info"></i> <span class="label label-success">Versement {{$clientVersemnt->nom}}</span></h4>
                    @endif
                </div>
                @if($fournisseurtVersemnt)
                <div class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <div>
                                <i class="fa fa-user"></i> Nom :{{$fournisseurtVersemnt->nom}}<br>
                                <i class="fa fa-phone"></i> Phone: {{$fournisseurtVersemnt->phone}}
                            </div>
                        </div>
                        <div class="col-md-5">
                            <form action="{{route('vesementFournisseur.versemnt')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group {{$errors->has('mtt') ? 'has-error' : ''}}">
                                            <label for=""> Versement</label>
                                            <input type="text" class="form-control" placeholder="Montant" name="mtt" id="mtt" value="{{old('mtt')}}" required>
                                            <input type="hidden" name="nom" value="{{$fournisseurtVersemnt->nom}}">
                                            <input type="hidden" name="phone" value="{{$fournisseurtVersemnt->phone}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <br>
                                        <button type="submit" class="btn btn-success btn-fill" rel="tooltip" title="Enregister"><i class="fa fa-save"></i></button>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                @elseif($clientVersemnt)
                <div class="content">
                    <div class="row">
                        <div class="col-md-2">
                            <div>
                                <i class="fa fa-user"></i> Nom :{{$clientVersemnt->nom}}<br>
                                <i class="fa fa-phone"></i> Phone: {{$clientVersemnt->phone}}
                            </div>
                        </div>
                        <div class="col-md-5">
                            <form action="{{route('vesementClient.versemnt')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{$errors->has('mtt') ? 'has-error' : ''}}">
                                            <label for=""> Versement</label>
                                            <input type="text" class="form-control" placeholder="Montant" name="mtt" id="mtt" value="{{old('mtt')}}" required>
                                            <input type="hidden" name="nom" value="{{$clientVersemnt->nom}}">
                                            <input type="hidden" name="phone" value="{{$clientVersemnt->phone}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <br>
                                        <button type="submit" class="btn btn-success btn-fill" rel="tooltip" title="Enregister"><i class="fa fa-save"></i></button>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </form>
                        </div>
                        <div class="col-md-5">
                            <form action="{{route('creditClient.credit')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{$errors->has('mtt') ? 'has-error' : ''}}">
                                            <label for="">Credit</label>
                                            <input type="text" class="form-control" placeholder="Montant" name="mtt" id="mtt" value="{{old('mtt')}}">
                                            <input type="hidden" name="nom" value="{{$clientVersemnt->nom}}">
                                            <input type="hidden" name="phone" value="{{$clientVersemnt->phone}}">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <br>
                                        <button type="submit" class="btn btn-danger btn-fill" rel="tooltip" title="Enregister"><i class="fa fa-save"></i></button>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    @if($fournisseur)
                        <h5 class="title text-primary"><i class="fa fa-cart-arrow-down text-primary"></i> <span class="label label-primary">Modification {{$fournisseur->nom}}</span></h5>
                    @elseif($client)
                        <h5 class="title text-primary"><i class="fa fa-cart-arrow-down text-info"></i> <span class="label label-info">Modification {{$client->nom}}</span></h5>
                    @else
                        <h4 class="title"><i class="fa fa-users text-info"></i> <span class="label label-info">Ajouter (Fournisseur, Client)</span></h4>
                    @endif
                </div>
                <div class="content">
                     <div class="row">
                         <div class="col-md-6" style="border-right: #bfbfbf 10px solid">
                            @if($fournisseur)
                             <form action="{{route('fournisseur.update', ['fournisseur' => $fournisseur])}}" method="post">
                             {{method_field('PATCH')}}
                             @else
                             <form action="{{route('fournisseur.store')}}" method="post">
                                 @endif
                                 @csrf
                                     <div class="row">
                                         <div class="col-md-6">
                                             <div class="form-group {{$errors->has('nom') ? 'has-error' : ''}}">
                                                 <label for=""><i class="fa fa-user text-danger"></i> Nom Founisseur</label>
                                                 @if($fournisseur)
                                                     <input type="text" class="form-control" placeholder="Ex. Amadou" name="nom" id="nom" value="{{old('nom')? old('name') : $fournisseur->nom}}">
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
                                         <div class="col-md-4" id="clientPhone">
                                             <div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
                                                 <label for=""><i class="fa fa-phone text-danger"></i> Téléphone</label>
                                                 @if($fournisseur)
                                                     <input type="text" class="form-control" placeholder="623 964 837" name="phone" id="phone" value="{{old('phone') ? old('phone') : $fournisseur->phone}}">
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
                                             <br>
                                             @if($fournisseur)
                                                 <button type="submit" class="btn btn-primary btn-xs" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></button>
                                                 <a href="{{route('activiste')}}" class="btn btn-danger btn-xs" rel="tooltip" title="Fermer"><i class="fa fa-close"></i></a>
                                             @else
                                                 <button type="submit" class="btn btn-danger btn-fill" rel="tooltip" title="Enregister"><i class="fa fa-save"></i></button>
                                             @endif
                                         </div>
                                     </div>

                                 <div class="clearfix"></div>
                             </form>
                         </div>
                         <div class="col-md-6">
                             @if($client)
                                 <form action="{{route('client.update', ['vente' => $client])}}" method="post">
                                     {{method_field('PATCH')}}
                                     @else
                                         <form action="{{route('client.store')}}" method="post">
                                             @endif
                                             @csrf
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="form-group {{$errors->has('nomClient') ? 'has-error' : ''}}">
                                                         <label for=""><i class="fa fa-user text-primary"></i> Nom Client</label>
                                                         @if($client)
                                                             <input type="text" class="form-control" placeholder="Ex. Amadou" name="nomClient" id="nomClient" value="{{old('nomClient')? old('nomClient') : $client->nom}}">
                                                         @else
                                                             <input type="text" class="form-control" placeholder="Ex. Amadou" name="nomClient" id="nomClient" value="{{old('nomClient')}}">
                                                         @endif
                                                     </div>
                                                     @if($errors->has('nomClient'))
                                                         <span class="text-danger">
                                            <p style="font-size: 11px">{{$errors->first('nomClient')}}</p>
                                        </span>
                                                     @endif
                                                 </div>
                                                 <div class="col-md-4" id="clientPhone">
                                                     <div class="form-group {{$errors->has('phoneClient') ? 'has-error' : ''}}">
                                                         <label for=""><i class="fa fa-phone text-primary"></i> Téléphone</label>
                                                         @if($client)
                                                             <input type="text" class="form-control" placeholder="623 964 837" name="phoneClient" id="phoneClient" value="{{old('phoneClient') ? old('phoneClient') : $client->phone}}">
                                                         @else
                                                             <input type="text" class="form-control" placeholder="623 964 837" name="phoneClient" id="phoneClient" value="{{old('phoneClient')}}">
                                                         @endif
                                                     </div>
                                                     @if($errors->has('phoneClient'))
                                                         <span class="text-danger">
                                            <p style="font-size: 11px">{{$errors->first('phoneClient')}}</p>
                                        </span>
                                                     @endif
                                                 </div>
                                                 <div class="col-md-2">
                                                     <br>
                                                     @if($client)
                                                         <button type="submit" class="btn btn-primary btn-xs" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></button>
                                                         <a href="{{route('activiste')}}" class="btn btn-danger btn-xs" rel="tooltip" title="Fermer"><i class="fa fa-close"></i></a>
                                                     @else
                                                         <button type="submit" class="btn btn-primary btn-fill" rel="tooltip" title="Enregister"><i class="fa fa-save"></i></button>
                                                     @endif
                                                 </div>
                                             </div>

                                             <div class="clearfix"></div>
                                         </form>
                         </div>
                     </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h4 class="title"><i class="pe-7s-cart"></i> <span class="label label-info">Tous les Fournisseurs</span></h4>
                </div>
                <div class="content">
                    <table class="table table-hover table-striped" id="fournisseurTable">
                        <thead>
                        <th>Nom</th>
                        <th>Téléphone</th>
                        <th>Solde</th>
                        {{--<th>le</th>--}}
                        {{--<th>User</th>--}}
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($fournisseurs as $fournisseur)
                            <tr>
                                <td>{{$fournisseur->nom}}</td>
                                <td>{{$fournisseur->phone}}</td>
                                <td><span class="label label-danger">{{get_founisseur_solde($fournisseur->id)}}</span></td>
                                {{--<td>{{$fournisseur->created_at->format('d/m/y')}}</td>--}}
                                {{--<td>{{$fournisseur->user->username}}</td>--}}
                                <td>
                                    <a href="{{route('fournisseur.show', ['fournisseur' => $fournisseur])}}" class="btn btn-xs btn-primary btn-simple" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('fournisseur.edit', ['fournisseur' => $fournisseur])}}" data-toggle="tooltip" data-placement="left" rel="tooltip" title="Supprimer" class="btn btn-danger btn-xs delete btn-simple" data-method="DELETE" data-confirm="Etes-vous sûr"><i class="fa fa-trash"></i></a>
                                    <a href="{{route('vesementFournisseur.show', ['id' => $fournisseur])}}"  rel="tooltip" title="Versement"><i class="fa fa-hand-grab-o"></i></a>
                                </td>
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
                    <h4 class="title"><i class="pe-7s-cart"></i> <span class="label label-primary">Tous les Clients</span></h4>
                </div>
                <div class="content">
                    <table class="table table-hover table-striped" id="clientTable">
                        <thead>
                        <th>Nom</th>
                        <th>Contact</th>
                        <th>Solde</th>
                        {{--<th>Le</th>--}}
                        {{--<th>User</th>--}}
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{$client->nom}}</td>
                                <td>{{$client->phone}}</td>
                                <td><span class="label label-danger">{{get_client_solde($fournisseur->id)}}</span></td>
                                {{--<td>{{$client->created_at->format('d/m/y')}}</td>--}}
                                {{--<td>{{$client->user->username}}</td>--}}
                                <td>
                                    <a href="{{route('client.show', ['client' => $client])}}" class="btn btn-xs btn-primary btn-simple" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('client.edit', ['client' => $client])}}" data-toggle="tooltip" data-placement="left" rel="tooltip" title="Supprimer" class="btn btn-danger btn-xs delete btn-simple" data-method="DELETE" data-confirm="Etes-vous sûr"><i class="fa fa-trash"></i></a>
                                    <a href="{{route('vesementClient.show', ['id' => $client])}}" rel="tooltip" title="Versement & crédit" class="btn btn-danger btn-xs delete btn-simple"><i class="fa fa-hand-grab-o"></i></a>
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
        <div class="card">
            <div class="header">
                <h4 class="title"><i class="pe-7s-display1"></i> <span class="label label-success">Tous les Versements & crédits (Fournisseurs, Client</span></h4>
            </div>
            <div class="content">
                <table class="table table-hover table-striped" id="mouvementTable">
                    <thead>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Nom</th>
                    <th>Montant</th>
                    <th>le</th>
                    <th>User</th>
                    </thead>
                    <tbody>
                    @foreach($mouvements as $mouvement)
                        <tr>
                        @if($mouvement->client_id)
                            @if($mouvement->versemClient)
                            <td>{{$mouvement->id}}</td>
                            <td><span class="label label-info">Client</span></td>
                            <td><span class="label label-success">Versement</span></td>
                            <td>{{get_client_name($mouvement->client_id)}}</td>
                            @elseif($mouvement->creditClient)
                            <td>{{$mouvement->id}}</td>
                            <td><span class="label label-info">Client</span></td>
                            <td><span class="label label-danger">Crédit</span></td>
                            <td>{{get_client_name($mouvement->client_id)}}</td>
                            @endif
                        @elseif($mouvement->fournisseur_id)
                            @if($mouvement->versemFournisseur)
                            <td>{{$mouvement->id}}</td>
                            <td><span class="label label-primary">Fournisseur</span></td>
                            <td><span class="label label-success">Versement</span></td>
                            <td>{{get_founisseur_name($mouvement->fournisseur_id)}}</td>
                            @elseif($mouvement->creditFournisseur)
                            <td>{{$mouvement->id}}</td>
                            <td><span class="label label-primary">Fournisseur</span></td>
                            <td><span class="label label-danger">Crédit</span></td>
                            <td>{{get_founisseur_name($mouvement->fournisseur_id)}}</td>
                            @endif
                        @endif
                            <td>{{number_format($mouvement->name)}}</td>
                            <td>{{$mouvement->created_at->format('d/m/Y H:i')}}</td>
                            <td>{{$mouvement->user->username}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

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
            var clients = ;
            $('#nom').autocomplete({
                lookup: clients,
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
                        url: '{{route('clientPhone.phone', ['id' => 1]) }}',
                        data: {
                            _token: '{{ Session::token() }}',
                            _method: "PATCH",
                            query: query
                        }
                    }).done(function (msg) {
                        var phone = $('#clientPhone').find('[name="phone"]')[0];
                        phone.value = msg['client'];
                    });
                }
            });
        });
    </script>
@stop
@section('notification')
    <script>
        $(function () {
            $('#fournisseurTable').DataTable()
        })
        $(function () {
            $('#clientTable').DataTable()
        })
        $(function () {
            $('#mouvementTable').DataTable()
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

    @if(Session::has('success-fournisseur'))
        <script type="text/javascript">
            notification('success', 'Fournisseur Créée');
        </script>
    @endif
    @if(Session::has('success-fournisseur'))
        <script type="text/javascript">
            notification('success', 'Fournisseur Créée');
        </script>
    @endif
    @if(Session::has('error-client'))
        <script type="text/javascript">
            notification('warning', 'Client existe déjà');
        </script>
    @endif
    @if(Session::has('error-client'))
        <script type="text/javascript">
            notification('warning', 'Client existe déjà');
        </script>
    @endif
    @if(Session::has('supression-fournisseur'))
        <script type="text/javascript">
            notification('danger', 'Fournisseur suprimée');
        </script>
    @endif
    @if(Session::has('modification-fournisseur'))
        <script type="text/javascript">
            notification('success', 'Fournisseur modifiée');
        </script>
    @endif
    @if(Session::has('supression-client'))
        <script type="text/javascript">
            notification('danger', 'Client suprimée');
        </script>
    @endif
    @if(Session::has('modification-client'))
        <script type="text/javascript">
            notification('success', 'Client modifiée');
        </script>
    @endif
    @if(Session::has('success-versement'))
        <script type="text/javascript">
            notification('success', 'Versement effectué');
        </script>
    @endif
    @if(Session::has('error-versement'))
        <script type="text/javascript">
            notification('warning', 'Versement échoué');
        </script>
    @endif
    @if(Session::has('success-credit'))
        <script type="text/javascript">
            notification('success', 'Crédit effectué');
        </script>
    @endif
    @if(Session::has('error-credit'))
        <script type="text/javascript">
            notification('warning', 'Crédit échoué');
        </script>
    @endif
@stop