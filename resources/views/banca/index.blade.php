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
                {{ $page_title or "Bancas" }}
                <small>{{ $page_description or null }}</small>
            </h1>

            <br>

        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->

            <div class="row">
                <div class="col-md-12">
                    
                    @if (session('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>{{ session('message') }}</strong>
                        </div>
                    @endif

                    @if (session('message-warning'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>{{ session('message-warning') }}</strong>
                        </div>
                    @endif

                    @if($countBancaData > 0)
                        <a href="{{ url('banca/imprime') }}" target="_blank" class="btn btn-success btn-sm" title="Imprimir lista de bancas"><i class="fa fa-print"></i> Imprimir</a>
                    @endif

                    <br>
                    <br>
                    @if(!empty($banca))
                        <table data-order='[[0, "asc"]]' class="table table-hover table-striped table-bordered display">
                            <thead>
                            <tr>
                                <th class="col-md-3">Trabalho</th>
                                <th>Orientador(es)</th>
                                <th>Acadêmico(as)</th>
                                <th>Data da Banca</th>
                                <th>Local da Banca</th>
                                <th class="text-center">Status da Banca</th>
                                <th class="text-center">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($banca as $banca)
                                    @if(empty($banca->trabalho))
                                        @continue
                                    @endif
                                    <tr>
                                        <td title="{{ $banca->trabalho->sigla }}">{{ $banca->trabalho->titulo }}</td>
                                        <td>
                                            <li>{{ \App\User::find(\App\MembroBanca::find($banca->trabalho->orientador_id)->user_id)->name }}</li>
                                            @if($banca->trabalho->coorientador_id)
                                                <li>{{ \App\User::find(\App\MembroBanca::find($banca->trabalho->coorientador_id)->user_id)->name }}</li>
                                            @endif
                                        </td>
                                        <td>
                                            @foreach($banca->academico as $academico)
                                                <li>{{ $academico->user->name }}</li>
                                            @endforeach
                                        </td>
                                        @if((empty($banca->data)))
                                            <td class="text-danger">
                                                Data a definir
                                            </td>
                                        @else
                                            <td>
                                                {{ \Carbon\Carbon::parse($banca->data)->format('d/m/Y H:i') }}

                                            </td>
                                        @endif
                                        <td>
                                            {{ $banca->local }}
                                        </td>
                                        <td class="text-center">
                                            @if($banca->status == 1)
                                                <label for="statusbanc" class="label label-success">Banca Realizada</label>
                                            @elseif($banca->data <= \Carbon\Carbon::now() && !is_null($banca->data))
                                                <button id="{{ $banca->trabalho_id }}" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalStatusBanca" title="Finalizar Banca">Concluir Banca</button>
                                            @else
                                                <label for="statusbanc" class="label label-default">Banca Não Realizada</label>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a id="{{ $banca->id }}" class="btn btn-link" href="{{ route('banca.edit', ['id'=>$banca->trabalho_id]) }}" title="Definir Data"><i class="fa fa-calendar"></i></a>
                                            <a id="{{ $banca->id }}" class="btn btn-link" href="{{ route('banca.edit', ['id'=>$banca->trabalho_id]) }}" title="Editar"><i class="fa fa-pencil"></i></a>
                                            @if($banca->status == 1)
                                                <button id="{{ $banca->trabalho_id }}" class="btn btn-link" data-toggle="modal" data-target="#myModalCertBanca" title="Gerar Certificado"><i class="fa fa-file"></i> </button>
                                            @endif
                                            <button id="{{ $banca->id }}" class="btn btn-link" data-toggle="modal" data-target="#myModalDelbanca" title="Excluir"><i class="fa fa-trash"></i> </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <table data-order='[[0, "asc"]]' class="table table-hover table-striped table-bordered display">
                            <thead>
                            <tr>
                                <th class="col-md-3">Trabalho</th>
                                <th>Orientador(es)</th>
                                <th>Acadêmico(as)</th>
                                <th>Data da Banca</th>
                                <th>Local da Banca</th>
                                <th class="text-center">Status da Banca</th>
                                <th class="text-center">Ação</th>
                            </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td title=""></td>
                                    <td>

                                    </td>
                                    <td>
                                        Nenhum registro

                                    </td>

                                    <td>


                                    </td>
                                    <td>

                                    </td>
                                    <td class="text-center">

                                    </td>
                                    <td class="text-center">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    @endif

            	</div> {{-- ./col-md-4 --}}
            	{{--<div class="col-md-4"></div> --}}{{-- ./col-md-4 --}}
            </div> {{-- ./row --}}

            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    
    <!-- Modal del banca -->
    <div id="myModalDelbanca" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-footer del-banca">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Gerar Certificado Banca -->
    <div id="myModalCertBanca" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer cert-banca">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirma que a banca já aconteceu -->
    <div id="myModalStatusBanca" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body">
                    Ao finalizar a banca, caso os alunos não tenham sido aprovados, serão considerados reprovados
                    e ficarão disponíveis para um novo trabalho no próximo ano letivo.
                </div>
                <div class="modal-footer status-banca">
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
{{-- jQuery Mask Plugin --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.9/jquery.mask.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap.js"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->

</body>

<script type="text/javascript">

    $(".alert").fadeTo(2000, 500).slideUp(500, function() {
        $(".alert").slideUp(500);
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


    // Deletar banca
    $('#myModalDelbanca').on('show.bs.modal', function(e) {

        var $modal = $(this);
        var bancaid = e.relatedTarget.id;
        $modal.find('.del-banca').html('<a href="banca/destroy/' + bancaid + '" class="btn btn-danger"> Excluir</a><button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>');
        $modal.find('.modal-title').html('Deseja realmente excluir?');
    });

    // Gerar Certificado Banca
    $('#myModalCertBanca').on('show.bs.modal', function(e) {

        var $modal = $(this);
        var bancaid = e.relatedTarget.id;
        $modal.find('.modal-title').html('Geração de Certificado de Presença de Banca');
        $modal.find('.cert-banca').html('<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button><a id="btnGeraCert" target="_blank" href="banca/show/'+ bancaid +'" class="btn btn-success"> Gerar</a>');
    });

    $('#btnGeraCert').click(function() {
        $('#myModalCertBanca').modal('hide');
    });

    // Confirmação que a banca já aconteceu
    $('#myModalStatusBanca').on('show.bs.modal', function(e) {

        var $modal = $(this);
        var bancaid = e.relatedTarget.id;
        $modal.find('.modal-title').html('Confirma a realização da banca?');
        $modal.find('.status-banca').html('<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button><a href="banca/finaliza/'+ bancaid +'" class="btn btn-success"> Confirmar</a>');
    });

</script>

</html>

