import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';

class CardListTile extends StatelessWidget {

  final title;
  final subTitle;
  final trailing;
  final style;

  CardListTile({this.title, this.subTitle, this.trailing, this.style});

  @override
  Widget build(BuildContext context) {
    return ListTile(title: Text(title, style: AppTheme.item_title,), subtitle: Text(subTitle, style: style ?? AppTheme.item_sub_title), trailing: trailing);
  }
}