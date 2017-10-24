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
                {{ $page_title or "Nova Instituição" }}
                <small>{{ $page_description or null }}</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="{{ url('/avaliador') }}"><i class="fa fa-dashboard"></i> Acadêmicos</a></li>
                <li class="active">Novo</li>
            </ol> --}}
            <a href="{{ url('instituicao') }}" class="btn btn-link pull-right breadcrumb">Voltar</a>
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


            <br><br>

            <div class="row">
            	<div class="col-md-4"></div> {{-- ./col-md-4 --}}
            	<div class="col-md-4">
            		{!! Form::open(['url' => '/instituicao/store', 'method'=>'post']) !!}

                        {!! Form::label('nome', 'Instituição de Ensino *') !!}
                        {!! Form::text('nome', null, ['class'=>'form-control', 'title'=>'Nome da instituição']) !!}
                        <br>
                        {!! Form::label('sigla', 'Sigla *') !!}
                        {!! Form::text('sigla', null, ['class'=>'form-control', 'title'=>'Sigla Ex: UEPG']) !!}

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

    <!-- Modal del instituicao-->
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
<script src="{{ asset ('app.min.js') }}" type="text/javascript"></script>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

<script type="text/javascript">

// Add instituição
$('#addInst').on('show.bs.modal', function(e) {
    
    var $modal = $(this);
    var instituicaoid = e.relatedTarget.id;
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


</script>


</body>


</html>

