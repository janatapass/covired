import 'package:flutter/material.dart';

class BackgroundContainer extends StatelessWidget {
  Widget child;
  Color color;

  @override
  Widget build(BuildContext context) {
    return Container(
        width: double.infinity,
        height: double.infinity,
        color: color ?? Colors.white,
        child: child);
  }

  BackgroundContainer({this.child, this.color});
}