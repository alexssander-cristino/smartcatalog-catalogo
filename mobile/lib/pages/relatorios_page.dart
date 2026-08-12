import 'package:flutter/material.dart';

import '../services/api_service.dart';

class RelatoriosPage extends StatefulWidget {
  const RelatoriosPage({super.key});

  @override
  State<RelatoriosPage> createState() =>
      _RelatoriosPageState();
}

class _RelatoriosPageState
    extends State<RelatoriosPage> {
  bool _carregando = true;
  String? _erro;

  Map<String, dynamic> _dados = {};

  @override
  void initState() {
    super.initState();
    _carregarRelatorio();
  }

  // ============================================================
  // CARREGAR
  // ============================================================

  Future<void> _carregarRelatorio() async {
    setState(() {
      _carregando = true;
      _erro = null;
    });

    try {
      final resposta =
          await ApiService.getRelatorios();

      if (!mounted) return;

      setState(() {
        _dados = resposta;
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
  // VALOR
  // ============================================================

  dynamic _valor(
    String chave, [
    dynamic padrao = 0,
  ]) {
    if (_dados.containsKey(chave)) {
      return _dados[chave];
    }

    if (_dados['data'] is Map) {
      final data = _dados['data'];

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
      backgroundColor:
          const Color(0xfff5f7fb),
      appBar: AppBar(
        elevation: 0,
        backgroundColor: Colors.white,
        foregroundColor:
            const Color(0xff111827),
        title: const Text(
          'Relatórios',
          style: TextStyle(
            fontWeight: FontWeight.w800,
          ),
        ),
        actions: [
          IconButton(
            onPressed: _carregarRelatorio,
            icon: const Icon(
              Icons.refresh_rounded,
            ),
          ),
        ],
      ),
      body: _buildBody(),
    );
  }

  // ============================================================
  // BODY
  // ============================================================

  Widget _buildBody() {
    if (_carregando) {
      return const Center(
        child: CircularProgressIndicator(),
      );
    }

    if (_erro != null) {
      return _buildErro();
    }

    return RefreshIndicator(
      onRefresh: _carregarRelatorio,
      child: SingleChildScrollView(
        physics:
            const AlwaysScrollableScrollPhysics(),
        padding: const EdgeInsets.all(20),
        child: Center(
          child: ConstrainedBox(
            constraints:
                const BoxConstraints(
              maxWidth: 1200,
            ),
            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment.start,
              children: [
                _buildCabecalho(),

                const SizedBox(height: 20),

                _buildIndicadores(),

                const SizedBox(height: 20),

                _buildEstoque(),

                const SizedBox(height: 20),

                _buildPedidos(),

                const SizedBox(height: 30),
              ],
            ),
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
            Color(0xff7c3aed),
            Color(0xff5b21b6),
          ],
        ),
        borderRadius:
            BorderRadius.circular(18),
      ),
      child: const Column(
        crossAxisAlignment:
            CrossAxisAlignment.start,
        children: [
          Icon(
            Icons.bar_chart_rounded,
            color: Colors.white,
            size: 38,
          ),
          SizedBox(height: 12),
          Text(
            'Relatórios',
            style: TextStyle(
              color: Colors.white,
              fontSize: 26,
              fontWeight: FontWeight.w800,
            ),
          ),
          SizedBox(height: 5),
          Text(
            'Acompanhe os principais indicadores do sistema.',
            style: TextStyle(
              color: Colors.white70,
              fontSize: 13,
            ),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // INDICADORES
  // ============================================================

  Widget _buildIndicadores() {
    final produtos =
        _valor('total_produtos');

    final ativos =
        _valor('produtos_ativos');

    final categorias =
        _valor('total_categorias');

    final pedidos =
        _valor('total_pedidos');

    return LayoutBuilder(
      builder: (
        context,
        constraints,
      ) {
        int colunas = 1;

        if (constraints.maxWidth >= 950) {
          colunas = 4;
        } else if (constraints.maxWidth >= 600) {
          colunas = 2;
        }

        return GridView.count(
          crossAxisCount: colunas,
          shrinkWrap: true,
          physics:
              const NeverScrollableScrollPhysics(),
          crossAxisSpacing: 15,
          mainAxisSpacing: 15,
          childAspectRatio:
              colunas == 1 ? 3 : 1.5,
          children: [
            _indicador(
              'Produtos',
              '$produtos',
              Icons.inventory_2_outlined,
              const Color(0xff2563eb),
            ),

            _indicador(
              'Produtos ativos',
              '$ativos',
              Icons.check_circle_outline,
              const Color(0xff16a34a),
            ),

            _indicador(
              'Categorias',
              '$categorias',
              Icons.category_outlined,
              const Color(0xff7c3aed),
            ),

            _indicador(
              'Pedidos',
              '$pedidos',
              Icons.receipt_long_outlined,
              const Color(0xfff59e0b),
            ),
          ],
        );
      },
    );
  }

  Widget _indicador(
    String titulo,
    String valor,
    IconData icon,
    Color color,
  ) {
    return Container(
      padding: const EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius:
            BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color:
                Colors.black.withOpacity(.04),
            blurRadius: 12,
            offset: const Offset(0, 5),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 48,
            height: 48,
            decoration: BoxDecoration(
              color:
                  color.withOpacity(.10),
              borderRadius:
                  BorderRadius.circular(12),
            ),
            child: Icon(
              icon,
              color: color,
            ),
          ),

          const SizedBox(width: 12),

          Expanded(
            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment.start,
              mainAxisAlignment:
                  MainAxisAlignment.center,
              children: [
                Text(
                  titulo,
                  style:
                      const TextStyle(
                    color:
                        Color(0xff64748b),
                    fontSize: 12,
                    fontWeight:
                        FontWeight.w600,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  valor,
                  style:
                      const TextStyle(
                    fontSize: 23,
                    fontWeight:
                        FontWeight.w800,
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
  // ESTOQUE
  // ============================================================

  Widget _buildEstoque() {
    final estoque =
        _valor('estoque_total');

    final baixo =
        _valor('estoque_baixo');

    return _buildBox(
      titulo: 'Relatório de estoque',
      icon: Icons.warehouse_outlined,
      color: const Color(0xff16a34a),
      child: Column(
        children: [
          _linha(
            'Total de unidades',
            '$estoque',
            Icons.inventory_2_outlined,
            const Color(0xff16a34a),
          ),

          _linha(
            'Produtos com estoque baixo',
            '$baixo',
            Icons.warning_amber_rounded,
            const Color(0xffdc2626),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // PEDIDOS
  // ============================================================

  Widget _buildPedidos() {
    final total =
        _valor('total_pedidos');

    final emitidos =
        _valor('pedidos_emitidos');

    final cancelados =
        _valor('pedidos_cancelados');

    final valor =
        _valor('valor_pedidos_emitidos');

    return _buildBox(
      titulo: 'Relatório de pedidos',
      icon:
          Icons.receipt_long_outlined,
      color:
          const Color(0xff2563eb),
      child: Column(
        children: [
          _linha(
            'Total de pedidos',
            '$total',
            Icons.receipt_long_outlined,
            const Color(0xff2563eb),
          ),

          _linha(
            'Pedidos emitidos',
            '$emitidos',
            Icons.check_circle_outline,
            const Color(0xff16a34a),
          ),

          _linha(
            'Pedidos cancelados',
            '$cancelados',
            Icons.cancel_outlined,
            const Color(0xffdc2626),
          ),

          _linha(
            'Valor dos pedidos emitidos',
            'R\$ ${_formatarValor(valor)}',
            Icons.attach_money_rounded,
            const Color(0xff7c3aed),
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
    required IconData icon,
    required Color color,
    required Widget child,
  }) {
    return Container(
      width: double.infinity,
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius:
            BorderRadius.circular(16),
      ),
      child: Column(
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
                        color.withOpacity(.10),
                    borderRadius:
                        BorderRadius.circular(
                      11,
                    ),
                  ),
                  child: Icon(
                    icon,
                    color: color,
                  ),
                ),

                const SizedBox(width: 12),

                Text(
                  titulo,
                  style:
                      const TextStyle(
                    fontSize: 17,
                    fontWeight:
                        FontWeight.w800,
                  ),
                ),
              ],
            ),
          ),

          const Divider(
            height: 1,
          ),

          Padding(
            padding:
                const EdgeInsets.symmetric(
              horizontal: 20,
              vertical: 5,
            ),
            child: child,
          ),
        ],
      ),
    );
  }

  // ============================================================
  // LINHA
  // ============================================================

  Widget _linha(
    String titulo,
    String valor,
    IconData icon,
    Color color,
  ) {
    return Padding(
      padding:
          const EdgeInsets.symmetric(
        vertical: 15,
      ),
      child: Row(
        children: [
          Icon(
            icon,
            color: color,
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

          Text(
            valor,
            style: TextStyle(
              color: color,
              fontSize: 17,
              fontWeight:
                  FontWeight.w800,
            ),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // ERRO
  // ============================================================

  Widget _buildErro() {
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(30),
        child: Column(
          mainAxisSize:
              MainAxisSize.min,
          children: [
            const Icon(
              Icons.cloud_off_rounded,
              size: 60,
              color:
                  Color(0xffdc2626),
            ),

            const SizedBox(height: 15),

            const Text(
              'Erro ao carregar relatório',
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
                color:
                    Color(0xff64748b),
              ),
            ),

            const SizedBox(height: 20),

            ElevatedButton.icon(
              onPressed:
                  _carregarRelatorio,
              icon: const Icon(
                Icons.refresh,
              ),
              label: const Text(
                'Tentar novamente',
              ),
            ),
          ],
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