import 'package:flutter/material.dart';

import 'pages/login_page.dart';
import 'pages/dashboard_page.dart';
import 'pages/produtos_page.dart';
import 'pages/produto_form_page.dart';
import 'pages/categorias_page.dart';
import 'pages/categoria_form_page.dart';
import 'pages/estoque_page.dart';
import 'pages/pedidos_page.dart';
import 'pages/relatorios_page.dart';

void main() {
  runApp(const SmartCatalogApp());
}

class SmartCatalogApp extends StatelessWidget {
  const SmartCatalogApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,

      title: 'SmartCatalog',

      theme: ThemeData(
        useMaterial3: true,

        colorScheme: ColorScheme.fromSeed(
          seedColor: const Color(0xff2563eb),
        ),

        scaffoldBackgroundColor:
            const Color(0xfff5f7fb),
      ),

      initialRoute: '/login',

      routes: {
        '/login': (context) => const LoginPage(),

        '/dashboard': (context) =>
            const DashboardPage(),

        '/produtos': (context) =>
            const ProdutosPage(),

        '/produto-form': (context) =>
            const ProdutoFormPage(),

        '/categorias': (context) =>
            const CategoriasPage(),

        '/categoria-form': (context) =>
            const CategoriaFormPage(),

        '/estoque': (context) =>
            const EstoquePage(),

        '/pedidos': (context) =>
            const PedidosPage(),

        '/relatorios': (context) =>
            const RelatoriosPage(),
      },
    );
  }
}