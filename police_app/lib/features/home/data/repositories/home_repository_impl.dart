import 'package:dartz/dartz.dart';
import 'package:janata_curfew/core/error/failures.dart';
import 'package:janata_curfew/core/error/exceptions.dart';
import 'package:janata_curfew/features/home/data/datasources/home_data_source.dart';
import 'package:janata_curfew/features/home/data/models/user_data.dart';
import 'package:janata_curfew/features/home/domain/repositories/home_repository.dart';
import 'package:meta/meta.dart';


class HomeRepositoryImpl implements HomeRepository {

  final HomeDataSource remoteDataSource;

  HomeRepositoryImpl({
    @required this.remoteDataSource,
  });

  Future<Either<Failure, UserData>> getQrData() async {
    try {
      final homePastData = await remoteDataSource.getQrData();
      return Right(homePastData);
    } on ServerException {
      return Left(ServerFailure());
    }
  }

}