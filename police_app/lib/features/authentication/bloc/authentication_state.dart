import 'package:equatable/equatable.dart';
import 'package:janata_curfew/features/authentication/data/models/registration_data.dart';
import 'package:meta/meta.dart';

import 'authentication_bloc.dart';

abstract class AuthenticationState extends Equatable {
  var present;

  @override
  List<Object> get props => [];
}

class Error extends AuthenticationState {
  final String message;

  Error(this.message);

  @override
  List<Object> get props => [message];
}

class Loading extends AuthenticationState {}

class RegistrationState extends AuthenticationState {}

class OtpState extends AuthenticationState {
  final String mobile;
  final RegistrationData data;

  OtpState({this.data, this.mobile});

  @override
  List<Object> get props => [data, mobile];
}


class GoToNextPage extends AuthenticationState {

  final String mobile;

  GoToNextPage({this.mobile});

  @override
  List<Object> get props => [mobile];
}