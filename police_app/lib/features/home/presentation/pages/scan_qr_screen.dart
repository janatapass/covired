import 'package:barcode_scan/barcode_scan.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:janata_curfew/core/app_colors.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/features/core/widgets/trip_details_tile.dart';
import 'package:janata_curfew/features/core/widgets/card_list_tile.dart';
import 'package:janata_curfew/features/home/presentation/bloc/qr/bloc.dart';
import 'package:janata_curfew/features/home/presentation/widgets/scan_qr_widget.dart';
import 'package:janata_curfew/injections.dart';
import 'package:flutter/services.dart';

class ScanQrScreen extends StatefulWidget {
  @override
  _ScanQrScreenState createState() => _ScanQrScreenState();

  ScanQrScreen();
}

class _ScanQrScreenState extends State<ScanQrScreen> {
  QrBloc bloc;

  @override
  void initState() {
    super.initState();
    bloc = sl<QrBloc>();
  }

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    bloc.add(ScanQrEvent());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      floatingActionButton: FloatingActionButton(backgroundColor: AppColors.green, child: Icon(FontAwesomeIcons.qrcode),onPressed: () {
        scan();
      }),
        body: BlocBuilder<QrBloc, QrBlocState>(
            bloc: bloc,
            builder: (BuildContext context, QrBlocState state) {
              if (state is Initial) {
                scan();
                return CircularProgressIndicator();
              } else if (state is Loaded) {
                return ScanQrWidget(userData: state.data);
              } else if (state is Loading) {
                return Center(child: CircularProgressIndicator());
              } else if (state is Error) {
                return Center(child: Text('No data found', style: AppTheme.error_text));
              }
              return null;
            }));
  }

  Future scan() async {
    String barcode = "";
    try {
      barcode = await BarcodeScanner.scan();
    } on PlatformException catch (e) {
      if (e.code == BarcodeScanner.CameraAccessDenied) {
//        barcode = 'The user did not grant the camera permission!';
      } else {
//        barcode = 'Unknown error: $e';
      }
    } on FormatException {
//      barcode =
//          'null (User returned using the "back"-button before scanning anything. Result)';
    } catch (e) {
//      barcode = 'Unknown error: $e';
    }
    bloc.add(GetUserQrData(barcode: barcode));
  }
}
