import 'package:dartz/dartz.dart';
import 'package:janata_curfew/core/error/failures.dart';
import 'package:janata_curfew/core/error/exceptions.dart';
import 'package:janata_curfew/features/authentication/data/datasources/authentication_data_source.dart';
import 'package:janata_curfew/features/authentication/data/models/registration_data.dart';
import 'package:janata_curfew/features/authentication/domain/repositories/authentication_repository.dart';
import 'package:meta/meta.dart';


class AuthenticationRepositoryImpl implements AuthenticationRepository {

  final AuthenticationDataSource remoteDataSource;

  AuthenticationRepositoryImpl({
    @required this.remoteDataSource,
  });

  @override
  Future<Either<Failure, RegistrationData>> confirmOtp(String mobile, String otp) async {
    try {
      final registrationData = await remoteDataSource.confirmOtp(mobile, otp);
      return Right(registrationData);
    } on ServerException {
      return Left(ServerFailure());
    }
  }

  @override
  Future<Either<Failure, RegistrationData>> registerMobile(String mobile) async {
    try {
      final registrationData = await remoteDataSource.registerMobile(mobile);
      return Right(registrationData);
    } on ServerException {
      return Left(ServerFailure());
    }
  }
}