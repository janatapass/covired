
import 'package:flutter/material.dart';

import '../app_theme.dart';

class AuthenticationTextField extends StatelessWidget {

  TextInputType textInputType;
  TextEditingController textEditingController;

  AuthenticationTextField({this.textInputType, this.textEditingController});

  @override
  Widget build(BuildContext context) {
    return  SizedBox(
      height: 48,
      child: TextField(
        controller: textEditingController,
        keyboardType: textInputType,
        style: AppTheme.authentication_textfield,
        decoration: InputDecoration(
          fillColor: Colors.grey.withAlpha(50),
          filled: true,
          focusedBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(4),
              borderSide:  BorderSide(color: Colors.white)
          ),
          enabledBorder: OutlineInputBorder(
              borderRadius: BorderRadius.circular(4),
              borderSide:  BorderSide(color: Colors.white)
          ),
        ),
      ),
    );
  }
}