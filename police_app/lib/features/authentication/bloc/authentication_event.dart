import 'package:equatable/equatable.dart';
import 'package:meta/meta.dart';

@immutable
abstract class AuthenticationEvent extends Equatable {
  @override
  List<Object> get props => [];
}

class MobileRegistrationEvent extends AuthenticationEvent {
  final String mobile;

  MobileRegistrationEvent({@required this.mobile});

  @override
  List<Object> get props => [mobile];
}

class OtpRegistrationEvent extends AuthenticationEvent {
  final String mobile;
  final String otp;

  OtpRegistrationEvent({@required this.mobile, @required this.otp});

  @override
  List<Object> get props => [mobile, otp];

}