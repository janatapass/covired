import 'dart:convert';

UserData userFromJson(String str) => UserData.fromJson(json.decode(str));

String userToJson(UserData data) => json.encode(data.toJson());

class UserData {
  String name;
  String mobileNumber;
  String address;
  TripDetails tripDetails;
  String reason;
  String vehicleNumber;

  UserData({
    this.name,
    this.mobileNumber,
    this.address,
    this.tripDetails,
    this.reason,
    this.vehicleNumber,
  });

  factory UserData.fromJson(Map<String, dynamic> json) => UserData(
    name: json["name"],
    mobileNumber: json["mobile_number"],
    address: json["address"],
    tripDetails: TripDetails.fromJson(json["trip_details"]),
    reason: json["reason"],
    vehicleNumber: json["vehicle_number"],
  );

  Map<String, dynamic> toJson() => {
    "name": name,
    "mobile_number": mobileNumber,
    "address": address,
    "trip_details": tripDetails.toJson(),
    "reason": reason,
    "vehicle_number": vehicleNumber,
  };
}

class TripDetails {
  String date;
  String fromTime;
  String toTime;
  String fromPlace;
  String toPlace;

  TripDetails({
    this.date,
    this.fromTime,
    this.toTime,
    this.fromPlace,
    this.toPlace,
  });

  factory TripDetails.fromJson(Map<String, dynamic> json) => TripDetails(
    date: json["date"],
    fromTime: json["from_time"],
    toTime: json["to_time"],
    fromPlace: json["from_place"],
    toPlace: json["to_place"],
  );

  Map<String, dynamic> toJson() => {
    "date": date,
    "from_time": fromTime,
    "to_time": toTime,
    "from_place": fromPlace,
    "to_place": toPlace,
  };
}
