import 'package:flutter/material.dart';

import '../services/api_service.dart';

class DashboardPage extends StatefulWidget {
  const DashboardPage({super.key});

  @override
  State<DashboardPage> createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  bool _carregando = true;
  String? _erro;

  Map<String, dynamic> _dashboard = {};

  @override
  void initState() {
    super.initState();
    _carregarDashboard();
  }

  // ============================================================
  // CARREGAR DASHBOARD
  // ============================================================

  Future<void> _carregarDashboard() async {
    if (mounted) {
      setState(() {
        _carregando = true;
        _erro = null;
      });
    }

    try {
      final data = await ApiService.getDashboard();

      if (!mounted) return;

      setState(() {
        _dashboard = data;
        _carregando = false;
      });
    } catch (e) {
      if (!mounted) return;

      setState(() {
        _erro = e.toString().replaceFirst('Exception: ', '');
        _carregando = false;
      });
    }
  }

  // ============================================================
  // LOGOUT
  // ============================================================

  Future<void> _logout() async {
    await ApiService.logout();

    if (!mounted) return;

    Navigator.pushNamedAndRemoveUntil(
      context,
      '/login',
      (route) => false,
    );
  }

  // ============================================================
  // OBTER VALOR DO DASHBOARD
  // ============================================================

  dynamic _valor(
    String chave, [
    dynamic padrao = 0,
  ]) {
    // Caso venha diretamente:
    //
    // {
    //   "total_produtos": 10
    // }

    if (_dashboard.containsKey(chave)) {
      return _dashboard[chave];
    }

    // Caso venha:
    //
    // {
    //   "success": true,
    //   "data": {
    //     "total_produtos": 10
    //   }
    // }

    if (_dashboard['data'] is Map) {
      final data = _dashboard['data'];

      return data[chave] ?? padrao;
    }

    return padrao;
  }

  // ============================================================
  // BUILD
  // ============================================================

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xfff5f7fb),
      drawer: _buildDrawer(),
      appBar: _buildAppBar(),
      body: RefreshIndicator(
        onRefresh: _carregarDashboard,
        child: _carregando
            ? const Center(
                child: CircularProgressIndicator(),
              )
            : _erro != null
                ? _buildErro()
                : _buildConteudo(),
      ),
    );
  }

  // ============================================================
  // APP BAR
  // ============================================================

  PreferredSizeWidget _buildAppBar() {
    return AppBar(
      elevation: 0,
      backgroundColor: Colors.white,
      foregroundColor: const Color(0xff111827),
      titleSpacing: 20,
      title: Row(
        children: [
          Container(
            width: 42,
            height: 42,
            decoration: BoxDecoration(
              color: const Color(0xff2563eb),
              borderRadius: BorderRadius.circular(12),
            ),
            child: const Icon(
              Icons.inventory_2_outlined,
              color: Colors.white,
            ),
          ),

          const SizedBox(width: 12),

          const Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                'SmartCatalog',
                style: TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.w800,
                ),
              ),
              Text(
                'Painel administrativo',
                style: TextStyle(
                  fontSize: 11,
                  color: Color(0xff64748b),
                ),
              ),
            ],
          ),
        ],
      ),
      actions: [
        IconButton(
          tooltip: 'Atualizar dashboard',
          onPressed: _carregando
              ? null
              : _carregarDashboard,
          icon: const Icon(
            Icons.refresh_rounded,
          ),
        ),

        const SizedBox(width: 8),
      ],
    );
  }

  // ============================================================
  // CONTEÚDO PRINCIPAL
  // ============================================================

  Widget _buildConteudo() {
    final produtos = _valor(
      'total_produtos',
      0,
    );

    final estoque = _valor(
      'estoque_total',
      0,
    );

    final pedidos = _valor(
      'total_pedidos',
      0,
    );

    final categorias = _valor(
      'total_categorias',
      0,
    );

    return SingleChildScrollView(
      physics: const AlwaysScrollableScrollPhysics(),
      padding: const EdgeInsets.all(20),
      child: Center(
        child: ConstrainedBox(
          constraints: const BoxConstraints(
            maxWidth: 1200,
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _buildCabecalho(),

              const SizedBox(height: 24),

              _buildCards(
                produtos,
                estoque,
                pedidos,
                categorias,
              ),

              const SizedBox(height: 24),

              _buildSecaoPrincipal(),

              const SizedBox(height: 24),

              _buildUltimosPedidos(),

              const SizedBox(height: 30),
            ],
          ),
        ),
      ),
    );
  }

  // ============================================================
  // CABEÇALHO
  // ============================================================

  Widget _buildCabecalho() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [
            Color(0xff2563eb),
            Color(0xff1d4ed8),
          ],
        ),
        borderRadius: BorderRadius.circular(18),
        boxShadow: [
          BoxShadow(
            color: Colors.blue.withOpacity(.18),
            blurRadius: 20,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Row(
        children: [
          Expanded(
            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment.start,
              children: [
                const Text(
                  'Olá!',
                  style: TextStyle(
                    color: Colors.white70,
                    fontSize: 15,
                  ),
                ),

                const SizedBox(height: 5),

                const Text(
                  'Visão geral do seu catálogo',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 24,
                    fontWeight: FontWeight.w800,
                  ),
                ),

                const SizedBox(height: 8),

                Text(
                  'Acompanhe produtos, estoque e pedidos em um só lugar.',
                  style: TextStyle(
                    color: Colors.white.withOpacity(.85),
                    fontSize: 13,
                  ),
                ),
              ],
            ),
          ),

          const SizedBox(width: 20),

          Container(
            width: 64,
            height: 64,
            decoration: BoxDecoration(
              color: Colors.white.withOpacity(.15),
              borderRadius: BorderRadius.circular(18),
            ),
            child: const Icon(
              Icons.bar_chart_rounded,
              color: Colors.white,
              size: 34,
            ),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // CARDS
  // ============================================================

  Widget _buildCards(
    dynamic produtos,
    dynamic estoque,
    dynamic pedidos,
    dynamic categorias,
  ) {
    return LayoutBuilder(
      builder: (context, constraints) {
        final largura = constraints.maxWidth;

        int colunas;

        if (largura >= 1000) {
          colunas = 4;
        } else if (largura >= 650) {
          colunas = 2;
        } else {
          colunas = 1;
        }

        return GridView.count(
          crossAxisCount: colunas,
          shrinkWrap: true,
          physics:
              const NeverScrollableScrollPhysics(),
          crossAxisSpacing: 16,
          mainAxisSpacing: 16,
          childAspectRatio:
              colunas == 1 ? 3.1 : 1.55,
          children: [
            _buildCard(
              titulo: 'Produtos',
              valor: '$produtos',
              descricao: 'produtos cadastrados',
              icon: Icons.inventory_2_outlined,
              iconColor:
                  const Color(0xff2563eb),
            ),

            _buildCard(
              titulo: 'Estoque',
              valor: '$estoque',
              descricao: 'unidades disponíveis',
              icon:
                  Icons.warehouse_outlined,
              iconColor:
                  const Color(0xff16a34a),
            ),

            _buildCard(
              titulo: 'Pedidos',
              valor: '$pedidos',
              descricao: 'pedidos registrados',
              icon:
                  Icons.receipt_long_outlined,
              iconColor:
                  const Color(0xfff59e0b),
            ),

            _buildCard(
              titulo: 'Categorias',
              valor: '$categorias',
              descricao: 'categorias cadastradas',
              icon:
                  Icons.category_outlined,
              iconColor:
                  const Color(0xff7c3aed),
            ),
          ],
        );
      },
    );
  }

  // ============================================================
  // CARD INDIVIDUAL
  // ============================================================

  Widget _buildCard({
    required String titulo,
    required String valor,
    required String descricao,
    required IconData icon,
    required Color iconColor,
  }) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color:
                Colors.black.withOpacity(.045),
            blurRadius: 14,
            offset: const Offset(0, 5),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 52,
            height: 52,
            decoration: BoxDecoration(
              color:
                  iconColor.withOpacity(.10),
              borderRadius:
                  BorderRadius.circular(14),
            ),
            child: Icon(
              icon,
              color: iconColor,
              size: 27,
            ),
          ),

          const SizedBox(width: 15),

          Expanded(
            child: Column(
              mainAxisAlignment:
                  MainAxisAlignment.center,
              crossAxisAlignment:
                  CrossAxisAlignment.start,
              children: [
                Text(
                  titulo,
                  style: const TextStyle(
                    color: Color(0xff64748b),
                    fontSize: 13,
                    fontWeight:
                        FontWeight.w600,
                  ),
                ),

                const SizedBox(height: 4),

                Text(
                  valor,
                  style: const TextStyle(
                    color: Color(0xff111827),
                    fontSize: 25,
                    fontWeight:
                        FontWeight.w800,
                  ),
                ),

                Text(
                  descricao,
                  style: const TextStyle(
                    color: Color(0xff94a3b8),
                    fontSize: 11,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // SEÇÃO PRINCIPAL
  // ============================================================

  Widget _buildSecaoPrincipal() {
    return LayoutBuilder(
      builder: (context, constraints) {
        if (constraints.maxWidth < 750) {
          return Column(
            children: [
              _buildEstoqueBaixo(),

              const SizedBox(height: 20),

              _buildResumoPedidos(),
            ],
          );
        }

        return Row(
          crossAxisAlignment:
              CrossAxisAlignment.start,
          children: [
            Expanded(
              child: _buildEstoqueBaixo(),
            ),

            const SizedBox(width: 20),

            Expanded(
              child: _buildResumoPedidos(),
            ),
          ],
        );
      },
    );
  }

  // ============================================================
  // ESTOQUE BAIXO
  // ============================================================

  Widget _buildEstoqueBaixo() {
    final produtos = _valor(
      'produtos_estoque_baixo',
      [],
    );

    final lista =
        produtos is List ? produtos : [];

    return _buildBox(
      titulo: 'Estoque baixo',
      subtitulo:
          'Produtos que precisam de atenção.',
      icon:
          Icons.warning_amber_rounded,
      iconColor:
          const Color(0xffdc2626),
      child: lista.isEmpty
          ? _buildVazio(
              'Nenhum produto com estoque baixo.',
            )
          : Column(
              children: lista
                  .take(5)
                  .map(
                    (produto) =>
                        _buildProdutoEstoque(
                      produto,
                    ),
                  )
                  .toList(),
            ),
    );
  }

  // ============================================================
  // PRODUTO COM ESTOQUE BAIXO
  // ============================================================

  Widget _buildProdutoEstoque(
    dynamic produto,
  ) {
    final nome = produto is Map
        ? produto['nome'] ?? 'Produto'
        : 'Produto';

    final estoque = produto is Map
        ? produto['estoque'] ?? 0
        : 0;

    return Container(
      padding:
          const EdgeInsets.symmetric(
        vertical: 12,
      ),
      decoration:
          const BoxDecoration(
        border: Border(
          bottom: BorderSide(
            color: Color(0xfff1f5f9),
          ),
        ),
      ),
      child: Row(
        children: [
          Container(
            width: 38,
            height: 38,
            decoration: BoxDecoration(
              color:
                  const Color(0xffffe2e2),
              borderRadius:
                  BorderRadius.circular(10),
            ),
            child: const Icon(
              Icons.inventory_2_outlined,
              color:
                  Color(0xffdc2626),
              size: 20,
            ),
          ),

          const SizedBox(width: 12),

          Expanded(
            child: Text(
              '$nome',
              overflow: TextOverflow.ellipsis,
              style: const TextStyle(
                fontWeight:
                    FontWeight.w700,
                color:
                    Color(0xff111827),
              ),
            ),
          ),

          Text(
            '$estoque un.',
            style: const TextStyle(
              color:
                  Color(0xffdc2626),
              fontWeight:
                  FontWeight.w800,
            ),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // RESUMO DOS PEDIDOS
  // ============================================================

  Widget _buildResumoPedidos() {
    final total = _valor(
      'total_pedidos',
      0,
    );

    final emitidos = _valor(
      'pedidos_emitidos',
      0,
    );

    final cancelados = _valor(
      'pedidos_cancelados',
      0,
    );

    final valorEmitidos = _valor(
      'valor_pedidos_emitidos',
      0,
    );

    return _buildBox(
      titulo: 'Resumo de pedidos',
      subtitulo:
          'Situação atual dos pedidos.',
      icon:
          Icons.receipt_long_outlined,
      iconColor:
          const Color(0xff2563eb),
      child: Column(
        children: [
          _buildResumoLinha(
            'Total de pedidos',
            '$total',
            Icons.receipt_long_outlined,
            const Color(0xff2563eb),
          ),

          _buildResumoLinha(
            'Pedidos emitidos',
            '$emitidos',
            Icons.check_circle_outline,
            const Color(0xff16a34a),
          ),

          _buildResumoLinha(
            'Pedidos cancelados',
            '$cancelados',
            Icons.cancel_outlined,
            const Color(0xffdc2626),
          ),

          _buildResumoLinha(
            'Valor dos pedidos emitidos',
            'R\$ ${_formatarValor(valorEmitidos)}',
            Icons.attach_money_rounded,
            const Color(0xff7c3aed),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // LINHA DO RESUMO
  // ============================================================

  Widget _buildResumoLinha(
    String titulo,
    String valor,
    IconData icon,
    Color color,
  ) {
    return Container(
      padding:
          const EdgeInsets.symmetric(
        vertical: 13,
      ),
      child: Row(
        children: [
          Icon(
            icon,
            color: color,
            size: 22,
          ),

          const SizedBox(width: 12),

          Expanded(
            child: Text(
              titulo,
              style: const TextStyle(
                color:
                    Color(0xff475569),
                fontWeight:
                    FontWeight.w600,
              ),
            ),
          ),

          const SizedBox(width: 10),

          Text(
            valor,
            style: TextStyle(
              color: color,
              fontSize: 18,
              fontWeight:
                  FontWeight.w800,
            ),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // ÚLTIMOS PEDIDOS
  // ============================================================

  Widget _buildUltimosPedidos() {
    final pedidos = _valor(
      'ultimos_pedidos',
      [],
    );

    final lista =
        pedidos is List ? pedidos : [];

    return _buildBox(
      titulo: 'Últimos pedidos',
      subtitulo:
          'Pedidos registrados recentemente.',
      icon:
          Icons.history_rounded,
      iconColor:
          const Color(0xff7c3aed),
      child: lista.isEmpty
          ? _buildVazio(
              'Nenhum pedido encontrado.',
            )
          : Column(
              children: lista
                  .take(8)
                  .map(
                    (pedido) =>
                        _buildPedido(
                      pedido,
                    ),
                  )
                  .toList(),
            ),
    );
  }

  // ============================================================
  // PEDIDO
  // ============================================================

  Widget _buildPedido(
    dynamic pedido,
  ) {
    final numero = pedido is Map
        ? pedido['numero'] ??
            pedido['id'] ??
            '#'
        : '#';

    final status = pedido is Map
        ? pedido['status'] ?? ''
        : '';

    final valor = pedido is Map
        ? pedido['valor_total'] ?? 0
        : 0;

    final statusNormalizado =
        status.toString().toLowerCase();

    final emitido =
        statusNormalizado == 'emitido';

    final cancelado =
        statusNormalizado == 'cancelado';

    String textoStatus;

    if (emitido) {
      textoStatus = 'Emitido';
    } else if (cancelado) {
      textoStatus = 'Cancelado';
    } else {
      textoStatus =
          status.toString().isEmpty
              ? 'Pendente'
              : status.toString();
    }

    final statusColor = emitido
        ? const Color(0xff166534)
        : cancelado
            ? const Color(0xff991b1b)
            : const Color(0xff92400e);

    final statusBackground = emitido
        ? const Color(0xffdcfce7)
        : cancelado
            ? const Color(0xffffe2e2)
            : const Color(0xfffff3c7);

    return Container(
      padding:
          const EdgeInsets.symmetric(
        vertical: 13,
      ),
      decoration:
          const BoxDecoration(
        border: Border(
          bottom: BorderSide(
            color: Color(0xfff1f5f9),
          ),
        ),
      ),
      child: Row(
        children: [
          Container(
            width: 40,
            height: 40,
            decoration: BoxDecoration(
              color:
                  const Color(0xfff1f5f9),
              borderRadius:
                  BorderRadius.circular(10),
            ),
            child: const Icon(
              Icons.receipt_long_outlined,
              color:
                  Color(0xff475569),
              size: 20,
            ),
          ),

          const SizedBox(width: 12),

          Expanded(
            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment.start,
              children: [
                Text(
                  'Pedido $numero',
                  style: const TextStyle(
                    fontWeight:
                        FontWeight.w700,
                    color:
                        Color(0xff111827),
                  ),
                ),

                const SizedBox(height: 3),

                Text(
                  'R\$ ${_formatarValor(valor)}',
                  style:
                      const TextStyle(
                    color:
                        Color(0xff64748b),
                    fontSize: 12,
                  ),
                ),
              ],
            ),
          ),

          Container(
            padding:
                const EdgeInsets.symmetric(
              horizontal: 10,
              vertical: 6,
            ),
            decoration: BoxDecoration(
              color: statusBackground,
              borderRadius:
                  BorderRadius.circular(20),
            ),
            child: Text(
              textoStatus,
              style: TextStyle(
                color: statusColor,
                fontSize: 11,
                fontWeight:
                    FontWeight.w800,
              ),
            ),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // BOX
  // ============================================================

  Widget _buildBox({
    required String titulo,
    required String subtitulo,
    required IconData icon,
    required Color iconColor,
    required Widget child,
  }) {
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius:
            BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color:
                Colors.black.withOpacity(.045),
            blurRadius: 14,
            offset:
                const Offset(0, 5),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment:
            CrossAxisAlignment.start,
        children: [
          Padding(
            padding:
                const EdgeInsets.all(20),
            child: Row(
              children: [
                Container(
                  width: 42,
                  height: 42,
                  decoration:
                      BoxDecoration(
                    color:
                        iconColor.withOpacity(
                      .10,
                    ),
                    borderRadius:
                        BorderRadius.circular(
                      11,
                    ),
                  ),
                  child: Icon(
                    icon,
                    color: iconColor,
                    size: 22,
                  ),
                ),

                const SizedBox(width: 12),

                Expanded(
                  child: Column(
                    crossAxisAlignment:
                        CrossAxisAlignment.start,
                    children: [
                      Text(
                        titulo,
                        style:
                            const TextStyle(
                          fontSize: 17,
                          fontWeight:
                              FontWeight
                                  .w800,
                          color:
                              Color(0xff111827),
                        ),
                      ),

                      const SizedBox(height: 3),

                      Text(
                        subtitulo,
                        style:
                            const TextStyle(
                          fontSize: 12,
                          color:
                              Color(0xff64748b),
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),

          const Divider(
            height: 1,
            color: Color(0xfff1f5f9),
          ),

          Padding(
            padding:
                const EdgeInsets.symmetric(
              horizontal: 20,
              vertical: 4,
            ),
            child: child,
          ),
        ],
      ),
    );
  }

  // ============================================================
  // VAZIO
  // ============================================================

  Widget _buildVazio(
    String texto,
  ) {
    return Padding(
      padding:
          const EdgeInsets.symmetric(
        vertical: 30,
      ),
      child: Center(
        child: Column(
          children: [
            const Icon(
              Icons.inbox_outlined,
              size: 42,
              color:
                  Color(0xffcbd5e1),
            ),

            const SizedBox(height: 10),

            Text(
              texto,
              textAlign:
                  TextAlign.center,
              style:
                  const TextStyle(
                color:
                    Color(0xff94a3b8),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // ============================================================
  // ERRO
  // ============================================================

  Widget _buildErro() {
    return ListView(
      physics:
          const AlwaysScrollableScrollPhysics(),
      padding:
          const EdgeInsets.all(24),
      children: [
        const SizedBox(height: 100),

        const Icon(
          Icons.cloud_off_rounded,
          size: 65,
          color:
              Color(0xffdc2626),
        ),

        const SizedBox(height: 20),

        const Text(
          'Não foi possível carregar o dashboard',
          textAlign:
              TextAlign.center,
          style: TextStyle(
            fontSize: 18,
            fontWeight:
                FontWeight.w800,
          ),
        ),

        const SizedBox(height: 8),

        Text(
          _erro ??
              'Erro desconhecido.',
          textAlign:
              TextAlign.center,
          style:
              const TextStyle(
            color: Colors.grey,
          ),
        ),

        const SizedBox(height: 20),

        Center(
          child:
              ElevatedButton.icon(
            onPressed:
                _carregarDashboard,
            icon: const Icon(
              Icons.refresh,
            ),
            label: const Text(
              'Tentar novamente',
            ),
          ),
        ),
      ],
    );
  }

  // ============================================================
  // DRAWER
  // ============================================================

  Widget _buildDrawer() {
    return Drawer(
      child: SafeArea(
        child: Column(
          children: [
            Container(
              width: double.infinity,
              padding:
                  const EdgeInsets.all(24),
              decoration:
                  const BoxDecoration(
                color:
                    Color(0xff2563eb),
              ),
              child: const Column(
                crossAxisAlignment:
                    CrossAxisAlignment.start,
                children: [
                  Icon(
                    Icons
                        .inventory_2_outlined,
                    color:
                        Colors.white,
                    size: 42,
                  ),

                  SizedBox(height: 15),

                  Text(
                    'SmartCatalog',
                    style:
                        TextStyle(
                      color:
                          Colors.white,
                      fontSize: 22,
                      fontWeight:
                          FontWeight
                              .w800,
                    ),
                  ),

                  SizedBox(height: 3),

                  Text(
                    'Painel administrativo',
                    style:
                        TextStyle(
                      color:
                          Colors.white70,
                    ),
                  ),
                ],
              ),
            ),

            const SizedBox(height: 10),

            _drawerItem(
              icon:
                  Icons.dashboard_outlined,
              titulo:
                  'Dashboard',
              selecionado:
                  true,
              onTap: () {
                Navigator.pop(context);
              },
            ),

            _drawerItem(
              icon:
                  Icons.inventory_2_outlined,
              titulo:
                  'Produtos',
              onTap: () {
                Navigator.pop(context);

                Navigator.pushNamed(
                  context,
                  '/produtos',
                );
              },
            ),

            _drawerItem(
              icon:
                  Icons.category_outlined,
              titulo:
                  'Categorias',
              onTap: () {
                Navigator.pop(context);

                Navigator.pushNamed(
                  context,
                  '/categorias',
                );
              },
            ),

            _drawerItem(
              icon:
                  Icons.warehouse_outlined,
              titulo:
                  'Estoque',
              onTap: () {
                Navigator.pop(context);

                Navigator.pushNamed(
                  context,
                  '/estoque',
                );
              },
            ),

            _drawerItem(
              icon:
                  Icons.receipt_long_outlined,
              titulo:
                  'Pedidos',
              onTap: () {
                Navigator.pop(context);

                Navigator.pushNamed(
                  context,
                  '/pedidos',
                );
              },
            ),

            _drawerItem(
              icon:
                  Icons.bar_chart_outlined,
              titulo:
                  'Relatórios',
              onTap: () {
                Navigator.pop(context);

                Navigator.pushNamed(
                  context,
                  '/relatorios',
                );
              },
            ),

            const Spacer(),

            const Divider(),

            _drawerItem(
              icon:
                  Icons.logout_rounded,
              titulo:
                  'Sair',
              color:
                  const Color(0xffdc2626),
              onTap:
                  _logout,
            ),

            const SizedBox(height: 10),
          ],
        ),
      ),
    );
  }

  // ============================================================
  // ITEM DO DRAWER
  // ============================================================

  Widget _drawerItem({
    required IconData icon,
    required String titulo,
    required VoidCallback onTap,
    bool selecionado = false,
    Color? color,
  }) {
    final itemColor = color ??
        (selecionado
            ? const Color(0xff2563eb)
            : const Color(0xff475569));

    return Padding(
      padding:
          const EdgeInsets.symmetric(
        horizontal: 10,
        vertical: 2,
      ),
      child: ListTile(
        onTap: onTap,
        shape:
            RoundedRectangleBorder(
          borderRadius:
              BorderRadius.circular(10),
        ),
        tileColor: selecionado
            ? const Color(0xffeff6ff)
            : null,
        leading: Icon(
          icon,
          color: itemColor,
        ),
        title: Text(
          titulo,
          style: TextStyle(
            color: itemColor,
            fontWeight: selecionado
                ? FontWeight.w800
                : FontWeight.w600,
          ),
        ),
      ),
    );
  }

  // ============================================================
  // FORMATAR VALOR
  // ============================================================

  String _formatarValor(
    dynamic valor,
  ) {
    final numero =
        double.tryParse(
              valor.toString(),
            ) ??
            0;

    return numero
        .toStringAsFixed(2)
        .replaceAll('.', ',');
  }
}