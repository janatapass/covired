
import 'package:flutter/material.dart';

import '../app_theme.dart';

class AuthenticationTextField extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return  SizedBox(
      height: 48,
      child: TextField(
        style: AppTheme.authentication_textfield,
        decoration: InputDecoration(
          fillColor: Colors.white.withAlpha(100),
          filled: true,
          focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(12),
              borderSide:  BorderSide(color: Colors.white)
          ),
          enabledBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(12),
              borderSide:  BorderSide(color: Colors.white)
          ),
        ),
      ),
    );
  }
}