import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/utils/hex_color.dart';
import 'package:janata_curfew/core/widgets/authentication_button.dart';
import 'package:janata_curfew/features/core/widgets/card_list_tile.dart';
import 'package:janata_curfew/features/core/widgets/trip_details_tile.dart';
import 'package:janata_curfew/features/home/data/models/user_data.dart';
import 'package:intl/intl.dart';

class HomeUserDetailsView extends StatelessWidget {

  final UserData userData;

  HomeUserDetailsView({this.userData});
  @override
  Widget build(BuildContext context) {
    var data = userData.data;
    var date =  (new DateFormat.yMMMd().format(userData.data.cdate));
    var fromTime =  (new DateFormat.jm().format(userData.data.cdate));
    var toTime =  (new DateFormat.jm().format(userData.data.mdate));
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 12),
      child: ListView(
        children: <Widget>[
          CardListTile(title: 'Name', subTitle: data.name, trailing: Icon(Icons.check_circle, color: HexColor.fromHex(data.colorCode))),
          Divider(),
          CardListTile(
              title: 'Mobile Number', subTitle: data.mobile),
          Divider(),
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            mainAxisAlignment: MainAxisAlignment.start,
            children: <Widget>[
              Container(child: Text(date, style: AppTheme.item_sub_title,), padding: EdgeInsets.fromLTRB(16, 16, 16, 0)),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: <Widget>[
                  Flexible(
                      child: TripDetailsTile(
                          title: 'from',
                          subTitle: fromTime)),
                  Flexible(
                      child: TripDetailsTile(
                          title: 'to',
                          subTitle: toTime))
                ],
              )
            ],
          ),
          Divider(),
          CardListTile(
              title: 'Reason Provided', subTitle: '-'),
          Divider(),
          CardListTile(title: 'From Locality', subTitle: data.address),
          Divider(),
          CardListTile(title: 'To Locality', subTitle: data.address),
          Divider(),
          CardListTile(title: 'City', subTitle: data.city),
          Divider(),
          CardListTile(title: 'Vehicle Number', subTitle: '-'),
          Divider(),
          CardListTile(title: 'Previous Warnings', subTitle: '-'),
          Divider(),
          Container(
            padding: EdgeInsets.all(24),
            width: 100,
            child: AuthenticationButton(text: 'Issue Warning', onPressed: () {

            }),
          )
        ],
      ),
    );
  }
}