import 'package:flutter/material.dart';
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/widgets/authentication_button.dart';
import 'package:janata_curfew/core/widgets/background_container.dart';
import 'package:janata_curfew/features/authentication/bloc/authentication_bloc.dart';
import 'package:janata_curfew/features/authentication/presentation/widgets/profile_review_item.dart';
import 'package:janata_curfew/features/home/presentation/pages/home_screen.dart';

class ProfileReviewScreen extends StatefulWidget {
  @override
  _ProfileReviewScreenState createState() => _ProfileReviewScreenState();
}

class _ProfileReviewScreenState extends State<ProfileReviewScreen> {
  AuthenticationBloc bloc;

  @override
  Widget build(BuildContext context) {
    return new Scaffold(
        body: BackgroundContainer(
      child: Padding(
        padding: const EdgeInsets.all(48.0),
        child: LayoutBuilder(
          builder: (context, constraint) {
            return SingleChildScrollView(
              child: ConstrainedBox(
                constraints: BoxConstraints(minHeight: constraint.maxHeight),
                child: IntrinsicHeight(
                  child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: <Widget>[
                        CircleAvatar(
                            radius: 70,
                            backgroundColor: Colors.orange,
                            child: Icon(Icons.thumb_up,
                                color: Colors.white, size: 48)),
                        SizedBox(height: 36),
                        Text('You have been onboarded as a verifier',
                            style: AppTheme.profile_review_header,
                            textAlign: TextAlign.center),
                        SizedBox(height: 36),
                        Container(
                            width: double.infinity,
                            child: Card(
                              elevation: 2,
                              child: Padding(
                                padding: const EdgeInsets.all(16.0),
                                child: Column(
                                  mainAxisAlignment: MainAxisAlignment.center,
                                  crossAxisAlignment: CrossAxisAlignment.center,
                                  children: <Widget>[
                                    Text('Your Details',
                                        style: AppTheme
                                            .profile_review_details_header,
                                        textAlign: TextAlign.start),
                                    SizedBox(height: 24),
                                    ProfileReviewItem(
                                        title: 'Name', subTitle: 'Rajmurugan'),
                                    SizedBox(height: 16),
                                    ProfileReviewItem(
                                        title: 'Mobile',
                                        subTitle: '9876543210'),
                                    SizedBox(height: 16),
                                    ProfileReviewItem(
                                        title: 'Address',
                                        subTitle:
                                            '84. Anna Salai, TVS colony, Chennai, TamilNadu'),
                                    SizedBox(height: 16),
                                    AuthenticationButton(
                                      text: 'Go to Home',
                                      onPressed: () {
                                        Navigator.push(
                                          context,
                                          MaterialPageRoute(
                                              builder: (context) =>
                                                  HomeScreen()),
                                        );
                                      },
                                    )
                                  ],
                                ),
                              ),
                            )),
                      ]),
                ),
              ),
            );
          },
        ),
      ),
    ));
  }
}
