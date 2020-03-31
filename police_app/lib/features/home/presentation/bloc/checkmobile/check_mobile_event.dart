import 'package:meta/meta.dart';

@immutable
abstract class CheckMobileBlocEvent {}

class ShowMobileField extends CheckMobileBlocEvent {}

class GetUserData extends CheckMobileBlocEvent {
  final String mobile;

  GetUserData({@required this.mobile});

  @override
  List<Object> get props => [mobile];

}
