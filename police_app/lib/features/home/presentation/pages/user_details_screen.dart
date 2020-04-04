import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/features/home/presentation/widgets/home_user_details_view.dart';

class UserDetailsScreen extends StatelessWidget {

  final userData;

  UserDetailsScreen({this.userData});

  @override
  Widget build(BuildContext context) {
    return new Scaffold(
      appBar: new AppBar(
        backgroundColor: Colors.orange,
        title: new Text('User Details', style: AppTheme.app_bar_text_white),
      ),
      body: HomeUserDetailsView(userData: userData)
    );
  }
}