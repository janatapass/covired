import 'dart:async';

import 'package:dartz/dartz.dart';
import 'package:janata_curfew/features/authentication/data/models/registration_data.dart';
import 'package:meta/meta.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:janata_curfew/core/error/failures.dart';
import 'package:janata_curfew/features/authentication/bloc/authentication_event.dart';
import 'package:janata_curfew/features/authentication/bloc/authentication_state.dart';
import 'package:janata_curfew/features/authentication/domain/repositories/authentication_repository.dart';

const String SERVER_FAILURE_MESSAGE = 'Server Failure';
const String CACHE_FAILURE_MESSAGE = 'Cache Failure';
const String INVALID_INPUT_FAILURE_MESSAGE =
    'Invalid Input - The number must be a positive integer or zero.';

class AuthenticationBloc
    extends Bloc<AuthenticationEvent, AuthenticationState> {

  final AuthenticationRepository repository;

  AuthenticationBloc({
    @required AuthenticationRepository repository,
  }) : repository = repository;

  @override
  AuthenticationState get initialState => Loaded(state: ScreenState.MOBILE);

  @override
  Stream<AuthenticationState> mapEventToState(
    AuthenticationEvent event,
  ) async* {
    if (event is MobileRegistrationEvent) {
      final failureOrRegistrationData = await repository.registerMobile(event.mobile);
      yield* _eitherMobileRegistrationLoadedOrErrorState(event.mobile, failureOrRegistrationData);
    } else if (event is OtpRegistrationEvent) {
      final failureOrRegistrationData = await repository.confirmOtp(event.mobile, event.otp);
      yield* _eitherOtpRegistrationLoadedOrErrorState(failureOrRegistrationData);
    }
  }

  Stream<AuthenticationState> _eitherMobileRegistrationLoadedOrErrorState(
      String mobile,
      Either<Failure, RegistrationData> failureOrHomePastData,
      ) async* {
    yield failureOrHomePastData.fold(
          (failure) => Error(),
          (userData) => Loaded(data: userData, state: ScreenState.OTP, mobile: mobile),
    );
  }

  Stream<AuthenticationState> _eitherOtpRegistrationLoadedOrErrorState(
      Either<Failure, RegistrationData> failureOrHomePastData,
      ) async* {
    yield failureOrHomePastData.fold(
          (failure) => Error(),
          (userData) => GoToNextPage(),
    );
  }
}

enum ScreenState {
  MOBILE, OTP
}
