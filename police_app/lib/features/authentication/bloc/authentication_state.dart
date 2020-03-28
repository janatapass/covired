import 'package:equatable/equatable.dart';
import 'package:meta/meta.dart';

abstract class AuthenticationState extends Equatable {
  var present;

  @override
  List<Object> get props => [];
}

class ScreenLoaded extends AuthenticationState {
  final ScreenState data;

  ScreenLoaded({@required this.data});

  @override
  List<Object> get props => [data];
}

enum ScreenState {
  MOBILE_REGISTRATION, OTP_REGISTRATION
}