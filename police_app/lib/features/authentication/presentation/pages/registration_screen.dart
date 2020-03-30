import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/image_path.dart';
import 'package:janata_curfew/core/widgets/background_container.dart';
import 'package:janata_curfew/core/widgets/footer_brand_text.dart';
import 'package:janata_curfew/features/authentication/bloc/authentication_bloc.dart';
import 'package:janata_curfew/features/authentication/bloc/authentication_event.dart';
import 'package:janata_curfew/features/authentication/bloc/authentication_state.dart';
import 'package:janata_curfew/features/authentication/presentation/pages/profile_review_screen.dart';
import 'package:janata_curfew/features/authentication/presentation/widgets/mobile_registration_view.dart';
import 'package:janata_curfew/features/authentication/presentation/widgets/otp_registration_view.dart';
import 'package:janata_curfew/features/home/presentation/pages/home_screen.dart';
import 'package:janata_curfew/injections.dart';

class RegistrationScreen extends StatefulWidget {
  @override
  _RegistrationScreenState createState() => _RegistrationScreenState();
}

class _RegistrationScreenState extends State<RegistrationScreen> {
  AuthenticationBloc bloc;

  @override
  void initState() {
    super.initState();
    bloc = sl<AuthenticationBloc>();
  }

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    bloc.add(MobileRegistrationEvent());
  }

  @override
  Widget build(BuildContext context) {
    return new Scaffold(
        body: BlocBuilder<AuthenticationBloc, AuthenticationState>(
            bloc: bloc,
            builder: (BuildContext context, AuthenticationState state) {
              if (state is ScreenLoaded) {
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
                                  mainAxisAlignment:
                                      MainAxisAlignment.spaceBetween,
                                  crossAxisAlignment: CrossAxisAlignment.center,
                                  children: <Widget>[
                                    Flexible(
                                      flex: 5,
                                      child: Column(
                                        mainAxisAlignment:
                                            MainAxisAlignment.center,
                                        crossAxisAlignment:
                                            CrossAxisAlignment.center,
                                        children: <Widget>[
                                          Image.asset(
                                            LOGO_APP,
                                            width: 120,
                                            height: 120,
                                          ),
                                          SizedBox(height: 8),
                                          Text('Janata Pass',
                                              style: AppTheme
                                                  .authentication_header),
                                        ],
                                      ),
                                    ),
                                    Flexible(
                                        flex: 5,
                                        child: state.data ==
                                                ScreenState.MOBILE_REGISTRATION
                                            ? MobileRegistrationView(
                                                onPressed: () {
                                                bloc.add(
                                                    OtpRegistrationEvent());
                                              })
                                            : OtpRegistrationView(
                                                onPressed: () {
                                                Navigator.push(
                                                  context,
                                                  MaterialPageRoute(
                                                      builder: (context) =>
                                                          ProfileReviewScreen()),
                                                );
                                              })),
                                    FooterBrandText()
                                  ]),
                            ),
                          ),
                        );
                      },
                    ),
                  ),
                );
              } else if (state is Error) {
                return null;
              }
              return null;
            }));
  }

  PageController _controller = PageController(
    initialPage: 1,
  );

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }
}
