<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>TCC</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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

    <body>

        <br>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="login-box">
                                <div class="login-logo">
                                    {{ Html::image('../resources/assets/images/uepg_ret.png', 'alt', array('width' => '200' , 'height' => '70', 'class'=>'text-center')) }}
                                </div>
                                <div class="login-box-body">
                                    <form class="form-horizontal" role="form" method="post" action="{{ route('login') }}">
                                        {{ csrf_field() }}

                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                            <div class="col-md-2"></div>
                                            <div class="col-md-9">
                                                <label for="anoletivo">Ano Letivo</label>
                                                <div class="form-group has-feedback">
                                                    <div id="anoletivosnovo">
                                                        <select id="anoletivos" name="anoletivo" class="form-control" title="Ano Letivo" autofocus required></select>
                                                    </div>
                                                    <span class="fa fa-calendar form-control-feedback"></span>
                                                    @if ($errors->has('anoletivo'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('anoletivo') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <label for="email">E-Mail</label>
                                                <div class="form-group has-feedback">
                                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required title="Endereço de E-Mail">
                                                    <span class="fa fa-envelope form-control-feedback"></span>
                                                    @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <label for="curso">Curso</label>
                                                <div class="form-group has-feedback">
                                                    <div id="cursos">
                                                        <select name="curso" class="form-control" title="Curso" ></select>
                                                    </div>
                                                    <span class="fa fa-graduation-cap form-control-feedback"></span>
                                                    @if ($errors->has('curso'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('curso') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-9">
                                                <label for="senha">Senha</label>
                                                <div class="form-group has-feedback">
                                                    <input id="password" type="password" class="form-control" name="password" required title="Senha">
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
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Lembrar-me
                                                    <button type="submit" class="btn btn-primary btn-flat pull-right">Entrar</button>
                                                </div> {{-- ./row --}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-2"></div>
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <a class="btn btn-link" href="{{ route('password.request') }}">Esqueceu sua senha?</a>
                                                </div> {{-- ./row --}}
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.login-box-body -->
                            </div>
                            <!-- /  .login-box -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<!-- jQuery 2.2.3 -->
<script src="../bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../bower_components/AdminLTE/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">

    $(document).ready(function() { 
    
        $('#email').on("focusout", function() {

            $.ajax({
                url: "h/" + $('#email').val(),
                type: 'GET',
                dataType: 'json',
            })
            .done(function(data) {

                //var html = '<select class="form-control" required name="curso" placeholder="Curso"><option value=" "></option>';
                var html = '<select class="form-control" required name="curso" placeholder="Curso">';

                for(var i = 0; i < data.length; i++) {
                    html += '<option value="'+ data[i].id +'">' + data[i].nome + '</option>';
                }

                html += '</select>';

                $('#cursos').html(html);

            })
            .fail(function() {
                //console.log("error");
            })
            .always(function() {
                //console.log("complete");
            });
        });

        $('#anoletivos').on("click", function() {

            $.ajax({
                url: "{{ url('anoletivo/anoletivoativo') }}",
                type: 'GET',
                dataType: 'json',
            })
            .done(function(data) {

                var html = '<select id="anoletivos" class="form-control" name="anoletivo" required><option value=" "></option>';

                for(var i = 0; i < data.length; i++) {
                    html += '<option value="'+ data[i].id +'">' + data[i].rotulo + '</option>';
                }

                html += '</select>';

                $('#anoletivosnovo').html(html);

            })
            .fail(function() {
                //console.log("error");
            })
            .always(function() {
                //console.log("complete");
            });
        });


    });

</script>

