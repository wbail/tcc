
@extends('layouts.app')
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ControleTCC</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../bower_components/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../bower_components/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../bower_components/AdminLTE/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">

                   <div class="login-box">
                      <div class="login-logo">
                        {{-- <a href="../bower_components/AdminLTE/index2.html"><b>Controle</b>TCC</a> --}}
                        <a href="{{ url('/admin') }}"><b>TCC</b></a>
                      </div>
                      <!-- /.login-logo -->
                      <div class="login-box-body">
                        <p class="login-box-msg">Login</p>
                          <form class="form-horizontal" role="form" method="post" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                {{-- <label for="email" class="col-md-4 control-label">E-Mail</label> --}}
                                <div class="col-md-2"></div>
                                <div class="col-md-9">
                                  <div class="form-group has-feedback">

                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                    <span class="fa fa-envelope form-control-feedback"></span>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                  </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                
                                <div class="col-md-2"></div>
                                <div class="col-md-9">
                                    <div class="form-group has-feedback">
                                      <input id="password" type="password" class="form-control" name="password" required>
                                      <span class="fa fa-lock form-control-feedback"></span>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <div class="row">
                                      
                                      <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembrar-me
                                      
                                      <button type="submit" class="btn btn-primary btn-flat pull-right">
                                          Login
                                      </button>
                                    </div> {{-- ./row --}}
                                    
                                </div>
                            </div>

                            <div class="form-group">
                              <div class="col-md-2"></div>
                                <div class="col-md-6">
                                    <div class="row">
                                      <a class="btn btn-link" href="{{ route('password.request') }}">
                                          Esqueceu sua senha?
                                      </a>

                                      
                                      
                                    </div> {{-- ./row --}}

                                </div>
                            </div>
                          </form>
                                                


                      </div>
                      <!-- /.login-box-body -->
                    </div>
                    <!-- /.login-box -->







                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery 2.2.3 -->
<script src="../bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../bower_components/AdminLTE/bootstrap/js/bootstrap.min.js"></script>

@endsection



{{-- 
 <!DOCTYPE html>
<html>

<body class="hold-transition login-page">



</body>
</html> --}}
