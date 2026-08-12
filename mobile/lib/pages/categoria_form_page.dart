import 'package:flutter/material.dart';

import '../services/api_service.dart';

class CategoriaFormPage extends StatefulWidget {
  final Map<String, dynamic>? categoria;

  const CategoriaFormPage({
    super.key,
    this.categoria,
  });

  @override
  State<CategoriaFormPage> createState() => _CategoriaFormPageState();
}

class _CategoriaFormPageState extends State<CategoriaFormPage> {
  final _formKey = GlobalKey<FormState>();

  final _nomeController = TextEditingController();
  final _descricaoController = TextEditingController();

  bool _salvando = false;

  bool get _editando => widget.categoria != null;

  static const Color _primary = Color(0xff2563eb);
  static const Color _primaryDark = Color(0xff1d4ed8);
  static const Color _background = Color(0xfff5f7fb);
  static const Color _text = Color(0xff111827);
  static const Color _muted = Color(0xff64748b);
  static const Color _border = Color(0xffe2e8f0);

  @override
  void initState() {
    super.initState();

    if (_editando) {
      _nomeController.text =
          widget.categoria!['nome']?.toString() ?? '';

      _descricaoController.text =
          widget.categoria!['descricao']?.toString() ?? '';
    }
  }

  @override
  void dispose() {
    _nomeController.dispose();
    _descricaoController.dispose();
    super.dispose();
  }

  Future<void> _salvar() async {
    FocusScope.of(context).unfocus();

    if (!_formKey.currentState!.validate()) {
      return;
    }

    setState(() {
      _salvando = true;
    });

    try {
      if (_editando) {
        final id = int.tryParse(
          widget.categoria!['id'].toString(),
        );

        if (id == null) {
          throw Exception('ID da categoria inválido.');
        }

        await ApiService.atualizarCategoria(
          id: id,
          nome: _nomeController.text.trim(),
          descricao: _descricaoController.text.trim(),
        );
      } else {
        await ApiService.criarCategoria(
          nome: _nomeController.text.trim(),
          descricao: _descricaoController.text.trim(),
        );
      }

      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          behavior: SnackBarBehavior.floating,
          margin: const EdgeInsets.all(16),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(14),
          ),
          content: Row(
            children: [
              const Icon(
                Icons.check_circle_rounded,
                color: Colors.white,
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Text(
                  _editando
                      ? 'Categoria atualizada com sucesso.'
                      : 'Categoria criada com sucesso.',
                ),
              ),
            ],
          ),
          backgroundColor: const Color(0xff16a34a),
        ),
      );

      Navigator.pop(context, true);
    } catch (e) {
      if (!mounted) return;

      setState(() {
        _salvando = false;
      });

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          behavior: SnackBarBehavior.floating,
          margin: const EdgeInsets.all(16),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(14),
          ),
          content: Row(
            children: [
              const Icon(
                Icons.error_outline_rounded,
                color: Colors.white,
              ),
              const SizedBox(width: 12),
              Expanded(
                child: Text(
                  e.toString().replaceFirst('Exception: ', ''),
                ),
              ),
            ],
          ),
          backgroundColor: const Color(0xffdc2626),
        ),
      );
    }
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
        leading: IconButton(
          onPressed: _salvando
              ? null
              : () => Navigator.pop(context),
          icon: const Icon(
            Icons.arrow_back_rounded,
          ),
          color: _text,
        ),
        title: Text(
          _editando ? 'Editar categoria' : 'Nova categoria',
          style: const TextStyle(
            color: _text,
            fontSize: 20,
            fontWeight: FontWeight.w800,
          ),
        ),
      ),
      body: SafeArea(
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.fromLTRB(
              20,
              24,
              20,
              30,
            ),
            child: ConstrainedBox(
              constraints: const BoxConstraints(
                maxWidth: 680,
              ),
              child: Column(
                children: [
                  _buildHeader(),
                  const SizedBox(height: 18),
                  _buildForm(),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildHeader() {
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
            blurRadius: 22,
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
            child: Icon(
              _editando
                  ? Icons.edit_rounded
                  : Icons.category_rounded,
              color: Colors.white,
              size: 29,
            ),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  _editando
                      ? 'Editar categoria'
                      : 'Nova categoria',
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 21,
                    fontWeight: FontWeight.w800,
                  ),
                ),
                const SizedBox(height: 5),
                Text(
                  _editando
                      ? 'Atualize as informações da categoria.'
                      : 'Cadastre uma nova categoria para seus produtos.',
                  style: TextStyle(
                    color: Colors.white.withOpacity(.82),
                    fontSize: 13,
                    height: 1.35,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildForm() {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(22),
        border: Border.all(
          color: _border,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(.035),
            blurRadius: 24,
            offset: const Offset(0, 8),
          ),
        ],
      ),
      child: Form(
        key: _formKey,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Informações',
              style: TextStyle(
                color: _text,
                fontSize: 18,
                fontWeight: FontWeight.w800,
              ),
            ),
            const SizedBox(height: 5),
            const Text(
              'Informe os dados da categoria abaixo.',
              style: TextStyle(
                color: _muted,
                fontSize: 13,
              ),
            ),
            const SizedBox(height: 24),
            _buildLabel('Nome da categoria'),
            const SizedBox(height: 8),
            TextFormField(
              controller: _nomeController,
              textInputAction: TextInputAction.next,
              textCapitalization: TextCapitalization.sentences,
              decoration: _inputDecoration(
                hint: 'Ex.: Camisetas',
                icon: Icons.category_outlined,
              ),
              validator: (valor) {
                if (valor == null || valor.trim().isEmpty) {
                  return 'Informe o nome da categoria.';
                }

                if (valor.trim().length < 2) {
                  return 'O nome deve ter pelo menos 2 caracteres.';
                }

                return null;
              },
            ),
            const SizedBox(height: 20),
            _buildLabel('Descrição'),
            const SizedBox(height: 8),
            TextFormField(
              controller: _descricaoController,
              maxLines: 5,
              minLines: 4,
              textCapitalization: TextCapitalization.sentences,
              decoration: _inputDecoration(
                hint: 'Ex.: Produtos relacionados a camisetas.',
                icon: Icons.description_outlined,
                alignIconTop: true,
              ),
            ),
            const SizedBox(height: 10),
            const Text(
              'A descrição é opcional.',
              style: TextStyle(
                color: _muted,
                fontSize: 12,
              ),
            ),
            const SizedBox(height: 26),
            Row(
              children: [
                Expanded(
                  child: OutlinedButton(
                    onPressed: _salvando
                        ? null
                        : () => Navigator.pop(context),
                    style: OutlinedButton.styleFrom(
                      minimumSize: const Size(
                        double.infinity,
                        52,
                      ),
                      foregroundColor: _text,
                      side: const BorderSide(
                        color: _border,
                      ),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(14),
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
                  flex: 2,
                  child: ElevatedButton(
                    onPressed: _salvando ? null : _salvar,
                    style: ElevatedButton.styleFrom(
                      minimumSize: const Size(
                        double.infinity,
                        52,
                      ),
                      backgroundColor: _primary,
                      foregroundColor: Colors.white,
                      disabledBackgroundColor:
                          _primary.withOpacity(.55),
                      elevation: 0,
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(14),
                      ),
                    ),
                    child: AnimatedSwitcher(
                      duration: const Duration(
                        milliseconds: 200,
                      ),
                      child: _salvando
                          ? const SizedBox(
                              key: ValueKey('loading'),
                              width: 22,
                              height: 22,
                              child: CircularProgressIndicator(
                                strokeWidth: 2.5,
                                valueColor:
                                    AlwaysStoppedAnimation<Color>(
                                  Colors.white,
                                ),
                              ),
                            )
                          : Row(
                              key: const ValueKey('save'),
                              mainAxisAlignment:
                                  MainAxisAlignment.center,
                              children: [
                                const Icon(
                                  Icons.check_rounded,
                                  size: 21,
                                ),
                                const SizedBox(width: 8),
                                Text(
                                  _editando
                                      ? 'Salvar alterações'
                                      : 'Criar categoria',
                                  style: const TextStyle(
                                    fontWeight: FontWeight.w800,
                                  ),
                                ),
                              ],
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
  }

  Widget _buildLabel(String texto) {
    return Text(
      texto,
      style: const TextStyle(
        color: _text,
        fontSize: 13,
        fontWeight: FontWeight.w700,
      ),
    );
  }

  InputDecoration _inputDecoration({
    required String hint,
    required IconData icon,
    bool alignIconTop = false,
  }) {
    return InputDecoration(
      hintText: hint,
      hintStyle: const TextStyle(
        color: Color(0xff94a3b8),
        fontSize: 14,
      ),
      prefixIcon: Padding(
        padding: alignIconTop
            ? const EdgeInsets.only(
                top: 15,
              )
            : EdgeInsets.zero,
        child: Icon(
          icon,
          color: _muted,
        ),
      ),
      filled: true,
      fillColor: const Color(0xfff8fafc),
      contentPadding: const EdgeInsets.symmetric(
        horizontal: 16,
        vertical: 16,
      ),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(14),
        borderSide: const BorderSide(
          color: _border,
        ),
      ),
      enabledBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(14),
        borderSide: const BorderSide(
          color: _border,
        ),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(14),
        borderSide: const BorderSide(
          color: _primary,
          width: 1.8,
        ),
      ),
      errorBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(14),
        borderSide: const BorderSide(
          color: Color(0xffdc2626),
        ),
      ),
      focusedErrorBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(14),
        borderSide: const BorderSide(
          color: Color(0xffdc2626),
          width: 1.8,
        ),
      ),
    );
  }
}