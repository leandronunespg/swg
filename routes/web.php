<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EntidadesController;
use App\Http\Controllers\TipoentidadeController;
use App\Http\Controllers\CentrocustoController;
use App\Http\Controllers\FormapagamentoController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\LancamentoController;
use App\Http\Controllers\PagamentoController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\TabelasController;
use App\Http\Controllers\CaixasController;
use App\Http\Controllers\EntradaprodutoController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\PedidoController;
// use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PDFController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

*/

//tela de login
// Route::get('/',              [UsuariosController::class, 'index'])->name('index');
// Route::get('/user/inserir',  [UsuariosController::class, 'inserir'])->name('user.inserir');

// Route::post('/user/salvar',  [UsuariosController::class, 'salvar'])->name('user.salvar');
// Route::post('/user/logar',   [UsuariosController::class, 'login'])->name('login');

Route::group(['middleware'=>'auth'],function(){
// definir rotas com apelido
    Route::get('/',                                [LancamentoController::class, 'home'])->name('home');

    
    //Rotas para Tipos de Entidade
    Route::get('/TipoEntidade',                    [TipoEntidadeController::class, 'index'])->name('tipoentidade.index');
    Route::get('/TipoEntidade/Adicionar/{id?}',    [TipoEntidadeController::class, 'create'])->name('tipoentidade.adicionar');
    Route::post('/TipoEntidade/Salvar/',           [TipoEntidadeController::class, 'store'])->name('tipoentidade.salvar');
    Route::get('/TipoEntidade/Editar/{id?}',       [TipoEntidadeController::class, 'edit'])->name('tipoentidade.editar');
    Route::post('/TipoEntidade/Update/{id?}',      [TipoEntidadeController::class, 'update'])->name('tipoentidade.atualizar');
    Route::get('/TipoEntidade/Deletar/{id?}',      [TipoEntidadeController::class, 'destroy'])->name('tipoentidade.deletar');

    //Rotas para entidades
    Route::get('/Entidades',                       [EntidadesController::class, 'index'])->name('entidades.index');
    Route::get('/Entidades/Adicionar',             [EntidadesController::class, 'create'])->name('entidades.adicionar');
    Route::post('/Entidades/Salvar/',              [EntidadesController::class, 'store'])->name('entidades.salvar');
    Route::get('/Entidades/Editar/{id?}',          [EntidadesController::class, 'edit'])->name('entidades.editar');
    Route::post('/Entidades/Update/{id?}',         [EntidadesController::class, 'update'])->name('entidades.atualizar');
    Route::get('/Entidades/Deletar/{id?}',         [EntidadesController::class, 'destroy'])->name('entidades.deletar');
    
    //Rotas para categorias
    Route::get('/Categorias',                      [CategoriasController::class, 'index'])->name('categorias.index');
    Route::get('/Categorias/Adicionar',            [CategoriasController::class, 'create'])->name('categorias.adicionar');
    Route::post('/Categorias/Salvar/',             [CategoriasController::class, 'store'])->name('categorias.salvar');
    Route::get('/Categorias/Editar/{id?}',         [CategoriasController::class, 'edit'])->name('categorias.editar');
    Route::post('/Categorias/Update/{id?}',        [CategoriasController::class, 'update'])->name('categorias.atualizar');
    Route::get('/Categorias/Deletar/{id?}',        [CategoriasController::class, 'destroy'])->name('categorias.deletar');
   
    //Rotas para produtos
    Route::get('/Produtos',                        [ProdutosController::class, 'index'])->name('produtos.index');
    Route::get('/Produtos/Adicionar',              [ProdutosController::class, 'create'])->name('produtos.adicionar');
    Route::post('/Produtos/Salvar/',               [ProdutosController::class, 'store'])->name('produtos.salvar');
    Route::get('/Produtos/Editar/{id?}',           [ProdutosController::class, 'edit'])->name('produtos.editar');
    Route::post('/Produtos/Update/{id?}',          [ProdutosController::class, 'update'])->name('produtos.atualizar');
    Route::get('/Produtos/Deletar/{id?}',          [ProdutosController::class, 'destroy'])->name('produtos.deletar');
    Route::post('/Produtos/Tabela/Salvar',         [ProdutosController::class, 'table'])->name('table.salvar');
    Route::get('/Tabela/Deletar/{id?}/{product_id?}',[ProdutosController::class, 'tableDestroy'])->name('table.deletar');

     //Rotas para tabela de preços
     Route::get('/TabelaPrecos',                   [TabelasController::class, 'index'])->name('tabela.index');
     Route::get('/TabelaPrecos/Adicionar',         [TabelasController::class, 'create'])->name('tabela.adicionar');
     Route::post('/TabelaPrecos/Salvar/',          [TabelasController::class, 'store'])->name('tabela.salvar');
     Route::get('/TabelaPrecos/Deletar/{id?}',     [TabelasController::class, 'destroy'])->name('tabela.deletar');
    
    //Rotas para Centro de Custo
    Route::get('/CentroCusto',                     [CentroCustoController::class, 'index'])->name('centrocusto.index');
    Route::get('/CentroCusto/Adicionar',           [CentroCustoController::class, 'create'])->name('centrocusto.adicionar');
    Route::post('/CentroCusto/Salvar/',            [CentroCustoController::class, 'store'])->name('centrocusto.salvar');
    Route::get('/CentroCusto/Editar/{id?}',        [CentroCustoController::class, 'edit'])->name('centrocusto.editar');
    Route::post('/CentroCusto/Update/{id?}',       [CentroCustoController::class, 'update'])->name('centrocusto.atualizar');
    Route::get('/CentroCusto/Deletar/{id?}',       [CentroCustoController::class, 'destroy'])->name('centrocusto.deletar');
    
    //Rotas para Formas de Pagamento
    Route::get('/FormaPagamento',                  [FormaPagamentoController::class, 'index'])->name('formapagamento.index');
    Route::get('/FormaPagamento/Adicionar',        [FormaPagamentoController::class, 'create'])->name('formapagamento.adicionar');
    Route::post('/FormaPagamento/Salvar/',         [FormaPagamentoController::class, 'store'])->name('formapagamento.salvar');
    Route::get('/FormaPagamento/Editar/{id?}',     [FormaPagamentoController::class, 'edit'])->name('formapagamento.editar');
    Route::post('/FormaPagamento/Update/{id?}',    [FormaPagamentoController::class, 'update'])->name('formapagamento.atualizar');
    Route::get('/FormaPagamento/Deletar/{id?}',    [FormaPagamentoController::class, 'destroy'])->name('formapagamento.deletar');
    
    //Rotas para Históricos
    Route::get('/Historico',                       [HistoricoController::class, 'index'])->name('historico.index');
    Route::get('/Historico/Adicionar',             [HistoricoController::class, 'create'])->name('historico.adicionar');
    Route::post('/Historico/Salvar/',              [HistoricoController::class, 'store'])->name('historico.salvar');
    Route::get('/Historico/Editar/{id?}',          [HistoricoController::class, 'edit'])->name('historico.editar');
    Route::post('/Historico/Update/{id?}',         [HistoricoController::class, 'update'])->name('historico.atualizar');
    Route::get('/Historico/Deletar/{id?}',         [HistoricoController::class, 'destroy'])->name('historico.deletar');
    
    //Rotas para Entrada de Produtos
    Route::get('/EntradaProduto',                  [EntradaprodutoController::class, 'index'])->name('entradaproduto.index');
    Route::get('/EntradaProduto/Adicionar',        [EntradaprodutoController::class, 'create'])->name('create');
    Route::post('/EntradaProduto/Salvar/',         [EntradaprodutoController::class, 'store'])->name('entradaproduto.salvar');
    Route::get('/EntradaProduto/Editar/{id?}',     [EntradaprodutoController::class, 'edit'])->name('entradaproduto.editar');
    Route::post('/EntradaProduto/Update/{id?}',    [EntradaprodutoController::class, 'update'])->name('entradaproduto.atualizar');
    Route::get('/EntradaProduto/Deletar/{id?}',    [EntradaprodutoController::class, 'destroy'])->name('entradaproduto.deletar');
    Route::post('/ConsultaProdutos/{search?}',     [EntradaprodutoController::class, 'consultaprodutos'])->name('consultaprodutos');       
    
    //Rotas para Lançamentos
    Route::get('/Lancamentos/{status?}',           [LancamentoController::class, 'index'])->name('lancamentos.index');
    Route::get('/Lancamentos/Dados/',              [LancamentoController::class, 'dados'])->name('lancamentos.dados');
    Route::get('/Lancamentos/Filtro/{status?}',   [LancamentoController::class, 'index'])->name('lancamentos.filtro');
    Route::get('/Lancamentos/Adicionar/Dados/{status?}',    [LancamentoController::class, 'create'])->name('lancamentos.adicionar');
    Route::post('/Lancamentos/Salvar/Dados',       [LancamentoController::class, 'store'])->name('lancamentos.salvar');
    Route::get('/Lancamentos/Editar/{id?}',        [LancamentoController::class, 'edit'])->name('lancamentos.editar');
    Route::post('/Lancamentos/Update/{id?}',       [LancamentoController::class, 'update'])->name('lancamentos.atualizar');
    Route::get('/Lancamentos/Deletar/{id?}',       [LancamentoController::class, 'destroy'])->name('lancamentos.deletar');
    Route::get('/ConsultaHistorico/{id?}',         [LancamentoController::class, 'consultahistorico'])->name('consultahistorico.deletar');
   
    //Rotas para Pagamentos
    Route::get('/Pagamentos/{id?}',                [PagamentoController::class, 'index'])->name('pagamentos.index');
    Route::get('/Pagamentos/Adicionar',            [PagamentoController::class, 'create'])->name('pagamentos.adicionar');
    Route::post('/Pagamentos/Salvar',              [PagamentoController::class, 'store'])->name('pagamentos.salvar');
    Route::get('/Pagamentos/Editar/{id?}',         [PagamentoController::class, 'edit'])->name('pagamentos.editar');
    Route::post('/Pagamentos/Update/{id?}',        [PagamentoController::class, 'update'])->name('pagamentos.atualizar');
    Route::get('/Pagamentos/Deletar/{id?}',        [PagamentoController::class, 'destroy'])->name('pagamentos.deletar');
    
    Route::get('/Calendario/Financeiro/',          [LancamentoController::class, 'calendariofinanceiro'])->name('calendariofinanceiro');
    Route::get('/DashBoard',                       [LancamentoController::class, 'DashBoard'])->name('DashBoard');

     //Rotas para Bancos
     Route::get('/Bancos/{status?}',               [BancoController::class, 'index'])->name('bancos.index');


     //Rotas para Caixas
    Route::get('/Caixa/{id?}',                     [CaixasController::class, 'index'])->name('caixa.index');
    Route::get('/Caixa/Adicionar',                 [CaixasController::class, 'create'])->name('caixa.adicionar');
    Route::post('/Caixa/Salvar',                   [CaixasController::class, 'store'])->name('caixa.salvar');
    Route::get('/Caixa/Editar/{id?}',              [CaixasController::class, 'edit'])->name('caixa.editar');
    Route::post('/Caixa/Update/{id?}',             [CaixasController::class, 'update'])->name('caixa.atualizar');
    Route::get('/Caixa/Deletar/{id?}',             [CaixasController::class, 'destroy'])->name('caixa.deletar');
    
    //Rotas para Pedidos
    Route::get('/Orcamento/{id?}',                 [OrcamentoController::class, 'index'])->name('orcamento.index');
    Route::get('/OrcamentoAdd/Adicionar',          [OrcamentoController::class, 'create'])->name('orcamento.adicionar');
    Route::post('/Orcamento/Salvar',               [OrcamentoController::class, 'store'])->name('orcamento.salvar');
    Route::get('/Orcamento/Editar/{id?}',          [OrcamentoController::class, 'edit'])->name('orcamento.editar');
    Route::post('/Orcamento/Update/{id?}',         [OrcamentoController::class, 'update'])->name('orcamento.atualizar');
    Route::get('/Orcamento/Deletar/{id?}',         [OrcamentoController::class, 'destroy'])->name('orcamento.deletar');
    Route::get('/ConsultaValorProduto/{id?}',      [OrcamentoController::class, 'ConsultaValorProduto'])->name('ConsultaValorProduto');
    Route::get('/ConsultaEnderecoEntidade/{id?}',  [OrcamentoController::class, 'ConsultaEnderecoEntidade'])->name('ConsultaEnderecoEntidade');
    Route::get('/ItemOrcamento/Deletar/{id?}/{orcamento_id?}',[OrcamentoController::class, 'ItemDestroy'])->name('item.deletar');
    Route::get('/GerarPedido/{id?}/{orcamento_id?}',[OrcamentoController::class, 'GerarPedido'])->name('pedido.gerar');
    Route::get('/Orcamento/Imprimir/{id?}',        [OrcamentoController::class, 'edit'])->name('orcamento.imprimir');
    Route::get('orcamento-pdf/{id?}',              [PDFController::class, 'GerarOrcamento']);
    

    //Rotas para Pedidos
    Route::get('/Pedido/{id?}',                    [PedidoController::class, 'index'])->name('pedido.index');
    Route::post('/Pedido/Adicionar',               [PedidoController::class, 'create'])->name('pedido.adicionar');
    Route::post('/Pedido/Salvar',                  [PedidoController::class, 'store'])->name('pedido.salvar');
    Route::get('/Pedido/Editar/{id?}',             [PedidoController::class, 'edit'])->name('pedido.editar');
    Route::post('/Pedido/Update/{id?}',            [PedidoController::class, 'update'])->name('pedido.atualizar');
    Route::get('/Pedido/Deletar/{id?}',            [PedidoController::class, 'destroy'])->name('pedido.deletar');
    Route::get('pedido-pdf/{id?}',                 [PDFController::class, 'GerarPedido']);
});

Auth::routes();

Route::get('/home',                                 [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
