import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/widgets/authentication_button.dart';
import 'package:janata_curfew/core/widgets/authentication_text_field.dart';

class CheckMobileFieldView extends StatelessWidget {

  VoidCallback onPressed;


  CheckMobileFieldView({this.onPressed});

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(24.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: <Widget>[
          Text('Mobile number',
              style: AppTheme.item_sub_title),
          SizedBox(height: 16),
          AuthenticationTextField(
              textInputType: TextInputType.number),
          SizedBox(height: 24),
          Center(
            child: AuthenticationButton(
                text: 'Submit',
                onPressed: onPressed,
          ),
          )],
      ),
    );
  }
}