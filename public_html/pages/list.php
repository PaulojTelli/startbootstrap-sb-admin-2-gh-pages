<?php require 'header.php' ?>
<?php require 'sidebar.php' ?>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Settings
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                            Activity Log
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Lista de Aluguéis</h1>
            <p class="mb-4">Clique no nome para expandir e mostrar mais opções.</p>

            <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">

            <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">


                    <!-- menu antes da lista -->
                    <!-- categorias -->

                    <form method="get" action="list.php">
                        <button class="btn btn-primary" type="submit" name="categoria" value="todos">Todos</button>
                        <button class="btn btn-primary" type="submit" name="categoria" value="pago">Pagos</button>
                        <button class="btn btn-primary" type="submit" name="categoria" value="atrasado">Atrasados</button>
                        <button class="btn btn-primary" type="submit" name="categoria" value="naoVencido">Não
                            Vencido</button>
                        <button class="btn btn-primary" type="submit" name="categoria" value="vago">Vagos</button>
                    </form>
                </div>

                <div class="bg-white py-2 collapse-inner rounded">

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFuncoes" aria-expanded="true" aria-controls="collapseFuncoes">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Funções</span>
                    </a>
                    <div id="collapseFuncoes" class="collapse" aria-labelledby="headingFuncoes" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">

                            <form method="post" id="novo_mes_form">
                                <button type="submit" class="btn btn-primary mb-2" name="executar_funcao">Encerrar
                                    Mês <i class="fa-regular fa-calendar-check"></i></button>
                            </form>




                            <script type="text/javascript">
                                document.getElementById("novo_mes_form").addEventListener("submit", function(event) {
                                    var result = confirm("Tem certeza que deseja encerrar o mês?");
                                    if (!result) {
                                        event.preventDefault();
                                    }
                                });
                            </script>

                            <?php
                            if (isset($_POST['executar_funcao'])) {
                                encerrarMes();
                            } ?>


                            </form>
                        </div>
                    </div>



                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-hover table" id="dataTable" width="100%" cellspacing="0">


                            <?php
                            //    atualizaVago();
                            if (isset($_GET['categoria'])) {
                                // Obtém o valor do botão clicado
                                $mostrar = $_GET['categoria'];

                                // Executa a função certa usando switch case
                                switch ($mostrar) {
                                    case 'todos':
                                        listT();
                                        break;
                                    case 'pago':
                                        listP();
                                        break;
                                    case 'atrasado':
                                        listA();
                                        break;
                                    case 'naoVencido':
                                        listN();
                                        break;
                                    case 'vago':
                                        ListV();
                                        break;
                                    default:
                                        listT();
                                        break;
                                }
                            }

                            ?>

                        </table>

                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php require 'footer.php'; ?>