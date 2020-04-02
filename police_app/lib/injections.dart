import 'package:get_it/get_it.dart';
import 'package:http/http.dart' as http;
import 'package:janata_curfew/features/authentication/bloc/authentication_bloc.dart';
import 'package:janata_curfew/features/authentication/data/datasources/authentication_data_source.dart';
import 'package:janata_curfew/features/authentication/data/datasources/authentication_data_source_impl.dart';
import 'package:janata_curfew/features/authentication/data/repositories/authentication_repository_impl.dart';
import 'package:janata_curfew/features/authentication/domain/repositories/authentication_repository.dart';

import 'features/home/data/datasources/home_data_source.dart';
import 'features/home/data/datasources/home_data_source_impl.dart';
import 'features/home/data/repositories/home_repository_impl.dart';
import 'features/home/domain/repositories/home_repository.dart';
import 'package:janata_curfew/features/home/presentation/bloc/qr/qr_bloc.dart';

import 'features/home/presentation/bloc/checkmobile/check_mobile_bloc.dart';

final sl = GetIt.instance;

Future<void> init() async {
  //! Features - Number Trivia
  // Bloc
  sl.registerFactory(
        () => AuthenticationBloc(repository: sl()),
  );

  sl.registerFactory(
        () => QrBloc(repository: sl()),
  );

  sl.registerFactory(
        () => CheckMobileBloc(repository: sl()),
  );
  // Repository
  sl.registerLazySingleton<HomeRepository>(
        () => HomeRepositoryImpl(
      remoteDataSource: sl(),
    ),
  );

  // Repository
  sl.registerLazySingleton<AuthenticationRepository>(
        () => AuthenticationRepositoryImpl(
      remoteDataSource: sl(),
    ),
  );

  // Data sources
  sl.registerLazySingleton<HomeDataSource>(
        () => HomeDataSourceImpl(client: sl()),
  );

  // Data sources
  sl.registerLazySingleton<AuthenticationDataSource>(
        () => AuthenticationDataSourceImpl(client: sl()),
  );
  //! External
  sl.registerLazySingleton(() => http.Client());
}