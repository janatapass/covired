import 'package:equatable/equatable.dart';
import 'package:janata_curfew/features/home/data/models/user_data.dart';
import 'package:meta/meta.dart';

@immutable
abstract class CheckMobileBlocState extends Equatable {
  @override
  List<Object> get props => [];
}
class Initial extends CheckMobileBlocState {}

class Loading extends CheckMobileBlocState {}

class Loaded extends CheckMobileBlocState {
  final UserData data;

  Loaded({@required this.data});

  @override
  List<Object> get props => [data];
}

class Error extends CheckMobileBlocState {}

class Empty extends CheckMobileBlocState {}
