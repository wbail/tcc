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
                {{ $page_title or "Editando o Curso " . $curso->nome }}
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

            <br><br>

            <div class="row">
            	<div class="col-md-4"></div> {{-- ./col-md-4 --}}
            	<div class="col-md-4">
            		{!! Form::open(['url' => "/curso/update/$curso->id", 'method'=>'put']) !!}
            			{!! Form::label('coordenador', 'Coordenador do Curso *') !!}
                        {!! Form::select('coordenador', $coordenadortodos, $curso->membrobanca[0]->pivot->coordenador_id, ['class'=>'form-control', 'title'=>'Nome do Coordenador do Curso', 'placeholder'=>'']) !!}
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('iniciovigencia', 'Data de Início *') !!}
                                {!! Form::text('iniciovigencia', \Carbon\Carbon::parse($curso->membrobanca[0]->pivot->inicio_vigencia)->format('d/m/Y'), ['class'=>'form-control', 'title'=>'Data de Início da vigência como coordenador', 'id'=>'datetimepicker']) !!}
                                
                            </div> <!-- ./col-md-6 -->
                            <div class="col-md-6">
                                {!! Form::label('fimvigencia', 'Data de Término') !!}
                                {!! Form::text('fimvigencia', \Carbon\Carbon::parse($curso->membrobanca[0]->pivot->fim_vigencia)->format('d/m/Y'), ['class'=>'form-control', 'title'=>'Data de término da vigência como coordenador', 'id'=>'datetimepicker1']) !!}
                            </div> <!-- ./col-md-6 -->
                        </div> <!-- ./row -->
                        <br>
                        {!! Form::label('departamento', 'Departamento *') !!}
                        {!! Form::select('departamento', $departamento, $curso->departamento->id, ['class'=>'form-control', 'title'=>'Nome do departamento da instituição de ensino', 'placeholder'=>'']) !!}
                        <br>
                        {!! Form::label('nome', 'Nome *') !!}
                        {!! Form::text('nome', $curso->nome, ['class'=>'form-control', 'title'=>'Nome do curso da instituição de ensino', 'placeholder'=>'']) !!}
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
{{-- Moment _ Datetimepicker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/pt-br.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.45/js/bootstrap-datetimepicker.min.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->


<script type="text/javascript">


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

