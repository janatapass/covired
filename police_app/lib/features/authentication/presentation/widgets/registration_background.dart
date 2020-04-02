import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/image_path.dart';
import 'package:janata_curfew/core/widgets/background_container.dart';
import 'package:janata_curfew/core/widgets/footer_brand_text.dart';

class RegistrationBackground extends StatelessWidget {

  final Widget child;


  RegistrationBackground({this.child});

  @override
  Widget build(BuildContext context) {
    return BackgroundContainer(
      child: Padding(
        padding: const EdgeInsets.all(48.0),
        child: LayoutBuilder(
          builder: (context, constraint) {
            return SingleChildScrollView(
              child: ConstrainedBox(
                constraints:
                BoxConstraints(minHeight: constraint.maxHeight),
                child: IntrinsicHeight(
                  child: Column(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: <Widget>[
                        Flexible(
                          flex: 5,
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
                        Flexible(
                            flex: 5,
                            child: child),
                        FooterBrandText()
                      ]),
                ),
              ),
            );
          },
        ),
      ),
    );
  }
}