@if(Auth::user()->permissao == 9)

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
                {{ $page_title or "Etapas" }}
                <small>{{ $page_description or null }}</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol> --}}
            <br>

        </section>


        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->

            <div class="col-md-2"></div> <!-- ./col-md-4 -->
            <div class="col-md-8">

                @if (session('message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{{ session('message') }}</strong>
                    </div>
                @endif

                <table data-order='[[0, "desc"]]' class="table table-hover table-striped table-bordered display">
                    <thead>
                        <tr>
                            {{--  <th class="col-md-2">Etapa</th>  --}}
                            <th class="col-md-3">Trabalho</th>
                            <th class="col-md-3">Descrição</th>
                            <th class="col-md-2">Data Entrega</th>
                            <th class="text-center col-md-1">Situação</th>
                            <th class="col-md-3">Arquivo</th>
                            <th class="text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etapaano as $etapaano)
                        @foreach($etapaano as $etapaano)
                        <tr>
                            {{--  <td>{{ $etapaano->etapa->desc }}</td>  --}}
                            <td>{{ $etapaano->titulo }}</td>
                            <td>{{ $etapaano->descricao }}</td>
                            <td>{{ \Carbon\Carbon::parse($etapaano->data_final)->format('d/m/Y H:m') }}</td>
                            @if($etapaano->ativa == 1)
                                <td class="text-center"><span class="label label-success">Ativa</span></td>
                            @else
                                <td class="text-center"><span class="label label-default">Não Ativa</span></td>
                            @endif
                            <td class="text-center">
                                @if($etapaano->ativa == 1)
                                    <button value="{{ $etapaano->trabalho_id }}" id="{{ $etapaano->id }}" class="btn btn-default btn-sm" title="Lista de Arquivos" data-toggle="modal" data-target="#myModalListArquivos"><i class="fa fa-list"></i> Listar</button>
                                    <button value="{{ $etapaano->trabalho_id }}" id="{{ $etapaano->id }}" class="btn btn-primary btn-sm" title="Enviar Arquivo" data-toggle="modal" data-target="#myModalUploadArquivos"><i class="fa fa-upload"></i> Enviar</button> 
                                @else
                                    <button value="{{ $etapaano->trabalho_id }}" id="{{ $etapaano->id }}" class="btn btn-default btn-sm" title="Lista de Arquivos" data-toggle="modal" data-target="#myModalListArquivos"><i class="fa fa-list"></i> Listar</button>
                                @endif
                            </td>
                            <td class="text-center">
                                <a id="{{ $etapaano->id }}" class="btn btn-link" href="{{ route('etapaano.edit', ['id'=>$etapaano->id]) }}" title="Editar"><i class="fa fa-pencil"></i></a>
                                <button id="{{ $etapaano->id }}" class="btn btn-link" data-toggle="modal" data-target="#myModalDelEtapa" title="Excluir"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table> {{-- ./table --}}

            </div> <!-- ./col-md-4 -->
            <div class="col-md-4"></div> <!-- ./col-md-4 -->
        </section><!-- /.content -->

        
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    
    <!-- Modal del etapa-->
    <div id="myModalDelEtapa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-footer del-etapa">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal lista arquivos -->
    <div id="myModalListArquivos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Lista de Arquivos</h4>
                </div>
                <div class="modal-body list-arquivos">
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal lista arquivos -->
    <div id="myModalUploadArquivos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Submeter Arquivo</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url' => '/home/importdoc', 'files' => true]) !!}
                        {!! Form::label('doc', 'Arquivo') !!}
                        {!! Form::file('doc') !!}
                        <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary pull-right" title="Enviar Arquivo">Enviar</button>
                </div>
                    {!! Form::close() !!}
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
{{-- jQuery Mask Plugin --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.9/jquery.mask.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap.js"></script>
{{-- Moment _ Datetimepicker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/pt-br.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

</body>

<script type="text/javascript">

    $('.envia-arquivo').click(function(){
        $('#arquivo').click();
    });

    $(document).ready (function() {
        $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-success").slideUp(500);
        });
    });

    // Pegar arquivos
    $('#myModalListArquivos').on('show.bs.modal', function(e) {
        var $modal = $(this);
        var etapaanoid = e.relatedTarget.id;
        var trabalhoid = e.relatedTarget.value;

    
        $.ajax({
            url: "etapaano/show/" + etapaanoid + '/' + trabalhoid,
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {
            //console.log("success");
            //console.log("etapaid = " + etapaid);
            //console.log("trabalho = " + trabalho);

            if (data.length < 1) {
            
                $modal.find('.list-arquivos').html('Nenhum Arquivo');    
            
            } else {
       
                var html = '';
                var meio = '';
                
                for(var i = 0; i < data.length; i++) {
                    
                    meio += '<tr><td>' + data[i].name + '<br>' + moment(data[i].created_at).format('DD/MM/YYYY HH:mm') 
                    + '</td><td><li><a target="_blank" href="' + data[i].caminho + ' ">' + data[i].descricao + '</a></li></td></tr>';
                };
                
                html = '<table class="table table-striped table-bordered table-hover">'+
                    '<thead>'+
                        '<tr>'+
                            '<th class"col-md-1">Usuário</th>'+
                            '<th class"col-md-1">Arquivo(s)</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+
                        meio+
                    '</tbody>'+
                '</table>';
                
                $modal.find('.list-arquivos').html(html);           
 
            }

            
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            //console.log("complete");
        });

    });


    $(document).ready( function () {
        $('table.display').DataTable({
            "language": {
            
                "decimal":        "",
                "emptyTable":     "Nenhum registro",
                "info":           "Mostrando _START_ de _END_ de um total de _TOTAL_ registros",
                "infoEmpty":      "Mostrando 0 to 0 de 0 registros",
                "infoFiltered":   "(filtrado de _MAX_ registros)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "loadingRecords": "Carregando...",
                "processing":     "Procesando...",
                "search":         "Procurar:",
                "zeroRecords":    "Nenhum registro encontrado",
                "paginate": {
                    "first":      "Primeiro",
                    "last":       "Último",
                    "next":       "Próximo",
                    "previous":   "Anterior"
                },
                
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
            }, //fim language

            "ordering": true,
        });
    });


    // Deletar etapa
    $('#myModalDelEtapa').on('show.bs.modal', function(e) {    
        var $modal = $(this);
        var etapaid = e.relatedTarget.id;
        $modal.find('.modal-title').html('Deseja realmente excluir?');
        $modal.find('.del-etapa').html('<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button><a href="etapa/destroy/' + etapaid + '" class="btn btn-danger"> Excluir </a>');           
    });

</script>

</html>

@elseif(Auth::user()->permissao >= 1 && Auth::user()->permissao <= 8)

@include('includes')

    <!-- Header -->
    @include('header') 

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            
            <h1>
                {{ $page_title or "Etapas" }}
                <small>{{ $page_description or null }}</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            {{-- <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol> --}}
            <br>

        </section>


        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->

            <div class="col-md-2"></div> <!-- ./col-md-4 -->
            <div class="col-md-8">

                @if (session('message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{{ session('message') }}</strong>
                    </div>
                @endif

                <table data-order='[[2, "desc"]]' class="table table-hover table-striped table-bordered display">
                    <thead>
                        <tr>
                            {{--  <th class="col-md-2">Etapa</th>  --}}
                            <th class="col-md-3">Trabalho</th>
                            <th class="col-md-3">Descrição</th>
                            <th class="col-md-2">Data Entrega</th>
                            <th class="text-center">Situação</th>
                            <th class="text-center">Arquivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etapaano as $etapaano)
                        @foreach($etapaano as $etapaano)
                        <tr>
                            {{--  <td>{{ $etapaano->etapa->desc }}</td>  --}}
                            <td>{{ $etapaano->titulo }}</td>
                            <td>{{ $etapaano->descricao }}</td>
                            <td>{{ \Carbon\Carbon::parse($etapaano->data_final)->format('d/m/Y H:m') }}</td>
                            @if($etapaano->ativa == 1)
                                <td class="text-center"><span class="label label-success">Ativa</span></td>
                            @else
                                <td class="text-center"><span class="label label-default">Não Ativa</span></td>
                            @endif
                            
                            <td class="text-center">
                                @if($etapaano->ativa == 1)
                                    <button value="{{ $etapaano->trabalho_id }}" id="{{ $etapaano->id }}" class="btn btn-default btn-sm" title="Lista de Arquivos" data-toggle="modal" data-target="#myModalListArquivos"><i class="fa fa-list"></i> Listar</button>
                                    <button value="{{ $etapaano->trabalho_id }}" id="{{ $etapaano->id }}" class="btn btn-primary btn-sm" title="Enviar Arquivo" data-toggle="modal" data-target="#myModalUploadArquivos"><i class="fa fa-upload"></i> Enviar</button> 
                                @else
                                    <button value="{{ $etapaano->trabalho_id }}" id="{{ $etapaano->id }}" class="btn btn-default btn-sm" title="Lista de Arquivos" data-toggle="modal" data-target="#myModalListArquivos"><i class="fa fa-list"></i> Listar</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endforeach
                    </tbody>
                </table> {{-- ./table --}}

            </div> <!-- ./col-md-4 -->
            <div class="col-md-4"></div> <!-- ./col-md-4 -->
        </section><!-- /.content -->

        
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    
    <!-- Modal lista arquivos -->
    <div id="myModalListArquivos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Lista de Arquivos</h4>
                </div>
                <div class="modal-body list-arquivos">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal upload arquivos -->
    <div id="myModalUploadArquivos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Submeter Arquivo</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url' => '/home/importdoc', 'files' => true]) !!}
                        {!! Form::label('doc', 'Arquivo') !!}
                        {!! Form::file('doc') !!}
                        <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary pull-right" title="Enviar Arquivo">Enviar</button>
                </div>
                    {!! Form::close() !!}
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
{{-- jQuery Mask Plugin --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.9/jquery.mask.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap.js"></script>
{{-- Moment _ Datetimepicker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/pt-br.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

</body>

<script type="text/javascript">

    $(document).ready (function() {
        $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-success").slideUp(500);
        });
    });

    // Pegar arquivos
    $('#myModalListArquivos').on('show.bs.modal', function(e) {
        var $modal = $(this);
        var etapaanoid = e.relatedTarget.id;
        var trabalhoid = e.relatedTarget.value;

    
        $.ajax({
            // url: "etapaano/show/" + etapaanoid + trabalhoid, 
            url: "etapaano/show/" + etapaanoid + '/' + trabalhoid,
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {
            // console.log("success"); 
            // console.log('trabalhoid = ' + trabalhoid);
            // console.log('etapaanoid = ' + etapaanoid); 
             
            if (data.length < 1) {
            
                $modal.find('.list-arquivos').html('Nenhum Arquivo');    
            
            } else {
       
                var html = '';
                var meio = '';
                
                for(var i = 0; i < data.length; i++) {
                    
                    meio += '<tr><td>' + data[i].name + '<br>' 
                    + '</td><td><li><a target="_blank" href="' + data[i].caminho + ' ">' + data[i].descricao + '</a></li></td><td>' + moment(data[i].created_at).format('DD/MM/YYYY HH:mm') + '</td></tr>';
                };
                
                html = '<table class="table table-striped table-bordered table-hover">'+
                    '<thead>'+
                        '<tr>'+
                            '<th class"col-md-1">Usuário</th>'+
                            '<th class"col-md-1">Arquivo</th>'+
                            '<th class"col-md-1">Enviado em</th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody>'+
                        meio+
                    '</tbody>'+
                '</table>';
                
                $modal.find('.list-arquivos').html(html);           
 
            }

            
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            //console.log("complete");
        });

    });


    $(document).ready( function () {
        $('table.display').DataTable({
            "language": {
            
                "decimal":        "",
                "emptyTable":     "Nenhum registro",
                "info":           "Mostrando _START_ de _END_ de um total de _TOTAL_ registros",
                "infoEmpty":      "Mostrando 0 to 0 de 0 registros",
                "infoFiltered":   "(filtrado de _MAX_ registros)",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Mostrar _MENU_ registros",
                "loadingRecords": "Carregando...",
                "processing":     "Procesando...",
                "search":         "Procurar:",
                "zeroRecords":    "Nenhum registro encontrado",
                "paginate": {
                    "first":      "Primeiro",
                    "last":       "Último",
                    "next":       "Próximo",
                    "previous":   "Anterior"
                },
                
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
            }, // fim language

            "ordering": true,
        });
    });
     


</script>

</html>

@else

    <h1>Sem permissão</h1>

@endif



