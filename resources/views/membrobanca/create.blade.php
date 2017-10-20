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
                {{ $page_title or "Novo(a) Professor(a)" }}
                <small>{{ $page_description or null }}</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="{{ url('/avaliador') }}"><i class="fa fa-dashboard"></i> Acadêmicos</a></li>
                <li class="active">Novo</li>
            </ol> --}}
            <a href="{{ url('membrobanca') }}" class="btn btn-link pull-right breadcrumb">Voltar</a>
            <br>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->

            @if(count($errors) > 0)
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('message'))
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ session('message') }}</strong>
                </div>
            @endif

            <br><br>

            {!! Form::open(['url'=>'/membrobanca/store', 'method'=>'post']) !!}
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Informações Básicas</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-5">
                                    {!! Form::label('departamento', 'Departamento *') !!}
                                    {!! Form::select('departamento', $departamento, null, ['class'=>'form-control', 'placeholder' => '', 'title'=>'Departamento que o(a) avaliador(a) pertence']) !!}
                                    <br>
                                </div> {{-- ./col-md-5 --}}
                                <div class="col-md-5">
                                    {!! Form::label('nome', 'Nome *') !!}
                                    {!! Form::text('nome', null, ['class'=>'form-control', 'title'=>'Nome do(a) avaliador(a)']) !!}
                                </div> {{-- ./col-md-5 --}}
                            </div> {{-- ./row --}}
                            <div class="row">
                                <div class="col-md-9">
                                    {!! Form::label('permissao', 'Permissão *') !!}
                                    {!! Form::checkbox('orientador', 4, false) !!}
                                    {!! Form::label('orientador', 'Orientador') !!}
                                    {!! Form::checkbox('coorientador', 2, false) !!}
                                    {!! Form::label('coorientador', 'Coorientador') !!}
                                    {!! Form::checkbox('banca', 1, false) !!}
                                    {!! Form::label('banca', 'Banca') !!}
                                </div> {{-- ./col-md-9 --}}
                            </div> {{-- ./row --}}
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::label('ativo', 'Ativo *') !!}
                                    {!! Form::checkbox('ativo', 1, true, ['title'=>'Situação no sistema: Ativo']) !!}
                                </div> {{-- ./col-md-6 --}}
                            </div> {{-- ./row --}}

                        </div> {{-- ./panel-body --}}
                    </div> {{-- ./panel --}}


                </div> {{-- ./col-md-6 --}}

                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Contato</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::label('email', 'E-mail *') !!}
                                    {!! Form::text('email', null, ['class'=>'form-control', 'title'=>'E-mail do avaliador(a)']) !!}
                                </div> {{-- ./col-md-6 --}}
                                <div class="col-md-5">
                                    {!! Form::label('telefone', 'Telefone *') !!}<br>

                                    {!! Form::text('telefone', null, ['class'=>'form-control phone_with_ddd', 'title'=>'Número do telefone com DDD']) !!}
                                    <span id="addTelefone" onclick="add()" class="btn btn-link btn-sm" title="Adicionar telefone"><i class="fa fa-plus"></i></span>
                                    <div class="add-telefone">
                                        <br>
                                    </div>

                                    <br><br><br><br>

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

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

</body>

<script type="text/javascript">
    $('.phone_with_ddd').mask('(00) 00000-0000');


    $('.btn-primary').click(function() {
        $('.phone_with_ddd').unmask();
        
    });


    var count = 1;
    function add() {

        $('.add-telefone').append('<div class="telefone' + count + '"><input id="telefone' + count + '" name="telefone' + count + '" class="form-control phone_with_ddd" title="Número do telefone com DDD" /><span id="addTelefone" onclick="add()" class="btn btn-link" title="Adicionar telefone"><i class="fa fa-plus"></i></span><span id="telefone' + count +'" onclick="rm(id)" class="btn btn-link btn-sm" title="Remover telefone"><i class="fa fa-minus"></i></span><br><br></div>');

        count += 1;

    }

    function rm(telefoneid) {
        $('.' + telefoneid).html('');
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

