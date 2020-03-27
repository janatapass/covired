import 'package:flutter/material.dart';
import 'package:janata_curfew/features/authentication/presentation/registration_screen.dart';


void main() => runApp(JanataApp());

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

