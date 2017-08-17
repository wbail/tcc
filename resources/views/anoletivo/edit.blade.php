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
                                {!! Form::text('data', $anoletivo->data, ['class'=>'form-control', 'title'=>'Ultimo dia para o ano letivo']) !!}
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
<script src="{{ asset ('../bower_components/AdminLTE/dist/js/app.min.js') }}" type="text/javascript"></script>


</body>


</html>


