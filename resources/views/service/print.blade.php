<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="copyright" content="2015 - {{Date('Y')}}">
    <meta name="Author" content="Aboubackr bah">
    <title></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.css')}}">
</head>
<body style="background-color: #F1F1E0"  onclick="window.print();">
    <div class="container">
        <!-- page content -->

                <div class="row">
                    <section class="content invoice">
                        <!-- Table row -->
                        <div class="row">
                            <div class="table">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Produits</th>
                                        <th>QTT</th>
                                        <th>PU</th>
                                        <th>Montant</th>
                                    </tr>
                                    </thead>
                                    <tbody id="elInvoice">
                                    <?php $total = 0 ?>
                                    <?php $date = null ?>
                                    <?php $num = null ?>
                                    @foreach($factures as $facture)
                                        <?php $total += $facture->qtt * $facture->pu ?>
                                        <?php $date = $facture->created_at->format('d/m/y') ?>
                                        <?php $num = $facture->factureNum ?>
                                        <tr>
                                            <td style="padding-left: 20px">{{$facture->foodsName->foodsName}}</td>
                                            <td>{{$facture->qtt}}</td>
                                            <td>{{number_format($facture->pu)}}</td>
                                            <td>{{number_format($facture->qtt * $facture->pu)}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>

                                    <!-- --><tr style="border: 2px #ccc dashed;">
                                        <td>{{$date}}</td>
                                        <td>N°{{$num}}</td>
                                        <td>RST:{{number_format($reste)}}</td>
                                        <td>TOT:{{number_format($total)}}</td>
                                    </tr><!-- -->
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                    </section>
                </div>
    </div>
</body>
</html>