import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/image_path.dart';
import 'package:janata_curfew/core/widgets/background_container.dart';
import 'package:janata_curfew/core/widgets/footer_brand_text.dart';
import 'package:janata_curfew/features/authentication/presentation/mobile_registration_view.dart';
import 'package:janata_curfew/features/authentication/presentation/otp_registration_view.dart';

class RegistrationScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return new Scaffold(
        body: BackgroundContainer(
          child: Padding(
            padding: const EdgeInsets.all(48.0),
            child: LayoutBuilder(
              builder: (context, constraint) {
                return SingleChildScrollView(
                  child: ConstrainedBox(
                    constraints: BoxConstraints(minHeight: constraint.maxHeight),
                    child: IntrinsicHeight(
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
                                  Image.asset(
                                    LOGO_APP,
                                    width: 120,
                                    height: 120,
                                  ),
                                  SizedBox(height: 8),
                                  Text('Janata Pass',
                                      style: AppTheme.authentication_header),
                                ],
                              ),
                            ),
                            SizedBox(height: 24),
                            Flexible(flex: 6, child: OtpRegistrationView()),
                            FooterBrandText()
                          ]),
                    ),
                  ),
                );
              },
            ),
          ),
        ));
  }
}
