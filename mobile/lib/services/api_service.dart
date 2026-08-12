import 'dart:convert';
import 'dart:io';

import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class ApiService {
  // ============================================================
  // CONFIGURAÇÃO
  // ============================================================

  static const String baseUrl = 'http://192.168.1.38:8000/api';

  // ============================================================
  // LOGIN
  // ============================================================

  static Future<Map<String, dynamic>> login({
    required String email,
    required String password,
  }) async {
    final response = await http.post(
      Uri.parse('$baseUrl/login'),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: jsonEncode({
        'email': email,
        'password': password,
      }),
    );

    final data = _decodeResponse(response);

    if (response.statusCode == 200 && data['success'] == true) {
      final token = data['token'];

      if (token == null || token.toString().isEmpty) {
        throw Exception('Token não recebido pela API.');
      }

      final prefs = await SharedPreferences.getInstance();

      await prefs.setString(
        'token',
        token.toString(),
      );

      if (data['user'] is Map) {
        await prefs.setString(
          'user',
          jsonEncode(data['user']),
        );
      }

      return data;
    }

    throw Exception(
      data['message']?.toString() ??
          'E-mail ou senha incorretos.',
    );
  }

  // ============================================================
  // TOKEN
  // ============================================================

  static Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();

    return prefs.getString('token');
  }

  // ============================================================
  // VERIFICAR LOGIN
  // ============================================================

  static Future<bool> isLoggedIn() async {
    final token = await getToken();

    return token != null && token.isNotEmpty;
  }

  // ============================================================
  // LOGOUT
  // ============================================================

  static Future<void> logout() async {
    final token = await getToken();

    if (token != null && token.isNotEmpty) {
      try {
        await http.post(
          Uri.parse('$baseUrl/logout'),
          headers: {
            'Accept': 'application/json',
            'Authorization': 'Bearer $token',
          },
        );
      } catch (_) {
        // Mesmo se a API falhar,
        // o token local será removido.
      }
    }

    await _clearToken();
  }

  // ============================================================
  // USUÁRIO AUTENTICADO
  // ============================================================

  static Future<Map<String, dynamic>> getUser() async {
    final token = await _requiredToken();

    final response = await http.get(
      Uri.parse('$baseUrl/user'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode == 200 &&
        (data['success'] == true || data['user'] is Map)) {
      if (data['user'] is Map) {
        final prefs = await SharedPreferences.getInstance();

        await prefs.setString(
          'user',
          jsonEncode(data['user']),
        );
      }

      return data;
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao carregar usuário.',
    );
  }

  // ============================================================
  // USUÁRIO SALVO LOCALMENTE
  // ============================================================

  static Future<Map<String, dynamic>?> getLocalUser() async {
    final prefs = await SharedPreferences.getInstance();

    final userJson = prefs.getString('user');

    if (userJson == null || userJson.isEmpty) {
      return null;
    }

    try {
      final data = jsonDecode(userJson);

      if (data is Map<String, dynamic>) {
        return data;
      }

      if (data is Map) {
        return Map<String, dynamic>.from(data);
      }

      return null;
    } catch (_) {
      return null;
    }
  }

  // ============================================================
  // ATUALIZAR PERFIL
  // ============================================================

  static Future<Map<String, dynamic>> updateProfile({
    required String name,
    required String email,
    String? currentPassword,
    String? newPassword,
    String? newPasswordConfirmation,
  }) async {
    final token = await _requiredToken();

    final body = <String, dynamic>{
      'name': name,
      'email': email,
    };

    if (currentPassword != null &&
        currentPassword.trim().isNotEmpty) {
      body['current_password'] = currentPassword;
    }

    if (newPassword != null &&
        newPassword.trim().isNotEmpty) {
      body['password'] = newPassword;
    }

    if (newPasswordConfirmation != null &&
        newPasswordConfirmation.trim().isNotEmpty) {
      body['password_confirmation'] =
          newPasswordConfirmation;
    }

    final response = await http.put(
      Uri.parse('$baseUrl/user'),
      headers: _authHeaders(token),
      body: jsonEncode(body),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      if (data['user'] is Map) {
        final prefs = await SharedPreferences.getInstance();

        await prefs.setString(
          'user',
          jsonEncode(data['user']),
        );
      }

      return data;
    }

    if (response.statusCode == 422) {
      throw Exception(
        _extractValidationErrors(data),
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao atualizar perfil.',
    );
  }

  // ============================================================
  // DASHBOARD
  // ============================================================

  static Future<Map<String, dynamic>> getDashboard() async {
    final token = await _requiredToken();

    final response = await http.get(
      Uri.parse('$baseUrl/dashboard'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode == 200) {
      return data;
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao carregar dashboard.',
    );
  }

  // ============================================================
  // CATEGORIAS - LISTAR
  // ============================================================

  static Future<List<dynamic>> getCategorias() async {
    final token = await _requiredToken();

    final response = await http.get(
      Uri.parse('$baseUrl/categorias'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return _extractList(data);
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao carregar categorias.',
    );
  }

  // ============================================================
  // CATEGORIA - BUSCAR
  // ============================================================

  static Future<Map<String, dynamic>> getCategoria(int id) async {
    final token = await _requiredToken();

    final response = await http.get(
      Uri.parse('$baseUrl/categorias/$id'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao carregar categoria.',
    );
  }

  // ============================================================
  // CATEGORIA - CRIAR
  // ============================================================

  static Future<Map<String, dynamic>> criarCategoria({
    required String nome,
    String? descricao,
  }) async {
    final token = await _requiredToken();

    final body = <String, dynamic>{
      'nome': nome,
    };

    if (descricao != null &&
        descricao.trim().isNotEmpty) {
      body['descricao'] = descricao;
    }

    final response = await http.post(
      Uri.parse('$baseUrl/categorias'),
      headers: _authHeaders(token),
      body: jsonEncode(body),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    if (response.statusCode == 422) {
      throw Exception(
        _extractValidationErrors(data),
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao criar categoria.',
    );
  }

  // ============================================================
  // CATEGORIA - ATUALIZAR
  // ============================================================

  static Future<Map<String, dynamic>> atualizarCategoria({
    required int id,
    required String nome,
    String? descricao,
  }) async {
    final token = await _requiredToken();

    final body = <String, dynamic>{
      'nome': nome,
      'descricao': descricao ?? '',
    };

    final response = await http.put(
      Uri.parse('$baseUrl/categorias/$id'),
      headers: _authHeaders(token),
      body: jsonEncode(body),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    if (response.statusCode == 422) {
      throw Exception(
        _extractValidationErrors(data),
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao atualizar categoria.',
    );
  }

  // ============================================================
  // CATEGORIA - EXCLUIR
  // ============================================================

  static Future<void> excluirCategoria(int id) async {
    final token = await _requiredToken();

    final response = await http.delete(
      Uri.parse('$baseUrl/categorias/$id'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return;
    }

    final data = _decodeResponse(response);

    throw Exception(
      data['message']?.toString() ??
          'Erro ao excluir categoria.',
    );
  }

  // ============================================================
  // PRODUTOS - LISTAR
  // ============================================================

  static Future<List<dynamic>> getProdutos() async {
    final token = await _requiredToken();

    final response = await http.get(
      Uri.parse('$baseUrl/produtos'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return _extractList(data);
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao carregar produtos.',
    );
  }

  // ============================================================
  // PRODUTO - BUSCAR
  // ============================================================

  static Future<Map<String, dynamic>> getProduto(int id) async {
    final token = await _requiredToken();

    final response = await http.get(
      Uri.parse('$baseUrl/produtos/$id'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao carregar produto.',
    );
  }

  // ============================================================
  // PRODUTO - CRIAR
  // ============================================================

  static Future<Map<String, dynamic>> criarProduto({
    required String nome,
    required dynamic preco,
    required dynamic estoque,
    int? categoriaId,
  }) async {
    final token = await _requiredToken();

    final body = <String, dynamic>{
      'nome': nome,
      'preco': preco,
      'estoque': estoque,
    };

    if (categoriaId != null) {
      body['categoria_id'] = categoriaId;
    }

    final response = await http.post(
      Uri.parse('$baseUrl/produtos'),
      headers: _authHeaders(token),
      body: jsonEncode(body),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    if (response.statusCode == 422) {
      throw Exception(
        _extractValidationErrors(data),
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao criar produto.',
    );
  }

  // ============================================================
  // PRODUTO - ATUALIZAR
  // ============================================================

  static Future<Map<String, dynamic>> atualizarProduto({
    required int id,
    required String nome,
    required dynamic preco,
    required dynamic estoque,
    int? categoriaId,
  }) async {
    final token = await _requiredToken();

    final body = <String, dynamic>{
      'nome': nome,
      'preco': preco,
      'estoque': estoque,
    };

    if (categoriaId != null) {
      body['categoria_id'] = categoriaId;
    }

    final response = await http.put(
      Uri.parse('$baseUrl/produtos/$id'),
      headers: _authHeaders(token),
      body: jsonEncode(body),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    if (response.statusCode == 422) {
      throw Exception(
        _extractValidationErrors(data),
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao atualizar produto.',
    );
  }

  // ============================================================
  // PRODUTO - EXCLUIR
  // ============================================================

  static Future<void> excluirProduto(int id) async {
    final token = await _requiredToken();

    final response = await http.delete(
      Uri.parse('$baseUrl/produtos/$id'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return;
    }

    final data = _decodeResponse(response);

    throw Exception(
      data['message']?.toString() ??
          'Erro ao excluir produto.',
    );
  }

  // ============================================================
  // ADICIONAR IMAGEM AO PRODUTO
  // ============================================================

  static Future<Map<String, dynamic>> adicionarImagemProduto({
    required int produtoId,
    required String caminhoImagem,
  }) async {
    final token = await _requiredToken();

    final request = http.MultipartRequest(
      'POST',
      Uri.parse(
        '$baseUrl/produtos/$produtoId/imagem',
      ),
    );

    request.headers.addAll({
      'Accept': 'application/json',
      'Authorization': 'Bearer $token',
    });

    request.files.add(
      await http.MultipartFile.fromPath(
        'imagem',
        caminhoImagem,
      ),
    );

    final streamedResponse = await request.send();

    final response = await http.Response.fromStream(
      streamedResponse,
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao enviar imagem.',
    );
  }

  // ============================================================
  // ENVIAR IMAGEM DO PRODUTO
  // ============================================================

  static Future<dynamic> enviarImagemProduto({
    required int produtoId,
    required File imagem,
  }) async {
    final token = await _requiredToken();

    final request = http.MultipartRequest(
      'POST',
      Uri.parse(
        '$baseUrl/produtos/$produtoId/imagem',
      ),
    );

    request.headers.addAll({
      'Accept': 'application/json',
      'Authorization': 'Bearer $token',
    });

    request.files.add(
      await http.MultipartFile.fromPath(
        'imagem',
        imagem.path,
      ),
    );

    final streamedResponse = await request.send();

    final response = await http.Response.fromStream(
      streamedResponse,
    );

    await _checkUnauthorized(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      if (response.body.isEmpty) {
        return null;
      }

      return jsonDecode(response.body);
    }

    throw Exception(
      extrairMensagemErro(response),
    );
  }

  // ============================================================
  // EXCLUIR IMAGEM
  // ============================================================

  static Future<void> excluirImagem(int imagemId) async {
    final token = await _requiredToken();

    final response = await http.delete(
      Uri.parse('$baseUrl/imagem/$imagemId'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return;
    }

    final data = _decodeResponse(response);

    throw Exception(
      data['message']?.toString() ??
          'Erro ao excluir imagem.',
    );
  }

  // ============================================================
  // PEDIDOS - LISTAR
  // ============================================================

  static Future<List<dynamic>> getPedidos() async {
    final token = await _requiredToken();

    final response = await http.get(
      Uri.parse('$baseUrl/pedidos'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return _extractList(data);
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao carregar pedidos.',
    );
  }

  // ============================================================
  // PEDIDO - BUSCAR
  // ============================================================

  static Future<Map<String, dynamic>> getPedido(int id) async {
    final token = await _requiredToken();

    final response = await http.get(
      Uri.parse('$baseUrl/pedidos/$id'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao carregar pedido.',
    );
  }

  // ============================================================
  // PEDIDO - CRIAR
  // ============================================================

  static Future<Map<String, dynamic>> criarPedido({
    String? numero,
    required String status,
    required dynamic valorTotal,
  }) async {
    final token = await _requiredToken();

    final body = <String, dynamic>{
      'status': status,
      'valor_total': valorTotal,
    };

    if (numero != null &&
        numero.trim().isNotEmpty) {
      body['numero'] = numero.trim();
    }

    final response = await http.post(
      Uri.parse('$baseUrl/pedidos'),
      headers: _authHeaders(token),
      body: jsonEncode(body),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    if (response.statusCode == 422) {
      throw Exception(
        _extractValidationErrors(data),
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao criar pedido.',
    );
  }

  // ============================================================
  // RELATÓRIOS
  // ============================================================

  static Future<Map<String, dynamic>> getRelatorios() async {
    final token = await _requiredToken();

    final response = await http.get(
      Uri.parse('$baseUrl/dashboard'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode == 200) {
      return data;
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao carregar relatórios.',
    );
  }

  // ============================================================
  // ESTOQUE - ATUALIZAR QUANTIDADE
  // ============================================================

  static Future<Map<String, dynamic>> atualizarEstoque({
    required int id,
    required int estoque,
  }) async {
    if (estoque < 0) {
      throw Exception(
        'O estoque não pode ser negativo.',
      );
    }

    final token = await _requiredToken();

    final produtoResponse = await http.get(
      Uri.parse('$baseUrl/produtos/$id'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(produtoResponse);

    final produtoData = _decodeResponse(
      produtoResponse,
    );

    if (produtoResponse.statusCode < 200 ||
        produtoResponse.statusCode >= 300) {
      throw Exception(
        produtoData['message']?.toString() ??
            'Erro ao carregar produto.',
      );
    }

    dynamic produto = produtoData['data'];

    if (produto is! Map) {
      produto = produtoData;
    }

    final body = <String, dynamic>{
      'nome': produto['nome'],
      'preco': produto['preco'],
      'estoque': estoque,
    };

    if (produto['categoria_id'] != null) {
      body['categoria_id'] =
          produto['categoria_id'];
    }

    final response = await http.put(
      Uri.parse('$baseUrl/produtos/$id'),
      headers: _authHeaders(token),
      body: jsonEncode(body),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    if (response.statusCode == 422) {
      throw Exception(
        _extractValidationErrors(data),
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao atualizar estoque.',
    );
  }

  // ============================================================
  // ESTOQUE - LISTAR
  // ============================================================

  static Future<Map<String, dynamic>> getEstoque() async {
    final token = await _requiredToken();

    final response = await http.get(
      Uri.parse('$baseUrl/estoque'),
      headers: _authHeaders(token),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao carregar estoque.',
    );
  }

  // ============================================================
  // ESTOQUE - ENTRADA
  // ============================================================

  static Future<Map<String, dynamic>> entradaEstoque({
    required int produtoId,
    required int quantidade,
  }) async {
    if (quantidade <= 0) {
      throw Exception(
        'A quantidade deve ser maior que zero.',
      );
    }

    final token = await _requiredToken();

    final response = await http.post(
      Uri.parse(
        '$baseUrl/estoque/$produtoId/entrada',
      ),
      headers: _authHeaders(token),
      body: jsonEncode({
        'quantidade': quantidade,
      }),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    if (response.statusCode == 422) {
      throw Exception(
        _extractValidationErrors(data),
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao adicionar estoque.',
    );
  }

  // ============================================================
  // ESTOQUE - SAÍDA
  // ============================================================

  static Future<Map<String, dynamic>> saidaEstoque({
    required int produtoId,
    required int quantidade,
  }) async {
    if (quantidade <= 0) {
      throw Exception(
        'A quantidade deve ser maior que zero.',
      );
    }

    final token = await _requiredToken();

    final response = await http.post(
      Uri.parse(
        '$baseUrl/estoque/$produtoId/saida',
      ),
      headers: _authHeaders(token),
      body: jsonEncode({
        'quantidade': quantidade,
      }),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    if (response.statusCode == 422) {
      throw Exception(
        _extractValidationErrors(data),
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao retirar estoque.',
    );
  }

  // ============================================================
  // ESTOQUE - AJUSTAR
  // ============================================================

  static Future<Map<String, dynamic>> ajustarEstoque({
    required int produtoId,
    required int estoque,
  }) async {
    if (estoque < 0) {
      throw Exception(
        'O estoque não pode ser negativo.',
      );
    }

    final token = await _requiredToken();

    final response = await http.put(
      Uri.parse(
        '$baseUrl/estoque/$produtoId/ajustar',
      ),
      headers: _authHeaders(token),
      body: jsonEncode({
        'estoque': estoque,
      }),
    );

    await _checkUnauthorized(response);

    final data = _decodeResponse(response);

    if (response.statusCode >= 200 &&
        response.statusCode < 300) {
      return data;
    }

    if (response.statusCode == 422) {
      throw Exception(
        _extractValidationErrors(data),
      );
    }

    throw Exception(
      data['message']?.toString() ??
          'Erro ao ajustar estoque.',
    );
  }

  // ============================================================
  // HEADERS AUTENTICADOS
  // ============================================================

  static Map<String, String> _authHeaders(String token) {
    return {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'Authorization': 'Bearer $token',
    };
  }

  // ============================================================
  // TOKEN OBRIGATÓRIO
  // ============================================================

  static Future<String> _requiredToken() async {
    final token = await getToken();

    if (token == null || token.isEmpty) {
      throw Exception(
        'Usuário não autenticado.',
      );
    }

    return token;
  }

  // ============================================================
  // VERIFICAR 401
  // ============================================================

  static Future<void> _checkUnauthorized(
    http.Response response,
  ) async {
    if (response.statusCode == 401) {
      await _clearToken();

      throw Exception(
        'Sessão expirada. Faça login novamente.',
      );
    }
  }

  // ============================================================
  // LIMPAR TOKEN
  // ============================================================

  static Future<void> _clearToken() async {
    final prefs = await SharedPreferences.getInstance();

    await prefs.remove('token');
    await prefs.remove('user');
  }

  // ============================================================
  // DECODIFICAR RESPOSTA
  // ============================================================

  static Map<String, dynamic> _decodeResponse(
    http.Response response,
  ) {
    if (response.body.isEmpty) {
      return {};
    }

    try {
      final decoded = jsonDecode(response.body);

      if (decoded is Map<String, dynamic>) {
        return decoded;
      }

      if (decoded is Map) {
        return Map<String, dynamic>.from(decoded);
      }

      return {
        'data': decoded,
      };
    } catch (_) {
      return {
        'message': response.body,
      };
    }
  }

  // ============================================================
  // EXTRAIR LISTA
  // ============================================================

  static List<dynamic> _extractList(
    Map<String, dynamic> data,
  ) {
    if (data['data'] is List) {
      return data['data'] as List<dynamic>;
    }

    if (data['categorias'] is List) {
      return data['categorias'] as List<dynamic>;
    }

    if (data['produtos'] is List) {
      return data['produtos'] as List<dynamic>;
    }

    if (data['pedidos'] is List) {
      return data['pedidos'] as List<dynamic>;
    }

    if (data['estoque'] is List) {
      return data['estoque'] as List<dynamic>;
    }

    return [];
  }

  // ============================================================
  // ERROS DE VALIDAÇÃO
  // ============================================================

  static String _extractValidationErrors(
    Map<String, dynamic> data,
  ) {
    if (data['errors'] is Map) {
      final errors = data['errors'] as Map;

      final mensagens = <String>[];

      for (final valor in errors.values) {
        if (valor is List) {
          mensagens.addAll(
            valor.map(
              (e) => e.toString(),
            ),
          );
        } else {
          mensagens.add(
            valor.toString(),
          );
        }
      }

      if (mensagens.isNotEmpty) {
        return mensagens.join('\n');
      }
    }

    return data['message']?.toString() ??
        'Existem erros nos dados enviados.';
  }

  // ============================================================
  // EXTRAIR MENSAGEM DE ERRO
  // ============================================================

  static String extrairMensagemErro(
    http.Response response,
  ) {
    if (response.body.isEmpty) {
      return 'Erro na comunicação com o servidor.';
    }

    try {
      final decoded = jsonDecode(response.body);

      if (decoded is Map) {
        if (decoded['message'] != null) {
          return decoded['message'].toString();
        }

        if (decoded['error'] != null) {
          return decoded['error'].toString();
        }

        if (decoded['errors'] is Map) {
          final erros = decoded['errors'] as Map;

          final mensagens = <String>[];

          for (final valor in erros.values) {
            if (valor is List) {
              mensagens.addAll(
                valor.map(
                  (e) => e.toString(),
                ),
              );
            } else {
              mensagens.add(
                valor.toString(),
              );
            }
          }

          if (mensagens.isNotEmpty) {
            return mensagens.join('\n');
          }
        }
      }
    } catch (_) {
      // Continua para retornar o corpo original.
    }

    return response.body;
  }
}