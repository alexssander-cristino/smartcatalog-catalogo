import 'package:flutter/material.dart';

import '../services/api_service.dart';
import 'produto_form_page.dart' hide ApiService;

class ProdutosPage extends StatefulWidget {
  const ProdutosPage({super.key});

  @override
  State<ProdutosPage> createState() => _ProdutosPageState();
}

class _ProdutosPageState extends State<ProdutosPage> {
  bool _carregando = true;
  String? _erro;

  List<dynamic> _produtos = [];

  @override
  void initState() {
    super.initState();
    _carregarProdutos();
  }

  // ============================================================
  // CARREGAR PRODUTOS
  // ============================================================

  Future<void> _carregarProdutos() async {
    if (mounted) {
      setState(() {
        _carregando = true;
        _erro = null;
      });
    }

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
        _erro = e.toString().replaceFirst('Exception: ', '');
        _carregando = false;
      });
    }
  }

  // ============================================================
  // NOVO PRODUTO
  // ============================================================

  Future<void> _novoProduto() async {
    final resultado = await Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) => const ProdutoFormPage(),
      ),
    );

    if (resultado == true) {
      await _carregarProdutos();
    }
  }

  // ============================================================
  // EDITAR PRODUTO
  // ============================================================

  Future<void> _editarProduto(
    Map<String, dynamic> produto,
  ) async {
    final resultado = await Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) => ProdutoFormPage(
          produto: produto,
        ),
      ),
    );

    if (resultado == true) {
      await _carregarProdutos();
    }
  }

  // ============================================================
  // EXCLUIR PRODUTO
  // ============================================================

  Future<void> _excluirProduto(
    Map<String, dynamic> produto,
  ) async {
    final id = int.tryParse(
      produto['id']?.toString() ?? '',
    );

    if (id == null) {
      _mostrarMensagem(
        'ID do produto inválido.',
        erro: true,
      );
      return;
    }

    final nome = produto['nome']?.toString() ?? 'Produto';

    final confirmar = await showDialog<bool>(
      context: context,
      builder: (context) {
        return AlertDialog(
          title: const Text('Excluir produto'),
          content: Text(
            'Deseja realmente excluir "$nome"?',
          ),
          actions: [
            TextButton(
              onPressed: () {
                Navigator.pop(context, false);
              },
              child: const Text('Cancelar'),
            ),
            ElevatedButton(
              style: ElevatedButton.styleFrom(
                backgroundColor: const Color(0xffdc2626),
                foregroundColor: Colors.white,
              ),
              onPressed: () {
                Navigator.pop(context, true);
              },
              child: const Text('Excluir'),
            ),
          ],
        );
      },
    );

    if (confirmar != true) return;

    try {
      await ApiService.excluirProduto(id);

      if (!mounted) return;

      _mostrarMensagem(
        'Produto excluído com sucesso.',
      );

      await _carregarProdutos();
    } catch (e) {
      if (!mounted) return;

      _mostrarMensagem(
        e.toString().replaceFirst(
              'Exception: ',
              '',
            ),
        erro: true,
      );
    }
  }

  // ============================================================
  // MENSAGEM
  // ============================================================

  void _mostrarMensagem(
    String mensagem, {
    bool erro = false,
  }) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(mensagem),
        backgroundColor: erro
            ? const Color(0xffdc2626)
            : const Color(0xff16a34a),
      ),
    );
  }

  // ============================================================
  // BUILD
  // ============================================================

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xfff5f7fb),

      appBar: AppBar(
        backgroundColor: Colors.white,
        foregroundColor: const Color(0xff111827),
        elevation: 0,

        title: const Text(
          'Produtos',
          style: TextStyle(
            fontWeight: FontWeight.w800,
          ),
        ),

        actions: [
          IconButton(
            tooltip: 'Atualizar',
            onPressed: _carregarProdutos,
            icon: const Icon(
              Icons.refresh_rounded,
            ),
          ),
          const SizedBox(width: 8),
        ],
      ),

      floatingActionButton: FloatingActionButton.extended(
        backgroundColor: const Color(0xff2563eb),
        foregroundColor: Colors.white,
        onPressed: _novoProduto,
        icon: const Icon(Icons.add),
        label: const Text('Novo produto'),
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
      onRefresh: _carregarProdutos,
      child: ListView.builder(
        padding: const EdgeInsets.all(20),
        itemCount: _produtos.length,
        itemBuilder: (context, index) {
          final produto = _produtos[index];

          if (produto is! Map) {
            return const SizedBox.shrink();
          }

          return _buildProduto(
            Map<String, dynamic>.from(produto),
          );
        },
      ),
    );
  }

  // ============================================================
  // CARD DO PRODUTO
  // ============================================================

  Widget _buildProduto(
    Map<String, dynamic> produto,
  ) {
    final nome = produto['nome']?.toString() ?? 'Produto';

    final preco = double.tryParse(
          produto['preco']?.toString() ?? '',
        ) ??
        0;

    final estoque = int.tryParse(
          produto['estoque']?.toString() ?? '',
        ) ??
        0;

    String? categoria;

    if (produto['categoria'] is Map) {
      categoria =
          produto['categoria']['nome']?.toString();
    }

    if (categoria == null ||
        categoria!.trim().isEmpty) {
      categoria =
          produto['categoria_nome']?.toString();
    }

    final ativo =
        produto['ativo'] == true ||
        produto['ativo']?.toString() == '1';

    final estoqueBaixo = estoque <= 5;

    return Container(
      margin: const EdgeInsets.only(bottom: 14),

      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),

        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(.04),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),

      child: Padding(
        padding: const EdgeInsets.all(16),

        child: Row(
          crossAxisAlignment: CrossAxisAlignment.start,

          children: [
            Container(
              width: 58,
              height: 58,

              decoration: BoxDecoration(
                color: const Color(0xffeff6ff),
                borderRadius: BorderRadius.circular(14),
              ),

              child: const Icon(
                Icons.inventory_2_outlined,
                color: Color(0xff2563eb),
                size: 28,
              ),
            ),

            const SizedBox(width: 14),

            Expanded(
              child: Column(
                crossAxisAlignment:
                    CrossAxisAlignment.start,

                children: [
                  Text(
                    nome,
                    style: const TextStyle(
                      fontSize: 16,
                      fontWeight: FontWeight.w800,
                      color: Color(0xff111827),
                    ),
                  ),

                  const SizedBox(height: 5),

                  if (categoria != null &&
                      categoria!.trim().isNotEmpty)
                    Text(
                      categoria!,
                      style: const TextStyle(
                        fontSize: 12,
                        color: Color(0xff64748b),
                      ),
                    ),

                  const SizedBox(height: 8),

                  Wrap(
                    spacing: 8,
                    runSpacing: 6,

                    children: [
                      _badge(
                        'R\$ ${preco.toStringAsFixed(2).replaceAll('.', ',')}',
                        const Color(0xff2563eb),
                      ),

                      _badge(
                        '$estoque un.',
                        estoqueBaixo
                            ? const Color(0xffdc2626)
                            : const Color(0xff16a34a),
                      ),

                      _badge(
                        ativo ? 'Ativo' : 'Inativo',
                        ativo
                            ? const Color(0xff16a34a)
                            : const Color(0xff64748b),
                      ),
                    ],
                  ),
                ],
              ),
            ),

            PopupMenuButton<String>(
              onSelected: (valor) {
                if (valor == 'editar') {
                  _editarProduto(produto);
                }

                if (valor == 'excluir') {
                  _excluirProduto(produto);
                }
              },

              itemBuilder: (context) {
                return const [
                  PopupMenuItem<String>(
                    value: 'editar',
                    child: Row(
                      children: [
                        Icon(
                          Icons.edit_outlined,
                        ),
                        SizedBox(width: 10),
                        Text('Editar'),
                      ],
                    ),
                  ),

                  PopupMenuItem<String>(
                    value: 'excluir',
                    child: Row(
                      children: [
                        Icon(
                          Icons.delete_outline,
                          color: Color(0xffdc2626),
                        ),
                        SizedBox(width: 10),
                        Text('Excluir'),
                      ],
                    ),
                  ),
                ];
              },
            ),
          ],
        ),
      ),
    );
  }

  // ============================================================
  // BADGE
  // ============================================================

  Widget _badge(
    String texto,
    Color cor,
  ) {
    return Container(
      padding: const EdgeInsets.symmetric(
        horizontal: 9,
        vertical: 5,
      ),

      decoration: BoxDecoration(
        color: cor.withOpacity(.10),
        borderRadius: BorderRadius.circular(20),
      ),

      child: Text(
        texto,
        style: TextStyle(
          color: cor,
          fontSize: 11,
          fontWeight: FontWeight.w800,
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
        padding: const EdgeInsets.all(30),

        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,

          children: [
            const Icon(
              Icons.inventory_2_outlined,
              size: 70,
              color: Color(0xffcbd5e1),
            ),

            const SizedBox(height: 15),

            const Text(
              'Nenhum produto cadastrado',
              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.w800,
              ),
            ),

            const SizedBox(height: 8),

            const Text(
              'Cadastre o primeiro produto.',
              textAlign: TextAlign.center,
              style: TextStyle(
                color: Color(0xff64748b),
              ),
            ),

            const SizedBox(height: 20),

            ElevatedButton.icon(
              onPressed: _novoProduto,
              icon: const Icon(Icons.add),
              label: const Text(
                'Cadastrar produto',
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
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(30),

        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,

          children: [
            const Icon(
              Icons.cloud_off_rounded,
              size: 65,
              color: Color(0xffdc2626),
            ),

            const SizedBox(height: 15),

            const Text(
              'Não foi possível carregar os produtos',
              textAlign: TextAlign.center,

              style: TextStyle(
                fontSize: 18,
                fontWeight: FontWeight.w800,
              ),
            ),

            const SizedBox(height: 8),

            Text(
              _erro ?? 'Erro desconhecido.',
              textAlign: TextAlign.center,

              style: const TextStyle(
                color: Color(0xff64748b),
              ),
            ),

            const SizedBox(height: 20),

            ElevatedButton.icon(
              onPressed: _carregarProdutos,
              icon: const Icon(Icons.refresh),
              label: const Text(
                'Tentar novamente',
              ),
            ),
          ],
        ),
      ),
    );
  }
}