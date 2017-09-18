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
                {{ $page_title or "Trabalhos" }}
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

            @if (session('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ session('message') }}</strong>
                </div>
            @endif

            <br>
            <table id="example" cellspacing="5" cellpadding="5" border="0">
                <tbody><tr>
                    <td>Ano Letivo (min):</td>
                    <td><input id="min" name="min" type="text" value="{{ Session::get('anoletivo')->rotulo }}"></td>
                </tr>
                <tr>
                    <td>Ano Letivo (max):</td>
                    <td><input id="max" name="max" type="text" value=""></td>
                </tr>
                </tbody>

            </table>
            <br>
            <table data-order='[["1", "asc"]]' class="table table-striped table-hover table-bordered display">

            	<thead>
            		<tr>
                        <th class="col-md-1">Ano Letivo</th>
                        <th class="col-md-3">Titulo</th>
                        <th class="text-center">Período</th>
                        <th class="col-md-2">Acadêmico(as)</th>
                        <th title="Orientador/Coorientador">Orientador(as)</th>
                        <th class="text-center">Ação</th>
            		</tr>
            	</thead>

            	<tbody>
            		@foreach($trabalhos as $trabalho)

                        <tr>
                            <td>{{ $trabalho->anoletivo }}</td>
                            <td>{{ $trabalho->titulo }}</td>
                            <td class="text-center">
                                @if($trabalho->periodo == 3)
                                    Anual
                                @else
                                    {{ $trabalho->periodo }}
                                @endif
                            </td>
                            <td>
                                <li>
                                    {{ $trabalho->academico }}
                                </li>
                            </td>
                            <td>
                                <li>
                                    {{ $trabalho->orientador }}
                                </li>
                                {{--@if($trabalho->coorientador != null)--}}
                                    {{--<li>--}}
                                        {{--{{ $trabalho->coorientador }}--}}
                                    {{--</li>--}}
                                {{--@endif--}}
                            </td>

                            <td class="text-center">
                                <a href="{{ route('trabalho.edit', ['id'=>$trabalho->id]) }}" class="btn btn-link" title="Editar"><i class="fa fa-pencil"></i></a>
                                <button id="{{ $trabalho->id }}" class="btn btn-link" data-toggle="modal" data-target="#myModalDelTrabalho" title="Excluir"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>

                    @endforeach

            	</tbody>

            </table> {{-- ./table --}}

            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->

    <!-- Modal del trabalho-->
    <div id="myModalDelTrabalho" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-footer del-trabalho">
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
<!-- DataTable -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap.js"></script>
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


    $(document).ready( function () {

        var table = $('.display').DataTable({

            // Filtro de range de ano letivo

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
        });

        // Evento do range de anos, filtrando os inputs
        $('#min, #max').keyup( function() {
            table.draw();
        });

        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {
                var min = parseInt( $('#min').val(), 10 );
                var max = parseInt( $('#max').val(), 10 );
                var age = parseFloat( data[0] ) || 0; // Muda o ano

                if ( ( isNaN( min ) && isNaN( max ) ) ||
                    ( isNaN( min ) && age <= max ) ||
                    ( min <= age   && isNaN( max ) ) ||
                    ( min <= age   && age <= max ) )
                {
                    return true;
                }
                return false;
            }
        );

    });

    // Deletar trabalho
    $('#myModalDelTrabalho').on('show.bs.modal', function(e) {

        var $modal = $(this);
        var trabalhoid = e.relatedTarget.id;
        $modal.find('.modal-title').html('Deseja realmente excluir?');
        $modal.find('.del-trabalho').html('<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button><a href="trabalho/destroy/' + trabalhoid + '" class="btn btn-danger"> Excluir </a>');
    });


</script>



</html>




