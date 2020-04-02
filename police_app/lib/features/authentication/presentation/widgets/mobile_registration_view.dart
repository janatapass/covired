import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/widgets/authentication_button.dart';
import 'package:janata_curfew/core/widgets/authentication_text_field.dart';
import 'package:janata_curfew/features/home/presentation/pages/home_screen.dart';

class MobileRegistrationView extends StatefulWidget {
  RegistrationButtonClick onPressed;

  MobileRegistrationView({this.onPressed});

  @override
  _MobileRegistrationViewState createState() => _MobileRegistrationViewState();
}

class _MobileRegistrationViewState extends State<MobileRegistrationView> {
  TextEditingController textEditingController;

  @override
  void initState() {
    super.initState();
    textEditingController = TextEditingController();
  }

  @override
  Widget build(BuildContext context) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.start,
      crossAxisAlignment: CrossAxisAlignment.start,
      children: <Widget>[
        Text('Mobile number', style: AppTheme.authentication_textfield_header),
        SizedBox(height: 16),
        AuthenticationTextField(
            textInputType: TextInputType.number,
            textEditingController: textEditingController),
        SizedBox(height: 24),
        Center(
          child: AuthenticationButton(
              text: 'Request OTP',
              onPressed: () {
                widget.onPressed(textEditingController.text);
              }),
        ),
      ],
    );
  }
}

typedef RegistrationButtonClick = Function(String);
