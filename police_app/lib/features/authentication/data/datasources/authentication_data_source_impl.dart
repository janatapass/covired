import 'package:janata_curfew/core/error/exceptions.dart';
import 'package:janata_curfew/features/authentication/data/models/registration_data.dart';
import 'authentication_data_source.dart';
import 'package:http/http.dart' as http;
import 'package:meta/meta.dart';

class AuthenticationDataSourceImpl extends AuthenticationDataSource {
  final http.Client client;

  AuthenticationDataSourceImpl({@required this.client});


  Future<RegistrationData> _getRegistrationData(String url, {Map<String, String> params}) async {
    final response = await client.post(
        url,
      body: params);
    if (response.statusCode == 200) {
      return registrationDataFromJson(response.body);
    } else {
      throw ServerException();
    }
  }

  @override
  Future<RegistrationData> confirmOtp(String mobile, String otp) {
    Map<String, String> params = {
      "mobile": mobile,
      "otp": otp,
    };
    return _getRegistrationData("https://fatneedle.com/janata_pass/Application/web_api/verify_otp", params: params);
  }

  @override
  Future<RegistrationData> registerMobile(String mobile) {
    Map<String, String> params = {
      "mobile": mobile,
    };
    return _getRegistrationData("https://fatneedle.com/janata_pass/Application/web_api/verify_mobile", params: params);
  }
}
