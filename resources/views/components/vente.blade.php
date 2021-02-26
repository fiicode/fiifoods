@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/buttons.dataTables.min.css')}}">
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
    <?php $vente = session('vente') ?>
    @if(Session::has('ventes'))
        <?php $ventes = session('ventes') ?>
    @endif

    @if(Auth::user()->id != 2)
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="header">
                        @if($vente)
                            <h5 class="title text-primary"><i class="fa fa-cart-arrow-down text-primary"></i> Modification Facture N°{{$vente->factureNum}}</h5>
                        @else
                            <h4 class="title"><i class="fa fa-cart-arrow-down text-danger"></i> <span class="label label-danger">Page de vente</span></h4>
                        @endif
                    </div>
                    <div class="content">
                        @if($vente)
                        <form action="{{route('ventes.update', ['vente' => $vente])}}" method="post">
                        {{method_field('PATCH')}}
                        @else
                        <form action="{{route('ventes.store')}}" method="post">
                        @endif
                            @csrf
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group {{$errors->has('nom') ? 'has-error' : ''}}">
                                            <label for=""><i class="fa fa-user text-primary"></i> Nom Client</label>
                                            @if($vente)
                                                <input type="text" class="form-control" placeholder="Ex. Amadou" name="nom" id="nom" value="{{old('nom')? old('name') : get_client_name($vente->client_id)}}">
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
                                    <div class="col-md-2" id="clientPhone">
                                        <div class="form-group {{$errors->has('phone') ? 'has-error' : ''}}">
                                            <label for=""><i class="fa fa-phone text-primary"></i> Téléphone</label>
                                            @if($vente)
                                                <input type="text" class="form-control" placeholder="623 964 837" name="phone" id="phone" value="{{old('phone') ? old('phone') : get_client_phone($vente->client_id)}}">
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
                                            <label for=""><i class="fa fa-coffee text-primary"></i> Produit</label>
                                            <select class="form-control select2" name="foodsName" id="foodsName">
                                                @foreach($produits as $produit)
                                                    @if($vente)
                                                        <option {{$produit->id == $vente->foods_name_id ? 'selected' : ''}} value="{{$produit->id}}">{{$produit->foodsName}}</option>
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
                                            @if($vente)
                                                <input type="number" class="form-control" placeholder="Quantité" name="qtt" value="{{old('qtt')? old('qtt'): $vente->qtt}}" required>
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
                                            <label for="">Prix de vente</label>
                                            @if($vente)
                                                <input type="text" class="form-control" placeholder="Prix Vente" name="prixAchat" value="{{old('prixAchat')? old('prixAchat') : $vente->pu}}" required>
                                            @else
                                                <input type="text" class="form-control" placeholder="Prix Vente" name="prixAchat" value="{{old('prixAchat')}}" required>
                                            @endif
                                        </div>
                                        @if($errors->has('prixAchat'))
                                            <span class="text-danger">
                                                <p style="font-size: 11px">{{$errors->first('prixAchat')}}</p>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group {{$errors->has('paye') ? 'has-error' : ''}}">
                                            <label for="">Payé?</label>
                                            @if($vente)
                                                <input type="text" class="form-control" placeholder="Payé" name="paye" value="{{old('paye') ? old('paye') : $vente->paye}}">
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
                                        <div class="form-group {{$errors->has('factureNum') ? 'has-error' : ''}}">
                                            <label for="">N°Fac</label>
                                            @if($vente)
                                                <input type="text" class="form-control" placeholder="CM01" name="factureNum" value="{{old('factureNum') ? old('factureNum') : $vente->factureNum }}">
                                            @else
                                                <input type="text" class="form-control" placeholder="CM01" name="factureNum" value="{{old('factureNum') ? old('factureNum') : 'F' . get_facture_num() }}">
                                            @endif
                                        </div>
                                        @if($errors->has('factureNum'))
                                            <span class="text-danger">
                                                <p style="font-size: 11px">{{$errors->first('factureNum')}}</p>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-1">
                                        <br>
                                        @if($vente)
                                            <button type="submit" class="btn btn-primary btn-xs" rel="tooltip" title="Modifier"><i class="fa fa-edit"></i></button>
                                            <a href="{{route('ventes.index')}}" class="btn btn-danger btn-xs" rel="tooltip" title="Fermer"><i class="fa fa-close"></i></a>
                                        @else
                                            <button type="submit" class="btn btn-danger" rel="tooltip" title="Enregister"><i class="fa fa-save"></i></button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                        @if($vente)
                        </form>
                        @else
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4><i class="pe-7s-cart"></i> <span class="label label-danger">Toutes les ventes</span> <a href="{{route('ventes')}}" class="btn btn-info btn-fill pull-right btn-xs"><i class="fa fa-flask"></i> Toutes les factures</a></h4>

                  
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
    <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/js/getter-edit-sweet-alert.js')}}"></script>
    <script src="{{asset('assets/js/jquery.autocomplete.min.js')}}"></script>


    {{--<script src="{{asset('assets/js/jquery.dataTables.bootstrap.min.js')}}"></script>--}}
    <script src="{{asset('assets/js/dataTables.buttons.min.js')}}"></script>
    {{--<script src="{{asset('assets/js/buttons.flash.min.js')}}"></script>--}}
    {{--<script src="{{asset('assets/js/buttons.html5.min.js')}}"></script>--}}
    <script src="{{asset('assets/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/js/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/js/dataTables.select.min.js')}}"></script>



    <script>
        $(document).ready(function(){
            var clients = <?= $clients; ?>;
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
            $('#foodsName').on('click', function () {
                var article = $('form').find('[name="foodsName"]')[0];
                var pu = $('form').find('[name="prixAchat"]')[0];
                $.ajax({
                    method: 'GET',
                    url: '{{ route('price', ['foods' => 1]) }}',
                    data: {
                        _token: '{{ Session::token() }}',
                        foodsId: article.value
                    }
                }).done(function (msg) {
                    var prixVente = msg['pv'];
                    // if (prixVente > 0) {
                        pu.value = prixVente;
                    // }
                });
            });
        });

        // $(document).ready(function() {
        //    $('#dynamic-table').DataTable( {
        //         dom: 'Bfrtip',
        //         buttons: [
        //             //'columnsToggle'
        //             // {
        //             //     extend: "colvis",
        //             //     "text": "<i class='fa fa-search bigger-110 blue'></i></span>",
        //             //     //"className": "btn btn-white btn-primary btn-bold",
        //             //     //columns: ':not(:first):not(:last)'
        //             //    // postfixButtons: [ 'colvisRestore' ]
        //             // },
        //             {
        //                 extend: 'columnsToggle',
        //                 //columns: '.toggle'
        //             },
        //             {
        //                 extend: 'print',
        //                 text: 'Imprimer',
        //                 autoPrint: false,
        //                 //message: 'Toutes les transactions',
        //                 customize: function ( win ) {
        //                     $(win.document.body)
        //                         .css( 'font-size', '10pt' )
        //                         .prepend(
        //                             '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
        //                         );
        //
        //                     $(win.document.body).find( 'table' )
        //                         .addClass( 'compact' )
        //                         .css( 'font-size', 'inherit' );
        //                     $(win.document.body).find('h1').css('display', 'none')
        //                 }
        //             },
        //         ]
        //     } );
        // } )


    </script>
@stop
@section('notification')
    <script>
        $(function () {
            $('#factureTable').DataTable()
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

    @if(Session::has('success-facture'))
        <script type="text/javascript">
            notification('success', 'Facture Créée');
        </script>
    @endif
    @if(Session::has('error-facture'))
        <script type="text/javascript">
            notification('warning', 'Facture existe déjà');
        </script>
    @endif
    
    @if(Session::has('supression-facture'))
        <script type="text/javascript">
            notification('danger', 'Facture suprimée');
        </script>
    @endif
    @if(Session::has('modification-facture'))
        <script type="text/javascript">
            notification('success', 'Facture modifiée');
        </script>
    @endif
@stop