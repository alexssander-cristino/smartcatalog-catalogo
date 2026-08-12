import 'package:flutter/material.dart';

import '../services/api_service.dart';
import 'categoria_form_page.dart';

class CategoriasPage extends StatefulWidget {
  const CategoriasPage({super.key});

  @override
  State<CategoriasPage> createState() => _CategoriasPageState();
}

class _CategoriasPageState extends State<CategoriasPage> {
  static const Color _primary = Color(0xff2563eb);
  static const Color _primaryDark = Color(0xff1d4ed8);
  static const Color _background = Color(0xfff5f7fb);
  static const Color _text = Color(0xff111827);
  static const Color _muted = Color(0xff64748b);
  static const Color _border = Color(0xffe2e8f0);
  static const Color _danger = Color(0xffdc2626);
  static const Color _success = Color(0xff16a34a);

  bool _carregando = true;
  String? _erro;

  List<dynamic> _categorias = [];
  String _busca = '';

  final TextEditingController _buscaController =
      TextEditingController();

  @override
  void initState() {
    super.initState();
    _carregarCategorias();
  }

  @override
  void dispose() {
    _buscaController.dispose();
    super.dispose();
  }

  Future<void> _carregarCategorias() async {
    setState(() {
      _carregando = true;
      _erro = null;
    });

    try {
      final categorias = await ApiService.getCategorias();

      if (!mounted) return;

      setState(() {
        _categorias = categorias;
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

  Future<void> _novaCategoria() async {
    final resultado = await Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) => const CategoriaFormPage(),
      ),
    );

    if (resultado == true) {
      await _carregarCategorias();
    }
  }

  Future<void> _editarCategoria(
    Map<String, dynamic> categoria,
  ) async {
    final id = int.tryParse(
      categoria['id'].toString(),
    );

    if (id == null) {
      _mostrarMensagem(
        'ID da categoria inválido.',
        erro: true,
      );
      return;
    }

    final resultado = await Navigator.push(
      context,
      MaterialPageRoute(
        builder: (_) => CategoriaFormPage(
          categoria: categoria,
        ),
      ),
    );

    if (resultado == true) {
      await _carregarCategorias();
    }
  }

  Future<void> _excluirCategoria(
    Map<String, dynamic> categoria,
  ) async {
    final id = int.tryParse(
      categoria['id'].toString(),
    );

    if (id == null) {
      _mostrarMensagem(
        'ID da categoria inválido.',
        erro: true,
      );
      return;
    }

    final nome =
        categoria['nome']?.toString() ?? 'Categoria';

    final confirmar = await _confirmarExclusao(nome);

    if (confirmar != true) {
      return;
    }

    try {
      await ApiService.excluirCategoria(id);

      if (!mounted) return;

      _mostrarMensagem(
        'Categoria excluída com sucesso.',
      );

      await _carregarCategorias();
    } catch (e) {
      if (!mounted) return;

      _mostrarMensagem(
        e.toString().replaceFirst('Exception: ', ''),
        erro: true,
      );
    }
  }

  Future<bool?> _confirmarExclusao(String nome) {
    return showDialog<bool>(
      context: context,
      barrierDismissible: true,
      builder: (context) {
        return Dialog(
          backgroundColor: Colors.white,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(24),
          ),
          child: Padding(
            padding: const EdgeInsets.all(24),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                Container(
                  width: 64,
                  height: 64,
                  decoration: BoxDecoration(
                    color: _danger.withOpacity(.10),
                    shape: BoxShape.circle,
                  ),
                  child: const Icon(
                    Icons.delete_outline_rounded,
                    color: _danger,
                    size: 31,
                  ),
                ),
                const SizedBox(height: 18),
                const Text(
                  'Excluir categoria?',
                  style: TextStyle(
                    color: _text,
                    fontSize: 20,
                    fontWeight: FontWeight.w800,
                  ),
                ),
                const SizedBox(height: 10),
                Text(
                  'Você está prestes a excluir "$nome". '
                  'Essa ação não poderá ser desfeita.',
                  textAlign: TextAlign.center,
                  style: const TextStyle(
                    color: _muted,
                    fontSize: 14,
                    height: 1.45,
                  ),
                ),
                const SizedBox(height: 24),
                Row(
                  children: [
                    Expanded(
                      child: OutlinedButton(
                        onPressed: () {
                          Navigator.pop(context, false);
                        },
                        style: OutlinedButton.styleFrom(
                          minimumSize: const Size(
                            double.infinity,
                            50,
                          ),
                          foregroundColor: _text,
                          side: const BorderSide(
                            color: _border,
                          ),
                          shape: RoundedRectangleBorder(
                            borderRadius:
                                BorderRadius.circular(13),
                          ),
                        ),
                        child: const Text(
                          'Cancelar',
                          style: TextStyle(
                            fontWeight: FontWeight.w700,
                          ),
                        ),
                      ),
                    ),
                    const SizedBox(width: 12),
                    Expanded(
                      child: ElevatedButton(
                        onPressed: () {
                          Navigator.pop(context, true);
                        },
                        style: ElevatedButton.styleFrom(
                          minimumSize: const Size(
                            double.infinity,
                            50,
                          ),
                          backgroundColor: _danger,
                          foregroundColor: Colors.white,
                          elevation: 0,
                          shape: RoundedRectangleBorder(
                            borderRadius:
                                BorderRadius.circular(13),
                          ),
                        ),
                        child: const Text(
                          'Excluir',
                          style: TextStyle(
                            fontWeight: FontWeight.w800,
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        );
      },
    );
  }

  void _mostrarMensagem(
    String mensagem, {
    bool erro = false,
  }) {
    ScaffoldMessenger.of(context).hideCurrentSnackBar();

    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        behavior: SnackBarBehavior.floating,
        margin: const EdgeInsets.all(16),
        backgroundColor:
            erro ? _danger : _success,
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(14),
        ),
        content: Row(
          children: [
            Icon(
              erro
                  ? Icons.error_outline_rounded
                  : Icons.check_circle_outline_rounded,
              color: Colors.white,
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Text(
                mensagem,
                style: const TextStyle(
                  fontWeight: FontWeight.w600,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  List<dynamic> get _categoriasFiltradas {
    if (_busca.trim().isEmpty) {
      return _categorias;
    }

    final termo = _busca.trim().toLowerCase();

    return _categorias.where((categoria) {
      if (categoria is! Map) {
        return false;
      }

      final nome =
          categoria['nome']?.toString().toLowerCase() ?? '';

      final descricao =
          categoria['descricao']?.toString().toLowerCase() ?? '';

      return nome.contains(termo) ||
          descricao.contains(termo);
    }).toList();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: _background,
      appBar: AppBar(
        backgroundColor: Colors.white,
        surfaceTintColor: Colors.white,
        elevation: 0,
        centerTitle: false,
        title: const Text(
          'Categorias',
          style: TextStyle(
            color: _text,
            fontSize: 20,
            fontWeight: FontWeight.w800,
          ),
        ),
        actions: [
          IconButton(
            tooltip: 'Atualizar',
            onPressed: _carregando
                ? null
                : _carregarCategorias,
            icon: const Icon(
              Icons.refresh_rounded,
              color: _text,
            ),
          ),
          const SizedBox(width: 8),
        ],
      ),
      body: _buildBody(),
    );
  }

  Widget _buildBody() {
    if (_carregando) {
      return _buildLoading();
    }

    if (_erro != null) {
      return _buildErro();
    }

    return RefreshIndicator(
      color: _primary,
      onRefresh: _carregarCategorias,
      child: ListView(
        physics:
            const AlwaysScrollableScrollPhysics(),
        padding: const EdgeInsets.fromLTRB(
          18,
          18,
          18,
          110,
        ),
        children: [
          _buildHeader(),
          const SizedBox(height: 18),
          _buildSearch(),
          const SizedBox(height: 20),
          if (_categorias.isEmpty)
            _buildVazio()
          else if (_categoriasFiltradas.isEmpty)
            _buildSemResultado()
          else
            ..._categoriasFiltradas.map(
              (categoria) {
                if (categoria is! Map) {
                  return const SizedBox.shrink();
                }

                return _buildCategoria(
                  Map<String, dynamic>.from(categoria),
                );
              },
            ),
        ],
      ),
    );
  }

  Widget _buildHeader() {
    final quantidade = _categorias.length;

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(22),
      decoration: BoxDecoration(
        gradient: const LinearGradient(
          begin: Alignment.topLeft,
          end: Alignment.bottomRight,
          colors: [
            _primary,
            _primaryDark,
          ],
        ),
        borderRadius: BorderRadius.circular(22),
        boxShadow: [
          BoxShadow(
            color: _primary.withOpacity(.18),
            blurRadius: 24,
            offset: const Offset(0, 10),
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            width: 58,
            height: 58,
            decoration: BoxDecoration(
              color: Colors.white.withOpacity(.16),
              borderRadius: BorderRadius.circular(17),
              border: Border.all(
                color: Colors.white.withOpacity(.20),
              ),
            ),
            child: const Icon(
              Icons.category_rounded,
              color: Colors.white,
              size: 30,
            ),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment.start,
              children: [
                const Text(
                  'Categorias de produtos',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 19,
                    fontWeight: FontWeight.w800,
                  ),
                ),
                const SizedBox(height: 5),
                Text(
                  quantidade == 1
                      ? '1 categoria cadastrada'
                      : '$quantidade categorias cadastradas',
                  style: TextStyle(
                    color: Colors.white.withOpacity(.82),
                    fontSize: 13,
                  ),
                ),
              ],
            ),
          ),
          Container(
            decoration: BoxDecoration(
              color: Colors.white.withOpacity(.15),
              borderRadius: BorderRadius.circular(13),
            ),
            child: IconButton(
              tooltip: 'Nova categoria',
              onPressed: _novaCategoria,
              icon: const Icon(
                Icons.add_rounded,
                color: Colors.white,
                size: 27,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSearch() {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: _border,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(.025),
            blurRadius: 12,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: TextField(
        controller: _buscaController,
        onChanged: (valor) {
          setState(() {
            _busca = valor;
          });
        },
        decoration: InputDecoration(
          hintText: 'Buscar categoria...',
          hintStyle: const TextStyle(
            color: Color(0xff94a3b8),
          ),
          prefixIcon: const Icon(
            Icons.search_rounded,
            color: _muted,
          ),
          suffixIcon: _busca.isEmpty
              ? null
              : IconButton(
                  onPressed: () {
                    _buscaController.clear();

                    setState(() {
                      _busca = '';
                    });
                  },
                  icon: const Icon(
                    Icons.close_rounded,
                    color: _muted,
                  ),
                ),
          border: InputBorder.none,
          contentPadding:
              const EdgeInsets.symmetric(
            horizontal: 16,
            vertical: 16,
          ),
        ),
      ),
    );
  }

  Widget _buildCategoria(
    Map<String, dynamic> categoria,
  ) {
    final nome =
        categoria['nome']?.toString() ?? 'Sem nome';

    final descricao =
        categoria['descricao']?.toString() ?? '';

    final id =
        categoria['id']?.toString() ?? '';

    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(18),
        border: Border.all(
          color: _border,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(.025),
            blurRadius: 14,
            offset: const Offset(0, 5),
          ),
        ],
      ),
      child: Material(
        color: Colors.transparent,
        child: InkWell(
          borderRadius: BorderRadius.circular(18),
          onTap: () => _editarCategoria(categoria),
          child: Padding(
            padding: const EdgeInsets.all(16),
            child: Row(
              children: [
                _buildCategoriaIcon(nome),
                const SizedBox(width: 14),
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
                        style: const TextStyle(
                          color: _text,
                          fontSize: 16,
                          fontWeight: FontWeight.w800,
                        ),
                      ),
                      const SizedBox(height: 5),
                      Text(
                        descricao.isEmpty
                            ? 'Nenhuma descrição informada'
                            : descricao,
                        maxLines: 2,
                        overflow:
                            TextOverflow.ellipsis,
                        style: TextStyle(
                          color: descricao.isEmpty
                              ? const Color(0xff94a3b8)
                              : _muted,
                          fontSize: 13,
                          height: 1.35,
                        ),
                      ),
                      const SizedBox(height: 8),
                      Container(
                        padding:
                            const EdgeInsets.symmetric(
                          horizontal: 8,
                          vertical: 4,
                        ),
                        decoration: BoxDecoration(
                          color: const Color(
                            0xfff1f5f9,
                          ),
                          borderRadius:
                              BorderRadius.circular(7),
                        ),
                        child: Text(
                          'ID $id',
                          style: const TextStyle(
                            color: _muted,
                            fontSize: 11,
                            fontWeight: FontWeight.w700,
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
                const SizedBox(width: 8),
                _buildMenu(categoria),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildCategoriaIcon(String nome) {
    final letra = nome.trim().isEmpty
        ? 'C'
        : nome.trim()[0].toUpperCase();

    return Container(
      width: 54,
      height: 54,
      decoration: BoxDecoration(
        gradient: LinearGradient(
          colors: [
            _primary.withOpacity(.12),
            _primary.withOpacity(.06),
          ],
        ),
        borderRadius: BorderRadius.circular(16),
      ),
      child: Center(
        child: Text(
          letra,
          style: const TextStyle(
            color: _primary,
            fontSize: 21,
            fontWeight: FontWeight.w900,
          ),
        ),
      ),
    );
  }

  Widget _buildMenu(
    Map<String, dynamic> categoria,
  ) {
    return Container(
      decoration: BoxDecoration(
        color: const Color(0xfff8fafc),
        borderRadius: BorderRadius.circular(12),
      ),
      child: PopupMenuButton<String>(
        tooltip: 'Opções',
        padding: EdgeInsets.zero,
        icon: const Icon(
          Icons.more_vert_rounded,
          color: _muted,
        ),
        shape: RoundedRectangleBorder(
          borderRadius: BorderRadius.circular(15),
        ),
        onSelected: (valor) {
          if (valor == 'editar') {
            _editarCategoria(categoria);
          }

          if (valor == 'excluir') {
            _excluirCategoria(categoria);
          }
        },
        itemBuilder: (context) {
          return const [
            PopupMenuItem(
              value: 'editar',
              child: Row(
                children: [
                  Icon(
                    Icons.edit_outlined,
                    color: _primary,
                    size: 20,
                  ),
                  SizedBox(width: 12),
                  Text(
                    'Editar',
                    style: TextStyle(
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ],
              ),
            ),
            PopupMenuItem(
              value: 'excluir',
              child: Row(
                children: [
                  Icon(
                    Icons.delete_outline_rounded,
                    color: _danger,
                    size: 20,
                  ),
                  SizedBox(width: 12),
                  Text(
                    'Excluir',
                    style: TextStyle(
                      color: _danger,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ],
              ),
            ),
          ];
        },
      ),
    );
  }

  Widget _buildVazio() {
    return Padding(
      padding: const EdgeInsets.only(
        top: 50,
      ),
      child: Column(
        children: [
          Container(
            width: 90,
            height: 90,
            decoration: BoxDecoration(
              color: _primary.withOpacity(.08),
              shape: BoxShape.circle,
            ),
            child: const Icon(
              Icons.category_outlined,
              size: 44,
              color: _primary,
            ),
          ),
          const SizedBox(height: 20),
          const Text(
            'Nenhuma categoria',
            style: TextStyle(
              color: _text,
              fontSize: 20,
              fontWeight: FontWeight.w800,
            ),
          ),
          const SizedBox(height: 8),
          const Text(
            'Você ainda não possui categorias cadastradas.',
            textAlign: TextAlign.center,
            style: TextStyle(
              color: _muted,
              fontSize: 14,
              height: 1.4,
            ),
          ),
          const SizedBox(height: 22),
          ElevatedButton.icon(
            onPressed: _novaCategoria,
            style: ElevatedButton.styleFrom(
              backgroundColor: _primary,
              foregroundColor: Colors.white,
              elevation: 0,
              padding:
                  const EdgeInsets.symmetric(
                horizontal: 20,
                vertical: 14,
              ),
              shape: RoundedRectangleBorder(
                borderRadius:
                    BorderRadius.circular(13),
              ),
            ),
            icon: const Icon(
              Icons.add_rounded,
            ),
            label: const Text(
              'Criar categoria',
              style: TextStyle(
                fontWeight: FontWeight.w800,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSemResultado() {
    return Padding(
      padding: const EdgeInsets.only(
        top: 50,
      ),
      child: Column(
        children: [
          Container(
            width: 80,
            height: 80,
            decoration: BoxDecoration(
              color: const Color(0xfff1f5f9),
              shape: BoxShape.circle,
            ),
            child: const Icon(
              Icons.search_off_rounded,
              size: 38,
              color: _muted,
            ),
          ),
          const SizedBox(height: 18),
          const Text(
            'Nenhuma categoria encontrada',
            style: TextStyle(
              color: _text,
              fontSize: 18,
              fontWeight: FontWeight.w800,
            ),
          ),
          const SizedBox(height: 7),
          Text(
            'Não encontramos resultados para "$_busca".',
            textAlign: TextAlign.center,
            style: const TextStyle(
              color: _muted,
              fontSize: 13,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildErro() {
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(30),
        child: Column(
          mainAxisAlignment:
              MainAxisAlignment.center,
          children: [
            Container(
              width: 85,
              height: 85,
              decoration: BoxDecoration(
                color: _danger.withOpacity(.08),
                shape: BoxShape.circle,
              ),
              child: const Icon(
                Icons.cloud_off_rounded,
                size: 42,
                color: _danger,
              ),
            ),
            const SizedBox(height: 20),
            const Text(
              'Não foi possível carregar',
              textAlign: TextAlign.center,
              style: TextStyle(
                color: _text,
                fontSize: 19,
                fontWeight: FontWeight.w800,
              ),
            ),
            const SizedBox(height: 8),
            Text(
              _erro ?? 'Erro desconhecido.',
              textAlign: TextAlign.center,
              style: const TextStyle(
                color: _muted,
                fontSize: 13,
                height: 1.4,
              ),
            ),
            const SizedBox(height: 22),
            ElevatedButton.icon(
              onPressed: _carregarCategorias,
              style: ElevatedButton.styleFrom(
                backgroundColor: _primary,
                foregroundColor: Colors.white,
                elevation: 0,
                padding:
                    const EdgeInsets.symmetric(
                  horizontal: 20,
                  vertical: 14,
                ),
                shape: RoundedRectangleBorder(
                  borderRadius:
                      BorderRadius.circular(13),
                ),
              ),
              icon: const Icon(
                Icons.refresh_rounded,
              ),
              label: const Text(
                'Tentar novamente',
                style: TextStyle(
                  fontWeight: FontWeight.w800,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildLoading() {
    return Center(
      child: Column(
        mainAxisSize: MainAxisSize.min,
        children: [
          Container(
            width: 65,
            height: 65,
            decoration: BoxDecoration(
              color: _primary.withOpacity(.08),
              shape: BoxShape.circle,
            ),
            padding: const EdgeInsets.all(18),
            child: const CircularProgressIndicator(
              strokeWidth: 3,
              color: _primary,
            ),
          ),
          const SizedBox(height: 18),
          const Text(
            'Carregando categorias...',
            style: TextStyle(
              color: _muted,
              fontSize: 14,
              fontWeight: FontWeight.w600,
            ),
          ),
        ],
      ),
    );
  }
}