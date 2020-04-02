import 'dart:convert';

RegistrationData registrationDataFromJson(String str) => RegistrationData.fromJson(json.decode(str));

String registrationDataToJson(RegistrationData data) => json.encode(data.toJson());

class RegistrationData {
  int status;
  String message;
  int userId;

  RegistrationData({
    this.status,
    this.message,
    this.userId,
  });

  factory RegistrationData.fromJson(Map<String, dynamic> json) => RegistrationData(
    status: json["status"],
    message: json["message"],
    userId: json["user_id"],
  );

  Map<String, dynamic> toJson() => {
    "status": status,
    "message": message,
    "user_id": userId,
  };
}
