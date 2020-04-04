import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/widgets/authentication_button.dart';
import 'package:janata_curfew/features/home/presentation/pages/home_screen.dart';
import 'package:pin_code_fields/pin_code_fields.dart';

class OtpRegistrationView extends StatefulWidget {

  OtpButtonClick onPressed;
  String mobile;

  OtpRegistrationView({this.mobile, this.onPressed});

  @override
  _OtpRegistrationViewState createState() => _OtpRegistrationViewState();
}

class _OtpRegistrationViewState extends State<OtpRegistrationView> {

  String otp;

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
          textInputType: TextInputType.number,
          selectedColor: Colors.orange,
          inactiveColor: Colors.grey.withAlpha(50),
          backgroundColor: Colors.transparent,
          activeColor: Colors.black,
          length: 4,
          obsecureText: false,
          shape: PinCodeFieldShape.box,
          borderRadius: BorderRadius.circular(5),
          fieldHeight: 50,
          fieldWidth: 60,
          onChanged: (value) {
            this.otp = value;
          },
        ),
        SizedBox(height: 24),
        Center(
          child: AuthenticationButton(
              text: 'Submit',
              onPressed: () {
                widget.onPressed(widget.mobile, otp);
              }
          ),
        ),
      ],
    );
  }
}

typedef OtpButtonClick = Function(String, String);
