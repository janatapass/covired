import 'package:janata_curfew/core/error/exceptions.dart';
import 'package:janata_curfew/features/home/data/models/user_data.dart';
import 'home_data_source.dart';
import 'package:http/http.dart' as http;
import 'package:meta/meta.dart';

class HomeDataSourceImpl extends HomeDataSource {
  final http.Client client;

  HomeDataSourceImpl({@required this.client});


  Future<UserData> _getUserData(String url) async {
    final response = await client.get(
      url,
    );
    if (response.statusCode == 200) {
      return userFromJson(response.body);
    } else {
      throw ServerException();
    }
  }

  @override
  Future<UserData> getQrData() {
    return _getUserData("http://www.mocky.io/v2/5e823eb12f000053002fb9b2");
  }

}
