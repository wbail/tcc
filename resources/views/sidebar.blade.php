@if(Auth::user()->permissao == 9)
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">Menu</li>
                <!-- Optionally, you can add icons to the links -->

                <li class="treeview">
                    <a href="#"><span><i class="fa fa-user"></i> Aluno</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/academico/novo') }}"><i class="fa fa-plus"></i> Novo</a></li>
                        <li><a href="{{ url('/academico') }}"><i class="fa fa-list"></i> Listar</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><span><i class="fa fa-pencil-square-o"></i> Professor</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/membrobanca/novo') }}"><i class="fa fa-plus"></i> Novo</a></li>
                        <li><a href="{{ url('/membrobanca') }}"><i class="fa fa-list"></i> Listar</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><span><i class="fa fa-calendar"></i> Banca de Avaliação</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/banca/novo') }}"><i class="fa fa-plus"></i> Membros de Avaliação</a></li>
                        <li><a href="{{ url('/banca') }}"><i class="fa fa-list"></i> Listar</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><span><i class="fa fa-graduation-cap"></i> Curso</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/curso/novo') }}"><i class="fa fa-plus"></i> Novo</a></li>
                        <li><a href="{{ url('/curso') }}"><i class="fa fa-list"></i> Listar</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><span><i class="fa fa-users"></i> Departamento</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/departamento/novo') }}"><i class="fa fa-plus"></i> Novo</a></li>
                        <li><a href="{{ url('/departamento') }}"><i class="fa fa-list"></i> Listar</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><span><i class="fa fa-bell"></i> Etapa</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/etapa/novo') }}"><i class="fa fa-plus"></i> Nova etapa</a></li>
                        <li><a href="{{ url('/etapaano/novo') }}"><i class="fa fa-plus"></i> Definir Datas</a></li>
                        <li><a href="{{ url('/etapa') }}"><i class="fa fa-list"></i> Listar Etapas</a></li>
                        <li><a href="{{ url('/etapaano') }}"><i class="fa fa-list"></i> Listar Datas de Entrega</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><span><i class="fa fa-bank"></i> Instituição</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/instituicao/novo') }}"><i class="fa fa-plus"></i> Novo</a></li>
                        <li><a href="{{ url('/instituicao') }}"><i class="fa fa-list"></i> Listar</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><span><i class="fa fa-file"></i> Trabalho</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/trabalho/novo') }}"><i class="fa fa-plus"></i> Novo</a></li>
                        <li><a href="{{ url('/trabalho') }}"><i class="fa fa-list"></i> Listar</a></li>
                    </ul>
                </li>


                <li class="treeview">
                    <a href="#"><span><i class="fa fa-gear"></i> Configurações</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="#"><span><i class="fa fa-calendar-o"></i> Ano Letivo</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="{{ url('/anoletivo/novo') }}"><i class="fa fa-plus"></i> Novo</a></li>
                                <li><a href="{{ url('/anoletivo') }}"><i class="fa fa-list"></i> Listar</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

            </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

@elseif(Auth::user()->permissao >= 1 && Auth::user()->permissao <= 8)

    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <li class="header">Menu</li>
                <!-- Optionally, you can add icons to the links -->

                <li class="treeview">
                    <a href="#"><span><i class="fa fa-bell"></i> Etapa</span> <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                        <li><a href="{{ url('/etapaano') }}"><i class="fa fa-list"></i> Listar Datas de Entrega</a></li>
                    </ul>
                </li>

            </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

@else

    <h1>Sem permissão</h1>

@endif
