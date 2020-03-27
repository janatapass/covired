import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_colors.dart';

class AuthenticationButton extends StatelessWidget {
  VoidCallback onPressed;
  final buttonText;

  @override
  Widget build(BuildContext context) {
    return FlatButton(
      padding: EdgeInsets.fromLTRB(24, 8, 24, 8),
      shape:
          RoundedRectangleBorder(borderRadius: new BorderRadius.circular(12.0)),
      onPressed: onPressed,
      textColor: AppColors.white,
      color: Colors.green,
      child: Text(buttonText),
    );
  }

  AuthenticationButton({this.onPressed, this.buttonText})
      : assert(buttonText != null, "Button text should not be null"),
        assert(onPressed != null,
            "Buttton on press listener has to be implemented");
}
