import 'package:flutter/material.dart';
import 'package:janata_curfew/core/widgets/loading_progress_indicator.dart';

class LoadingDialog extends StatelessWidget {
  final Alignment alignment = Alignment.center;
  final double width = 36.0;
  final double height = 36.0;

  @override
  Widget build(BuildContext context) {
    return Material(
      type: MaterialType.transparency,
      child: Container(
        width: double.infinity,
        color: Colors.black54,
        child: const LoadingProgressIndicator(),
      ),
    );
  }
}
