import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/widgets/authentication_button.dart';
import 'package:janata_curfew/core/widgets/authentication_text_field.dart';
import 'package:janata_curfew/features/home/presentation/home_screen.dart';

class MobileRegistrationView extends StatelessWidget {

  VoidCallback onPressed;

  MobileRegistrationView({this.onPressed});

  @override
  Widget build(BuildContext context) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.start,
      crossAxisAlignment: CrossAxisAlignment.start,
      children: <Widget>[
        Text('Mobile number',
            style: AppTheme.authentication_textfield_header),
        SizedBox(height: 16),
        AuthenticationTextField(textInputType: TextInputType.number),
        SizedBox(height: 24),
        Center(
          child: AuthenticationButton(
              text: 'Request OTP',
              onPressed: onPressed),
        ),
      ],
    );
  }
}