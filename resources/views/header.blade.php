<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/admin') }}" class="logo"><b>TCC</b></a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">

                    @if(Auth::user()->permissao == 9)
                    <li>
                        <a href="#">
                            {{--<i class="fa fa-user"> Engenharia de Software</i>--}}
                            @if(session()->get('curso'))
                                <i class="fa fa-graduation-cap"> {{ session()->get('curso')->nome }}</i>
                            @endif
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" title="Ano Letivo Corrente">
                            <i class="fa fa-calendar-o"></i> {{ session()->get('anoletivo')->rotulo }}
                        </a>
                        {{--<ul class="dropdown-menu" role="menu">--}}
                            {{--@foreach(session()->get('anoletivoativo') as $a)--}}
                                {{--<li>--}}
                                    {{--<a href="{{ url('/anoletivo/edit') . '/' . $a->id }}" class="text-right"><i class="fa fa-minus"></i> {{ $a->rotulo }}</a>--}}
                                    {{--<a href="#" id="{{ $a->id }}" class="text-right anoletivo"><i class="fa fa-minus"></i> {{ $a->rotulo }}</a>--}}
                                {{--</li>--}}
                            {{--@endforeach--}}
                        {{--</ul>--}}
                    </li>
                    @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Sair
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                </li>
            </ul>
        </div>
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        $('.anoletivo').on("click", function() {

            if(confirm("Voce sera desconectado, deseja continuar?")) {
                document.getElementById('logout-form').submit();
            } else {
                //
            }
        })
    </script>
</header>