import 'dart:convert';

RegistrationData registrationDataFromJson(String str) => RegistrationData.fromJson(json.decode(str));

String registrationDataToJson(RegistrationData data) => json.encode(data.toJson());

class RegistrationData {
  int status;
  String message;

  RegistrationData({
    this.status,
    this.message,
  });

  factory RegistrationData.fromJson(Map<String, dynamic> json) => RegistrationData(
    status: json["status"],
    message: json["message"],
  );

  Map<String, dynamic> toJson() => {
    "status": status,
    "message": message,
  };
}
