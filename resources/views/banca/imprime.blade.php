
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $page_title or "TCC - Horário Bancas" }}</title>
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

    <style type="text/css">
        .border-left { border-left:1px solid; }
        .border-right { border-right:1px solid; }
        .border-top { border-top:1px solid; }
        .border-bottom { border-bottom:1px solid; }
        .none-border { border:none; border-bottom:1px solid; }
        .head, .detail-head, .detail-content { text-align:center; }
        .detail-total { text-align:right; }
        .space {height:100px;}
        .content td { padding:5px; }
        [placeholder]:empty:before {
            font-size:14px;
            content: attr(placeholder);
            color: #F55151;
        }

        [placeholder]:empty:focus:before {
            content: "";
        }
        .content-editable { color:green; font-size:14px; }
        .ui-autocomplete {min-height:300px; overflow:auto;}
        .ui-autocomplete-loading {
            background: white url("https://jquery-ui.googlecode.com/svn/tags/1.8.2/themes/smoothness/images/ui-anim_basic_16x16.gif") right center no-repeat;
        }

        body,
        .modal-open .page-container,
        .modal-open .page-container .navbar-fixed-top,
        .modal-open .modal-container {
            overflow-y: scroll;
        }

        @media (max-width: 979px) {
            .modal-open .page-container .navbar-fixed-top{
                overflow-y: visible;
            }
        }
        .saveBtn { width: 10%; float: left; text-align: center; vertical-align: middle;  }
        /* .ean { width: 80%; float: left; } */
        .tooltip{ font-size: 12px !important; }
        /* .add-a-savePoDetail{ width: 15%; float:right; display:none;} */
        .addPoDetail .modal-body { margin-left:10px;}
        #addPoDetailForm {width:100%; margin-bottom: 0;}
        .required {color:red;}

    </style>

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
    <b>
        <h4 class="text-center">EDITAL</h4>
        <br>
        <h5 class="text-center">CRONOGRAMA DE DEFESAS DE TCC {{ session()->get('anoletivo')->rotulo }} - {{ $cursoupper }}</h5>
    </b>
    <br>
    <br>
    <p class="text-justify">
        <span>O presente edital tem por finalidade informar as defesas de Trabalho de Conclusão de Curso para o ano letivo de {{ session()->get('anoletivo')->rotulo }},
        curso de {{ session()->get('curso')->nome }}, dentro do período oficial de {{ \Carbon\Carbon::parse($data->data_inicial)->formatLocalized('%d de %B de %Y') }}
        a {{ \Carbon\Carbon::parse($data->data_final)->formatLocalized('%d de %B de %Y') }}</span>
        <br>
        <br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
        <br><br><br>
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
    <br><br><br>
    <br><br><br>
    <br><br><br>

    @foreach ($banca as $banca)
        <div style="margin:5px;">
            <div>
                <table cellpadding="0" cellspacing="0" width="100%" class="border-bottom border-left">
                    <thead>
                        <tr bgcolor="#f5f5ef">
                            <th class="col-sm-1 content border-top border-bottom border-left border-right" valign="top">Título</th>
                            <td class="content border-top border-bottom border-left border-right" valign="top">{{ $banca->trabalho->titulo }}</td>
                        </tr>
                        <tr>
                            <th class="content border-bottom border-left border-right" valign="top">Academico(as)</th>
                            <td class="content border-bottom border-left border-right" valign="top">
                                @foreach($banca->academico as $academico)
                                    {{ $academico->user->name }}
                                    <br>
                                @endforeach
                            </td>
                        </tr>
                        <tr bgcolor="#f5f5ef">
                            <th class="content border-bottom border-left border-right" valign="top">Orientador(as)</th>
                            <td class="content border-bottom border-left border-right" valign="top">
                                {{ \App\User::find(\App\MembroBanca::find($banca->trabalho->orientador_id)->user_id)->name }}
                                <br>
                                @if($banca->trabalho->coorientador_id)
                                    {{ \App\User::find(\App\MembroBanca::find($banca->trabalho->coorientador_id)->user_id)->name }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="content border-bottom border-left border-right" valign="top">Membros da Banca</th>
                            <td class="content border-bottom border-left border-right" valign="top">
                                @foreach($banca->membrobanca as $membrobanca)
                                    @if($membrobanca->pivot->papel < 3)
                                        {{ $membrobanca->user->name }}
                                        <br>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr bgcolor="#f5f5ef">
                            <th class="content border-bottom border-left border-right" valign="top">Membros Suplentes</th>
                            <td class="content border-bottom border-left border-right" valign="top">
                                @foreach($banca->membrobanca as $membrobanca)
                                    @if($membrobanca->pivot->papel > 2)
                                        {{ $membrobanca->user->name }}
                                        <br>
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th class="content border-bottom border-left border-right" valign="top">Data e Horário</th>
                            <td class="content border-bottom border-left border-right" valign="top">{{ \Carbon\Carbon::parse($banca->data)->format('d/m/Y à\\s H:i') }}</td>
                        </tr>
                        <tr bgcolor="#f5f5ef">
                            <th class="content border-bottom border-left border-right" valign="top">Local</th>
                            <td class="content border-bottom border-left border-right" valign="top">{{ $banca->local }}</td>
                        </tr>
                    </thead>
                </table>
                <br><br>
            </div>
        </div>
    @endforeach

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