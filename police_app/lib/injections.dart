import 'package:get_it/get_it.dart';
import 'package:http/http.dart' as http;
import 'package:janata_curfew/features/authentication/bloc/authentication_bloc.dart';

import 'features/home/data/datasources/home_data_source.dart';
import 'features/home/data/datasources/home_data_source_impl.dart';
import 'features/home/data/repositories/home_repository_impl.dart';
import 'features/home/domain/repositories/home_repository.dart';
import 'features/home/presentation/bloc/qr_bloc.dart';

final sl = GetIt.instance;

Future<void> init() async {
  //! Features - Number Trivia
  // Bloc
  sl.registerFactory(
        () => AuthenticationBloc(),
  );

  sl.registerFactory(
        () => QrBloc(repository: sl()),
  );

  // Repository
  sl.registerLazySingleton<HomeRepository>(
        () => HomeRepositoryImpl(
      remoteDataSource: sl(),
    ),
  );

  // Data sources
  sl.registerLazySingleton<HomeDataSource>(
        () => HomeDataSourceImpl(client: sl()),
  );

  //! External
  sl.registerLazySingleton(() => http.Client());
}