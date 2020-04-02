import 'package:equatable/equatable.dart';
import 'package:janata_curfew/features/authentication/data/models/registration_data.dart';
import 'package:meta/meta.dart';

import 'authentication_bloc.dart';

abstract class AuthenticationState extends Equatable {
  var present;

  @override
  List<Object> get props => [];
}

class Error extends AuthenticationState {}

class Loaded extends AuthenticationState {
  final String mobile;
  final RegistrationData data;
  final ScreenState state;

  Loaded({this.data, this.state, this.mobile});

  @override
  List<Object> get props => [data, state, mobile];
}

class GoToNextPage extends AuthenticationState {}