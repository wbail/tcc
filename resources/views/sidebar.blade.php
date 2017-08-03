<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
{{--         <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("../bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div> --}}

        <!-- search form (Optional) -->
        {{-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                  <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form> --}}
        <!-- /.search form -->

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
                <a href="#"><span><i class="fa fa-clock-o"></i> Histórico de Trabalhos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    
                    <li class="treeview">
                        <a href="#"><span>2015</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="#">Trabalhos</a></li>
                            <li><a href="#">Link</a></li>
                        </ul>
                    </li>


                    <li class="treeview">
                        <a href="#"><span>2016</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="#">Trabalhos</a></li>
                            <li><a href="#">Link</a></li>
                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#"><span>2017</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="#">Trabalhos</a></li>
                            <li><a href="#">Link</a></li>
                        </ul>
                    </li>

                </ul>
            </li>

            <li class="treeview">
                <a href="#"><span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Link in level 2</a></li>
                    <li><a href="#">Link in level 2</a></li>
                </ul>
            </li>

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>