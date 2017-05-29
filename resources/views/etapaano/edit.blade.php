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
                {{ $page_title or "Editando a etapa " . $etapaano->titulo }}
                <small>{{ $page_description or null }}</small>
            </h1>
               
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="{{ url('/avaliador') }}"><i class="fa fa-dashboard"></i> Acadêmicos</a></li>
                <li class="active">Novo</li>
            </ol> --}}
            <a href="{{ url('etapaano') }}" class="btn btn-link pull-right breadcrumb">Voltar</a>
            
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
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    {!! Form::open(['url' => "/etapaano/update/$etapaano->id", 'method'=>'put']) !!}
                        
                        {!! Form::label('etapa', 'Título *') !!}
                        {!! Form::select('etapa', $etapa, $etapaano->etapa->id, ['class'=>'form-control', 'title'=>'Etapa', 'placeholder'=>'']) !!}
                        <br>
                        {!! Form::label('titulo', 'Descrição *') !!}
                        {!! Form::text('titulo', $etapaano->titulo, ['class'=>'form-control', 'title'=>'Descrição da etapa']) !!}
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('data_inicial', 'Data Inicial') !!}
                                {!! Form::text('data_inicial', \Carbon\Carbon::parse($etapaano->data_inicial)->format('d/m/Y H:mm'), ['class'=>'form-control', 'title'=>'Data de início da etapa', 'id'=>'datetimepicker']) !!}
                            </div> <!-- ./col-md-6 -->
                            <div class="col-md-6">
                                {!! Form::label('data_final', 'Data Final *') !!}
                                {!! Form::text('data_final', \Carbon\Carbon::parse($etapaano->data_final)->format('d/m/Y H:mm'), ['class'=>'form-control', 'title'=>'Data de término da etapa', 'id'=>'datetimepicker1']) !!}
                            </div> <!-- ./col-md-6 -->
                        </div> <!-- ./row -->
                        <br>
                        {!! Form::label('trabalho', 'Trabalho') !!}
                        {!! Form::select('trabalho[]', $trabalho, $etapaano->trabalho->pluck('id')->toArray() , ['class'=>'form-control', 'title'=>'Vincular trabalho à esta etapa', 'multiple'=>'multiple']) !!}                        
                        <br>
                        {!! Form::label('ativa', 'Etapa ativa') !!}
                        {!! Form::checkbox('ativa', 1, $etapaano->ativa) !!}
                        <br>
                        {!! Form::submit('Salvar', ['class'=>'btn btn-primary pull-right']) !!}

                    {!! Form::close() !!}

                </div> {{-- ./col-md-4 --}}

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
{{-- Select2 --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.js"></script>
{{-- Select2 - pt-BR --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/pt-BR.js"></script>
{{-- Moment _ Datetimepicker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/pt-br.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.45/js/bootstrap-datetimepicker.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-dateFormat/1.0/jquery.dateFormat.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

<script type="text/javascript">

    $('#datetimepicker').datetimepicker({
        locale: 'pt-br',
        format: 'DD/MM/YYYY HH:mm',
    });

    $('#datetimepicker1').datetimepicker({
        locale: 'pt-br',
        format: 'DD/MM/YYYY HH:mm',
    });

    $('.btn-primary').click(function() {

        if ($('#datetimepicker').val() == '') {
            var originalDateFinal = $('#datetimepicker1').val();
            var convertedDateFinal = moment(originalDateFinal, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD HH:mm');
            $('#datetimepicker1').val(convertedDateFinal);
            
        } else {
            var originalDateInicial = $('#datetimepicker').val();
            var originalDateFinal = $('#datetimepicker1').val();

            var convertedDateInicial = moment(originalDateInicial, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD HH:mm');
            var convertedDateFinal = moment(originalDateFinal, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD HH:mm');

            $('#datetimepicker').val(convertedDateInicial);
            $('#datetimepicker1').val(convertedDateFinal);
                        
        }

    });


</script>


</body>


</html>


