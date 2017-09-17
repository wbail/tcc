@include('includes')

    <!-- Header -->
    @include('header')

    <!-- Sidebar -->
    @include('sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            
            <h1>
                {{ $page_title or "Novo(a) Aluno(a)" }}
                <small>{{ $page_description or null }}</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="{{ url('/academico') }}"><i class="fa fa-dashboard"></i> Acadêmicos</a></li>
                <li class="active">Novo</li>
            </ol> --}}
            <a href="{{ url('academico') }}" class="btn btn-link pull-right breadcrumb">Voltar</a>
            <br>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->

             @if (count($errors) > 0)
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ session('message') }}</strong>
                </div>
            @endif

            <br>

             {!! Form::open(['url'=>'/academico/store', 'method'=>'post']) !!}
            <div class="row">

                <div class="col-md-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Informações Básicas</h3>
                        </div>
                        <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::label('curso', 'Curso *') !!}
                                        {!! Form::select('curso', $curso, null, ['class'=>'form-control', 'title'=>'Curso do(a) acadêmico(a)', 'placeholder'=>'']) !!}
                                        <br>
                                    </div>                                  
                                    <div class="col-md-4">
                                        {!! Form::label('nome', 'Nome *') !!}
                                        {!! Form::text('nome', null, ['class'=>'form-control', 'title'=>'Nome do(a) acadêmico(a)']) !!}
                                        <br>
                                    </div> {{-- ./col-md-4 --}}
                                    <div class="col-md-4">
                                        {!! Form::label('ra', 'RA *') !!}
                                        {!! Form::text('ra', null, ['class'=>'form-control', 'min'=>'0', 'maxlength'=>'8', 'title'=>'Registro Acadêmico']) !!}
                                        <br>
                                    </div> {{-- ./col-md-4 --}}
                                </div> {{-- ./row --}}
                        </div> {{-- ./panel-body --}}
                    </div> {{-- ./panel --}}
                </div> {{-- ./col-md-7 --}}

                <div class="col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Contato</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::label('email', 'E-mail *') !!}
                                    {!! Form::text('email', null, ['class'=>'form-control', 'title'=>'E-mail do(a) acadêmico(a)']) !!}
                                </div> {{-- ./col-md-6 --}}
                            </div> {{-- ./row --}}
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                
                                    {{--{!! Form::label('tipo', 'Tipo de Telefone *') !!}<br>--}}
                                    {{--{!! Form::select('tipo', $tipo, 1, ['class'=>'form-control', 'title'=>'Tipo de Telefone', 'placeholder'=>'']) !!}--}}

                                    {{-- 
                                    {!! Form::text('telefone', null, ['class'=>'form-control phone_with_ddd', 'title'=>'Número do telefone com DDD']) !!}
                                    <span id="addTelefone" onclick="add()" class="btn btn-link btn-sm" title="Adicionar telefone"><i class="fa fa-plus"></i></span>
                                    <div class="add-telefone">
                                        <br>                                
                                    </div>
                                    --}}

                                    <!-- Add telefone angular -->
                                    {!! Form::label('telefone', 'Telefone *') !!}<br>
                                    <div ng-app="numeroTelefoneList" ng-cloak ng-controller="myCtrl">

                                        <div ng-repeat="x in numero">
                                            <div class="row">
                                                <div class="col-md-9">

                                                    <input type="text" name="telefone@{{$index}}" value="@{{x}}" class="form-control"/>
                                                </div>
                                                <div class="col-md-1">
                                                    <span ng-click="removeItem($index)" style="cursor:pointer;" class="w3-right w3-margin-right" title="Remover telefone"><i class="fa fa-remove"></i> </span>
                                                    <br>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">

                                                <a href="#" id="popoverid" data-toggle="popover" data-content="@{{errortext}}" data-trigger="focus">
                                                    <input id="adicionTelefone" ng-model="addMe" class="form-control phone_with_ddd" type="text" title="Ex: (42) 99999-9999">
                                                </a>
                                            </div>
                                            <div class="col-md-1">

                                                <a href="#" ng-click="addItem()" title="Adicionar telefone"><i class="fa fa-plus"></i></a>
                                            </div>
                                        </div>
                                        {{-- <p class="w3-padding-left w3-text-red">@{{errortext}}</p> --}}
                                    </div>

                                </div> {{-- ./col-md-4 --}}
                                <div class="col-md-6">

                                
                                </div> {{-- ./col-md-6 --}}
                            </div> {{-- ./row --}}

                        </div> {{-- ./panel-body --}}
                    </div> {{-- ./panel --}}
                </div> {{-- ./col-md-6 --}}
            </div> {{-- ./row --}}
                                {!! Form::submit('Salvar', ['class'=>'btn btn-primary pull-right']) !!}
                                
                            {!! Form::close() !!}


            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset ('../bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ('../bower_components/AdminLTE/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset ('../bower_components/AdminLTE/dist/js/app.min.js') }}" type="text/javascript"></script>
{{-- jQuery Mask Plugin --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.9/jquery.mask.js"></script>
{{-- AngularJS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular.min.js"></script>

<script src="../../resources/assets/js/appangular.js" type="text/javascript"></script>
{{-- 
<script src="../../resources/assets/js/primeiro-controller.js" type="text/javascript"></script>
--}}

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

</body>

<script type="text/javascript">
    
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
        $(".alert-success").slideUp(500);
    });

    $('.phone_with_ddd').mask('(00) 00000-0000');


    $('.btn-primary').click(function() {
        $('.phone_with_ddd').unmask();
        
    });


    var count = 1;
    function add() {

        $('.add-telefone').append('<input name="telefone' + count + '" class="form-control phone_with_ddd" title="Número do telefone com DDD" /><span id="addTelefone" onclick="add()" class="btn btn-link" title="Adicionar telefone"><i class="fa fa-plus"></i></span><br><br>');

        count += 1;

    }


    var app = angular.module("numeroTelefoneList", []);
    app.controller("myCtrl", function($scope) {
        $scope.numero = [];
        $scope.addItem = function () {
            $scope.errortext = "";
            
            if (!$scope.addMe) {
                return;
            }

            if ($scope.numero.indexOf($scope.addMe) == -1) {
                $scope.numero.push($scope.addMe);
                $('#adicionTelefone').val('');

            } else {
                $scope.errortext = "Número já adicionado.";
                $('#popoverid').popover('show');

            }
        }

        $scope.removeItem = function (x) {
        
            $scope.errortext = "";
            
            $scope.numero.splice(x, 1);
        }
    
    });





</script>

</html>

