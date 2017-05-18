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
                {{ $page_title or "Departamentos" }}
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

            <div class="row">
            	<div class="col-md-3"></div> {{-- ./col-md-3 --}}
                <div class="col-md-6">
                    
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
                                <th>Instituição</th>
                                <th>Nome</th>
		                        <th>Sigla</th>
		                        <th class="text-center">Ação</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    @foreach($departamento as $departamento)
		                    <tr>
                                <td>{{ $departamento->instituicao->sigla }}</td>
                                <td>{{ $departamento->nome }}</td>
		                        <td>{{ $departamento->sigla }}</td>
		                        <td class="text-center">
		                            <a id="{{ $departamento->id }}" class="btn btn-link" href="{{ route('departamento.edit', ['id'=>$departamento->id]) }}" title="Editar"><i class="fa fa-pencil"></i></a>
		                            <button id="{{ $departamento->id }}" class="btn btn-link" data-toggle="modal" data-target="#myModalDelDepartamento" title="Excluir"><i class="fa fa-trash"></i> </button>
		                        </td>
		                    </tr>
		                    @endforeach
		                </tbody>
		            </table>

            	</div> {{-- ./col-md-4 --}}
            	<div class="col-md-4"></div> {{-- ./col-md-4 --}}
            </div> {{-- ./row --}}

            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    
    <!-- Modal del departamento-->
    <div id="myModalDelDepartamento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-footer del-departamento">
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

            "ordering": true,
        });
    });


// Deletar departamento
$('#myModalDelDepartamento').on('show.bs.modal', function(e) {
    
    var $modal = $(this);
    var departamentoid = e.relatedTarget.id;
    $modal.find('.modal-title').html('Deseja realmente excluir?');
    $modal.find('.del-departamento').html('<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button><a href="departamento/destroy/' + departamentoid + '" class="btn btn-danger"> Excluir </a>');           
});



</script>

</html>

