import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';

class TripDetailsTile extends StatelessWidget {
  final title;
  final subTitle;
  final caption;
  final subTitleStyle;
  final crossAxisAlignment;

  TripDetailsTile({this.title, this.subTitle, this.caption, this.subTitleStyle, this.crossAxisAlignment});

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.start,
          crossAxisAlignment: crossAxisAlignment ?? CrossAxisAlignment.start,
          children: <Widget>[
            Text(title, style: AppTheme.item_title),
            Text(subTitle, style: subTitleStyle ?? AppTheme.item_sub_title),
            Text(caption, style: AppTheme.item_sub_title)
          ],
        ),
      ),
    );
  }
}
