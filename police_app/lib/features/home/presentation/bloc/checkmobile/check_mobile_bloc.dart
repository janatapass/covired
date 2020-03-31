import 'dart:async';
import 'package:bloc/bloc.dart';
import 'package:dartz/dartz.dart';
import 'package:janata_curfew/core/error/failures.dart';
import 'package:janata_curfew/features/home/data/models/user_data.dart';
import 'package:janata_curfew/features/home/domain/repositories/home_repository.dart';
import 'package:janata_curfew/features/home/presentation/bloc/checkmobile/check_mobile_bloc_state.dart';
import 'package:janata_curfew/features/home/presentation/bloc/checkmobile/check_mobile_event.dart';
import 'package:meta/meta.dart';

class CheckMobileBloc extends Bloc<CheckMobileBlocEvent, CheckMobileBlocState> {
  final HomeRepository homeRepository;

  CheckMobileBloc({
    @required HomeRepository repository,
  }) : homeRepository = repository;

  @override
  CheckMobileBlocState get initialState => Initial();

  @override
  Stream<CheckMobileBlocState> mapEventToState(
    CheckMobileBlocEvent event,
  ) async* {
    if (event is GetUserData) {
      yield Loading();
      if (event.mobile.isNotEmpty) {
        final failureOrHomePresentData = await homeRepository.getMobileUserData("9538131314");
        yield* _eitherLoadedOrErrorState(failureOrHomePresentData);
      } else {
        yield* showError();
      }
    } else if (event is ShowMobileField) {
      yield* showInitial();
    }
  }

  Stream<CheckMobileBlocState> _eitherLoadedOrErrorState(
    Either<Failure, UserData> failureOrHomePastData,
  ) async* {
    yield failureOrHomePastData.fold(
      (failure) => Error(),
      (userData) => Loaded(data: userData),
    );
  }

  Stream<CheckMobileBlocState> showInitial() async* {
    yield Initial();
  }

  Stream<CheckMobileBlocState> showError() async* {
    yield Error();
  }
}
