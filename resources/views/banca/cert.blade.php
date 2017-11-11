
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $page_title or "TCC - Participantes Banca" }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset("../bower_components/AdminLTE/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('../bower_components/AdminLTE/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ asset('../bower_components/AdminLTE/dist/css/skins/skin-blue-light.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<div class="container">

    <div class="row">
        <div class="col-md-2 text-center">
            {{ Html::image('../resources/assets/images/uepg.png', null, array('width' => 75, 'height' => 70)) }}
        </div>
        <div class="col-md-9 text-center text-info">
            Universidade Estadual de Ponta Grossa
            <br>
            Setor de Ciências Agrárias e de Tecnologia
            <br>
            Departamento de Informática
        </div>
    </div>
    <br>
    <br>
    <br>
    <h4 class="text-center">DECLARAÇÃO</h4>
    <br>
    <br>
    <p class="text-justify">
        Declaro para os devidos fins que o(a) <strong>Professor(a) {{ $orientador }}</strong>
        participou da Banca Examinadora do Trabalho de Conclusão de Curso, como <strong>orientador(a)</strong> do(s) acadêmico(s) @if($aluno > 1) {{ $aluno[0] }} e {{ $aluno[1] }},
        @else <strong>{{ $aluno }}</strong>, @endif intitulado <strong>{{ $banca[0]->titulo }}</strong>, no dia {{ \Carbon\Carbon::parse($banca[0]->data)->format('d/m/Y à\s H:i') }}. A banca foi
        constituída também pelos(as) Professores(as) {{ $prof[0] }} e {{ $prof[1] }}.
        <br>
        <br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        Por ser verdade, firmo a presente declaração.
        <br>
        <br>

        Ponta Grossa, {{ \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }}
        <br><br><br>
        <div class="text-center">
            <strong>
                {{ $coordenadorTcc }}
                <br>
                Coordenador(a) dos Trabalhos de Conclusão de Curso
                <br>
                Curso de {{ session()->get('curso')->nome }}
            </strong>
        </div>
    </p>

</div>

<script type="tejxt/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset ("../bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js") }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ("../bower_components/AdminLTE/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset ('../bower_components/AdminLTE/dist/js/app.min.js') }}" type="text/javascript"></script>

</body>
</html>