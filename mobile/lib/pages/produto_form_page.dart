import 'dart:io';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

import '../services/api_service.dart';

class ProdutoFormPage extends StatefulWidget {
  final Map<String, dynamic>? produto;

  const ProdutoFormPage({
    super.key,
    this.produto,
  });

  bool get editando => produto != null;

  @override
  State<ProdutoFormPage> createState() => _ProdutoFormPageState();
}

class _ProdutoFormPageState extends State<ProdutoFormPage> {
  final _formKey = GlobalKey<FormState>();

  final _nomeController = TextEditingController();
  final _precoController = TextEditingController();
  final _estoqueController = TextEditingController();

  final ImagePicker _imagePicker = ImagePicker();

  List<dynamic> _categorias = [];

  int? _categoriaId;

  File? _imagemSelecionada;

  bool _carregando = false;
  bool _carregandoCategorias = true;

  @override
  void initState() {
    super.initState();

    _preencherProduto();
    _carregarCategorias();
  }

  // ============================================================
  // PREENCHER PRODUTO QUANDO FOR EDIÇÃO
  // ============================================================

  void _preencherProduto() {
    final produto = widget.produto;

    if (produto == null) {
      _estoqueController.text = '0';
      return;
    }

    _nomeController.text =
        produto['nome']?.toString() ?? '';

    _precoController.text =
        produto['preco']?.toString() ?? '';

    _estoqueController.text =
        produto['estoque']?.toString() ?? '0';

    final categoriaId =
        produto['categoria_id'];

    if (categoriaId != null) {
      _categoriaId =
          int.tryParse(categoriaId.toString());
    }
  }

  // ============================================================
  // CARREGAR CATEGORIAS
  // ============================================================

  Future<void> _carregarCategorias() async {
    try {
      final categorias =
          await ApiService.getCategorias();

      if (!mounted) return;

      setState(() {
        _categorias = categorias;
        _carregandoCategorias = false;
      });
    } catch (e) {
      if (!mounted) return;

      setState(() {
        _carregandoCategorias = false;
      });

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
  // SELECIONAR IMAGEM
  // ============================================================

  Future<void> _selecionarImagem() async {
    try {
      final imagem =
          await _imagePicker.pickImage(
        source: ImageSource.gallery,
        imageQuality: 85,
      );

      if (imagem == null) return;

      setState(() {
        _imagemSelecionada =
            File(imagem.path);
      });
    } catch (e) {
      if (!mounted) return;

      _mostrarMensagem(
        'Não foi possível selecionar a imagem.',
        erro: true,
      );
    }
  }

  // ============================================================
  // SALVAR
  // ============================================================

  Future<void> _salvar() async {
    if (!_formKey.currentState!.validate()) {
      return;
    }

    final nome =
        _nomeController.text.trim();

    final precoTexto =
        _precoController.text
            .trim()
            .replaceAll(',', '.');

    final estoqueTexto =
        _estoqueController.text.trim();

    final preco =
        double.tryParse(precoTexto);

    final estoque =
        int.tryParse(estoqueTexto);

    if (preco == null) {
      _mostrarMensagem(
        'Informe um preço válido.',
        erro: true,
      );
      return;
    }

    if (estoque == null || estoque < 0) {
      _mostrarMensagem(
        'Informe um estoque válido.',
        erro: true,
      );
      return;
    }

    setState(() {
      _carregando = true;
    });

    try {
      int produtoId;

      // ========================================================
      // EDITAR
      // ========================================================

      if (widget.editando) {
        final id = int.tryParse(
          widget.produto!['id']?.toString() ?? '',
        );

        if (id == null) {
          throw Exception(
            'ID do produto inválido.',
          );
        }

        final resultado =
            await ApiService.atualizarProduto(
          id: id,
          nome: nome,
          preco: preco,
          estoque: estoque,
          categoriaId: _categoriaId,
        );

        produtoId = id;

        // ======================================================
        // ENVIAR IMAGEM SE FOI SELECIONADA
        // ======================================================

        if (_imagemSelecionada != null) {
          await ApiService.enviarImagemProduto(
            produtoId: produtoId,
            imagem: _imagemSelecionada!,
          );
        }

        if (!mounted) return;

        _mostrarMensagem(
          resultado['message']?.toString() ??
              'Produto atualizado com sucesso.',
        );
      }

      // ========================================================
      // CRIAR
      // ========================================================

      else {
        final resultado =
            await ApiService.criarProduto(
          nome: nome,
          preco: preco,
          estoque: estoque,
          categoriaId: _categoriaId,
        );

        produtoId = _obterIdProduto(resultado);

        // ======================================================
        // ENVIAR IMAGEM
        // ======================================================

        if (_imagemSelecionada != null &&
            produtoId > 0) {
          await ApiService.enviarImagemProduto(
            produtoId: produtoId,
            imagem: _imagemSelecionada!,
          );
        }

        if (!mounted) return;

        _mostrarMensagem(
          resultado['message']?.toString() ??
              'Produto cadastrado com sucesso.',
        );
      }

      if (!mounted) return;

      Navigator.pop(context, true);
    } catch (e) {
      if (!mounted) return;

      _mostrarMensagem(
        e.toString().replaceFirst(
              'Exception: ',
              '',
            ),
        erro: true,
      );
    } finally {
      if (mounted) {
        setState(() {
          _carregando = false;
        });
      }
    }
  }

  // ============================================================
  // OBTER ID DO PRODUTO CRIADO
  // ============================================================

  int _obterIdProduto(
    Map<String, dynamic> data,
  ) {
    dynamic id;

    if (data['id'] != null) {
      id = data['id'];
    }

    if (id == null &&
        data['produto'] is Map) {
      id = data['produto']['id'];
    }

    if (id == null &&
        data['data'] is Map) {
      id = data['data']['id'];
    }

    return int.tryParse(
          id?.toString() ?? '',
        ) ??
        0;
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
  // DISPOSE
  // ============================================================

  @override
  void dispose() {
    _nomeController.dispose();
    _precoController.dispose();
    _estoqueController.dispose();

    super.dispose();
  }

  // ============================================================
  // BUILD
  // ============================================================

  @override
  Widget build(BuildContext context) {
    final titulo = widget.editando
        ? 'Editar produto'
        : 'Novo produto';

    return Scaffold(
      backgroundColor:
          const Color(0xfff5f7fb),

      appBar: AppBar(
        backgroundColor: Colors.white,
        foregroundColor:
            const Color(0xff111827),
        elevation: 0,

        title: Text(
          titulo,
          style: const TextStyle(
            fontWeight: FontWeight.w800,
          ),
        ),
      ),

      body: SafeArea(
        child: Form(
          key: _formKey,

          child: SingleChildScrollView(
            padding: const EdgeInsets.all(20),

            child: Column(
              crossAxisAlignment:
                  CrossAxisAlignment.stretch,

              children: [
                // ==================================================
                // IMAGEM
                // ==================================================

                _buildImagem(),

                const SizedBox(height: 24),

                // ==================================================
                // NOME
                // ==================================================

                TextFormField(
                  controller: _nomeController,

                  textInputAction:
                      TextInputAction.next,

                  decoration:
                      const InputDecoration(
                    labelText: 'Nome do produto',
                    hintText:
                        'Digite o nome do produto',
                    prefixIcon:
                        Icon(Icons.inventory_2_outlined),
                    border:
                        OutlineInputBorder(),
                  ),

                  validator: (valor) {
                    if (valor == null ||
                        valor.trim().isEmpty) {
                      return 'Informe o nome do produto.';
                    }

                    if (valor.trim().length < 2) {
                      return 'O nome é muito curto.';
                    }

                    return null;
                  },
                ),

                const SizedBox(height: 16),

                // ==================================================
                // PREÇO
                // ==================================================

                TextFormField(
                  controller:
                      _precoController,

                  keyboardType:
                      const TextInputType.numberWithOptions(
                    decimal: true,
                  ),

                  textInputAction:
                      TextInputAction.next,

                  decoration:
                      const InputDecoration(
                    labelText: 'Preço',
                    hintText: '0,00',
                    prefixText: 'R\$ ',
                    prefixIcon:
                        Icon(Icons.attach_money),
                    border:
                        OutlineInputBorder(),
                  ),

                  validator: (valor) {
                    if (valor == null ||
                        valor.trim().isEmpty) {
                      return 'Informe o preço.';
                    }

                    final numero =
                        double.tryParse(
                      valor
                          .replaceAll(',', '.')
                          .trim(),
                    );

                    if (numero == null) {
                      return 'Informe um preço válido.';
                    }

                    if (numero < 0) {
                      return 'O preço não pode ser negativo.';
                    }

                    return null;
                  },
                ),

                const SizedBox(height: 16),

                // ==================================================
                // ESTOQUE
                // ==================================================

                TextFormField(
                  controller:
                      _estoqueController,

                  keyboardType:
                      TextInputType.number,

                  textInputAction:
                      TextInputAction.next,

                  decoration:
                      const InputDecoration(
                    labelText: 'Estoque',
                    hintText: '0',
                    prefixIcon:
                        Icon(Icons.warehouse_outlined),
                    suffixText: 'un.',
                    border:
                        OutlineInputBorder(),
                  ),

                  validator: (valor) {
                    if (valor == null ||
                        valor.trim().isEmpty) {
                      return 'Informe o estoque.';
                    }

                    final numero =
                        int.tryParse(
                      valor.trim(),
                    );

                    if (numero == null) {
                      return 'Informe uma quantidade válida.';
                    }

                    if (numero < 0) {
                      return 'O estoque não pode ser negativo.';
                    }

                    return null;
                  },
                ),

                const SizedBox(height: 16),

                // ==================================================
                // CATEGORIA
                // ==================================================

                _buildCategoria(),

                const SizedBox(height: 28),

                // ==================================================
                // BOTÃO SALVAR
                // ==================================================

                SizedBox(
                  height: 52,

                  child: ElevatedButton.icon(
                    onPressed:
                        _carregando
                            ? null
                            : _salvar,

                    icon: _carregando
                        ? const SizedBox(
                            width: 20,
                            height: 20,
                            child:
                                CircularProgressIndicator(
                              strokeWidth: 2,
                              color: Colors.white,
                            ),
                          )
                        : const Icon(
                            Icons.save_outlined,
                          ),

                    label: Text(
                      _carregando
                          ? 'Salvando...'
                          : widget.editando
                              ? 'Salvar alterações'
                              : 'Cadastrar produto',
                    ),

                    style:
                        ElevatedButton.styleFrom(
                      backgroundColor:
                          const Color(0xff2563eb),
                      foregroundColor:
                          Colors.white,

                      shape:
                          RoundedRectangleBorder(
                        borderRadius:
                            BorderRadius.circular(12),
                      ),
                    ),
                  ),
                ),

                const SizedBox(height: 12),

                // ==================================================
                // CANCELAR
                // ==================================================

                SizedBox(
                  height: 50,

                  child: OutlinedButton(
                    onPressed: _carregando
                        ? null
                        : () {
                            Navigator.pop(
                              context,
                            );
                          },

                    child:
                        const Text('Cancelar'),
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }

  // ============================================================
  // IMAGEM
  // ============================================================

  Widget _buildImagem() {
    return Center(
      child: Column(
        children: [
          GestureDetector(
            onTap: _selecionarImagem,

            child: Container(
              width: 150,
              height: 150,

              decoration: BoxDecoration(
                color:
                    const Color(0xffeff6ff),

                borderRadius:
                    BorderRadius.circular(20),

                border: Border.all(
                  color:
                      const Color(0xffdbeafe),
                  width: 2,
                ),
              ),

              clipBehavior:
                  Clip.antiAlias,

              child:
                  _imagemSelecionada != null
                      ? Image.file(
                          _imagemSelecionada!,
                          fit: BoxFit.cover,
                        )
                      : const Center(
                          child: Column(
                            mainAxisAlignment:
                                MainAxisAlignment.center,
                            children: [
                              Icon(
                                Icons
                                    .add_photo_alternate_outlined,
                                size: 42,
                                color:
                                    Color(0xff2563eb),
                              ),
                              SizedBox(height: 8),
                              Text(
                                'Adicionar foto',
                                style:
                                    TextStyle(
                                  color:
                                      Color(0xff2563eb),
                                  fontWeight:
                                      FontWeight.w700,
                                ),
                              ),
                            ],
                          ),
                        ),
            ),
          ),

          const SizedBox(height: 8),

          const Text(
            'Toque para selecionar uma imagem',
            style: TextStyle(
              fontSize: 12,
              color: Color(0xff64748b),
            ),
          ),
        ],
      ),
    );
  }

  // ============================================================
  // CATEGORIA
  // ============================================================

  Widget _buildCategoria() {
    if (_carregandoCategorias) {
      return const InputDecorator(
        decoration: InputDecoration(
          labelText: 'Categoria',
          prefixIcon:
              Icon(Icons.category_outlined),
          border: OutlineInputBorder(),
        ),

        child: SizedBox(
          height: 24,

          child: Align(
            alignment: Alignment.centerLeft,

            child: SizedBox(
              width: 20,
              height: 20,

              child:
                  CircularProgressIndicator(
                strokeWidth: 2,
              ),
            ),
          ),
        ),
      );
    }

    if (_categorias.isEmpty) {
      return InputDecorator(
        decoration: const InputDecoration(
          labelText: 'Categoria',
          prefixIcon:
              Icon(Icons.category_outlined),
          border: OutlineInputBorder(),
        ),

        child: const Text(
          'Nenhuma categoria cadastrada',
          style: TextStyle(
            color: Color(0xff64748b),
          ),
        ),
      );
    }

    return DropdownButtonFormField<int>(
      value: _categoriaId,

      decoration:
          const InputDecoration(
        labelText: 'Categoria',
        prefixIcon:
            Icon(Icons.category_outlined),
        border: OutlineInputBorder(),
      ),

      hint:
          const Text('Selecione uma categoria'),

      items: _categorias
          .where((categoria) => categoria is Map)
          .map<DropdownMenuItem<int>>(
        (categoria) {
          final id = int.tryParse(
            categoria['id']?.toString() ?? '',
          );

          final nome =
              categoria['nome']?.toString() ??
                  'Categoria';

          return DropdownMenuItem<int>(
            value: id,
            child: Text(nome),
          );
        },
      )
          .where((item) => item.value != null)
          .toList(),

      onChanged: _carregando
          ? null
          : (valor) {
              setState(() {
                _categoriaId = valor;
              });
            },
    );
  }
}