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
                Editando o aluno(a) {{ $academico->user->name }}
                <small>{{ $page_description or null }}</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
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
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ session('message') }}</strong>
                </div>
            @endif


            @if (session('message-tel'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ session('message-tel') }}</strong>
                </div>
            @endif

			<br>

             {!! Form::open(['url'=>"academico/update/$academico->id", 'method'=>'put']) !!}
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
                                        {!! Form::select('curso', $curso, $academico->curso_id, ['class'=>'form-control', 'title'=>'Curso do(a) acadêmico(a)']) !!}
                                    </div> {{-- ./col-md-4 --}}
                                    <div class="col-md-4">
                                        {!! Form::label('nome', 'Nome *') !!}
                                        {!! Form::text('nome', $academico->user->name, ['class'=>'form-control', 'title'=>'Nome do(a) acadêmico(a)']) !!}
                                    </div> {{-- ./col-md-4 --}}
                                    <div class="col-md-4">
                                        {!! Form::label('ra', 'RA *') !!}
                                        {!! Form::number('ra', $academico->ra, ['class'=>'form-control', 'min'=>'0', 'title'=>'Registro Acadêmico']) !!}
                                        <br>
                                    </div> {{-- ./col-md-4 --}}
                                </div> {{-- ./row --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        {!! Form::label('ativo', 'Ativo *') !!}
                                        {!! Form::checkbox('ativo', 1, $academico->user->ativo, ['title'=>'Status do(a) Aluno(a)']) !!}
                                    </div>
                                </div>
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
                                <div class="col-md-6">
                                    {!! Form::label('email', 'E-mail *') !!}
                                    {!! Form::text('email', $academico->user->email, ['class'=>'form-control', 'title'=>'E-mail do(a) acadêmico(a)']) !!}
                                </div> {{-- ./col-md-6 --}}

                                <div class="col-md-5 add-telefone">
                                    {!! Form::label('telefone', 'Telefone *') !!}<br>
                                    @foreach($academico->user->telefone as $contato)
                                        @if($loop->index == 0)
                                            {!! Form::text('telefone0', $contato->numero, ['class'=>'form-control phone_with_ddd', 'title'=>'Número do telefone com DDD']) !!}
                                            <span id="addTelefone" onclick="add()" class="btn btn-link btn-sm" title="Adicionar telefone"><i class="fa fa-plus"></i></span>
                                        @else
                                            <div class='telefone{{$loop->index}}'>
                                                {!! Form::text("telefone$loop->index", $contato->numero, ['class'=>'form-control phone_with_ddd', 'title'=>'Número do telefone com DDD']) !!}
                                                <span id="addTelefone" onclick="add()" class="btn btn-link btn-sm" title="Adicionar telefone"><i class="fa fa-plus"></i></span>
                                                <span id="{{$contato->id}}" onclick="rm(id)" class="btn btn-link btn-sm" title="Remover telefone" data-toggle="modal" data-target="#myModalDelTelefone"><i class="fa fa-minus"></i></span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div> {{-- ./col-md-5 --}}

                            </div> {{-- ./row --}}
                            <br>
                        </div> {{-- ./panel-body --}}
                    </div> {{-- ./panel --}}
                </div> {{-- ./col-md-6 --}}
            </div> {{-- ./row --}}
                                {!! Form::submit('Salvar', ['class'=>'btn btn-primary pull-right']) !!}
                                
                            {!! Form::close() !!}

        <!-- Modal del telefone-->
            <div id="myModalDelTelefone" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel"></h4>
                        </div>
                        <div class="modal-footer del-telefone">
                        </div>
                    </div>
                </div>
            </div>
            
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

    // Deletar telefone
    $('#myModalDelTelefone').on('show.bs.modal', function(e) {

        var $modal = $(this);
        var telefoneid = e.relatedTarget.id;
        $modal.find('.modal-title').html('Deseja realmente excluir?');
        $modal.find('.del-telefone').html('<a href="/tcc/public/telefone/destroy/'+telefoneid+'" class="btn btn-danger"> Excluir </a><button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>');
    });


</script>

</html>

