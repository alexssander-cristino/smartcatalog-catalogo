import 'package:flutter/material.dart';

import '../services/api_service.dart';

class PedidosPage extends StatefulWidget {
  const PedidosPage({super.key});

  @override
  State<PedidosPage> createState() => _PedidosPageState();
}

class _PedidosPageState extends State<PedidosPage> {
  bool _carregando = true;
  String? _erro;

  List<dynamic> _pedidos = [];

  String _filtro = 'todos';

  @override
  void initState() {
    super.initState();
    _carregarPedidos();
  }

  // ============================================================
  // CARREGAR
  // ============================================================

  Future<void> _carregarPedidos() async {
    setState(() {
      _carregando = true;
      _erro = null;
    });

    try {
      final pedidos = await ApiService.getPedidos();

      if (!mounted) return;

      setState(() {
        _pedidos = pedidos;
        _carregando = false;
      });
    } catch (e) {
      if (!mounted) return;

      setState(() {
        _erro = e.toString().replaceFirst(
              'Exception: ',
              '',
            );
        _carregando = false;
      });
    }
  }

  // ============================================================
  // NOVO PEDIDO
  // ============================================================

  Future<void> _novoPedido() async {
    final numeroController = TextEditingController();
    final valorController = TextEditingController();

    String status = 'emitido';
    bool salvando = false;

    final resultado = await showDialog<bool>(
      context: context,
      barrierDismissible: false,
      builder: (dialogContext) {
        return StatefulBuilder(
          builder: (
            context,
            setDialogState,
          ) {
            return AlertDialog(
              backgroundColor: Colors.white,
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(24),
              ),
              titlePadding: const EdgeInsets.fromLTRB(
                24,
                24,
                24,
                8,
              ),
              contentPadding: const EdgeInsets.fromLTRB(
                24,
                8,
                24,
                10,
              ),
              actionsPadding: const EdgeInsets.fromLTRB(
                24,
                8,
                24,
                20,
              ),
              title: Row(
                children: [
                  Container(
                    width: 44,
                    height: 44,
                    decoration: BoxDecoration(
                      color: const Color(0xffeff6ff),
                      borderRadius: BorderRadius.circular(13),
                    ),
                    child: const Icon(
                      Icons.add_shopping_cart_rounded,
                      color: Color(0xff2563eb),
                    ),
                  ),
                  const SizedBox(width: 12),
                  const Expanded(
                    child: Text(
                      'Novo pedido',
                      style: TextStyle(
                        fontSize: 21,
                        fontWeight: FontWeight.w800,
                        color: Color(0xff111827),
                      ),
                    ),
                  ),
                ],
              ),
              content: SingleChildScrollView(
                child: Column(
                  crossAxisAlignment:
                      CrossAxisAlignment.start,
                  children: [
                    const SizedBox(height: 10),

                    const Text(
                      'Cadastre as informações do pedido.',
                      style: TextStyle(
                        color: Color(0xff64748b),
                      ),
                    ),

                    const SizedBox(height: 22),

                    TextField(
                      controller: numeroController,
                      textInputAction:
                          TextInputAction.next,
                      decoration: InputDecoration(
                        labelText: 'Número do pedido',
                        hintText: 'Ex.: PED-001',
                        prefixIcon: const Icon(
                          Icons.tag_rounded,
                        ),
                        filled: true,
                        fillColor:
                            const Color(0xfff8fafc),
                        border: OutlineInputBorder(
                          borderRadius:
                              BorderRadius.circular(14),
                          borderSide: BorderSide.none,
                        ),
                      ),
                    ),

                    const SizedBox(height: 15),

                    TextField(
                      controller: valorController,
                      keyboardType:
                          const TextInputType.numberWithOptions(
                        decimal: true,
                      ),
                      decoration: InputDecoration(
                        labelText: 'Valor total',
                        hintText: '0,00',
                        prefixText: 'R\$ ',
                        prefixIcon: const Icon(
                          Icons.payments_outlined,
                        ),
                        filled: true,
                        fillColor:
                            const Color(0xfff8fafc),
                        border: OutlineInputBorder(
                          borderRadius:
                              BorderRadius.circular(14),
                          borderSide: BorderSide.none,
                        ),
                      ),
                    ),

                    const SizedBox(height: 15),

                    DropdownButtonFormField<String>(
                      value: status,
                      decoration: InputDecoration(
                        labelText: 'Status',
                        prefixIcon: const Icon(
                          Icons.flag_outlined,
                        ),
                        filled: true,
                        fillColor:
                            const Color(0xfff8fafc),
                        border: OutlineInputBorder(
                          borderRadius:
                              BorderRadius.circular(14),
                          borderSide: BorderSide.none,
                        ),
                      ),
                      items: const [
                        DropdownMenuItem(
                          value: 'emitido',
                          child: Text('Emitido'),
                        ),
                        DropdownMenuItem(
                          value: 'cancelado',
                          child: Text('Cancelado'),
                        ),
                      ],
                      onChanged: salvando
                          ? null
                          : (valor) {
                              if (valor == null) return;

                              setDialogState(() {
                                status = valor;
                              });
                            },
                    ),
                  ],
                ),
              ),
              actions: [
                TextButton(
                  onPressed: salvando
                      ? null
                      : () {
                          Navigator.pop(
                            dialogContext,
                            false,
                          );
                        },
                  child: const Text(
                    'Cancelar',
                    style: TextStyle(
                      color: Color(0xff64748b),
                      fontWeight: FontWeight.w700,
                    ),
                  ),
                ),
                ElevatedButton.icon(
                  style: ElevatedButton.styleFrom(
                    backgroundColor:
                        const Color(0xff2563eb),
                    foregroundColor: Colors.white,
                    padding: const EdgeInsets.symmetric(
                      horizontal: 18,
                      vertical: 13,
                    ),
                    shape: RoundedRectangleBorder(
                      borderRadius:
                          BorderRadius.circular(13),
                    ),
                  ),
                  onPressed: salvando
                      ? null
                      : () async {
                          final valorTexto =
                              valorController.text
                                  .trim()
                                  .replaceAll(',', '.');

                          final valor =
                              double.tryParse(
                            valorTexto,
                          );

                          if (valor == null ||
                              valor < 0) {
                            ScaffoldMessenger.of(
                              dialogContext,
                            ).showSnackBar(
                              const SnackBar(
                                content: Text(
                                  'Informe um valor válido.',
                                ),
                                backgroundColor:
                                    Color(0xffdc2626),
                              ),
                            );
                            return;
                          }

                          setDialogState(() {
                            salvando = true;
                          });

                          try {
                            await ApiService.criarPedido(
                              numero:
                                  numeroController.text,
                              status: status,
                              valorTotal: valor,
                            );

                            if (!mounted) return;

                            Navigator.pop(
                              dialogContext,
                              true,
                            );

                            _mostrarMensagem(
                              'Pedido criado com sucesso.',
                            );

                            _carregarPedidos();
                          } catch (e) {
                            if (!mounted) return;

                            setDialogState(() {
                              salvando = false;
                            });

                            ScaffoldMessenger.of(
                              dialogContext,
                            ).showSnackBar(
                              SnackBar(
                                content: Text(
                                  e.toString().replaceFirst(
                                        'Exception: ',
                                        '',
                                      ),
                                ),
                                backgroundColor:
                                    const Color(0xffdc2626),
                              ),
                            );
                          }
                        },
                  icon: salvando
                      ? const SizedBox(
                          width: 18,
                          height: 18,
                          child:
                              CircularProgressIndicator(
                            strokeWidth: 2,
                            color: Colors.white,
                          ),
                        )
                      : const Icon(
                          Icons.check_rounded,
                        ),
                  label: Text(
                    salvando
                        ? 'Salvando...'
                        : 'Criar pedido',
                  ),
                ),
              ],
            );
          },
        );
      },
    );

    numeroController.dispose();
    valorController.dispose();

    if (resultado == true) {
      await _carregarPedidos();
    }
  }

  // ============================================================
  // FILTRO
  // ============================================================

  List<dynamic> get _pedidosFiltrados {
    if (_filtro == 'todos') {
      return _pedidos;
    }

    return _pedidos.where((pedido) {
      if (pedido is! Map) return false;

      final status =
          (pedido['status'] ?? '')
              .toString()
              .toLowerCase();

      return status == _filtro;
    }).toList();
  }

  // ============================================================
  // RESUMOS
  // ============================================================

  int get _totalPedidos {
    return _pedidos.length;
  }

  int get _totalEmitidos {
    return _pedidos.where((pedido) {
      if (pedido is! Map) return false;

      return (pedido['status'] ?? '')
              .toString()
              .toLowerCase() ==
          'emitido';
    }).length;
  }

  int get _totalCancelados {
    return _pedidos.where((pedido) {
      if (pedido is! Map) return false;

      return (pedido['status'] ?? '')
              .toString()
              .toLowerCase() ==
          'cancelado';
    }).length;
  }

  double get _valorTotal {
    double total = 0;

    for (final pedido in _pedidos) {
      if (pedido is! Map) continue;

      total += double.tryParse(
            pedido['valor_total']
                    ?.toString() ??
                '0',
          ) ??
          0;
    }

    return total;
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
          'Pedidos',
          style: TextStyle(
            fontWeight: FontWeight.w800,
          ),
        ),
        actions: [
          IconButton(
            tooltip: 'Atualizar',
            onPressed: _carregarPedidos,
            icon: const Icon(
              Icons.refresh_rounded,
            ),
          ),
          const SizedBox(width: 8),
        ],
      ),
      floatingActionButton:
          FloatingActionButton.extended(
        backgroundColor:
            const Color(0xff2563eb),
        foregroundColor: Colors.white,
        elevation: 5,
        onPressed: _novoPedido,
        icon: const Icon(
          Icons.add_rounded,
        ),
        label: const Text(
          'Novo pedido',
          style: TextStyle(
            fontWeight: FontWeight.w800,
          ),
        ),
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
      onRefresh: _carregarPedidos,
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

                const SizedBox(height: 18),

                _buildResumo(),

                const SizedBox(height: 20),

                _buildFiltros(),

                const SizedBox(height: 20),

                _buildLista(),

                const SizedBox(height: 100),
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
      padding: const EdgeInsets.all(25),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [
            Color(0xff2563eb),
            Color(0xff1d4ed8),
          ],
        ),
        borderRadius:
            BorderRadius.circular(22),
        boxShadow: [
          BoxShadow(
            color: const Color(0xff2563eb)
                .withOpacity(.18),
            blurRadius: 20,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 60,
            height: 60,
            decoration: BoxDecoration(
              color: Colors.white
                  .withOpacity(.15),
              borderRadius:
                  BorderRadius.circular(17),
            ),
            child: const Icon(
              Icons.receipt_long_rounded,
              color: Colors.white,
              size: 32,
            ),
          ),
          const SizedBox(width: 16),
          const Expanded(
            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment.start,
              children: [
                Text(
                  'Pedidos',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 26,
                    fontWeight:
                        FontWeight.w800,
                  ),
                ),
                SizedBox(height: 5),
                Text(
                  'Gerencie os pedidos da loja.',
                  style: TextStyle(
                    color: Colors.white70,
                    fontSize: 13,
                  ),
                ),
              ],
            ),
          ),
          if (MediaQuery.of(context)
              .size
              .width >
              600)
            ElevatedButton.icon(
              onPressed: _novoPedido,
              style: ElevatedButton.styleFrom(
                backgroundColor:
                    Colors.white,
                foregroundColor:
                    const Color(0xff2563eb),
                elevation: 0,
                padding:
                    const EdgeInsets.symmetric(
                  horizontal: 18,
                  vertical: 14,
                ),
                shape:
                    RoundedRectangleBorder(
                  borderRadius:
                      BorderRadius.circular(13),
                ),
              ),
              icon: const Icon(
                Icons.add_rounded,
              ),
              label: const Text(
                'Novo pedido',
                style: TextStyle(
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
  // RESUMO
  // ============================================================

  Widget _buildResumo() {
    return LayoutBuilder(
      builder: (context, constraints) {
        final largura =
            constraints.maxWidth;

        final duasColunas =
            largura > 600;

        final cards = [
          _resumoCard(
            'Pedidos',
            '$_totalPedidos',
            Icons.receipt_long_outlined,
            const Color(0xff2563eb),
          ),
          _resumoCard(
            'Emitidos',
            '$_totalEmitidos',
            Icons.check_circle_outline_rounded,
            const Color(0xff16a34a),
          ),
          _resumoCard(
            'Cancelados',
            '$_totalCancelados',
            Icons.cancel_outlined,
            const Color(0xffdc2626),
          ),
          _resumoCard(
            'Valor total',
            'R\$ ${_formatarValor(_valorTotal)}',
            Icons.payments_outlined,
            const Color(0xff7c3aed),
          ),
        ];

        if (duasColunas) {
          return Row(
            children: [
              for (int i = 0;
                  i < cards.length;
                  i++) ...[
                Expanded(
                  child: cards[i],
                ),
                if (i != cards.length - 1)
                  const SizedBox(
                    width: 12,
                  ),
              ],
            ],
          );
        }

        return Wrap(
          spacing: 12,
          runSpacing: 12,
          children: cards
              .map(
                (card) => SizedBox(
                  width:
                      (largura - 12) / 2,
                  child: card,
                ),
              )
              .toList(),
        );
      },
    );
  }

  Widget _resumoCard(
    String titulo,
    String valor,
    IconData icone,
    Color cor,
  ) {
    return Container(
      padding:
          const EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius:
            BorderRadius.circular(18),
        boxShadow: [
          BoxShadow(
            color:
                Colors.black.withOpacity(.035),
            blurRadius: 12,
            offset:
                const Offset(0, 4),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 45,
            height: 45,
            decoration: BoxDecoration(
              color: cor.withOpacity(.10),
              borderRadius:
                  BorderRadius.circular(13),
            ),
            child: Icon(
              icone,
              color: cor,
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
                  style: const TextStyle(
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
                  overflow:
                      TextOverflow.ellipsis,
                  style: const TextStyle(
                    fontSize: 19,
                    fontWeight:
                        FontWeight.w800,
                    color:
                        Color(0xff111827),
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
  // FILTROS
  // ============================================================

  Widget _buildFiltros() {
    return Container(
      padding: const EdgeInsets.all(6),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius:
            BorderRadius.circular(16),
      ),
      child: SingleChildScrollView(
        scrollDirection:
            Axis.horizontal,
        child: Row(
          children: [
            _filtroButton(
              'Todos',
              'todos',
            ),
            _filtroButton(
              'Emitidos',
              'emitido',
            ),
            _filtroButton(
              'Cancelados',
              'cancelado',
            ),
          ],
        ),
      ),
    );
  }

  Widget _filtroButton(
    String titulo,
    String valor,
  ) {
    final selecionado =
        _filtro == valor;

    return Padding(
      padding:
          const EdgeInsets.symmetric(
        horizontal: 3,
      ),
      child: ChoiceChip(
        label: Text(
          titulo,
          style: TextStyle(
            fontWeight:
                selecionado
                    ? FontWeight.w800
                    : FontWeight.w600,
            color: selecionado
                ? Colors.white
                : const Color(
                    0xff64748b,
                  ),
          ),
        ),
        selected: selecionado,
        selectedColor:
            const Color(0xff2563eb),
        backgroundColor:
            Colors.transparent,
        showCheckmark: false,
        onSelected: (_) {
          setState(() {
            _filtro = valor;
          });
        },
      ),
    );
  }

  // ============================================================
  // LISTA
  // ============================================================

  Widget _buildLista() {
    final lista =
        _pedidosFiltrados;

    if (lista.isEmpty) {
      return _buildVazio();
    }

    return Container(
      width: double.infinity,
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius:
            BorderRadius.circular(18),
        boxShadow: [
          BoxShadow(
            color:
                Colors.black.withOpacity(.035),
            blurRadius: 14,
            offset:
                const Offset(0, 5),
          ),
        ],
      ),
      child: Column(
        children: [
          Padding(
            padding:
                const EdgeInsets.all(20),
            child: Row(
              children: [
                Container(
                  width: 40,
                  height: 40,
                  decoration: BoxDecoration(
                    color:
                        const Color(0xffeff6ff),
                    borderRadius:
                        BorderRadius.circular(
                      12,
                    ),
                  ),
                  child: const Icon(
                    Icons.list_alt_rounded,
                    color:
                        Color(0xff2563eb),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Text(
                    '${lista.length} pedido(s)',
                    style:
                        const TextStyle(
                      fontSize: 17,
                      fontWeight:
                          FontWeight.w800,
                    ),
                  ),
                ),
              ],
            ),
          ),
          const Divider(
            height: 1,
          ),
          ...lista.map(
            (pedido) =>
                _buildPedido(pedido),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // PEDIDO
  // ============================================================

  Widget _buildPedido(
    dynamic pedido,
  ) {
    if (pedido is! Map) {
      return const SizedBox();
    }

    final id =
        pedido['id'] ?? '-';

    final numero =
        pedido['numero'] ?? id;

    final status =
        (pedido['status'] ??
                'emitido')
            .toString()
            .toLowerCase();

    final valor =
        pedido['valor_total'] ?? 0;

    final statusInfo =
        _statusInfo(status);

    return InkWell(
      onTap: () {
        _mostrarDetalhes(
          pedido,
        );
      },
      child: Container(
        padding:
            const EdgeInsets.all(18),
        decoration:
            const BoxDecoration(
          border: Border(
            bottom: BorderSide(
              color:
                  Color(0xfff1f5f9),
            ),
          ),
        ),
        child: Row(
          children: [
            Container(
              width: 50,
              height: 50,
              decoration:
                  BoxDecoration(
                color:
                    statusInfo[
                        'background'],
                borderRadius:
                    BorderRadius.circular(
                  14,
                ),
              ),
              child: Icon(
                status == 'cancelado'
                    ? Icons
                        .cancel_outlined
                    : Icons
                        .receipt_long_outlined,
                color:
                    statusInfo['color'],
              ),
            ),

            const SizedBox(
              width: 14,
            ),

            Expanded(
              child: Column(
                crossAxisAlignment:
                    CrossAxisAlignment
                        .start,
                children: [
                  Text(
                    'Pedido #$numero',
                    style:
                        const TextStyle(
                      fontSize: 15,
                      fontWeight:
                          FontWeight.w800,
                      color:
                          Color(0xff111827),
                    ),
                  ),
                  const SizedBox(
                    height: 5,
                  ),
                  Text(
                    'ID: $id',
                    style:
                        const TextStyle(
                      color:
                          Color(0xff94a3b8),
                      fontSize: 11,
                    ),
                  ),
                ],
              ),
            ),

            Column(
              crossAxisAlignment:
                  CrossAxisAlignment.end,
              children: [
                Text(
                  'R\$ ${_formatarValor(valor)}',
                  style:
                      const TextStyle(
                    fontSize: 15,
                    fontWeight:
                        FontWeight.w800,
                    color:
                        Color(0xff111827),
                  ),
                ),
                const SizedBox(
                  height: 6,
                ),
                Container(
                  padding:
                      const EdgeInsets
                          .symmetric(
                    horizontal: 9,
                    vertical: 5,
                  ),
                  decoration:
                      BoxDecoration(
                    color: statusInfo[
                        'background'],
                    borderRadius:
                        BorderRadius
                            .circular(
                      20,
                    ),
                  ),
                  child: Text(
                    statusInfo[
                        'texto'],
                    style: TextStyle(
                      color:
                          statusInfo[
                              'color'],
                      fontSize: 10,
                      fontWeight:
                          FontWeight.w800,
                    ),
                  ),
                ),
              ],
            ),

            const SizedBox(
              width: 8,
            ),

            const Icon(
              Icons
                  .chevron_right_rounded,
              color:
                  Color(0xff94a3b8),
            ),
          ],
        ),
      ),
    );
  }

  // ============================================================
  // STATUS
  // ============================================================

  Map<String, dynamic> _statusInfo(
    String status,
  ) {
    switch (status) {
      case 'emitido':
        return {
          'texto': 'Emitido',
          'color':
              const Color(0xff166534),
          'background':
              const Color(0xffdcfce7),
        };

      case 'cancelado':
        return {
          'texto': 'Cancelado',
          'color':
              const Color(0xff991b1b),
          'background':
              const Color(0xffffe2e2),
        };

      default:
        return {
          'texto': 'Emitido',
          'color':
              const Color(0xff166534),
          'background':
              const Color(0xffdcfce7),
        };
    }
  }

  // ============================================================
  // DETALHES
  // ============================================================

  void _mostrarDetalhes(
    dynamic pedido,
  ) {
    if (pedido is! Map) {
      return;
    }

    final numero =
        pedido['numero'] ??
            pedido['id'] ??
            '-';

    final status =
        pedido['status'] ??
            'emitido';

    final valor =
        pedido['valor_total'] ??
            0;

    final criado =
        pedido['created_at'] ??
            '-';

    final statusInfo =
        _statusInfo(
      status.toString(),
    );

    showModalBottomSheet(
      context: context,
      showDragHandle: true,
      backgroundColor:
          Colors.white,
      shape:
          const RoundedRectangleBorder(
        borderRadius:
            BorderRadius.vertical(
          top: Radius.circular(25),
        ),
      ),
      builder: (_) {
        return SafeArea(
          child: Padding(
            padding:
                const EdgeInsets.fromLTRB(
              24,
              8,
              24,
              25,
            ),
            child: Column(
              mainAxisSize:
                  MainAxisSize.min,
              crossAxisAlignment:
                  CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Container(
                      width: 48,
                      height: 48,
                      decoration:
                          BoxDecoration(
                        color:
                            const Color(
                          0xffeff6ff,
                        ),
                        borderRadius:
                            BorderRadius
                                .circular(
                          14,
                        ),
                      ),
                      child:
                          const Icon(
                        Icons
                            .receipt_long_rounded,
                        color:
                            Color(
                          0xff2563eb,
                        ),
                      ),
                    ),
                    const SizedBox(
                      width: 13,
                    ),
                    Expanded(
                      child: Text(
                        'Pedido #$numero',
                        style:
                            const TextStyle(
                          fontSize: 21,
                          fontWeight:
                              FontWeight.w800,
                        ),
                      ),
                    ),
                  ],
                ),

                const SizedBox(
                  height: 24,
                ),

                _detalhe(
                  'Status',
                  statusInfo[
                      'texto'],
                ),

                _detalhe(
                  'Valor total',
                  'R\$ ${_formatarValor(valor)}',
                ),

                _detalhe(
                  'Criado em',
                  criado.toString(),
                ),
              ],
            ),
          ),
        );
      },
    );
  }

  Widget _detalhe(
    String titulo,
    String valor,
  ) {
    return Container(
      padding:
          const EdgeInsets.symmetric(
        vertical: 12,
      ),
      decoration:
          const BoxDecoration(
        border: Border(
          bottom: BorderSide(
            color:
                Color(0xfff1f5f9),
          ),
        ),
      ),
      child: Row(
        children: [
          Text(
            titulo,
            style:
                const TextStyle(
              color:
                  Color(0xff64748b),
              fontWeight:
                  FontWeight.w600,
            ),
          ),
          const Spacer(),
          Flexible(
            child: Text(
              valor,
              textAlign:
                  TextAlign.right,
              style:
                  const TextStyle(
                fontWeight:
                    FontWeight.w800,
                color:
                    Color(0xff111827),
              ),
            ),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // VAZIO
  // ============================================================

  Widget _buildVazio() {
    return Container(
      width: double.infinity,
      padding:
          const EdgeInsets.all(45),
      decoration:
          BoxDecoration(
        color: Colors.white,
        borderRadius:
            BorderRadius.circular(18),
      ),
      child: Column(
        children: [
          Container(
            width: 80,
            height: 80,
            decoration:
                BoxDecoration(
              color:
                  const Color(0xffeff6ff),
              borderRadius:
                  BorderRadius.circular(
                24,
              ),
            ),
            child: const Icon(
              Icons
                  .receipt_long_outlined,
              size: 40,
              color:
                  Color(0xff2563eb),
            ),
          ),
          const SizedBox(
            height: 18,
          ),
          const Text(
            'Nenhum pedido encontrado',
            style:
                TextStyle(
              fontSize: 18,
              fontWeight:
                  FontWeight.w800,
            ),
          ),
          const SizedBox(
            height: 7,
          ),
          const Text(
            'Comece criando o primeiro pedido.',
            textAlign:
                TextAlign.center,
            style:
                TextStyle(
              color:
                  Color(0xff64748b),
            ),
          ),
          const SizedBox(
            height: 20,
          ),
          ElevatedButton.icon(
            onPressed: _novoPedido,
            style:
                ElevatedButton.styleFrom(
              backgroundColor:
                  const Color(
                0xff2563eb,
              ),
              foregroundColor:
                  Colors.white,
              padding:
                  const EdgeInsets
                      .symmetric(
                horizontal: 20,
                vertical: 13,
              ),
              shape:
                  RoundedRectangleBorder(
                borderRadius:
                    BorderRadius.circular(
                  13,
                ),
              ),
            ),
            icon: const Icon(
              Icons.add_rounded,
            ),
            label: const Text(
              'Criar primeiro pedido',
              style:
                  TextStyle(
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
  // ERRO
  // ============================================================

  Widget _buildErro() {
    return Center(
      child: Padding(
        padding:
            const EdgeInsets.all(30),
        child: Column(
          mainAxisSize:
              MainAxisSize.min,
          children: [
            Container(
              width: 80,
              height: 80,
              decoration:
                  BoxDecoration(
                color:
                    const Color(
                  0xfffef2f2,
                ),
                borderRadius:
                    BorderRadius.circular(
                  24,
                ),
              ),
              child: const Icon(
                Icons.cloud_off_rounded,
                size: 40,
                color:
                    Color(0xffdc2626),
              ),
            ),

            const SizedBox(
              height: 18,
            ),

            const Text(
              'Erro ao carregar pedidos',
              style:
                  TextStyle(
                fontSize: 19,
                fontWeight:
                    FontWeight.w800,
              ),
            ),

            const SizedBox(
              height: 8,
            ),

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

            const SizedBox(
              height: 20,
            ),

            ElevatedButton.icon(
              onPressed:
                  _carregarPedidos,
              icon: const Icon(
                Icons.refresh_rounded,
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
  // MENSAGEM
  // ============================================================

  void _mostrarMensagem(
    String mensagem, {
    bool erro = false,
  }) {
    ScaffoldMessenger.of(
      context,
    ).showSnackBar(
      SnackBar(
        behavior:
            SnackBarBehavior.floating,
        margin:
            const EdgeInsets.all(16),
        shape:
            RoundedRectangleBorder(
          borderRadius:
              BorderRadius.circular(
            12,
          ),
        ),
        content: Text(
          mensagem,
        ),
        backgroundColor: erro
            ? const Color(
                0xffdc2626,
              )
            : const Color(
                0xff16a34a,
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
        .replaceAll(
          '.',
          ',',
        );
  }
}