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
                {{ $page_title or "Novo Trabalho" }}
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

            <br>

            {!! Form::open(['url'=>'/trabalho/store', 'method'=>'post']) !!}
            <div class="row">
                <div class="col-md-3"></div> {{-- ./col-md-4 --}}
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Informações Básicas</h3>
                        </div>
                        <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::label('titulo', 'Titulo do trabalho *') !!}
                                        {!! Form::text('titulo', null, ['class'=>'form-control', 'title'=>'Título do trabalho']) !!}
                                    </div> {{-- ./col-md-5 --}}
                                </div> {{-- ./row --}}
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::label('academico', 'Acadêmico(a) *') !!}
                                        {!! Form::select('academico', $academico, null, ['class'=>'form-control s2', 'placeholder'=>'', 'title'=>'Nome do(a) Acadêmico(a)']) !!}
                                        
                                    </div> {{-- ./col-md-6 --}}
                                    <div class="col-md-6">
                                        {!! Form::label('academico1', 'Acadêmico(a)') !!}
                                        {!! Form::select('academico1', $academico, null, ['class'=>'form-control s2', 'placeholder'=>'', 'title'=>'Nome do(a) Acadêmico(a)']) !!}
                                    </div> {{-- ./col-md-6 --}}
                                </div> {{-- ./row --}}
                                <br>                                
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::label('ano', 'Ano') !!}
                                        {!! Form::text('ano', null, ['class'=>'form-control', 'id'=>'datetimepicker', 'title'=>'Ano do trabalho']) !!}
                                    </div> {{-- ./col-md-2 --}}
                                    <div class="col-md-4">
                                        {!! Form::label('periodo', 'Período') !!}
                                        <br>
                                        {!! Form::radio('periodo', 1, true, ['title'=>'Disciplina Anual']) !!}
                                        {!! Form::label('tres', 'Anual') !!}
                                        {!! Form::radio('periodo', 1, false, ['title'=>'Primeiro Semestre']) !!}
                                        {!! Form::label('um', '1') !!}
                                        {!! Form::radio('periodo', 2, false, ['title'=>'Segundo Semestre']) !!}
                                        {!! Form::label('dois', '2') !!}
                                    </div> {{-- ./col-md-3 --}}
                                    
                                </div> {{-- ./row --}}
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::label('orientador', 'Orientador(a) *') !!}
                                        {!! Form::select('orientador', $orientador, null, ['class'=>'form-control s3', 'placeholder'=>'', 'title'=>'Nome do(a) Orientador(a)']) !!}
                                    </div> {{-- ./col-md-6 --}}
                                    <div class="col-md-6">
                                        {!! Form::label('coorientador', 'Coorientador(a)') !!}
                                        {!! Form::select('coorientador', $orientador, null, ['class'=>'form-control s3', 'placeholder'=>'', 'title'=>'Nome do(a) Coorientador(a)']) !!}
                                    </div> {{-- ./col-md-6 --}}
                                </div> {{-- ./row --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <br>
                                        {!! Form::label('aprovado', 'Aprovado') !!}
                                        <br>
                                        {!! Form::checkbox('aprovado', 1, false, ['title'=>'Situação do trabalho. Aprovado/Não Aprovado']) !!}
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




