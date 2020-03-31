import 'dart:convert';

import 'package:janata_curfew/core/error/exceptions.dart';
import 'package:janata_curfew/features/home/data/models/user_data.dart';
import 'home_data_source.dart';
import 'package:http/http.dart' as http;
import 'package:meta/meta.dart';

class HomeDataSourceImpl extends HomeDataSource {
  final http.Client client;

  HomeDataSourceImpl({@required this.client});


  Future<UserData> _getUserData({Map<String, String> params}) async {
    final response = await client.post(
      "https://fatneedle.com/janata_pass/Application/web_api/user_details",
      body: params);
    if (response.statusCode == 200) {
      return userFromJson(response.body);
    } else {
      throw ServerException();
    }
  }

  @override
  Future<UserData> getQrData(String value) {
    Map<String, String> params = {
      "qr_code": value,
    };
    return _getUserData(params: params);
  }

  @override
  Future<UserData> getMobileData(String value) {
    Map<String, String> params = {
      "mobile": value,
    };
    return _getUserData(params: params);
  }
}
