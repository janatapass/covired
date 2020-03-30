import 'package:dartz/dartz.dart';
import 'package:janata_curfew/core/error/failures.dart';
import 'package:janata_curfew/features/home/data/models/user_data.dart';


abstract class HomeRepository {
  Future<Either<Failure, UserData>> getQrData();
}