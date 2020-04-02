import 'package:janata_curfew/features/authentication/data/models/registration_data.dart';

abstract class AuthenticationDataSource {
  Future<RegistrationData> registerMobile(String mobile);
  Future<RegistrationData> confirmOtp(String mobile, String otp);
}

