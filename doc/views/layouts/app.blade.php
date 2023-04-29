<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Coman - Mercantil de Polimeros<</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/theme/adminlte.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app_theme.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">  

    <!-- JQuery -->
    <script src="{{ asset('plugins/jquery/jquery.js') }}" ></script>

    <!-- Application -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/theme/adminlte.js') }}"></script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script> 
    
    <script src="{{ asset('js/app_theme.js') }}" defer></script>
    <script src="{{ asset('js/app_functions.js') }}" defer></script>
    <script src="{{ asset('js/app_modules.js') }}" defer></script>

    <!-- JQuery Validate -->
    <script src="{{ asset('plugins/jquery.validate/jquery.validate.js') }}" defer></script>
    <script src="{{ asset('plugins/jquery.validate/additional-methods.js') }}" defer></script>
    
    <!-- JQuery Mask -->
    <script src="{{ asset('plugins/jquery.mask/jquery.mask.js') }}" defer></script>
    
    <!-- JQuery Alertify -->
    <link href="{{ asset('plugins/jquery.alertify/css/jquery.alertify.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/jquery.alertify/css/themes/jquery.bootstrap.css') }}" rel="stylesheet">
    <script src="{{ asset('plugins/jquery.alertify/jquery.alertify.js') }}" defer></script>

    <!-- JQuery Form -->
    <script src="{{ asset('plugins/jquery.form.min.js') }}" defer></script>    

</head>
<body style="background:#333333;">
    <div id="app" class="wrapper" data-base-url="{{url('/')}}">
        <nav class="main-header navbar navbar-expand navbar-dark" style="border-radius: 0px !important;">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="./dashboard" class="nav-link">Página Inicial</a>
                </li>
            </ul>
            <div class="navbar-nav ml-auto">
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        
                        <a href="#" class="dropdown-item dropdown-footer">Fechar</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" title="Perfil" data-toggle="dropdown" href="#">
                        <i class="fa fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="col-lg-12" style="background-color: #343A40; height: 240px; padding: 20px; color: #FFFFFF;">
                            <div class="text-center" style="padding-left: 55px;">
                                @if(Auth::user()->profile_photo_path !== "")
                                    <img src="{{url('storage/users/'.Auth::user()->profile_photo_path)}}" class="img-circle" alt="User Image" width="160">
                                @else
                                    <img src="images/no-image.jpg" class="img-circle" alt="User Image" width="160">
                                @endif
                            </div>
                            <div class="text-center">
                                <p>{{Auth::user()->name}}</p>
                                <small>{{Auth::user()->email}}</small>
                            </div>
                        </div>
                        <div class="row col-lg-12" style="padding: 0px; padding-left: 15px; padding-top: 10px; padding-bottom: 10px;">
                            <div class="col-lg-6">
                                <button class="btn btn-default btn-sm btn-block" data-action="{{ route('users/profile') }}" onclick="Application.onRedirect(this);">
                                    <span class="fa fa-user"></span>&nbsp;&nbsp;&nbsp;&nbsp;Perfil
                                </button>
                            </div>
                            <div class="col-lg-6">
                                <button class="btn btn-default btn-sm btn-block" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-chevron-right"></i>&nbsp;&nbsp;&nbsp;&nbsp;Sair
                                </button>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>   
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary" id="main-sidebar">
            <a href="./dashboard" class="brand-link navbar-dark">
                <img src="{{url('/images/logo-icon.png')}}" alt="AdminLTE Logo" class="brand-image "
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Coman</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar" style="font-size: 12px;">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if(Auth::user()->profile_photo_path !== "")
                            <img src="{{url('storage/users/'.Auth::user()->profile_photo_path)}}" class="img-circle elevation-2" alt="User Image">
                        @else
                            <img src="images/no-image.jpg" class="img-circle elevation-2" alt="User Image">
                        @endif
                        
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{Auth::user()->name}}</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="sidebar-menu">
                        @php
                        $MenuNivel1 = new \App\Models\Menu();
                        foreach($MenuNivel1->where('nivel',1)->orderBy('name','ASC')->get() as $menu)
                        {
                            echo('<li class="nav-item has-treeview">');
                                echo('<a href="#" class="nav-link" style="margin-left: -10px;" data-menu-id="menu-id-'.$menu->id.'" id="menu-id-'.$menu->id.'">');
                                    echo('<i class="nav-icon fas fa-ellipsis-v"></i>');
                                    echo('<p>'.$menu->name.'<i class="right fas fa-angle-left"></i></p>');
                                echo('</a>');
                                $MenuNivel2 = new \App\Models\Menu();
                                foreach($MenuNivel2->where([['nivel','=','2'],['nivel_1_menu_id','=',$menu->id]])->orderBy('name','ASC')->get() as $submenu)
                                {
                                    $MenuNivel3 = new \App\Models\Menu();
                                    $MenuNivel3List = $MenuNivel2->where([['nivel','=','3'],['nivel_2_menu_id','=',$submenu->id]])->orderBy('name','ASC')->get();
                                    if(count($MenuNivel3List) > 0)
                                    {
                                        echo('<ul class="nav nav-treeview has-treeview" style="width: 100%;">');
                                            echo('<li class="nav-item has-treeview" style="width: 100%">');
                                                echo('<a href="'.url('/'.$submenu->link).'" class="nav-link">');
                                                    echo('<i class="far fa-chevron-left nav-icon"></i>');
                                                    echo('<p>'.$submenu->name.'<i class="right fas fa-angle-left"></i></p>');
                                                echo('</a>');
                                                echo('<ul class="nav nav-treeview" style="display: block; margin-left: 10px;">');
                                                    foreach($MenuNivel3List as $subsubmenu)
                                                    {
                                                        echo('<li class="nav-item" style="width: 100%">');
                                                            echo('<a href="'.url('/'.$subsubmenu->link).'" class="nav-link">');
                                                                echo('<i class="far fa-circle nav-icon"></i>');
                                                                echo('<p>'.$subsubmenu->name.'</p>');
                                                            echo('</a>');
                                                        echo('</li>');
                                                    }
                                                echo('</ul>');
                                            echo('</li>');
                                        echo('</ul>');
                                    } 
                                    else
                                    {
                                        echo('<ul class="nav nav-treeview" style="width: 100%">');
                                            echo('<li class="nav-item" style="width: 100%">');
                                                echo('<a href="'.url('/'.$submenu->link).'" class="nav-link">');
                                                    echo('<i class="fas fa-chevron-right nav-icon"></i>');
                                                    echo('<p>'.$submenu->name.'</p>');
                                                echo('</a>');
                                            echo('</li>');
                                        echo('</ul>');
                                    }
                                }
                            echo('</li>');
                        }
                        @endphp
                    </ul>  
                </nav>
            </div>
        </aside>
        <aside class="control-sidebar control-sidebar-dark"></aside>
        <div class="content-wrapper">
            <section class="content">
                <main class="container-fluid" id="main" style="padding: 0px;">
                    {!!html_entity_decode($View)!!}
                </main>
            </section>
        </div>
    </div>
</body>
<script>
    $(document).ready(function(){
        Application.onReady();
        if(parseInt($('#main-sidebar').height()) < parseInt($('#main').height()+120))
        {
            $('#main-sidebar').css({'min-height': +parseInt($('#main').height()+120)+'px'});
        }
    });
</script>
</html>
