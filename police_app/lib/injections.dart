import 'package:get_it/get_it.dart';
import 'package:http/http.dart' as http;
import 'package:janata_curfew/features/authentication/bloc/authentication_bloc.dart';

final sl = GetIt.instance;

Future<void> init() async {
  //! Features - Number Trivia
  // Bloc
  sl.registerFactory(
        () => AuthenticationBloc(),
  );

  //! External
  sl.registerLazySingleton(() => http.Client());
}