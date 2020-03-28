import 'package:equatable/equatable.dart';
import 'package:meta/meta.dart';

@immutable
abstract class AuthenticationEvent extends Equatable {
  @override
  List<Object> get props => [];
}

class MobileRegistrationEvent extends AuthenticationEvent {}

class OtpRegistrationEvent extends AuthenticationEvent {}