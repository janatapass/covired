import 'package:flutter/material.dart';
import 'package:barcode_scan/barcode_scan.dart';
import 'package:flutter/services.dart';
import 'package:janata_curfew/core/app_colors.dart';
import 'package:janata_curfew/core/app_theme.dart';

class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen>
    with SingleTickerProviderStateMixin {
  String barcode = "";
  TabController _tabController;

  @override
  void initState() {
    super.initState();
    _tabController = new TabController(vsync: this, length: 2);
    _tabController.addListener(_handleTabChange);
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
                Tab(icon: Text('Check Mobile')),
                Tab(icon: Text('Check QR'))
              ],
            ),
          ),
          body: TabBarView(
            controller: _tabController,
            children: [
              Center(child: Text('Mobile')),
              Center(child: Text(barcode)),
            ],
          )),
    );
  }

  Future scan() async {
    try {
      String barcode = await BarcodeScanner.scan();
      setState(() => this.barcode = barcode);
    } on PlatformException catch (e) {
      if (e.code == BarcodeScanner.CameraAccessDenied) {
        setState(() {
          this.barcode = 'The user did not grant the camera permission!';
        });
      } else {
        setState(() => this.barcode = 'Unknown error: $e');
      }
    } on FormatException {
      setState(() => this.barcode =
          'null (User returned using the "back"-button before scanning anything. Result)');
    } catch (e) {
      setState(() => this.barcode = 'Unknown error: $e');
    }
  }

  void _handleTabChange() {
    if (_tabController.index == 1) {
      scan();
    }
  }
}
