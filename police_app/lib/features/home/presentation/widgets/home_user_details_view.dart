import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/features/core/widgets/card_list_tile.dart';
import 'package:janata_curfew/features/core/widgets/trip_details_tile.dart';
import 'package:janata_curfew/features/home/data/models/user_data.dart';

class HomeUserDetailsView extends StatelessWidget {

  final UserData userData;

  HomeUserDetailsView({this.userData});
  @override
  Widget build(BuildContext context) {
    var data = userData.data;
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 12),
      child: ListView(
        children: <Widget>[
          CardListTile(title: 'Name', subTitle: data.name),
          CardListTile(
              title: 'Mobile Number', subTitle: data.mobile),
          CardListTile(title: 'Address', subTitle: data.address),
          Card(
            elevation: 1,
            margin: EdgeInsets.fromLTRB(8, 4, 8, 4),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisAlignment: MainAxisAlignment.start,
              children: <Widget>[
                Container(child: Text(userData.data.cdate, style: AppTheme.item_sub_title,), padding: EdgeInsets.fromLTRB(16, 16, 16, 0)),
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  crossAxisAlignment: CrossAxisAlignment.center,
                  children: <Widget>[
                    Flexible(
                        child: TripDetailsTile(
                            subTitleStyle:
                            AppTheme.item_sub_title_orange,
                            title: 'from',
                            subTitle: "",
                            caption: userData.data.cdate)),
                    Flexible(
                        child: TripDetailsTile(
                            subTitleStyle:
                            AppTheme.item_sub_title_orange,
                            title: 'to',
                            subTitle: "",
                            caption: userData.data.cdate))
                  ],
                )
              ],
            ),
          ),
          CardListTile(
              title: 'Reason for Travel',
              subTitle: '',
              style: AppTheme.item_sub_title_orange),
          CardListTile(
              title: 'Vehicle Number',
              subTitle: ''),
        ],
      ),
    );
  }
}