import 'dart:async';
import 'package:bloc/bloc.dart';
import 'package:dartz/dartz.dart';
import 'package:janata_curfew/core/error/failures.dart';
import 'package:janata_curfew/features/home/data/models/user_data.dart';
import 'package:janata_curfew/features/home/domain/repositories/home_repository.dart';
import 'package:janata_curfew/features/home/presentation/bloc/qr_bloc_event.dart';
import 'package:janata_curfew/features/home/presentation/bloc/qr_bloc_state.dart';
import 'package:meta/meta.dart';

class QrBloc extends Bloc<QrBlocEvent, QrBlocState> {
  final HomeRepository homeRepository;

  QrBloc({
    @required HomeRepository repository,
  }) : homeRepository = repository;

  @override
  QrBlocState get initialState => Initial();

  @override
  Stream<QrBlocState> mapEventToState(
    QrBlocEvent event,
  ) async* {
    if (event is ScanQrEvent) {
      yield* scanQr();
    } else if (event is GetUserQrData) {
      yield Loading();
      if (event.barcode.isNotEmpty) {
        final failureOrHomePresentData = await homeRepository.getQrData();
        yield* _eitherLoadedOrErrorState(failureOrHomePresentData);
      } else {
        yield* showError();
      }
    }
  }

  Stream<QrBlocState> _eitherLoadedOrErrorState(
    Either<Failure, UserData> failureOrHomePastData,
  ) async* {
    yield failureOrHomePastData.fold(
      (failure) => Error(),
      (userData) => Loaded(data: userData),
    );
  }

  Stream<QrBlocState> scanQr() async* {
    yield Initial();
  }

  Stream<QrBlocState> showError() async* {
    yield Error();
  }
}
