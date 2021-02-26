@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert.css')}}">
@stop
@section('content')
    <?php $user = session('user') ?>
    <?php $depense = session('depense') ?>
    <?php $motif = session('motif') ?>
    <?php $entite = session('entite') ?>
 
    @if(Session::has('achats'))
        <?php $depenses = session('depenses') ?>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card" style="background-color: #FFF">
                <div class="header">
                    @if($depense)
                        <h4 class="title text-danger"><i class="pe-7s-graph text-primary"></i> Modification Dépense N°{{$depense->code}}</h4>
                    @else
                        <h4 class="title"><i class="pe-7s-graph text-success"></i ><span class="label label-danger"> Nouvelle Dépense</span></h4>
                    @endif
                </div>
                <div class="content">
                    @if($depense)
                        <form action="{{route('depense.update', ['depense' => $depense])}}" method="post">
                            @method('PATCH')
                    @else
                        <form action="{{route('depense.store')}}" method="post">
                    
                            @csrf
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group {{$errors->has('description') ? 'has-error' : ''}}">
                                                <label for="">Description</label>
                                                @if($depense)
                                                    <textarea class="form-control" placeholder="Description" name="description" id="description">{{old('description')? old('name') : $depense->description}}</textarea>
                                                @else
                                                    <textarea class="form-control" placeholder="Description" name="description" id="description">{{old('description')}}</textarea>
                                                @endif
                                            </div>
                                            @if($errors->has('description'))
                                                <span class="text-danger">
                                                    <p style="font-size: 11px">{{$errors->first('description')}}</p>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group {{$errors->has('montant') ? 'has-error' : ''}}">
                                                <label for="">Montant</label>
                                                @if($depense)
                                                    <input type="text" class="form-control" placeholder="Montant" name="montant" value="{{old('montant')? old('montant') : $depense->priceOfPurchase}}" required>
                                                @else
                                                    <input type="text" class="form-control" placeholder="Montant" name="montant" value="{{old('montant')}}" required>
                                                @endif
                                            </div>
                                            @if($errors->has('montant'))
                                                <span class="text-danger">
                                                <p style="font-size: 11px">{{$errors->first('montant')}}</p>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Motif</label>
                                                <select class="form-control select2" name="motif" id="motif">
                                                    @foreach(get_motif() as $motif)
                                                        @if($depense)
                                                            <option {{$motif->motif == $depense->motif ? 'selected' : ''}} value="{{$motif->id}}">{{$motif->name}}</option>
                                                        @else
                                                            <option value="{{$motif->id}}">{{$motif->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="">Entité</label>
                                                <select class="form-control select2" name="entite" id="motif">
                                                    @foreach(get_entite() as $entite)
                                                        @if($depense)
                                                            <option {{$entite->entite == $depense->entite ? 'selected' : ''}} value="{{$entite->id}}">{{$entite->name}}</option>
                                                        @else
                                                            <option value="{{$entite->id}}">{{$entite->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <br>
                                            @if($depense)
                                                <button type="submit" class="btn btn-primary btn-xs" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></button>
                                                <a href="{{route('depense.index')}}" class="btn btn-danger btn-xs" rel="tooltip" title="Fermer"><i class="fa fa-close"></i></a>
                                            @else
                                                <button type="submit" class="btn btn-primary" rel="tooltip" title="Enregister"><i class="fa fa-save"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                            </form>
                        
                        </form>
                    @endif
                
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title"><i class="pe-7s-box1"></i><span class="label label-danger"> Toutes les Dépenses</span>  <a href="{{route('achats')}}" class="btn btn-info btn-fill pull-right btn-xs"><i class="fa fa-flask"></i> Toutes les dépenses</a></h4>
                </div>
                <div class="content">
                    <table class="table table-hover table-striped" id="orderTable">
                        <thead>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Montant</th>
                            <th>Motif</th>
                            <th>Entité</th>
                            <th>Crée le</th>
                            <th>User</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($depenses as $depense)
                                <tr>
                                    @if($depense->user_id == auth()->user()->id  || Auth::user()->id == 1 || Auth::user()->id == 2  || (access_sell() && access_order() && access_anal()) )
                                        <td>{{$depense->id}}</td>
                                        <td>{{$depense->description}}</td>
                                        <td>{{number_format($depense->montant)}}</td>
                                        <td>{{get_option_name($depense->motif)}}</td>
                                        <td>{{get_option_name($depense->entite)}}</td>
                                        <td>{{$depense->created_at->format('d/m/Y H:i')}}</td>
                                        <td>{{$depense->user->username}}</td>
                                        <td>
                                            <a href="#" class="btn btn-xs btn-primary btn-simple" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></a>
                                            <a href="#" data-toggle="tooltip" data-placement="left" rel="tooltip" title="Supprimer" class="btn btn-danger btn-xs delete btn-simple" data-method="DELETE" data-confirm="Etes-vous sûr"><i class="fa fa-trash"></i></a>
                                        </td>                                    
                                    @endif
                                </tr>
                            @endforeach
                       
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h5 class="title"><span class="label label-primary">Ajouter un motif</span></h5>
                </div>
                <div class="content">
                    <form action="{{route('motif')}}" method="post">
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                        <input type="text" class="form-control" placeholder="Nom du Motif" name="name" value="{{old('name')}}" required>
                                    </div>
                                    @if($errors->has('name'))
                                        <span class="text-danger">
                                            <p style="font-size: 11px">{{$errors->first('name')}}</p>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-info btn-fill" rel="tooltip" title="Enregister"><i class="fa fa-save"></i>Enregistrer</button>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h5 class="title"><span class="label label-primary">Ajouter une Entité</span></h5>
                </div>
                <div class="content">
                    <form action="{{route('entite')}}" method="post">
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{$errors->has('name') ? 'has-error' : ''}}">
                                        <input type="text" class="form-control" placeholder="Ex. PCS" name="name" value="{{old('name')}}" required>
                                    </div>
                                    @if($errors->has('name'))
                                        <span class="text-danger">
                                            <p style="font-size: 11px">{{$errors->first('name')}}</p>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-info btn-fill" rel="tooltip" title="Enregister"><i class="fa fa-save"></i>Enregistrer</button>
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
        <div class="col-md-6">
            <div class="card">
                <div class="header">
                    <h4 class="title"><span class="label label-primary">Tous les motifs</span></h4>
                </div>
                <div class="content">
                    <table class="table table-hover table-striped" id="motifTable">
                        <thead>
                        <th>name</th>
                        <th>Le</th>
                        <th>User</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($motifs as $motif)
                            <tr>
                                <td>{{$motif->name}}</td>
                                <td>{{$motif->created_at->format('d/m/y')}}</td>
                                <td>{{$motif->user->username}}</td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-primary btn-simple" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></a>
                                    <a href="#" data-toggle="tooltip" data-placement="left" rel="tooltip" title="Supprimer" class="btn btn-danger btn-xs delete btn-simple" data-method="DELETE" data-confirm="Etes-vous sûr"><i class="fa fa-trash"></i></a>
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
                    <h4 class="title"><span class="label label-primary">Toutes les entitées</span></h4>
                </div>
                <div class="content">
                    <table class="table table-hover table-striped" id="entiteTable">
                        <thead>
                        <th>name</th>
                        <th>Le</th>
                        <th>User</th>
                        <th>Action</th>
                        </thead>
                        <tbody>
                        @foreach($entites as $entite)
                            <tr>
                                <td>{{$entite->name}}</td>
                                <td>{{$entite->created_at->format('d/m/y')}}</td>
                                <td>{{$entite->user->username}}</td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-primary btn-simple" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></a>
                                    <a href="#" data-toggle="tooltip" data-placement="left" rel="tooltip" title="Supprimer" class="btn btn-danger btn-xs delete btn-simple" data-method="DELETE" data-confirm="Etes-vous sûr"><i class="fa fa-trash"></i></a>
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
@stop
@section('notification')
    <script>
        $(function () {
            $('#orderTable').DataTable()
        })
        $(function () {
            $('#motifTable').DataTable()
        })
        $(function () {
            $('#entiteTable').DataTable()
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

    @if(Session::has('success-motif'))
        <script type="text/javascript">
            notification('success', 'Motif crée');
        </script>
    @endif
    @if(Session::has('success-entite'))
        <script type="text/javascript">
            notification('success', 'Entite crée');
        </script>
    @endif
    @if(Session::has('error-option'))
        <script type="text/javascript">
            notification('warning', 'Option');
        </script>
    @endif
    @if(Session::has('success-depense'))
        <script type="text/javascript">
            notification('success', 'Dépense Crée');
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