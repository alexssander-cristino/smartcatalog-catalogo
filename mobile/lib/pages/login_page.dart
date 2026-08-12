import 'package:flutter/material.dart';

import '../services/api_service.dart';
import 'dashboard_page.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final _formKey = GlobalKey<FormState>();

  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  bool _carregando = false;
  bool _mostrarSenha = false;

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();

    super.dispose();
  }

  Future<void> _login() async {
    if (!_formKey.currentState!.validate()) {
      return;
    }

    FocusScope.of(context).unfocus();

    setState(() {
      _carregando = true;
    });

    try {
      await ApiService.login(
        email: _emailController.text.trim(),
        password: _passwordController.text,
      );

      if (!mounted) {
        return;
      }

      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (_) => const DashboardPage(),
        ),
      );
    } catch (e) {
      if (!mounted) {
        return;
      }

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(
            e.toString().replaceFirst(
              'Exception: ',
              '',
            ),
          ),
          backgroundColor: const Color(0xffdc2626),
          behavior: SnackBarBehavior.floating,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
          margin: const EdgeInsets.all(16),
        ),
      );
    } finally {
      if (mounted) {
        setState(() {
          _carregando = false;
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xfff5f7fb),
      body: SafeArea(
        child: Center(
          child: SingleChildScrollView(
            padding: const EdgeInsets.all(24),
            child: ConstrainedBox(
              constraints: const BoxConstraints(
                maxWidth: 430,
              ),
              child: _buildLoginCard(),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildLoginCard() {
    return Container(
      padding: const EdgeInsets.all(30),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(22),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(.07),
            blurRadius: 30,
            offset: const Offset(0, 12),
          ),
        ],
      ),
      child: Form(
        key: _formKey,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            _buildLogo(),

            const SizedBox(height: 24),

            const Text(
              'Bem-vindo de volta!',
              textAlign: TextAlign.center,
              style: TextStyle(
                color: Color(0xff111827),
                fontSize: 25,
                fontWeight: FontWeight.w800,
              ),
            ),

            const SizedBox(height: 8),

            const Text(
              'Entre para acessar o painel do SmartCatalog.',
              textAlign: TextAlign.center,
              style: TextStyle(
                color: Color(0xff64748b),
                fontSize: 13,
                height: 1.4,
              ),
            ),

            const SizedBox(height: 32),

            _buildLabel('E-mail'),

            const SizedBox(height: 7),

            _buildEmailField(),

            const SizedBox(height: 20),

            _buildLabel('Senha'),

            const SizedBox(height: 7),

            _buildPasswordField(),

            const SizedBox(height: 28),

            _buildLoginButton(),

            const SizedBox(height: 24),

            Row(
              children: [
                Expanded(
                  child: Container(
                    height: 1,
                    color: const Color(0xffe5e7eb),
                  ),
                ),

                const Padding(
                  padding: EdgeInsets.symmetric(
                    horizontal: 12,
                  ),
                  child: Text(
                    'SmartCatalog',
                    style: TextStyle(
                      color: Color(0xff94a3b8),
                      fontSize: 11,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ),

                Expanded(
                  child: Container(
                    height: 1,
                    color: const Color(0xffe5e7eb),
                  ),
                ),
              ],
            ),

            const SizedBox(height: 18),

            const Text(
              'Sistema de gerenciamento de catálogo',
              textAlign: TextAlign.center,
              style: TextStyle(
                color: Color(0xff94a3b8),
                fontSize: 11,
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildLogo() {
    return Center(
      child: Container(
        width: 76,
        height: 76,
        decoration: BoxDecoration(
          gradient: const LinearGradient(
            colors: [
              Color(0xff3b82f6),
              Color(0xff1d4ed8),
            ],
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
          ),
          borderRadius: BorderRadius.circular(20),
          boxShadow: [
            BoxShadow(
              color: const Color(0xff2563eb)
                  .withOpacity(.25),
              blurRadius: 18,
              offset: const Offset(0, 8),
            ),
          ],
        ),
        child: const Icon(
          Icons.inventory_2_outlined,
          color: Colors.white,
          size: 40,
        ),
      ),
    );
  }

  Widget _buildLabel(String texto) {
    return Text(
      texto,
      style: const TextStyle(
        color: Color(0xff334155),
        fontSize: 13,
        fontWeight: FontWeight.w700,
      ),
    );
  }

  Widget _buildEmailField() {
    return TextFormField(
      controller: _emailController,
      keyboardType: TextInputType.emailAddress,
      textInputAction: TextInputAction.next,
      style: const TextStyle(
        color: Color(0xff111827),
        fontSize: 14,
      ),
      decoration: InputDecoration(
        hintText: 'seu@email.com',
        hintStyle: const TextStyle(
          color: Color(0xff94a3b8),
        ),
        prefixIcon: const Icon(
          Icons.email_outlined,
          color: Color(0xff64748b),
          size: 21,
        ),
        filled: true,
        fillColor: const Color(0xfff8fafc),
        contentPadding:
            const EdgeInsets.symmetric(
          horizontal: 16,
          vertical: 16,
        ),
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            color: Color(0xffe2e8f0),
          ),
        ),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            color: Color(0xffe2e8f0),
          ),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            color: Color(0xff2563eb),
            width: 1.5,
          ),
        ),
        errorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            color: Color(0xffdc2626),
          ),
        ),
        focusedErrorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            color: Color(0xffdc2626),
            width: 1.5,
          ),
        ),
      ),
      validator: (value) {
        if (value == null ||
            value.trim().isEmpty) {
          return 'Digite seu e-mail.';
        }

        if (!value.contains('@')) {
          return 'Digite um e-mail válido.';
        }

        return null;
      },
    );
  }

  Widget _buildPasswordField() {
    return TextFormField(
      controller: _passwordController,
      obscureText: !_mostrarSenha,
      textInputAction: TextInputAction.done,
      onFieldSubmitted: (_) {
        if (!_carregando) {
          _login();
        }
      },
      style: const TextStyle(
        color: Color(0xff111827),
        fontSize: 14,
      ),
      decoration: InputDecoration(
        hintText: 'Digite sua senha',
        hintStyle: const TextStyle(
          color: Color(0xff94a3b8),
        ),
        prefixIcon: const Icon(
          Icons.lock_outline,
          color: Color(0xff64748b),
          size: 21,
        ),
        suffixIcon: IconButton(
          onPressed: () {
            setState(() {
              _mostrarSenha = !_mostrarSenha;
            });
          },
          icon: Icon(
            _mostrarSenha
                ? Icons.visibility_off_outlined
                : Icons.visibility_outlined,
            color: const Color(0xff64748b),
            size: 21,
          ),
        ),
        filled: true,
        fillColor: const Color(0xfff8fafc),
        contentPadding:
            const EdgeInsets.symmetric(
          horizontal: 16,
          vertical: 16,
        ),
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            color: Color(0xffe2e8f0),
          ),
        ),
        enabledBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            color: Color(0xffe2e8f0),
          ),
        ),
        focusedBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            color: Color(0xff2563eb),
            width: 1.5,
          ),
        ),
        errorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            color: Color(0xffdc2626),
          ),
        ),
        focusedErrorBorder: OutlineInputBorder(
          borderRadius: BorderRadius.circular(12),
          borderSide: const BorderSide(
            color: Color(0xffdc2626),
            width: 1.5,
          ),
        ),
      ),
      validator: (value) {
        if (value == null || value.isEmpty) {
          return 'Digite sua senha.';
        }

        return null;
      },
    );
  }

  Widget _buildLoginButton() {
    return SizedBox(
      height: 52,
      child: ElevatedButton(
        onPressed: _carregando ? null : _login,
        style: ElevatedButton.styleFrom(
          backgroundColor: const Color(0xff2563eb),
          disabledBackgroundColor:
              const Color(0xff93c5fd),
          foregroundColor: Colors.white,
          elevation: 0,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
        ),
        child: AnimatedSwitcher(
          duration: const Duration(
            milliseconds: 200,
          ),
          child: _carregando
              ? const SizedBox(
                  key: ValueKey('loading'),
                  width: 23,
                  height: 23,
                  child: CircularProgressIndicator(
                    strokeWidth: 2.5,
                    valueColor:
                        AlwaysStoppedAnimation<Color>(
                      Colors.white,
                    ),
                  ),
                )
              : const Row(
                  key: ValueKey('login'),
                  mainAxisAlignment:
                      MainAxisAlignment.center,
                  children: [
                    Icon(
                      Icons.login_rounded,
                      size: 20,
                    ),
                    SizedBox(width: 9),
                    Text(
                      'Entrar no painel',
                      style: TextStyle(
                        fontSize: 15,
                        fontWeight: FontWeight.w800,
                      ),
                    ),
                  ],
                ),
        ),
      ),
    );
  }
}