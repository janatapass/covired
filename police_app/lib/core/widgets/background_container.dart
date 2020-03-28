import 'package:flutter/material.dart';

class BackgroundContainer extends StatelessWidget {
  Widget child;

  @override
  Widget build(BuildContext context) {
    return Container(
        width: double.infinity,
        height: double.infinity,
        color: Colors.blue.withAlpha(100),
        child: child);
  }

  BackgroundContainer({this.child});
}