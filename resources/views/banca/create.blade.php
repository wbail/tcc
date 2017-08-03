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
                {{ $page_title or "Nova Banca de Avaliação" }}
                <small>{{ $page_description or null }}</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="{{ url('/avaliador') }}"><i class="fa fa-dashboard"></i> Acadêmicos</a></li>
                <li class="active">Novo</li>
            </ol> --}}
            <a href="{{ url('etapa') }}" class="btn btn-link pull-right breadcrumb">Voltar</a>
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
                    <ul>
                        <li>{{ session('message') }}</li>
                    </ul>
                </div>
            @endif

            <br>

            <div class="row">
            	<div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Trabalho</h3>
                        </div>
                        <div class="panel-body">
                            {!! Form::open(['url' => '/banca/store', 'method'=>'post']) !!}
                                {!! Form::label('trabalho', 'Trabalho *') !!}
                                {!! Form::select('trabalho', $trabalho, null, ['id'=>'trabalho', 'class'=>'form-control', 'title'=>'Trabalho', 'placeholder'=>'']) !!}
                                <br>
                                {!! Form::label('aluno', 'Aluno(s) *') !!}
                                <div class="row">
                                    <div class="col-md-6">
                                         {!! Form::text('aluno', null, ['id'=>'aluno', 'class'=>'form-control', 'title'=>'Aluno', 'disabled']) !!} 
                                    </div> <!-- ./col-md-6 -->
                                    <div class="col-md-6">
                                         {!! Form::text('aluno1', null, ['id'=>'aluno1', 'class'=>'form-control', 'title'=>'Aluno', 'disabled']) !!}                                         
                                    </div> <!-- ./col-md-6 -->
                                </div> <!-- ./row -->
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                         {!! Form::label('orientador', 'Orientador(a) *') !!}
                                         {!! Form::text('orientador', null, ['id'=>'orientador', 'class'=>'form-control', 'title'=>'Orientador', 'disabled']) !!} 
                                    </div> <!-- ./col-md-6 -->
                                    <div class="col-md-6">
                                         {!! Form::label('coorientador', 'Corientador(a) *') !!} 
                                         {!! Form::text('coorientador', null, ['id'=>'coorientador', 'class'=>'form-control', 'title'=>'Coorientador', 'disabled']) !!}   
                                    </div> <!-- ./col-md-6 -->
                                </div> <!-- ./row -->
                                <br>
                                
                        </div>
                    </div> {{-- ./panel --}}
                </div> {{-- ./col-md-6 --}}
            	<div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Informações Adicionais</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Semana de bancas</label>
                                    <label>
                                        <h4>{{ \Carbon\Carbon::parse($data->data_inicial)->format('d/m/Y H:m') }} a {{ \Carbon\Carbon::parse($data->data_final)->format('d/m/Y H:m') }}</h4>
                                    </label>
                                </div>
                            
                                <div class="col-md-6">
                                    {!! Form::label('data', 'Data *') !!}
                                    {!! Form::text('data', null, ['class'=>'form-control', 'title'=>'Data da banca', 'id'=>'datetimepicker']) !!}
                                </div> <!-- ./col-md-12 -->
                            </div> <!-- ./row -->
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::label('membro', 'Membro de Banca *') !!}
                                    {!! Form::select('membro', $membros, null, ['class'=>'form-control', 'title'=>'Membro de Banca', 'placeholder'=>'']) !!}
                                </div> <!-- ./col-md-6 -->
                                <div class="col-md-6">
                                    {!! Form::label('membro2', 'Membro de Banca *') !!}
                                    {!! Form::select('membro2', $membros, null, ['class'=>'form-control', 'title'=>'Membro de Banca', 'placeholder'=>'']) !!}
                                </div> <!-- ./col-md-6 -->
                            </div> <!-- ./row -->
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    {!! Form::label('suplente', 'Membro Suplente*') !!}
                                    {!! Form::select('suplente', $membros, null, ['class'=>'form-control', 'title'=>'Membro Suplente', 'placeholder'=>'']) !!}
                                </div> <!-- ./col-md-6 -->
                                <div class="col-md-6">
                                    {!! Form::label('suplente2', 'Membro Suplente*') !!}
                                    {!! Form::select('suplente2', $membros, null, ['class'=>'form-control', 'title'=>'Membro Suplente', 'placeholder'=>'']) !!}
                                </div> <!-- ./col-md-6 -->
                            </div> <!-- ./row -->
    
                        </div>
                    </div> {{-- ./panel --}}
                                <br>
                                {!! Form::submit('Salvar', ['class'=>'btn btn-primary pull-right']) !!}
                            {!! Form::close() !!}
            	</div> {{-- ./col-md-6 --}}

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

    $('#datetimepicker').datetimepicker({
        locale: 'pt-br',
        format: 'DD/MM/YYYY HH:mm',
                
    });

    $('#datetimepicker1').datetimepicker({
        locale: 'pt-br',
        format: 'DD/MM/YYYY HH:mm'
    });

    $('#trabalho').on("change", function(e) {
        var trabalho = $(this).val();

        $.ajax({
            url: '{{ url("trabalho/show") }}/' + trabalho,
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {
            console.log(data);
            /*
            $('#aluno').html(data[0].nome_aluno);
            $('#aluno1').html(data[1].nome_aluno);
            $('#orientador').html(data[1].nome_ori);
            $('#coorientador').html(data[1].nome_ori);
            */

            
            document.getElementById("aluno").value = data[0].nome_aluno;
            document.getElementById("aluno1").value = data[0].nome_aluno;
            document.getElementById("orientador").value = data[1].nome_ori;
            document.getElementById("coorientador").value = data[1].nome_ori;
            
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });


    });


</script>

</body>


</html>
