import 'package:flutter_test/flutter_test.dart';
import 'package:mobile/main.dart';

void main() {
  testWidgets('SmartCatalog inicia corretamente', (WidgetTester tester) async {
    await tester.pumpWidget(const SmartCatalogApp());

    expect(find.text('SmartCatalog'), findsOneWidget);
  });
}