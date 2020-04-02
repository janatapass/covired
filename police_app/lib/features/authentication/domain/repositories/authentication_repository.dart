import 'package:dartz/dartz.dart';
import 'package:janata_curfew/core/error/failures.dart';
import 'package:janata_curfew/features/authentication/data/models/registration_data.dart';

abstract class AuthenticationRepository {
  Future<Either<Failure, RegistrationData>> registerMobile(String mobile);
  Future<Either<Failure, RegistrationData>> confirmOtp(String mobile, String otp);
}