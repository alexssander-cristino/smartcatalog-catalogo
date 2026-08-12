import 'package:flutter/material.dart';

import '../services/api_service.dart';

class EstoquePage extends StatefulWidget {
  const EstoquePage({super.key});

  @override
  State<EstoquePage> createState() => _EstoquePageState();
}

class _EstoquePageState extends State<EstoquePage> {
  bool _carregando = true;
  String? _erro;

  List<dynamic> _produtos = [];

  @override
  void initState() {
    super.initState();
    _carregar();
  }

  // ============================================================
  // CARREGAR PRODUTOS
  // ============================================================

  Future<void> _carregar() async {
    setState(() {
      _carregando = true;
      _erro = null;
    });

    try {
      final produtos = await ApiService.getProdutos();

      if (!mounted) return;

      setState(() {
        _produtos = produtos;
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
  // PEGAR ESTOQUE
  // ============================================================

  int _estoque(dynamic produto) {
    if (produto is! Map) {
      return 0;
    }

    return int.tryParse(
          produto['estoque']?.toString() ?? '0',
        ) ??
        0;
  }

  // ============================================================
  // ID DO PRODUTO
  // ============================================================

  int? _produtoId(dynamic produto) {
    if (produto is! Map) {
      return null;
    }

    return int.tryParse(
      produto['id']?.toString() ?? '',
    );
  }

  // ============================================================
  // TOTAL DE ESTOQUE
  // ============================================================

  int get _totalEstoque {
    return _produtos.fold(
      0,
      (total, produto) {
        return total + _estoque(produto);
      },
    );
  }

  // ============================================================
  // ESTOQUE BAIXO
  // ============================================================

  int get _baixoEstoque {
    return _produtos.where((produto) {
      final estoque = _estoque(produto);

      return estoque > 0 && estoque <= 5;
    }).length;
  }

  // ============================================================
  // SEM ESTOQUE
  // ============================================================

  int get _semEstoque {
    return _produtos.where((produto) {
      return _estoque(produto) <= 0;
    }).length;
  }

  // ============================================================
  // STATUS
  // ============================================================

  String _statusEstoque(int estoque) {
    if (estoque <= 0) {
      return 'Sem estoque';
    }

    if (estoque <= 5) {
      return 'Estoque baixo';
    }

    return 'Estoque normal';
  }

  Color _corEstoque(int estoque) {
    if (estoque <= 0) {
      return const Color(0xffdc2626);
    }

    if (estoque <= 5) {
      return const Color(0xfff59e0b);
    }

    return const Color(0xff16a34a);
  }

  IconData _iconeEstoque(int estoque) {
    if (estoque <= 0) {
      return Icons.remove_shopping_cart_outlined;
    }

    if (estoque <= 5) {
      return Icons.warning_amber_rounded;
    }

    return Icons.inventory_2_outlined;
  }

  // ============================================================
  // ALTERAR ESTOQUE
  // ============================================================

  Future<void> _alterarEstoque(
    dynamic produto,
    int quantidade,
  ) async {
    final id = _produtoId(produto);

    if (id == null) {
      _mostrarErro('Produto inválido.');
      return;
    }

    final estoqueAtual = _estoque(produto);

    final novoEstoque = estoqueAtual + quantidade;

    if (novoEstoque < 0) {
      _mostrarErro(
        'O estoque não pode ficar negativo.',
      );
      return;
    }

    try {
      await ApiService.atualizarEstoque(
        id: id,
        estoque: novoEstoque,
      );

      if (!mounted) return;

      setState(() {
        if (produto is Map) {
          produto['estoque'] = novoEstoque;
        }
      });

      _mostrarSucesso(
        quantidade > 0
            ? 'Estoque aumentado para $novoEstoque unidades.'
            : 'Estoque reduzido para $novoEstoque unidades.',
      );
    } catch (e) {
      if (!mounted) return;

      _mostrarErro(
        e.toString().replaceFirst(
          'Exception: ',
          '',
        ),
      );
    }
  }

  // ============================================================
  // AJUSTE MANUAL
  // ============================================================

  Future<void> _abrirAjusteManual(
    dynamic produto,
  ) async {
    final id = _produtoId(produto);

    if (id == null) {
      _mostrarErro('Produto inválido.');
      return;
    }

    final estoqueAtual = _estoque(produto);

    final controller = TextEditingController(
      text: estoqueAtual.toString(),
    );

    final novoEstoque = await showDialog<int>(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: const Text(
            'Ajustar estoque',
            style: TextStyle(
              fontWeight: FontWeight.w800,
            ),
          ),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            crossAxisAlignment:
                CrossAxisAlignment.start,
            children: [
              Text(
                '${produto['nome'] ?? 'Produto'}',
                style: const TextStyle(
                  fontWeight: FontWeight.w700,
                ),
              ),
              const SizedBox(height: 15),
              TextField(
                controller: controller,
                autofocus: true,
                keyboardType:
                    TextInputType.number,
                decoration:
                    const InputDecoration(
                  labelText: 'Quantidade',
                  prefixIcon: Icon(
                    Icons.inventory_2_outlined,
                  ),
                  border: OutlineInputBorder(),
                ),
              ),
            ],
          ),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.pop(context);
              },
              child: const Text('Cancelar'),
            ),
            ElevatedButton(
              onPressed: () {
                final valor = int.tryParse(
                  controller.text.trim(),
                );

                if (valor == null || valor < 0) {
                  return;
                }

                Navigator.pop(context, valor);
              },
              child: const Text('Salvar'),
            ),
          ],
        );
      },
    );

    controller.dispose();

    if (novoEstoque == null) {
      return;
    }

    if (novoEstoque == estoqueAtual) {
      return;
    }

    await _alterarEstoque(
      produto,
      novoEstoque - estoqueAtual,
    );
  }

  // ============================================================
  // SUCESSO
  // ============================================================

  void _mostrarSucesso(String mensagem) {
    if (!mounted) return;

    ScaffoldMessenger.of(context).hideCurrentSnackBar();

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(mensagem),
        behavior: SnackBarBehavior.floating,
        backgroundColor:
            const Color(0xff16a34a),
      ),
    );
  }

  // ============================================================
  // ERRO
  // ============================================================

  void _mostrarErro(String mensagem) {
    if (!mounted) return;

    ScaffoldMessenger.of(context).hideCurrentSnackBar();

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(mensagem),
        behavior: SnackBarBehavior.floating,
        backgroundColor:
            const Color(0xffdc2626),
      ),
    );
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
        backgroundColor: Colors.white,
        foregroundColor:
            const Color(0xff111827),
        elevation: 0,
        title: const Text(
          'Controle de Estoque',
          style: TextStyle(
            fontWeight: FontWeight.w800,
          ),
        ),
        actions: [
          IconButton(
            tooltip: 'Atualizar',
            onPressed: _carregar,
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

    if (_produtos.isEmpty) {
      return _buildVazio();
    }

    return RefreshIndicator(
      onRefresh: _carregar,
      child: ListView(
        physics:
            const AlwaysScrollableScrollPhysics(),
        padding: const EdgeInsets.all(18),
        children: [
          _buildCabecalho(),

          const SizedBox(height: 18),

          _buildIndicadores(),

          const SizedBox(height: 24),

          const Text(
            'Produtos',
            style: TextStyle(
              fontSize: 20,
              fontWeight: FontWeight.w800,
              color: Color(0xff111827),
            ),
          ),

          const SizedBox(height: 5),

          const Text(
            'Gerencie a quantidade disponível de cada produto.',
            style: TextStyle(
              color: Color(0xff64748b),
              fontSize: 13,
            ),
          ),

          const SizedBox(height: 15),

          ..._produtos.map(
            (produto) {
              if (produto is! Map) {
                return const SizedBox();
              }

              return _produtoCard(produto);
            },
          ),

          const SizedBox(height: 20),
        ],
      ),
    );
  }

  // ============================================================
  // CABEÇALHO
  // ============================================================

  Widget _buildCabecalho() {
    return Container(
      padding: const EdgeInsets.all(22),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          colors: [
            Color(0xff2563eb),
            Color(0xff1d4ed8),
          ],
        ),
        borderRadius:
            BorderRadius.circular(20),
        boxShadow: [
          BoxShadow(
            color:
                const Color(0xff2563eb)
                    .withOpacity(.20),
            blurRadius: 20,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: const Row(
        children: [
          CircleAvatar(
            radius: 28,
            backgroundColor:
                Colors.white24,
            child: Icon(
              Icons.warehouse_rounded,
              color: Colors.white,
              size: 30,
            ),
          ),
          SizedBox(width: 15),
          Expanded(
            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment.start,
              children: [
                Text(
                  'Controle de estoque',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 22,
                    fontWeight:
                        FontWeight.w800,
                  ),
                ),
                SizedBox(height: 5),
                Text(
                  'Acompanhe e ajuste seus produtos em tempo real.',
                  style: TextStyle(
                    color: Colors.white70,
                    fontSize: 13,
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
  // INDICADORES
  // ============================================================

  Widget _buildIndicadores() {
    return LayoutBuilder(
      builder: (
        context,
        constraints,
      ) {
        if (constraints.maxWidth < 600) {
          return Column(
            children: [
              Row(
                children: [
                  Expanded(
                    child: _infoCard(
                      'Unidades',
                      '$_totalEstoque',
                      Icons.inventory_2_outlined,
                      const Color(0xff2563eb),
                    ),
                  ),
                  const SizedBox(width: 12),
                  Expanded(
                    child: _infoCard(
                      'Baixo',
                      '$_baixoEstoque',
                      Icons.warning_amber_rounded,
                      const Color(0xfff59e0b),
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 12),
              _infoCard(
                'Sem estoque',
                '$_semEstoque',
                Icons.remove_shopping_cart_outlined,
                const Color(0xffdc2626),
              ),
            ],
          );
        }

        return Row(
          children: [
            Expanded(
              child: _infoCard(
                'Unidades',
                '$_totalEstoque',
                Icons.inventory_2_outlined,
                const Color(0xff2563eb),
              ),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: _infoCard(
                'Estoque baixo',
                '$_baixoEstoque',
                Icons.warning_amber_rounded,
                const Color(0xfff59e0b),
              ),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: _infoCard(
                'Sem estoque',
                '$_semEstoque',
                Icons.remove_shopping_cart_outlined,
                const Color(0xffdc2626),
              ),
            ),
          ],
        );
      },
    );
  }

  // ============================================================
  // CARD DE PRODUTO
  // ============================================================

  Widget _produtoCard(
    dynamic produto,
  ) {
    final estoque = _estoque(produto);

    final cor = _corEstoque(estoque);

    final nome =
        produto['nome']?.toString() ??
            'Produto';

    return Container(
      margin:
          const EdgeInsets.only(bottom: 12),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius:
            BorderRadius.circular(18),
        border: Border.all(
          color:
              const Color(0xffe5e7eb),
        ),
        boxShadow: [
          BoxShadow(
            color:
                Colors.black.withOpacity(.035),
            blurRadius: 12,
            offset: const Offset(0, 5),
          ),
        ],
      ),
      child: Column(
        children: [
          Row(
            children: [
              Container(
                width: 50,
                height: 50,
                decoration: BoxDecoration(
                  color:
                      cor.withOpacity(.10),
                  borderRadius:
                      BorderRadius.circular(
                    14,
                  ),
                ),
                child: Icon(
                  _iconeEstoque(estoque),
                  color: cor,
                  size: 26,
                ),
              ),

              const SizedBox(width: 13),

              Expanded(
                child: Column(
                  crossAxisAlignment:
                      CrossAxisAlignment.start,
                  children: [
                    Text(
                      nome,
                      maxLines: 1,
                      overflow:
                          TextOverflow.ellipsis,
                      style:
                          const TextStyle(
                        fontSize: 16,
                        fontWeight:
                            FontWeight.w800,
                        color:
                            Color(0xff111827),
                      ),
                    ),

                    const SizedBox(height: 5),

                    Row(
                      children: [
                        Container(
                          padding:
                              const EdgeInsets
                                  .symmetric(
                            horizontal: 8,
                            vertical: 4,
                          ),
                          decoration:
                              BoxDecoration(
                            color:
                                cor.withOpacity(
                              .10,
                            ),
                            borderRadius:
                                BorderRadius
                                    .circular(
                              20,
                            ),
                          ),
                          child: Text(
                            _statusEstoque(
                              estoque,
                            ),
                            style: TextStyle(
                              color: cor,
                              fontSize: 11,
                              fontWeight:
                                  FontWeight.w700,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ],
                ),
              ),

              Column(
                crossAxisAlignment:
                    CrossAxisAlignment.end,
                children: [
                  Text(
                    '$estoque',
                    style: TextStyle(
                      fontSize: 25,
                      fontWeight:
                          FontWeight.w900,
                      color: cor,
                    ),
                  ),
                  const Text(
                    'unidades',
                    style: TextStyle(
                      fontSize: 11,
                      color:
                          Color(0xff64748b),
                    ),
                  ),
                ],
              ),
            ],
          ),

          const SizedBox(height: 15),

          const Divider(height: 1),

          const SizedBox(height: 13),

          Row(
            children: [
              OutlinedButton(
                onPressed: estoque > 0
                    ? () {
                        _alterarEstoque(
                          produto,
                          -1,
                        );
                      }
                    : null,
                style:
                    OutlinedButton.styleFrom(
                  minimumSize:
                      const Size(45, 42),
                  padding:
                      EdgeInsets.zero,
                  shape:
                      RoundedRectangleBorder(
                    borderRadius:
                        BorderRadius.circular(
                      12,
                    ),
                  ),
                ),
                child: const Icon(
                  Icons.remove_rounded,
                ),
              ),

              const SizedBox(width: 8),

              Expanded(
                child: ElevatedButton.icon(
                  onPressed: () {
                    _abrirAjusteManual(
                      produto,
                    );
                  },
                  style:
                      ElevatedButton.styleFrom(
                    minimumSize:
                        const Size(0, 42),
                    backgroundColor:
                        const Color(
                      0xff111827,
                    ),
                    foregroundColor:
                        Colors.white,
                    elevation: 0,
                    shape:
                        RoundedRectangleBorder(
                      borderRadius:
                          BorderRadius.circular(
                        12,
                      ),
                    ),
                  ),
                  icon: const Icon(
                    Icons.edit_outlined,
                    size: 18,
                  ),
                  label: const Text(
                    'Ajustar estoque',
                    style: TextStyle(
                      fontWeight:
                          FontWeight.w700,
                    ),
                  ),
                ),
              ),

              const SizedBox(width: 8),

              OutlinedButton(
                onPressed: () {
                  _alterarEstoque(
                    produto,
                    1,
                  );
                },
                style:
                    OutlinedButton.styleFrom(
                  minimumSize:
                      const Size(45, 42),
                  padding:
                      EdgeInsets.zero,
                  foregroundColor:
                      const Color(
                    0xff16a34a,
                  ),
                  side: const BorderSide(
                    color: Color(
                      0xff16a34a,
                    ),
                  ),
                  shape:
                      RoundedRectangleBorder(
                    borderRadius:
                        BorderRadius.circular(
                      12,
                    ),
                  ),
                ),
                child: const Icon(
                  Icons.add_rounded,
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  // ============================================================
  // CARD DE INFORMAÇÃO
  // ============================================================

  Widget _infoCard(
    String titulo,
    String valor,
    IconData icon,
    Color cor,
  ) {
    return Container(
      padding:
          const EdgeInsets.all(17),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius:
            BorderRadius.circular(17),
        border: Border.all(
          color:
              const Color(0xffe5e7eb),
        ),
      ),
      child: Row(
        children: [
          Container(
            width: 44,
            height: 44,
            decoration: BoxDecoration(
              color:
                  cor.withOpacity(.10),
              borderRadius:
                  BorderRadius.circular(12),
            ),
            child: Icon(
              icon,
              color: cor,
              size: 23,
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
                  maxLines: 1,
                  overflow:
                      TextOverflow.ellipsis,
                  style: const TextStyle(
                    color:
                        Color(0xff64748b),
                    fontSize: 11,
                    fontWeight:
                        FontWeight.w600,
                  ),
                ),
                const SizedBox(height: 3),
                Text(
                  valor,
                  style:
                      const TextStyle(
                    fontSize: 22,
                    fontWeight:
                        FontWeight.w900,
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
              decoration: BoxDecoration(
                color:
                    const Color(0xffdc2626)
                        .withOpacity(.10),
                shape: BoxShape.circle,
              ),
              child: const Icon(
                Icons.cloud_off_rounded,
                size: 40,
                color:
                    Color(0xffdc2626),
              ),
            ),

            const SizedBox(height: 18),

            const Text(
              'Erro ao carregar estoque',
              style: TextStyle(
                fontSize: 19,
                fontWeight:
                    FontWeight.w800,
              ),
            ),

            const SizedBox(height: 8),

            Text(
              _erro ?? 'Erro desconhecido.',
              textAlign:
                  TextAlign.center,
              style: const TextStyle(
                color:
                    Color(0xff64748b),
              ),
            ),

            const SizedBox(height: 20),

            ElevatedButton.icon(
              onPressed: _carregar,
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
  // VAZIO
  // ============================================================

  Widget _buildVazio() {
    return Center(
      child: Padding(
        padding:
            const EdgeInsets.all(30),
        child: Column(
          mainAxisSize:
              MainAxisSize.min,
          children: [
            Container(
              width: 90,
              height: 90,
              decoration: BoxDecoration(
                color:
                    const Color(0xff2563eb)
                        .withOpacity(.10),
                shape: BoxShape.circle,
              ),
              child: const Icon(
                Icons.inventory_2_outlined,
                size: 45,
                color:
                    Color(0xff2563eb),
              ),
            ),

            const SizedBox(height: 20),

            const Text(
              'Nenhum produto encontrado',
              style: TextStyle(
                fontSize: 19,
                fontWeight:
                    FontWeight.w800,
              ),
            ),

            const SizedBox(height: 8),

            const Text(
              'Cadastre produtos para começar a controlar o estoque.',
              textAlign:
                  TextAlign.center,
              style: TextStyle(
                color:
                    Color(0xff64748b),
              ),
            ),
          ],
        ),
      ),
    );
  }
}