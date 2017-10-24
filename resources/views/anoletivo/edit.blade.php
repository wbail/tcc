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
                {{ $page_title or "Editando o Ano Letivo " . $anoletivo->rotulo }}
                <small>{{ $page_description or null }}</small>
            </h1>
               
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="{{ url('/avaliador') }}"><i class="fa fa-dashboard"></i> Acadêmicos</a></li>
                <li class="active">Novo</li>
            </ol> --}}
            <a href="{{ url('anoletivo') }}" class="btn btn-link pull-right breadcrumb">Voltar</a>
            
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
                    <ul>
                        <li>{{ session('message') }}</li>
                    </ul>
                </div>
            @endif

            <br>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    {!! Form::open(['url' => "/anoletivo/update/$anoletivo->id", 'method'=>'put']) !!}

                        {!! Form::label('rotulo', 'Rotulo *') !!}
                        {!! Form::text('rotulo', $anoletivo->rotulo, ['class'=>'form-control', 'title'=>'Rotulo do Ano Letivo']) !!}
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('ativo', 'Ativo *') !!}
                                {!! Form::checkbox('ativo', 1, $anoletivo->ativo, ['title'=>'Situacao do Ano Letivo']) !!}

                            </div>
                            <div class="col-md-6">
                                {!! Form::label('data', 'Ano valido ate *') !!}
                                {!! Form::text('data', \Carbon\Carbon::parse($anoletivo->data)->format('d/m/Y H:i'), ['class'=>'form-control', 'id'=>'datetimepicker', 'title'=>'Ultimo dia para o ano letivo']) !!}
                            </div>
                        </div>
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
<script src="{{ asset ('app.min.js') }}" type="text/javascript"></script>
{{-- Moment _ Datetimepicker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/pt-br.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.45/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>

<script>

    $('#datetimepicker').datetimepicker({
        locale: 'pt-br',
        format: 'DD/MM/YYYY',
    });

    $('.btn-primary').click(function() {

        if ($('#datetimepicker').val() == '') {
            var originalDateFinal = $('#datetimepicker').val();
        } else {
            var originalDateInicial = $('#datetimepicker').val();
            var convertedDateInicial = moment(originalDateInicial, 'DD/MM/YYYY HH:mm').format('YYYY-MM-DD HH:mm');
            $('#datetimepicker').val(convertedDateInicial);
        }
    });


</script>


</body>


</html>


