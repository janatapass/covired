import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/widgets/loading_progress_indicator.dart';
import 'package:janata_curfew/features/home/presentation/bloc/checkmobile/bloc.dart';
import 'package:janata_curfew/features/home/presentation/pages/user_details_screen.dart';
import 'package:janata_curfew/features/home/presentation/widgets/check_mobile_field_view.dart';
import 'package:janata_curfew/features/home/presentation/widgets/home_user_details_view.dart';
import 'package:janata_curfew/injections.dart';

class CheckMobileScreen extends StatefulWidget {
  @override
  _CheckMobileScreenState createState() => _CheckMobileScreenState();

  CheckMobileScreen();
}

class _CheckMobileScreenState extends State<CheckMobileScreen> {
  CheckMobileBloc bloc;

  @override
  void initState() {
    super.initState();
    bloc = sl<CheckMobileBloc>();
  }

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body: BlocProvider(
            create: (context) {
              return bloc;
            },
            child: BlocListener<CheckMobileBloc, CheckMobileBlocState>(
              listener: (context, state) {
                if (state is Loaded) {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                        builder: (context) => UserDetailsScreen(userData: state.data)),
                  );
                } else if (state is Error) {
                  Scaffold.of(context).showSnackBar(SnackBar(
                    content: Text(state.message),
                    duration: Duration(seconds: 3),
                  ));
                }
              },
              child: BlocBuilder<CheckMobileBloc, CheckMobileBlocState>(
                  bloc: bloc,
                  builder: (BuildContext context, CheckMobileBlocState state) {
                    if (state is Loading) {
                      return LoadingProgressIndicator();
                    }
                    return CheckMobileFieldView(onPressed: (mobile) {
                      bloc.add(GetUserData(mobile: mobile));
                    });
                  }),
            )));
  }
}
