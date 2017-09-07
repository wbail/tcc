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
                {{ $page_title or "Editando o trabalho " . $trabalho->titulo }}
                <small>{{ $page_description or null }}</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="{{ url('/trabalho') }}"><i class="fa fa-dashboard"></i> Acadêmicos</a></li>
                <li class="active">Novo</li>
            </ol> --}}
            <a href="{{ url('trabalho') }}" class="btn btn-link pull-right breadcrumb">Voltar</a>
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

            @if (session('message'))
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <ul>
                        <li>{{ session('message') }}</li>
                    </ul>
                </div>
            @endif

            <br>

            {!! Form::open(['url'=>"/trabalho/update/$trabalho->id", 'method'=>'put']) !!}
            <div class="row">
                <div class="col-md-3"></div> {{-- ./col-md-4 --}}
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Informações Básicas</h3>
                        </div>
                        <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        {!! Form::label('titulo', 'Titulo do trabalho *') !!}
                                        {!! Form::text('titulo', $trabalho->titulo, ['class'=>'form-control', 'title'=>'Título do trabalho']) !!}
                                    </div> {{-- ./col-md-9 --}}
                                    <div class="col-md-4">
                                        {!! Form::label('sigla', 'Sigla do trabalho *') !!}
                                        {!! Form::text('sigla', $trabalho->sigla, ['class'=>'form-control', 'title'=>'Sigla do trabalho']) !!}
                                    </div> {{-- ./col-md-3 --}}

                                </div> {{-- ./row --}}
                                <br>
                                <div class="row">
                                    @if($qntacademicos > 1)
                                        <div class="col-md-6">
                                            {!! Form::label('academico', 'Acadêmico(a) *') !!}
                                            {!! Form::select('academico', $academico, $academicos[0]->academico_id, ['class'=>'form-control s2', 'placeholder'=>'', 'title'=>'Nome do(a) Acadêmico(a)']) !!}
                                            
                                        </div> {{-- ./col-md-6 --}}
                                        <div class="col-md-6">
                                            {!! Form::label('academico1', 'Acadêmico(a)') !!}
                                            {!! Form::select('academico1', $academico, $academicos[1]->academico_id, ['class'=>'form-control s2', 'placeholder'=>'', 'title'=>'Nome do(a) Acadêmico(a)']) !!}
                                        </div> {{-- ./col-md-6 --}}
                                    @else
                                        <div class="col-md-6">
                                            {!! Form::label('academico', 'Acadêmico(a) *') !!}
                                            {!! Form::select('academico', $academico, $academicos[0]->academico_id, ['class'=>'form-control s2', 'placeholder'=>'', 'title'=>'Nome do(a) Acadêmico(a)']) !!}
                                            
                                        </div> {{-- ./col-md-6 --}}
                                        <div class="col-md-6">
                                            {!! Form::label('academico1', 'Acadêmico(a)') !!}
                                            {!! Form::select('academico1', $academico, null, ['class'=>'form-control s2', 'placeholder'=>'', 'title'=>'Nome do(a) Acadêmico(a)']) !!}
                                        </div> {{-- ./col-md-6 --}}
                                    @endif
                                </div> {{-- ./row --}}
                                <br>                                
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::label('ano', 'Ano') !!}
                                        {!! Form::text('ano', $trabalho->ano, ['class'=>'form-control', 'id'=>'datetimepicker', 'title'=>'Ano do trabalho']) !!}
                                    </div> {{-- ./col-md-2 --}}
                                    <div class="col-md-4">
                                        {!! Form::label('periodo', 'Período') !!}
                                        <br>
                                        @if($trabalho->periodo == 1)
                                        {!! Form::radio('periodo', 3, null, ['title'=>'Disciplina Anual']) !!}
                                        {!! Form::label('tres', 'Anual') !!}
                                        {!! Form::radio('periodo', 1, true, ['title'=>'Primeiro Semestre']) !!}
                                        {!! Form::label('um', '1') !!}
                                        {!! Form::radio('periodo', 2, null, ['title'=>'Segundo Semestre']) !!}
                                        {!! Form::label('dois', '2') !!}
                                        @elseif($trabalho->periodo == 2)
                                        {!! Form::radio('periodo', 3, null, ['title'=>'Disciplina Anual']) !!}
                                        {!! Form::label('tres', 'Anual') !!}
                                        {!! Form::radio('periodo', 1, null, ['title'=>'Primeiro Semestre']) !!}
                                        {!! Form::label('um', '1') !!}
                                        {!! Form::radio('periodo', 2, true, ['title'=>'Segundo Semestre']) !!}
                                        {!! Form::label('dois', '2') !!}
                                        @elseif($trabalho->periodo == 3)
                                        {!! Form::radio('periodo', 3, true, ['title'=>'Disciplina Anual']) !!}
                                        {!! Form::label('tres', 'Anual') !!}
                                        {!! Form::radio('periodo', 1, null, ['title'=>'Primeiro Semestre']) !!}
                                        {!! Form::label('um', '1') !!}
                                        {!! Form::radio('periodo', 2, null, ['title'=>'Segundo Semestre']) !!}
                                        {!! Form::label('dois', '2') !!}
                                        @endif
                                        
                                    </div> {{-- ./col-md-3 --}}
                                    
                                </div> {{-- ./row --}}
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::label('orientador', 'Orientador(a) *') !!}
                                        {!! Form::select('orientador', $orientador, $trabalho->orientador_id, ['class'=>'form-control s3', 'placeholder'=>'', 'title'=>'Nome do(a) Orientador(a)']) !!}
                                    </div> {{-- ./col-md-6 --}}
                                    <div class="col-md-6">
                                        {!! Form::label('coorientador', 'Coorientador(a)') !!}
                                        {!! Form::select('coorientador', $orientador, $trabalho->coorientador_id, ['class'=>'form-control s3', 'placeholder'=>'', 'title'=>'Nome do(a) Coorientador(a)']) !!}
                                    </div> {{-- ./col-md-6 --}}
                                </div> {{-- ./row --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <br>
                                        {!! Form::label('aprovado', 'Aprovado') !!}
                                        <br>
                                        {!! Form::checkbox('aprovado', 1, $trabalho->aprovado, ['title'=>'Situação do trabalho. Aprovado/Não Aprovado']) !!}
                                    </div>
                                </div>

                        </div> {{-- ./panel-body --}}
                    </div> {{-- ./panel --}}


                </div> {{-- ./col-md-4 --}}
                <div class="col-md-4"></div> {{-- ./col-md-4 --}}


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
{{-- Select2 --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>
{{-- Select2 - pt-BR --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>
{{-- Moment _ Datetimepicker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/pt-br.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.45/js/bootstrap-datetimepicker.min.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

</body>

<script type="text/javascript">
	
    // Academico
	$(".s2").select2({
		language: "pt-BR",
        allowClear: true,
        placeholder: '',

        ajax: {
            dataType: 'json',
            type: 'GET',
            url: '{{ url("/academico") }}',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function (data) {
                return {
                    
                    results: $.map(data.itens, function(val, i) {
                        return {id: val, text:i};
                    })
                };
                
            },
        }

	});


    // Orientador
    $(".s3").select2({
        language: "pt-BR",
        allowClear: true,        
        placeholder: '',
        ajax: {
            dataType: 'json',
            type: 'GET',
            url: '{{ url("/membrobanca") }}',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term
                }
            },
            processResults: function (data) {
                return {
                    
                    results: $.map(data.itens, function(val, i) {
                        return {id: val, text:i};
                    })
                };
                
            },
        }

    });



	$('#datetimepicker').datetimepicker({
		locale: 'pt-br',
		format: 'YYYY',
        
	});

    $('.datetimepicker1').datetimepicker({
        locale: 'pt-br',
        format: 'D/MM/YYYY H:m'
    });


</script>

</html>




