import 'package:flutter/material.dart';

import 'app_colors.dart';

class AppTheme {
  AppTheme._();

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