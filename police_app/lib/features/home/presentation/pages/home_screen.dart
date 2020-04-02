import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_colors.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/features/home/presentation/pages/check_mobile_screen.dart';
import 'package:janata_curfew/features/home/presentation/pages/scan_qr_screen.dart';

class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen>
    with SingleTickerProviderStateMixin {
  TabController _tabController;

  @override
  void initState() {
    super.initState();
    _tabController = new TabController(vsync: this, length: 2);
  }

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
          drawer: Drawer(),
          appBar: AppBar(
            iconTheme: new IconThemeData(color: Colors.black),
            elevation: 0,
            backgroundColor: Colors.white,
            title: Text(
              'Verify',
              style: AppTheme.app_bar_text,
            ),
            bottom: TabBar(
              controller: _tabController,
              labelColor: AppColors.primary_text,
              labelStyle: AppTheme.home_tab_selected,
              unselectedLabelStyle: AppTheme.home_tab_un_selected,
              indicatorColor: Colors.orange,
              tabs: [
                Tab(child: Text('Check Mobile')),
                Tab(child: Text('Check QR'))
              ],
            ),
          ),
          body: TabBarView(
            controller: _tabController,
            children: [
              CheckMobileScreen(),
              ScanQrScreen(),
            ],
          )),
    );
  }

  @override
  void dispose() {
    _tabController.dispose();
    super.dispose();
  }
}
