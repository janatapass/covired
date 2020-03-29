import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_colors.dart';

class AuthenticationButton extends StatelessWidget {
  VoidCallback onPressed;
  final text;

  @override
  Widget build(BuildContext context) {
    return RaisedButton(
      padding: EdgeInsets.fromLTRB(24, 8, 24, 8),
      shape:
          RoundedRectangleBorder(borderRadius: new BorderRadius.circular(4.0)),
      onPressed: onPressed,
      textColor: AppColors.white,
      color: Colors.orange,
      child: Text(text),
    );
  }

  AuthenticationButton({this.onPressed, this.text})
      : assert(text != null, "Button text should not be null"),
        assert(onPressed != null,
            "Buttton on press listener has to be implemented");
}
