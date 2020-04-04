import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_spinkit/flutter_spinkit.dart';
import 'package:janata_curfew/core/widgets/loading_dialog.dart';
import 'package:janata_curfew/core/widgets/loading_progress_indicator.dart';
import 'package:janata_curfew/features/authentication/bloc/authentication_bloc.dart';
import 'package:janata_curfew/features/authentication/bloc/authentication_event.dart';
import 'package:janata_curfew/features/authentication/bloc/authentication_state.dart';
import 'package:janata_curfew/features/authentication/presentation/pages/profile_review_screen.dart';
import 'package:janata_curfew/features/authentication/presentation/widgets/mobile_registration_view.dart';
import 'package:janata_curfew/features/authentication/presentation/widgets/otp_registration_view.dart';
import 'package:janata_curfew/features/authentication/presentation/widgets/registration_background.dart';
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
  Widget build(BuildContext context) {
    return new Scaffold(
      body: BlocProvider(
        create: (context) {
          return bloc;
        },
        child: BlocListener<AuthenticationBloc, AuthenticationState>(
            listener: (context, state) {
          if (state is GoToNextPage) {
            goToNextPage(context, state.mobile);
          } if (state is OtpState) {
            Scaffold.of(context).showSnackBar(SnackBar(
              content: Text(state.data.message),
              duration: Duration(seconds: 3),
            ));
          } else if (state is Error) {
            Scaffold.of(context).showSnackBar(SnackBar(
              content: Text(state.message),
              duration: Duration(seconds: 3),
            ));
          }
        }, child: BlocBuilder<AuthenticationBloc, AuthenticationState>(
                builder: (BuildContext context, AuthenticationState state) {
          if (state is RegistrationState) {
            return RegistrationBackground(
                child: MobileRegistrationView(onPressed: (mobile) {
              _onMobileRegistrationButtonPressed(mobile);
            }));
          } else if (state is OtpState) {
            return RegistrationBackground(
                child: OtpRegistrationView(
                    mobile: state.mobile,
                    onPressed: (mobile, otp) {
                      _onOtpButtonPressed(mobile, otp);
                    }));
          } else if (state is Loading) {
            return LoadingProgressIndicator();
          }
          return RegistrationBackground(
              child: MobileRegistrationView(onPressed: (mobile) {
            _onMobileRegistrationButtonPressed(mobile);
          }));
          ;
        })),
      ),
    );
  }

  _onMobileRegistrationButtonPressed(mobile) {
    bloc.add(MobileRegistrationEvent(mobile: mobile));
  }

  _onOtpButtonPressed(mobile, otp) {
    bloc.add(OtpRegistrationEvent(mobile: mobile, otp: otp));
  }

  goToNextPage(context, mobile) async {
    await Navigator.push(
      context,
      MaterialPageRoute(builder: (context) => ProfileReviewScreen(mobile: mobile)),
    );
  }

  @override
  void dispose() {
    super.dispose();
    bloc.close();
  }
}
