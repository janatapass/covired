import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';

class ProfileReviewItem extends StatelessWidget {
  final title;
  final subTitle;

  @override
  Widget build(BuildContext context) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: <Widget>[
        Flexible(
          flex: 5,
          child: Container(
            width: double.infinity,
            child: Text(title ?? "",
                style: AppTheme.profile_review_details_title,
                textAlign: TextAlign.start),
          ),
        ),
        Flexible(
          flex: 5,
          child: Container(
            width: double.infinity,
            child: Text(subTitle ?? "",
                style: AppTheme.profile_review_details_sub_title,
                textAlign: TextAlign.start),
          ),
        )
      ],
    );
  }

  ProfileReviewItem({this.title, this.subTitle});
}
