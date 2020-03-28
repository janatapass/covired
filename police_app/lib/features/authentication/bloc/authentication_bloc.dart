import 'dart:async';

import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:janata_curfew/core/error/failures.dart';
import 'package:janata_curfew/features/authentication/bloc/authentication_event.dart';
import 'package:janata_curfew/features/authentication/bloc/authentication_state.dart';

const String SERVER_FAILURE_MESSAGE = 'Server Failure';
const String CACHE_FAILURE_MESSAGE = 'Cache Failure';
const String INVALID_INPUT_FAILURE_MESSAGE =
    'Invalid Input - The number must be a positive integer or zero.';

class AuthenticationBloc
    extends Bloc<AuthenticationEvent, AuthenticationState> {

  @override
  AuthenticationState get initialState => ScreenLoaded(data: ScreenState.MOBILE_REGISTRATION);

  @override
  Stream<AuthenticationState> mapEventToState(
    AuthenticationEvent event,
  ) async* {
    if (event is MobileRegistrationEvent) {
      yield* pumpScreen(ScreenState.MOBILE_REGISTRATION);
    } else if (event is OtpRegistrationEvent) {
      yield* pumpScreen(ScreenState.OTP_REGISTRATION);
    }
  }

  Stream<AuthenticationState> pumpScreen(ScreenState screenState) async* {
    yield ScreenLoaded(data: screenState);
  }

  String _mapFailureToMessage(Failure failure) {
    switch (failure.runtimeType) {
      case ServerFailure:
        return SERVER_FAILURE_MESSAGE;
      default:
        return 'Unexpected error';
    }
  }
}
