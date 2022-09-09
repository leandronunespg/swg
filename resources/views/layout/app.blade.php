<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>CFF - Controle Financeiro Fácil</title>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="  crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('/select2-4.1.0-rc.0/dist/js/select2.min.js') }}" rel="stylesheet" ></script>
    
     <!-- SweetAlert JS -->    
     <script src="/sweetalert2@11.js"></script>
     
     
     <!-- DataTable CSS -->
     <link rel="stylesheet" type="text/css" href="{{ url('/DataTables-1.12.1/css/jquery.dataTables.css') }}">
  
     <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="{{ url('/DataTables-1.12.1/datatables.min.css') }}"/>

    <link rel="stylesheet" type="text/css" href="{{ url('/DataTables-1.12.1/css/buttons.dataTables.min.css') }}"/>

    <script type="text/javascript" src="{{ asset('/DataTables-1.12.1/datatables.min.js') }}" charset="utf8"></script>

    <link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">      

    <link rel="stylesheet" type="text/css"  href="{{ url('/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" >
    



    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
    <link rel="manifest" href="/manifest.json">
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

       
</head>
<!-- PWA  -->
<meta name="theme-color" content="#6777ef"/>
<link rel="apple-touch-icon" href="{{ asset('images/icon-72x72.png') }}">
<link rel="manifest" href="{{ asset('/manifest.json') }}">

<body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><a href="/"><img src="{{ url("/images/logoswg.png") }}" width="100%"></a></h3>
            </div>

            <ul class="list-unstyled components">                

                <li>
                    <a href="#" class="fs-6"><i class="bi bi-caret-right-square-fill"></i> Cadastros</a>
                </li>                
                <li>
                    <a href="/TipoEntidade"><i class="bi bi-person-lines-fill"></i> Tipo de Parceiro</a>
                </li>
                <li>
                    <a href="/Entidades"><i class="bi bi-people-fill"></i> Parceiro de Negócio</a>
                </li>
                <li>
                    <a href="/CentroCusto"><i class="bi bi-stickies"></i> Centro de Custo</a>
                </li>
                <li>
                    <a href="/Historico"><i class="bi bi-chat-square-text"></i> Históricos</a>
                </li>
                <li>
                    <a href="/FormaPagamento"><i class="bi bi-cash-stack"></i> Formas de Pagamento</a>
                </li>
                <li>
                    <a href="#" class="fs-6"><i class="bi bi-caret-right-square-fill"></i> Estoque/Produtos</a>
                </li> 
                <li>
                    <a href="/Categorias"><i class="bi bi-clipboard-check"></i> Categorias</a>
                </li>
                <li>
                    <a href="/Produtos"><i class="bi bi-music-player"></i> Produtos</a>
                </li>
                <li>
                    <a href="/EntradaProduto"><i class="bi bi-sign-turn-left"></i> Compra de Produtos</a>
                </li>
                <li>
                    <a href="#" class="fs-6"><i class="bi bi-caret-right-square-fill"></i> Financeiro</a>
                </li> 
                {{--<li>
                    <a href="/Bancos"><i class="bi bi-people-fill"></i> Bancos/Caixa</a>
                </li>--}}
                <li>
                    <a href="/Lancamentos"><i class="bi bi-cash-coin"></i> Lançamentos</a>
                </li>                
                <li>
                    <a href="/Caixa"><i class="bi bi-graph-up-arrow"></i> Caixas</a>
                </li>
                <li>
                    <a href="#" class="fs-6"><i class="bi bi-caret-right-square-fill"></i> Vendas</a>
                </li> 
                <li>
                    <a href="/Orcamento"><i class="bi bi-shop-window"></i> Orçamento</a>
                </li>
                <li>
                    <a href="/Pedido"><i class="bi bi-shop"></i> Pedidos</a>
                </li>
                <li>
                    <a href="/DashBoard"><i class="bi bi-graph-up-arrow"></i> DashBoard</a>
                </li>
                <li>
                    <a href="javascript:close();"> Sair</a>
                </li>
            </ul>
            
        </nav>

     
        
        <!-- Page Content  -->
        <div id="content">
            
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <div class="col-sm-6">
                    <button type="button" id="sidebarCollapse" class="btn">
                        <i class="bi bi-justify"></i>
                    </button>             
                    </div>
                    
                    <div class="col-sm-6 text-end">
                        <strong>{{ auth()->user()->name }} <br></strong>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Sair') }} <i class="bi bi-box-arrow-in-left"></i>
                                    </a>
            
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                      
                    </div>
                </div>
            </nav>
            
            @yield('content')
            
        </div>
    </div>

    
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- DataTable JS -->
    <script src="{{ asset('/DataTables-1.12.1/datatables.js') }}" type="text/javascript" charset="utf8"></script>
    
    <script src="{{ asset('/DataTables-1.12.1/jquery.dataTables.min.js') }}" type="text/javascript" charset="utf8"></script>
    
    <script src="{{ asset('/DataTables-1.12.1/dataTables.responsive.min.js') }}" type="text/javascript" charset="utf8"></script>
    
    <script src="{{ asset('/DataTables-1.12.1/dataTables.buttons.min.js') }}" type="text/javascript" charset="utf8"></script>
    
    <script src="{{ asset('/DataTables-1.12.1/buttons.print.min.js') }}" type="text/javascript" charset="utf8"></script>
    
    <script src="{{ asset('/js/printThis.js') }}" type="text/javascript" charset="utf8"></script>
    
    <script src="{{ asset('/functions/functions.js') }}" type="text/javascript" charset="utf8"></script>
    
    <script src="{{ asset('/functions/functions_search.js') }}" type="text/javascript" charset="utf8"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    

    {{-- <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
               
    </script> --}}

{{-- <script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script> --}}
    @stack('scripts')
</body>

</html>