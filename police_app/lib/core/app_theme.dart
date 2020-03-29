import 'package:flutter/material.dart';

import 'app_colors.dart';

class AppTheme {
  AppTheme._();

  static const TextStyle app_bar_text = TextStyle(
    fontFamily: 'OpenSans',
    fontWeight: FontWeight.w700,
    fontSize: 18,
    color: AppColors.primary_text,
  );

  static const TextStyle home_tab_selected = TextStyle(
    fontFamily: 'OpenSans',
    fontWeight: FontWeight.w600,
    fontSize: 14,
    letterSpacing: 1,
    color: AppColors.primary_text,
  );

  static const TextStyle home_tab_un_selected = TextStyle(
    fontFamily: 'OpenSans',
    fontWeight: FontWeight.w600,
    fontSize: 14,
    letterSpacing: 1,
    color: AppColors.secondary_text,
  );

  static const TextStyle profile_review_header = TextStyle(
    fontFamily: 'OpenSans',
    fontWeight: FontWeight.w700,
    fontSize: 20,
    color: AppColors.primary_text,
  );

  static const TextStyle profile_review_details_header = TextStyle(
    fontFamily: 'OpenSans',
    fontWeight: FontWeight.w600,
    fontSize: 20,
    color: AppColors.primary_text,
  );

  static const TextStyle profile_review_details_title = TextStyle(
    fontFamily: 'OpenSans',
    fontWeight: FontWeight.w600,
    fontSize: 14,
    color: AppColors.secondary_text,
  );

  static const TextStyle profile_review_details_sub_title = TextStyle(
    fontFamily: 'OpenSans',
    fontWeight: FontWeight.w700,
    fontSize: 14,
    color: AppColors.primary_text,
  );

  static const TextStyle authentication_header = TextStyle(
    fontFamily: 'OpenSans',
    fontWeight: FontWeight.w800,
    fontSize: 28,
    letterSpacing: 1,
    color: AppColors.primary_text,
  );

  static const TextStyle authentication_textfield_header = TextStyle(
    fontFamily: 'OpenSans',
    fontWeight: FontWeight.w800,
    fontSize: 16,
    letterSpacing: 1,
    color: AppColors.primary_text,
  );

  static const TextStyle authentication_textfield = TextStyle(
    fontFamily: 'OpenSans',
    fontWeight: FontWeight.w600,
    fontSize: 14,
    letterSpacing: 1,
      color: AppColors.primary_text,
  );

  static const TextStyle footer_brand_text = TextStyle(
    fontFamily: 'OpenSans',
    fontWeight: FontWeight.w700,
    fontSize: 18,
    letterSpacing: 1,
    color: AppColors.primary_text,
  );

}