import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/widgets/authentication_button.dart';
import 'package:janata_curfew/core/widgets/authentication_text_field.dart';
import 'package:janata_curfew/features/core/widgets/trip_details_tile.dart';
import 'package:janata_curfew/features/core/widgets/card_list_tile.dart';
import 'package:janata_curfew/features/home/presentation/bloc/checkmobile/bloc.dart';
import 'package:janata_curfew/features/home/presentation/widgets/check_mobile_widget.dart';
import 'package:janata_curfew/features/home/presentation/widgets/scan_qr_widget.dart';
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
    bloc.add(ShowMobileField());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        body: BlocBuilder<CheckMobileBloc, CheckMobileBlocState>(
            bloc: bloc,
            builder: (BuildContext context, CheckMobileBlocState state) {
              if (state is Initial) {
                return CheckMobileWidget(onPressed: () {
                  bloc.add(GetUserData(mobile: '9789010929'));
                });
              } else if (state is Loaded) {
                return ScanQrWidget(userData: state.data);
              } else if (state is Loading) {
                return Center(child: CircularProgressIndicator());
              } else if (state is Error) {
                return Center(
                    child: Text('No data found', style: AppTheme.error_text));
              }
              return null;
            }));
  }
}
