import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/widgets/authentication_button.dart';
import 'package:janata_curfew/core/widgets/authentication_text_field.dart';

class CheckMobileFieldView extends StatefulWidget {

  Function(String mobile) onPressed;


  CheckMobileFieldView({this.onPressed});

  @override
  _CheckMobileFieldViewState createState() => _CheckMobileFieldViewState();
}

class _CheckMobileFieldViewState extends State<CheckMobileFieldView> {

  TextEditingController textEditingController;

  @override
  void initState() {
    super.initState();
    textEditingController = new TextEditingController();
  }

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
            textEditingController: textEditingController,
              textInputType: TextInputType.number),
          SizedBox(height: 24),
          Center(
            child: AuthenticationButton(
                text: 'Submit',
                onPressed: () {
                  widget.onPressed(textEditingController.text);
                },
          ),
          )],
      ),
    );
  }
}