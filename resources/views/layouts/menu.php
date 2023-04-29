@php
                        $MenuNivel1 = new \App\Models\Menu();
                        foreach($MenuNivel1->where('nivel',1)->get() as $menu)
                        {
                            echo('<li class="nav-item has-treeview">');
                                echo('<a href="#" class="nav-link" style="margin-left: -10px;" data-menu-id="menu-id-'.$menu->id.'" id="menu-id-'.$menu->id.'">');
                                    echo('<i class="nav-icon fas fa-ellipsis-v"></i>');
                                    echo('<p>'.$menu->name.'<i class="right fas fa-angle-left"></i></p>');
                                echo('</a>');
                                $MenuNivel2 = new \App\Models\Menu();
                                foreach($MenuNivel2->where([['nivel','=','2'],['nivel_1_menu_id','=',$menu->id]])->get() as $submenu)
                                {
                                    echo('<ul class="nav nav-treeview"  style="width: 100%">');
                                        echo('<li class="nav-item">');
                                            echo('<a href="'.url('/'.$submenu->link).'" class="nav-link">');
                                                echo('<i class="far fa-circle nav-icon"></i>');
                                                echo('<p>'.$submenu->name.'</p>');
                                            echo('</a>');
                                        echo('</li>');
                                    echo('</ul>');
                                }
                            echo('</li>');
                        }
                        @endphp    
                    
                    





                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link" data-menu-id="menu-id-1" id="menu-id-1">
                                <i class="nav-icon fas fa-ellipsis-v"></i>
                                <p>Cadastros<i class="right fas fa-angle-left"></i></p>
                            </a>    

                            <ul class="nav nav-treeview" style="width: 100%">
                                <li class="nav-item" style="width: 100%">
                                    <a href="{{url('./branches')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Unidades</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="width: 100%">
                                    <a href="{{url('./operation-types')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tipos de Operação</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="width: 100%">
                                    <a href="{{url('./shaving-types')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tipos de Aparas</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="width: 100%">
                                    <a href="{{url('./restrictions')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Restrições</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="width: 100%">
                                    <a href="{{url('./destinations')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Destinos</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="width: 100%">
                                    <a href="{{url('./restricted-destinations')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Destinos Restritos</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="width: 100%">
                                    <a href="{{url('./segregators')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Segredador</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="width: 100%">
                                    <a href="{{url('./colors')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tonalidade/Cor</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="width: 100%">
                                    <a href="{{url('./branches-processing')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Unid. Processamento</p>
                                    </a>
                                </li>
                                <li class="nav-item" style="width: 100%">
                                    <a href="{{url('./colors')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cargos Quality</p>
                                    </a>
                                </li>