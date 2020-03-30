import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';

class CardListTile extends StatelessWidget {

  final title;
  final subTitle;
  final style;

  CardListTile({this.title, this.subTitle, this.style});

  @override
  Widget build(BuildContext context) {
    return Card(margin: EdgeInsets.fromLTRB(8, 4, 8, 4), elevation:1, child: ListTile(title: Text(title, style: AppTheme.item_title,), subtitle: Text(subTitle, style: style ?? AppTheme.item_sub_title)));
  }
}