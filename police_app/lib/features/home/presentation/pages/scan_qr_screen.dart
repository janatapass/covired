import 'package:barcode_scan/barcode_scan.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:janata_curfew/core/app_colors.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/features/core/widgets/trip_details_tile.dart';
import 'package:janata_curfew/features/core/widgets/card_list_tile.dart';
import 'package:janata_curfew/features/home/presentation/bloc/bloc.dart';
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
                var data = state.data;
                return Padding(
                  padding: const EdgeInsets.symmetric(vertical: 12),
                  child: ListView(
                    children: <Widget>[
                      CardListTile(title: 'Name', subTitle: data.name),
                      CardListTile(
                          title: 'Mobile Number', subTitle: data.mobileNumber),
                      CardListTile(title: 'Address', subTitle: data.address),
                      Card(
                        elevation: 1,
                        margin: EdgeInsets.fromLTRB(8, 4, 8, 4),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          mainAxisAlignment: MainAxisAlignment.start,
                          children: <Widget>[
                            Container(child: Text(data.tripDetails.date, style: AppTheme.item_sub_title,), padding: EdgeInsets.fromLTRB(16, 16, 16, 0)),
                            Row(
                              mainAxisAlignment: MainAxisAlignment.spaceBetween,
                              crossAxisAlignment: CrossAxisAlignment.center,
                              children: <Widget>[
                                Flexible(
                                    child: TripDetailsTile(
                                        subTitleStyle:
                                        AppTheme.item_sub_title_orange,
                                        title: 'from',
                                        subTitle: data.tripDetails.fromPlace,
                                        caption: data.tripDetails.fromTime)),
                                Flexible(
                                    child: TripDetailsTile(
                                        subTitleStyle:
                                        AppTheme.item_sub_title_orange,
                                        title: 'to',
                                        subTitle: data.tripDetails.toPlace,
                                        caption: data.tripDetails.toTime))
                              ],
                            )
                          ],
                        ),
                      ),
                      CardListTile(
                          title: 'Reason for Travel',
                          subTitle: data.reason,
                          style: AppTheme.item_sub_title_orange),
                      CardListTile(
                          title: 'Vehicle Number',
                          subTitle: data.vehicleNumber),
                    ],
                  ),
                );
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
