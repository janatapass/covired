// To parse this JSON data, do
//
//     final userData = userDataFromJson(jsonString);

import 'dart:convert';

UserData userFromJson(String str) => UserData.fromJson(json.decode(str));

String userToJson(UserData data) => json.encode(data.toJson());

class UserData {
  String passes;
  int status;
  String message;
  Data data;

  UserData({
    this.passes,
    this.status,
    this.message,
    this.data,
  });

  factory UserData.fromJson(Map<String, dynamic> json) => UserData(
    passes: json["passes"],
    status: json["status"],
    message: json["message"],
    data: Data.fromJson(json["data"]),
  );

  Map<String, dynamic> toJson() => {
    "passes": passes,
    "status": status,
    "message": message,
    "data": data.toJson(),
  };
}

class Data {
  String id;
  String name;
  String mobile;
  String aadharNumber;
  String userTypeId;
  String userCategoryId;
  String approverId;
  String services;
  String userProof;
  String userImage;
  String userBirthmark;
  String userEmail;
  String shareWithMobile;
  String relationship;
  String address;
  String city;
  String state;
  String pincode;
  String qrCode;
  String locationRecording;
  String deviceId;
  String status;
  String isActive;
  String cby;
  DateTime cdate;
  String mby;
  DateTime mdate;
  String colorCode;
  String organisation;

  Data({
    this.id,
    this.name,
    this.mobile,
    this.aadharNumber,
    this.userTypeId,
    this.userCategoryId,
    this.approverId,
    this.services,
    this.userProof,
    this.userImage,
    this.userBirthmark,
    this.userEmail,
    this.shareWithMobile,
    this.relationship,
    this.address,
    this.city,
    this.state,
    this.pincode,
    this.qrCode,
    this.locationRecording,
    this.deviceId,
    this.status,
    this.isActive,
    this.cby,
    this.cdate,
    this.mby,
    this.mdate,
    this.colorCode,
    this.organisation,
  });

  factory Data.fromJson(Map<String, dynamic> json) => Data(
    id: json["id"],
    name: json["name"],
    mobile: json["mobile"],
    aadharNumber: json["aadhar_number"],
    userTypeId: json["user_type_id"],
    userCategoryId: json["user_category_id"],
    approverId: json["approver_id"],
    services: json["services"],
    userProof: json["user_proof"],
    userImage: json["user_image"],
    userBirthmark: json["user_birthmark"],
    userEmail: json["user_email"],
    shareWithMobile: json["share_with_mobile"],
    relationship: json["relationship"],
    address: json["address"],
    city: json["city"],
    state: json["state"],
    pincode: json["pincode"],
    qrCode: json["qr_code"],
    locationRecording: json["location_recording"],
    deviceId: json["device_id"],
    status: json["status"],
    isActive: json["is_active"],
    cby: json["cby"],
    cdate: DateTime.parse(json["cdate"]),
    mby: json["mby"],
    mdate: DateTime.parse(json["mdate"]),
    colorCode: json["color_code"],
    organisation: json["organisation"],
  );

  Map<String, dynamic> toJson() => {
    "id": id,
    "name": name,
    "mobile": mobile,
    "aadhar_number": aadharNumber,
    "user_type_id": userTypeId,
    "user_category_id": userCategoryId,
    "approver_id": approverId,
    "services": services,
    "user_proof": userProof,
    "user_image": userImage,
    "user_birthmark": userBirthmark,
    "user_email": userEmail,
    "share_with_mobile": shareWithMobile,
    "relationship": relationship,
    "address": address,
    "city": city,
    "state": state,
    "pincode": pincode,
    "qr_code": qrCode,
    "location_recording": locationRecording,
    "device_id": deviceId,
    "status": status,
    "is_active": isActive,
    "cby": cby,
    "cdate": cdate.toIso8601String(),
    "mby": mby,
    "mdate": mdate.toIso8601String(),
    "color_code": colorCode,
    "organisation": organisation,
  };
}
