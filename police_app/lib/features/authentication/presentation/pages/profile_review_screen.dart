import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:janata_curfew/core/app_theme.dart';
import 'package:janata_curfew/core/error/exceptions.dart';
import 'package:janata_curfew/core/widgets/authentication_button.dart';
import 'package:janata_curfew/core/widgets/background_container.dart';
import 'package:janata_curfew/core/widgets/loading_progress_indicator.dart';
import 'package:janata_curfew/features/authentication/presentation/widgets/profile_review_item.dart';
import 'package:janata_curfew/features/home/data/models/user_data.dart';
import 'package:janata_curfew/features/home/presentation/pages/home_screen.dart';

class ProfileReviewScreen extends StatefulWidget {
  final mobile;

  ProfileReviewScreen({this.mobile});

  @override
  _ProfileReviewScreenState createState() => _ProfileReviewScreenState();
}

class _ProfileReviewScreenState extends State<ProfileReviewScreen> {
  @override
  Widget build(BuildContext context) {
    return new Scaffold(
        body: FutureBuilder(
            future: _getUserData(widget.mobile),
            builder: (BuildContext context, AsyncSnapshot<UserData> snapshot) {
              switch (snapshot.connectionState) {
                case ConnectionState.waiting:
                  return LoadingProgressIndicator();
                case ConnectionState.done:
                  if(snapshot.hasError){
                    return Center(child: Text('Unable to load details for this user. Plese contact the administator.', style: AppTheme.error_text));
                  }
                  var data = snapshot.data;
                  return BackgroundContainer(
                    child: Padding(
                      padding: const EdgeInsets.all(48.0),
                      child: LayoutBuilder(
                        builder: (context, constraint) {
                          return SingleChildScrollView(
                            child: ConstrainedBox(
                              constraints: BoxConstraints(
                                  minHeight: constraint.maxHeight),
                              child: IntrinsicHeight(
                                child: Column(
                                    mainAxisAlignment: MainAxisAlignment.center,
                                    crossAxisAlignment:
                                        CrossAxisAlignment.center,
                                    children: <Widget>[
                                      CircleAvatar(
                                          radius: 70,
                                          backgroundColor: Colors.orange,
                                          child: Icon(Icons.thumb_up,
                                              color: Colors.white, size: 48)),
                                      SizedBox(height: 36),
                                      Text(
                                          'You have been onboarded as a verifier',
                                          style: AppTheme.profile_review_header,
                                          textAlign: TextAlign.center),
                                      SizedBox(height: 36),
                                      Container(
                                          width: double.infinity,
                                          child: Card(
                                            elevation: 2,
                                            child: Padding(
                                              padding:
                                                  const EdgeInsets.all(16.0),
                                              child: Column(
                                                mainAxisAlignment:
                                                    MainAxisAlignment.center,
                                                crossAxisAlignment:
                                                    CrossAxisAlignment.center,
                                                children: <Widget>[
                                                  Text('Your Details',
                                                      style: AppTheme
                                                          .profile_review_details_header,
                                                      textAlign:
                                                          TextAlign.start),
                                                  SizedBox(height: 24),
                                                  ProfileReviewItem(
                                                      title: 'Name',
                                                      subTitle: data.data.name ?? ""),
                                                  SizedBox(height: 16),
                                                  ProfileReviewItem(
                                                      title: 'Mobile',
                                                      subTitle: data.data.mobile ?? ""),
                                                  SizedBox(height: 16),
                                                  ProfileReviewItem(
                                                      title: 'Address',
                                                      subTitle:
                                                      data.data.address ?? ""),
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
                  );
                case ConnectionState.none:
                  break;
                case ConnectionState.active:
                  break;
              }
              return null;
            }));
  }

  Future<UserData> _getUserData(String mobile) async {
    Map<String, String> params = {
      "mobile": mobile,
    };
    final response = await http.post(
        "https://fatneedle.com/janata_pass/Application/web_api/user_details",
        body: params);
    if (response.statusCode == 200) {
      return userFromJson(response.body);
    } else {
      throw ServerException();
    }
  }
}
