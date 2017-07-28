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
                {{ $page_title or "Professores" }}
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

            @if (session('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>{{ session('message') }}</strong>
                </div>
            @endif

            <br>

            <table data-order='[[0, "asc"]]' class="table table-hover table-striped table-bordered display">
                <thead>
                    <tr>
                        <th class="col-sm-2">Nome</th>
                        <th class="col-sm-1">E-mail</th>
                        <th class="col-sm-1">Dept</th>
                        <th class="col-sm-1">Função</th>
                        <th class="text-center col-sm-1">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($membrobanca as $membrobanca)
                    <tr>
                        <td>{{ $membrobanca->user->name }}</td>
                        <td>{{ $membrobanca->user->email }}</td>
                        <td>{{ $membrobanca->departamento->nome }}</td>
                        @if($membrobanca->user->permissao == 7)
                            <td>Banca/Orientador/Coordenador</td>
                        @elseif($membrobanca->user->permissao == 5)
                            <td>Banca/Orientador</td>
                        @elseif($membrobanca->user->permissao == 3)
                            <td>Banca/Coordenador</td>
                        @elseif($membrobanca->user->permissao == 1)
                            <td>Banca</td>
                        @elseif($membrobanca->user->permissao == 4)
                            <td>Orientador</td>
                        @elseif($membrobanca->user->permissao == 2)
                            <td>Coorientador</td>
                        @elseif($membrobanca->user->permissao == 6)
                            <td>Orientador/Coordenador</td>
                        @elseif($membrobanca->user->permissao == 9)
                            <td>Coordenador</td>
                        @endif
                        <td class="text-center">
                            <a id="{{ $membrobanca->id }}" class="btn btn-link" href="{{ route('membrobanca.edit', ['id'=>$membrobanca->id]) }}" title="Editar"><i class="fa fa-pencil"></i></a>
                            <button id="{{ $membrobanca->id }}" class="btn btn-link" data-toggle="modal" data-target="#myModalDelmembrobanca" title="Excluir"><i class="fa fa-trash"></i> </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    
    <!-- Modal del membrobanca-->
    <div id="myModalDelmembrobanca" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-footer del-membrobanca">
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

    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
        $(".alert-success").slideUp(500);
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

        });
    });


// Deletar membrobanca
$('#myModalDelmembrobanca').on('show.bs.modal', function(e) {
    
    var $modal = $(this);
    var membrobancaid = e.relatedTarget.id;
    $modal.find('.modal-title').html('Deseja realmente excluir?');
    $modal.find('.del-membrobanca').html('<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button><a href="membrobanca/destroy/' + avaliadorid + '" class="btn btn-danger"> Excluir </a>');           
});



</script>

</html>

