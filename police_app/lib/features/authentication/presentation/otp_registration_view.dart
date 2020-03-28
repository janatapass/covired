import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/widgets/authentication_button.dart';
import 'package:janata_curfew/features/home/presentation/home_screen.dart';
import 'package:pin_code_fields/pin_code_fields.dart';

class OtpRegistrationView extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.start,
      crossAxisAlignment: CrossAxisAlignment.start,
      children: <Widget>[
        Text('Enter your OTP',
            style: AppTheme.authentication_textfield_header),
        SizedBox(height: 16),
        PinCodeTextField(
          selectedColor: Colors.black,
          inactiveColor: Colors.black.withAlpha(100),
          backgroundColor: Colors.transparent,
          activeColor: Colors.black,
          length: 4,
          obsecureText: false,
          shape: PinCodeFieldShape.box,
          borderRadius: BorderRadius.circular(5),
          fieldHeight: 50,
          fieldWidth: 60,
          onChanged: (value) {
          },
        ),
        SizedBox(height: 24),
        Center(
          child: AuthenticationButton(
              buttonText: 'Submit',
              onPressed: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                      builder: (context) => HomeScreen()),
                );
              }),
        ),
      ],
    );
  }
}