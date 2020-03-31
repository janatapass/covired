import 'package:meta/meta.dart';

@immutable
abstract class QrBlocEvent {}

class ScanQrEvent extends QrBlocEvent {}

class GetUserQrData extends QrBlocEvent {
  final String barcode;

  GetUserQrData({@required this.barcode});

  @override
  List<Object> get props => [barcode];

}
