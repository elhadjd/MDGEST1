<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.98.0">
    <title>Relatorio</title>


    <link rel="stylesheet" href="/csss/ponto_de_venda/dashboard.css">
    <link rel="stylesheet" href="/csss/ponto_de_venda/dashboard.rtl.css">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>


    <!-- Custom styles for this template -->
    <link href="csss/ponto_de_venda/dashboard.css" rel="stylesheet">
  </head>
  <body>
    <div class="ResultadoMovementosProd d-flex justify-content-center top-0 w-100" id="ResultadoMovementosProd"> </div>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3 h-75 overflow-auto">
                <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Hoje
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                    <span data-feather="file" class="align-text-bottom"></span>
                    Ordens
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link VendidosLucro" table="controlo_produtos_vendidos" coluna="quantidade" tipo="DESC" href="">
                    <span data-feather="shopping-cart" class="align-text-bottom"></span>
                    Produtos mais vendidos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link VendidosLucro" href="" table="controlo_produtos_vendidos" coluna="quantidade" tipo="ASC">
                    <span data-feather="users" class="align-text-bottom"></span>
                    Produtos menos vendidos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link VendidosLucro" href="" table="margin_prods" coluna="margin" tipo="DESC">
                    <span data-feather="bar-chart-2" class="align-text-bottom"></span>
                    Produtos com mais lucro
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link VendidosLucro" href="" table="margin_prods" coluna="margin" tipo="ASC">
                    Produtos com menos lucro
                    </a>
                </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                <span>Saved reports</span>
                <a class="link-secondary" href="" aria-label="Add a new report">
                    <span data-feather="plus-circle" class="align-text-bottom"></span>
                </a>
                </h6>
                <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a class="nav-link" href="">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Current month
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Last quarter
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Social engagement
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                    <span data-feather="file-text" class="align-text-bottom"></span>
                    Year-end sale
                    </a>
                </li>
                </ul>
            </div>
            </nav>

            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-4 h-50">
                <div class="h-25">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">Dashboard</h1>
                        <div class="btn-toolbar mb-2 mb-md-0 mx-5">
                            <div class="btn-group me-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary">Hoje</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Ontem</button>
                            </div>
                            <button type="date" class="btn btn-sm btn-outline-secondary dropdown-toggle" id="dropdownMenuButton">
                                <span data-feather="calendar" id="datas" class="align-text-bottom">Intervalo</span>
                                <div class="dropdown-menu bg-white opacity-5 p-2 shadow-lg" id="datasInterval"  aria-labelledby="datas">
                                    <input type="date" name="dataInicio" id="dataInicio" class="form-control mt-2 p-1">
                                    <input type="date" name="dataInicio" id="dataFin" class="form-control mt-2 p-1">
                                    <input type="button" value="Validar" id="ValidaPorIntervalo" class="btn">
                                </div>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle ms-2" id="dropdownMenuButton">
                                <span data-feather="calendar" id="dropdownMenuButto" class="align-text-bottom">Selectiona</span>
                                <div class="dropdown-menu" id="porMes" aria-labelledby="dropdownMenuButton">
                                    <div class="dropdown-item">Esta semana</div>
                                    <div class="dropdown-item">Este mes</div>
                                    <div class="dropdown-item">Este ano</div>
                                </div>
                            </button>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-danger card-img-holder text-secondary">
                                    <div class="card-body">
                                        <h4 class="font-weight-normal mb-3"><strong>Total de venda</strong><i class="fa fa-chart-line mdi-24px float-right"></i>
                                        </h4>
                                        <h2 class="mb-5" id="TotalVenda"> </h2>
                                        <h6 class="card-text">Increased by 60%</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-info card-img-holder text-secondary">
                                    <div class="card-body">
                                        <h4 class="font-weight-normal mb-3"><strong>Total de gasto</strong><i class="mdi mdi-bookmark-outline mdi-24px float-right"></i>
                                        </h4>
                                        <h2 class="mb-5 GastosDiarios"></h2>
                                        <h6 class="card-text">Decreased by 10%</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 stretch-card grid-margin">
                                <div class="card bg-gradient-success card-img-holder text-secondary">
                                    <div class="card-body">
                                        <h4 class="font-weight-normal mb-3"><strong>Total de Lucro diario</strong><i class="mdi mdi-diamond mdi-24px float-right"></i>
                                        </h4>
                                        <h2 class="mb-5 TotalLucro"></h2>
                                        <h6 class="card-text">Increased by 5%</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-control-sm bg-white encomendasRelatorio position-absolute">
                        <div class="w-100 p-2 d-flex">
                            <div class="w-50">

                            </div>
                            <div class="w-50">
                                <input type="search" class="w-100" placeholder="Pesquisar por id da orden , Exemplo(110)" name="PesquisarOrden" id="PesquisarOrden">
                                <i class="fa fa-search position-absolute"></i>
                            </div>
                        </div>
                        <div class="d-flex titleListEncomenda text-secondary">
                            <div>Ref orden</div>
                            <div>Ponto de venda</div>
                            <div>Sessão</div>
                            <div>Funcionario</div>
                            <div>Total</div>
                            <div>Estado</div>
                        </div>
                        <div class="h-100 listaEncomendasRelatorio text-secondary overflow-auto">

                        </div>
                    </div>
                </div>
        </div>
    </div>

    <div class="ResultListPedidos position-absolute top-0 zindex-1080 w-100 h-100" style="z-index: 1080"></div>
</body>
</html>
<script src="csss/ponto_de_venda/relatorio.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
