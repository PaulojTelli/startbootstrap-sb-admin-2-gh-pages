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
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
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
                        <button class="btn btn-primary" type="submit" name="categoria"
                            value="atrasado">Atrasados</button>
                        <button class="btn btn-primary" type="submit" name="categoria" value="naoVencido">Não
                            Vencido</button>
                        <button class="btn btn-primary" type="submit" name="categoria" value="vago">Vagos</button>
                    </form>
                </div>

                <div class="bg-white py-2 collapse-inner rounded">

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFuncoes"
                        aria-expanded="true" aria-controls="collapseFuncoes">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Funções</span>
                    </a>
                    <div id="collapseFuncoes" class="collapse" aria-labelledby="headingFuncoes"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">

                            <form method="post" id="novo_mes_form">
                                <button type="submit" class="btn btn-primary mb-2" name="executar_funcao">Iniciar Novo
                                    Mês <i class="fa-regular fa-calendar-check"></i></button>
                            </form>

                            <!-- card cadastro ap -->
                            <div class="card shadow mb-4" style="margin-top:25px;
   ">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                                    role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                    <h6 class="m-0 font-weight-bold text-primary">Cadastrar Novo Apartamento</h6>

                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse hide" id="collapseCardExample">
                                    <div class="card-body">

                                        <?php
                                        $dir = $_SERVER['DOCUMENT_ROOT'] . '/img/';
                                        $imagens = glob($dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                                        ?>
                                        <div class="container">
                                            <h1>Cadastro de Apartamento</h1>
                                            <form action="\public_html\control\cadastro_apartamento.php" method="post">
                                                <div class="form-group">
                                                    <label for="apartamento">Apartamento:</label>
                                                    <input type="text" class="form-control" id="apartamento"
                                                        name="apartamento" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="endereco">Endereço:</label>
                                                    <input type="text" class="form-control" id="endereco"
                                                        name="endereco" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="preco">Preço:</label>
                                                    <input type="number" class="form-control" id="preco" name="preco"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="foto_ap">
                                                        <?php echo fotoAp(); ?>
                                                    </label>

                                                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                                            </form>
                                        </div>




                                    </div>
                                </div>
                            </div>
                            <!-- fim card cadastro ap -->


                            <script type="text/javascript">
                                document.getElementById("novo_mes_form").addEventListener("submit", function (event) {
                                    var result = confirm("Tem certeza que deseja iniciar um novo mês?");
                                    if (!result) {
                                        event.preventDefault();
                                    }
                                });
                            </script>

                            <?php
                            if (isset($_POST['executar_funcao'])) {
                                novoMes();
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

    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website 2020</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="/js/demo/datatables-demo.js"></script>

</body>

</html>
