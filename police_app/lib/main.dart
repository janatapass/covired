import 'package:flutter/material.dart';
import 'package:janata_curfew/features/authentication/presentation/pages/registration_screen.dart';
import 'injections.dart' as di;


void main() async {
  await di.init();
  runApp(JanataApp());
}

class JanataApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Flutter Demo',
      theme: ThemeData(
        primarySwatch: Colors.green,
      ),
      home: RegistrationScreen(),
    );
  }
}

