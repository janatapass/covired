import 'package:janata_curfew/features/home/data/models/user_data.dart';

abstract class HomeDataSource {
  Future<UserData> getQrData();
}

