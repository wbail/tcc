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
                {{ $page_title or "Novo Curso" }}
                <small>{{ $page_description or null }}</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="{{ url('/avaliador') }}"><i class="fa fa-dashboard"></i> Acadêmicos</a></li>
                <li class="active">Novo</li>
            </ol> --}}
            <a href="{{ url('curso') }}" class="btn btn-link pull-right breadcrumb">Voltar</a>
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

            <br>

            @if (session('message'))
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <ul>
                        <li>{{ session('message') }}</li>
                    </ul>
                </div>
            @endif

            <br>

            <div class="row">
                <div class="col-md-4"></div> {{-- ./col-md-4 --}}
                <div class="col-md-4">
                    {!! Form::open(['url' => '/curso/store', 'method'=>'post']) !!}


                        {!! Form::label('nome', 'Nome do Curso *') !!}
                        {!! Form::text('nome', null, ['class'=>'form-control', 'title'=>'Nome do curso']) !!}
                        
                        <br>
                        {!! Form::label('departamento', 'Departamento *') !!}
                        {!! Form::select('departamento', $departamento, null, ['class'=>'form-control', 'title'=>'Nome do departamento da instituição de ensino', 'placeholder'=>'']) !!}
                        <br>
                        
                        {!! Form::label('coordenador', 'Coordenador de TCC *') !!}
                        {!! Form::select('coordenador', $coordenador, null, ['class'=>'form-control', 'title'=>'Nome do coordenador da disciplina de TCC', 'placeholder'=>'']) !!}

                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('iniciovigencia', 'Data de Início *') !!}
                                {!! Form::text('iniciovigencia', null, ['class'=>'form-control', 'title'=>'Data de Início da vigência como coordenador', 'id'=>'datetimepicker']) !!}
                            </div> <!-- ./col-md-6 -->
                            <div class="col-md-6">
                                {!! Form::label('fimvigencia', 'Data de Término') !!}
                                {!! Form::text('fimvigencia', null, ['class'=>'form-control', 'title'=>'Data de término da vigência como coordenador', 'id'=>'datetimepicker1']) !!}
                            </div> <!-- ./col-md-6 -->
                        </div> <!-- ./row -->                        
                        <br>
            			
            			{!! Form::submit('Salvar', ['class'=>'btn btn-primary pull-right']) !!}
            		{!! Form::close() !!}
            	</div> {{-- ./col-md-4 --}}
            	<div class="col-md-4"></div> {{-- ./col-md-4 --}}
            </div> {{-- ./row --}}
            
            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->

    <!-- Modal del curso-->
    <div id="addInst" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="model-body">
                </div>
                <div class="modal-footer add-inst">
                </div>
            </div>
        </div>
    </div>

    

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset ('../bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ('../bower_components/AdminLTE/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset ('../bower_components/AdminLTE/dist/js/app.min.js') }}" type="text/javascript"></script>
{{-- Moment _ Datetimepicker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/pt-br.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.45/js/bootstrap-datetimepicker.min.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

<script type="text/javascript">

// Add instituição
$('#addInst').on('show.bs.modal', function(e) {
    
    var $modal = $(this);
    var cursoid = e.relatedTarget.id;
    $modal.find('.modal-title').html('Adicionar Instituição');
    $modal.find('.model-body').html('<label>Nome da Instituição</label><input id="nome" name="nome" type="text" class="form-control" title="Nome da Instituição de Ensino" />');  

    $modal.find('.add-inst').html('<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button><button type="submit" id="salvarInst" onClick="salvaInst();" class="btn btn-primary">Salvar</button>');
});

function salvaInst() {
    
    console.log($('#nome').val());

    $.ajax({
        url: "/instituicao/store",
        type: 'POST',
        // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {nome: $('#nome').val()},
    })
    .done(function() {
        console.log("success");
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
    
}

$('#datetimepicker').datetimepicker({
    locale: 'pt-br',
    format: 'DD/MM/YYYY'
});

$('#datetimepicker1').datetimepicker({
    locale: 'pt-br',
    format: 'DD/MM/YYYY'
});

</script>


</body>


</html>

