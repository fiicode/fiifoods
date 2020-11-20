<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Aboubackr bah">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="copyright" content="2015 - {{Date('Y')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="90,URL={{route('login')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name', 'fiifoods') }} | home</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="{{asset('welcome/assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('welcome/assets/css/now-ui-kit.css')}}" rel="stylesheet" />
    <link href="{{asset('welcome/assets/css/demo.css')}}" rel="stylesheet" />
</head>
<body class="login-page">
<nav class="navbar navbar-toggleable-md bg-primary fixed-top navbar-transparent " color-on-scroll="500">
    <div class="container">
        <div class="dropdown button-dropdown">
            <a href="#bahaboubackr" class="dropdown-toggle" id="navbarDropdown" data-toggle="dropdown">
                <span class="button-bar"></span>
                <span class="button-bar"></span>
                <span class="button-bar"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-header">SRAID App</a>
                <a class="dropdown-item" href="#">FMK</a>
                <a class="dropdown-item" href="#">FMK-GOT</a>
                <a class="dropdown-item" href="#">FiiFoods</a>
                <a class="dropdown-item" href="#">WOCO</a>
                <a class="dropdown-item" href="https://bah-trading.com/" target="_blank">Bah-Trading</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Productions</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Industries</a>
            </div>
        </div>
        <div class="navbar-translate">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}" rel="tooltip" title="SRAID GROUPE. Coder par Aboubackr" data-placement="bottom" target="_blank">
                <i class="now-ui-icons business_money-coins"></i> {{ config('app.name', 'fmk-GOT') }}
            </a>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navigation" data-nav-image="{{asset('welcome/assets/img/home.jpg')}}">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}"><i class="now-ui-icons users_single-02"></i> Connexion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" rel="tooltip" title="Suivez nous sur twitter" data-placement="bottom" href="https://twitter.com/BahAboubackr" target="_blank">
                        <i class="fa fa-twitter"></i>
                        <p class="hidden-lg-up">Twitter</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" rel="tooltip" title="Aimé nous sur Facebook" data-placement="bottom" href="https://www.facebook.com/aboubackr" target="_blank">
                        <i class="fa fa-facebook-square"></i>
                        <p class="hidden-lg-up">Facebook</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" rel="tooltip" title="Suivez nous sur Instagram" data-placement="bottom" href="https://www.instagram.com/aboubackr" target="_blank">
                        <i class="fa fa-instagram"></i>
                        <p class="hidden-lg-up">Instagram</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="page-header" filter-color="orange">
    <div class="page-header-image" style="background-image:url({{asset('welcome/assets/img/home.jpg')}}"></div>
    <div class="container">
        <div class="col-md-4 content-center">
            <div class="card card-login card-plain">
                <form class="form" action="{{ route('login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="content">
                        <div class="header header-primary text-center">
                            <div class="logo-container">
                                <img src="{{asset('favicon.ico')}}">
                            </div>
                        </div>
                        <div class="input-group form-group-no-border input-lg{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="now-ui-icons users_circle-08"></i>
                                    </span>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        <div class="input-group form-group-no-border input-lg{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <span class="input-group-addon">
                                        <i class="now-ui-icons ui-1_lock-circle-open"></i>
                                    </span>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <div class="input-group form-group-no-border input-lg">
                            <div class="col-xs-8">
                                <div class="input-group-addon icheck">
                                    <label>
                                        <input type="checkbox" id="check-all" class="flat" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-round btn-lg btn-block">
                                <i class="fa fa-sign-in"></i> Connexion
                            </button>
                        </div>
                    </div>
                    <div class="pull-center">
                        <h6>
                            <a class="btn btn-link" href="#">
                                Forgot Your Password <i class="fa fa-question"></i>
                            </a>
                        </h6>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <nav>
                <ul>
                    <li>
                        <a href="#">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            MIT License
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="copyright">
                &copy;
                2015 - {{Date('Y')}} , Production <a href="#" target="_blank">SRAID GOUPE</a>. Coded by <i class="now-ui-icons objects_globe"></i>
                <a href="https://twitter.com/BahAboubackr" target="_blank">Aboubackr</a>.
            </div>
        </div>
    </footer>
</div>
<script src="{{asset('welcome/assets/js/core/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('welcome/assets/js/core/tether.min.js')}}" type="text/javascript"></script>
<script src="{{asset('welcome/assets/js/core/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('welcome/assets/js/plugins/nouislider.min.js')}}" type="text/javascript"></script>
<script src="{{asset('welcome/assets/js/now-ui-kit.js')}}" type="text/javascript"></script>
</body>
</html>
