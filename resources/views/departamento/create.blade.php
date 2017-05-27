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
                {{ $page_title or "Novo Departamento" }}
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

            


            <br><br>

            <div class="row">
            	<div class="col-md-4"></div> {{-- ./col-md-4 --}}
            	<div class="col-md-4">

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


            		{!! Form::open(['url' => '/departamento/store', 'method'=>'post']) !!}
            			{!! Form::label('instituicao', 'Nome da Instituição *') !!}
                        {!! Form::select('instituicao', $inst, null, ['class'=>'form-control', 'title'=>'Nome da Instituição de Ensino', 'placeholder'=>'']) !!}
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                {!! Form::label('nome', 'Nome do Departamento *') !!}
                    			{!! Form::text('nome', null, ['class'=>'form-control', 'title'=>'Nome do Departamento']) !!}

                            </div> <!-- ./col-md-6 -->
                            <div class="col-md-6">
                                {!! Form::label('sigla', 'Sigla *') !!}
                                {!! Form::text('sigla', null, ['class'=>'form-control', 'title'=>'Sigla do Departamento']) !!}

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

    <!-- Modal del departamento-->
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


<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

<script type="text/javascript">





</script>


</body>


</html>

