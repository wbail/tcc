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
                {{ $page_title or "Editando o Departamento " . $departamento->descricao }}
                <small>{{ $page_description or null }}</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="{{ url('/avaliador') }}"><i class="fa fa-dashboard"></i> Acadêmicos</a></li>
                <li class="active">Novo</li>
            </ol> --}}
            <a href="{{ url('departamento') }}" class="btn btn-link pull-right breadcrumb">Voltar</a>
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
            		{!! Form::open(['url' => "/departamento/update/$departamento->id", 'method'=>'put']) !!}
            			{!! Form::label('instituicao', 'Instituição de Ensino *') !!}
                        {!! Form::select('instituicao', $inst, $departamento->instituicao_id, ['class'=>'form-control', 'title'=>'Instituição de Ensino', 'placeholder'=>'']) !!}
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('nome', 'Nome *') !!}
                                {!! Form::text('nome', $departamento->nome, ['class'=>'form-control', 'title'=>'Nome do Departamento']) !!}

                            </div> <!-- ./col-md-6 -->
                            <div class="col-md-6">
                                {!! Form::label('sigla', 'Sigla *') !!}
                                {!! Form::text('sigla', $departamento->sigla, ['class'=>'form-control', 'title'=>'Sigla do Departamento']) !!}

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
    

</div><!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="{{ asset ('../bower_components/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ('../bower_components/AdminLTE/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset ('app.min.js') }}" type="text/javascript"></script>
{{-- jQuery Mask Plugin --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.9/jquery.mask.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

</body>


</html>

