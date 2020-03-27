import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/image_path.dart';
import 'package:janata_curfew/core/widgets/authentication_button.dart';
import 'package:janata_curfew/core/widgets/authentication_text_field.dart';
import 'package:janata_curfew/core/widgets/footer_brand_text.dart';
import 'package:janata_curfew/features/home/presentation/home_screen.dart';

class RegistrationScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return new Scaffold(
        body: Container(
            width: double.infinity,
            height: double.infinity,
            color: Colors.blue.withAlpha(100),
            child: Padding(
              padding: const EdgeInsets.all(48.0),
              child: Column(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  crossAxisAlignment: CrossAxisAlignment.center,
                  children: <Widget>[
                    Flexible(
                      flex: 4,
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.center,
                        crossAxisAlignment: CrossAxisAlignment.center,
                        children: <Widget>[
                        Image.asset(LOGO_APP, width: 120, height: 120,),
                        SizedBox(height: 8),
                        Text('Janata Pass', style: AppTheme.authentication_header),
                      ],),
                    ),
                    SizedBox(height: 24),
                    Flexible(
                      flex: 6,
                      child: Column(
                        mainAxisAlignment: MainAxisAlignment.start,
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: <Widget>[
                          Text('Mobile number',
                              style: AppTheme.authentication_textfield_header),
                          SizedBox(height: 16),
                          AuthenticationTextField(),
                          SizedBox(height: 24),
                          Center(
                            child: AuthenticationButton(
                                buttonText: 'Request OTP',
                                onPressed: () {
                                  Navigator.push(
                                    context,
                                    MaterialPageRoute(
                                        builder: (context) => HomeScreen()),
                                  );
                                }),
                          ),
                        ],
                      ),
                    ),
                    FooterBrandText()
                  ]),
            )));
  }
}
