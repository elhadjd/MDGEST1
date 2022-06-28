<?php

use App\Http\Controllers\ArmagenControler;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\EncomendaPosControler;
use App\Http\Controllers\listcompra;
use App\Http\Controllers\produtos;
use App\Http\Controllers\tb_usuariolog;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\HomeControllers;
use App\Http\Controllers\pagamentos;
use App\Http\Controllers\PontoController;
use App\Http\Controllers\PosControler;
use App\Http\Controllers\StockControler;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Facades\Route;
use Mockery\Matcher\Any;

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
// Route para levar no arquivo controller
Route::get('/users',[UserController::class, 'show'])->name('liste_users');
Route::get('/produtos',[produtos::class, 'product'])->name('liste_prodict');
// para o arquivo home compras
Route::get('/ordens_de_compra',[listcompra::class, 'orden_conpra'])->name('liste_compras');
// O botao criar orden de compra
Route::get('/CriarOrdenDeCompra',[listcompra::class, 'InserirOrdenDeCompra'])->name('CriarOrdenDeCompra');
// A trazer a orden de compra criada
Route::get('/add_new_orden',[listcompra::class, 'nova_orden_compra'])->name('add_new_orden');

// A buscar fornecedor
Route::get('pesquisar_fornecedor',[listcompra::class, 'buscar_fornecedor'])->name('buscar fornecedor');

// A enviar adicionar fornecedor para esta orden
Route::get('/adicionar_fornecedor_na_orden_compras',[listcompra::class, 'adicionar_fornecedor_na_orden']);


// A ir na view fornecedore
Route::get('/new_fornecedore',[FornecedoresController::class, 'dados_fornecedor'])->name('new_fornecedore');

// A  enviar dados de fornecedore no banc de dado
Route::get('/upload_img_forn',[FornecedoresController::class, 'cadastrar_fornecedor'])->name('cadastrar_fornecedor');

// A adiacionar novos produtos para pedido
Route::get('/add_produtos_pedido',[listcompra::class, 'add_produtos_pedido'])->name('add_produtos_pedido');


// A pesquisar produto
Route::get('/pesquisar_produtos',[listcompra::class, 'pesquisar_produtos'])->name('pesquisar_produtos');

//// A buscar lista dos produtos
Route::get('/lista_dos_artigos',[listcompra::class, 'lista_dos_artigos'])->name('lista_dos_artigos');


// A adicionar produto na orden
Route::get('/adicionar_artigo',[listcompra::class, 'adicionar_artigo'])->name('adicionar_artigo');

// A fazer update os muvementos
Route::get('/updat_linha_de_pedido',[listcompra::class, 'updat_linha_de_pedido'])->name('updat_linha_de_pedido');

// A filtrtar  a pesquisa por estado e fornecedore
Route::get('/lista_das_orden_pesquisas',[listcompra::class, 'lista_das_orden_pesquisas'])->name('lista_das_orden_pesquisas');


// A apagare uma linha de pedido no banco
Route::get('/apagar_linha_de_artigo_pedido',[listcompra::class, 'apagar_linha_de_artigo_pedido'])->name('apagar_linha_de_artigo_pedido');

// clicar nos botoes de validaçoes
Route::get('/validacaoes_de_orden',[listcompra::class, 'validacaoes_de_orden'])->name('validacaoes_de_orden');

// Router por pagamentos
Route::get('/pagamentos',[pagamentos::class, 'tela_de_pagemento'])->name('tela_de_pagemento');

// A efectuar pagamento
Route::get('/fazer_pagamento',[pagamentos::class, 'fazer_pagamento'])->name('fazer_pagamento');

// A listar os produtos
Route::get('/lista_dos_produtos',[produtos::class, 'lista_dos_produtos'])->name('lista_dos_produtos');

// A pesquisar produto
Route::get('/pesquisas',[produtos::class, 'pesquisas'])->name('pesquisas');

// A crear novo produto
Route::get('/novo_produto',[produtos::class, 'novo_produto'])->name('novo_produto');

Route::get('/enformacoes_prod',[produtos::class, "enformacoes_prod"])->name('enformacoes_prod');

// A inserir informetion do produto
Route::get('/inserir_informacao_prod',[produtos::class, 'inserir_informacao_prod'])->name('inserir_informacao_prod');

Route::get('/entrar',[tb_usuariolog::class,'login'])->name('entrar');

// A ir para ponto de venda

Route::get('/ponto_de_venda',[PontoController::class , 'ponto_de_venda'])->name('ponto_de_venda');

// A ir para configuraçoes
Route::get('/config',[ConfigController::class, "MenuConfig"])->name('MenuConfig');

// A ir na lista de usuario pelo post
Route::any('/ListeUser',[ConfigController::class, 'ListUser'])->name('lista_de_usuario');

// A mostrar bloco de usuario unico
Route::get('/bloco_usuario',[ConfigController::class, 'bloco_usuario'])->name('bloco_usuario');

// A criar editar usuario
Route::get('/info_user_creat', [ConfigController::class, 'info_user_creat'])->name('info_user_creat');


// A buscar pagamentos
Route::get('/buscar_pagamentos', [pagamentos::class ,'buscar_pagamentos'])->name('buscar_pagamentos');

// A trazer menu de ponto de venda
Route::get('/menu_ponto_de_venda',[PontoController::class, 'menu_ponto_de_venda'])->name('menu_ponto_de_venda');

// A levar para bloco de caixa
Route::get('/bloco_caixa',[PontoController::class, 'bloco_caixa'])->name('bloco_caixa');


// A mandar AccesApp no banco de dados
Route::get('/accessApp',[ConfigController::class, 'accessApp'])->name('/accessApp');

//  A mandar ações no banco
Route::get('/AcoesUser',[ConfigController::class, 'AcoesUser'])->name('AcoesUser');

// A caminho de formulario caixa de ponto de venda
Route::get('/CriarCaixa',[PontoController::class, 'BlocoCaixa'])->name('BlocoCaixa');

// A ir no bloco pos
Route::get("/Pos",[PosControler::class ,'pos'])->name('pos');

Route::get('/menuPos',[PosControler::class , 'menuPos']);

// A buscar todo os produtos
Route::get('/trager_produtos', [PosControler::class , 'ListaArtigos']);

// A trazer a encomenda
Route::get('/buscarEncomenda',[EncomendaPosControler::class, 'encomenda'])->name('encomenda');

// A /AdicionarProduto

Route::get('/AdicionarProduto',[EncomendaPosControler::class, 'AddProd']);

// A ir apagar uma linha de pedido
Route::get('/ApagarLinhaPedido',[EncomendaPosControler::class, 'ApagarLinhaPedido']);

// A alterar quantidade preços e descontos
Route::get('/AlterarLinhaPedido',[EncomendaPosControler::class, 'AlterarLinhaPedido']);

// ROUTE formulario da caixa
Route::get('/FormularioSession',[PontoController::class, 'FormularioSession']);

// A trazer a lista de sessoes
Route::get('/SessoesCaixa',[PontoController::class , "SessoesCaixa"]);

// A ir nas sessoess das caixas enteriones
Route::get('/SessoesCaixas',[PontoController::class, 'SessoesCaixas'])->name('/SessoesCaixas');

// A abrir o controlo da caixa
Route::get('AbrirControloCaixa',[PontoController::class, 'AbrirControloCaixa']);

// A ir no pos

Route::get('/HeaderPos', [PontoController::class , 'HeaderPos'])->name('HeaderPos');

// A Sair do pos
Route::get('/SairPos',[PosControler::class, 'SairPos'])->name('SairPos');

// A monstrar o formulario de pagamento
Route::get('/FormPagamento',[PosControler::class, 'FormPagamento']);


// A validar pagamento
Route::get('/ValidarPagamento',[PosControler::class, 'ValidarPagamento']);


// A buscar a fatura desta encomenda recebida
Route::get('/BuscarFatura', [PosControler::class , 'BuscarFatura']);


// A fechar controlo da session
Route::get('/FecharSession',[PontoController::class , 'FecharSession']);


// A levar os relatorios
Route::get('/Relatorios',[PontoController::class , 'Relatorios']);


// a buscar orden de venda
Route::get('/BuscarOrden',[PontoController::class,'BuscarOrden']);


// A trazer a lista dos pedidos
Route::any('ListPedido',[PontoController::class , 'ListPedido']);

// A ir para annular a fatura
Route::get('/AnnularOrdenden',[PontoController::class , 'AnnularOrdenden']);

// A buscar o relatorio
Route::get('/BuscarRelatorio',[PontoController::class, 'BuscarRelatorio']);

// A trazer todos os artigo para a tabela avaliation de stock
Route::get('/ArtigosAvaliation',[PontoController::class,'ArtigosAvaliation']);

// A ir buscar relatorio dos muvementos dos artigos
Route::get('/MuvementosProd',[PontoController::class , 'MuvementosProd']);


// A adiacionar um gasto no banco de dados

Route::get('/AdicionarGasto',[PontoController::class, 'AdicionarGasto']);

// a criar um novo cliente
Route::get('/NovoCliente',[PosControler::class, 'NovoCliente']);



// a ir para a pagina de stock
Route::get('/Stock',[StockControler::class, 'Stock'])->name('Stock');


// A trazer menu stock
Route::get('/MenuStock',[StockControler::class, 'MenuStock']);


// A mostrar todos os armagens
Route::get('/Armagens',[StockControler::class, 'Armagens'])->name('Armagens');

// A guardar armagem no banco de dado
Route::get('GuardarArmagen',[StockControler::class, 'GuardarArmagen']);

// A trazer os relatorios de stock
Route::get('/RelatoriosStock',[StockControler::class , 'RelatoriosStock']);

// A fazer entrada e saida de stock
Route::get('/EntradaSaidaStock',[produtos::class , 'EntradaSaidaStock']);


// A buscar os muvementos de stock
Route::get('/BuscarMuvementosStock',[StockControler::class, 'BuscarMuvementosStock']);


















// Route para levar para view
Route::get('/', function () {return view('login.index');});





Route::get('/homes', [HomeControllers::class, 'index'])->name('homes');




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('testandoForm',[PontoController::class, 'testandoForm']);

Route::get('/DetalharArtigo', [produtos::class , 'DetalharArtigo']);


// A buscaR  as menssagens de usuario clicado
Route::get('/menssagens',[PosControler::class, 'menssagens']);
