import 'package:flutter/material.dart';

import '../services/api_service.dart';
import 'login_page.dart';

class HomePage extends StatefulWidget {
  const HomePage({
    super.key,
  });

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  Map<String, dynamic>? usuario;

  bool carregando = true;

  @override
  void initState() {
    super.initState();

    carregarUsuario();
  }

  Future<void> carregarUsuario() async {
    try {
      final resposta =
          await ApiService.getUser();

      if (!mounted) return;

      setState(() {
        usuario = resposta['user'];
        carregando = false;
      });
    } catch (e) {
      await ApiService.logout();

      if (!mounted) return;

      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (_) => const LoginPage(),
        ),
      );
    }
  }

  Future<void> sair() async {
    await ApiService.logout();

    if (!mounted) return;

    Navigator.pushReplacement(
      context,
      MaterialPageRoute(
        builder: (_) => const LoginPage(),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text(
          'SmartCatalog',
        ),

        actions: [
          IconButton(
            onPressed: sair,
            icon: const Icon(
              Icons.logout,
            ),
          ),
        ],
      ),

      body: carregando
          ? const Center(
              child: CircularProgressIndicator(),
            )

          : Padding(
              padding: const EdgeInsets.all(20),

              child: Column(
                crossAxisAlignment:
                    CrossAxisAlignment.start,

                children: [
                  Text(
                    'Olá, ${usuario?['name'] ?? 'Usuário'}!',

                    style: const TextStyle(
                      fontSize: 26,
                      fontWeight:
                          FontWeight.bold,
                    ),
                  ),

                  const SizedBox(height: 8),

                  Text(
                    usuario?['email'] ?? '',

                    style: const TextStyle(
                      color: Colors.grey,
                    ),
                  ),

                  const SizedBox(height: 30),

                  const Text(
                    'SmartCatalog Mobile',

                    style: TextStyle(
                      fontSize: 20,
                      fontWeight:
                          FontWeight.bold,
                    ),
                  ),

                  const SizedBox(height: 15),

                  const Text(
                    'Login realizado com sucesso. '
                    'A API está conectada ao aplicativo.',
                  ),
                ],
              ),
            ),
    );
  }
}
