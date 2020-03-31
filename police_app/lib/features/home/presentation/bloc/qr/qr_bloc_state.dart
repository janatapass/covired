import 'package:equatable/equatable.dart';
import 'package:janata_curfew/features/home/data/models/user_data.dart';
import 'package:meta/meta.dart';

@immutable
abstract class QrBlocState extends Equatable {
  @override
  List<Object> get props => [];
}
class Initial extends QrBlocState {}

class Loading extends QrBlocState {}

class Loaded extends QrBlocState {
  final UserData data;

  Loaded({@required this.data});

  @override
  List<Object> get props => [data];
}

class Error extends QrBlocState {}

class Empty extends QrBlocState {}
