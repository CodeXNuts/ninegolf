<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Test</h1>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyD50ia6qUmMpfh67VL2pDH2agjayxPww9U">
    </script>
    <script>
        var origin1 = new google.maps.LatLng(22.518, 88.3832);
// var origin2 = 'Greenwich, England';
var destinationA = new google.maps.LatLng(22.2745086, 87.92023730000001);
var destinationB = new google.maps.LatLng(22.5228058, 88.35003979999999);

var service = new google.maps.DistanceMatrixService();
service.getDistanceMatrix(
  {
    origins: [origin1],
    destinations: [destinationA, destinationB],
    travelMode: 'DRIVING',
    // transitOptions: TransitOptions,
    // drivingOptions: DrivingOptions,
    // unitSystem: UnitSystem,
    avoidHighways: false,
    avoidTolls: false,
  }, callback);

function callback(response, status) {
  // See Parsing the Results for
  // the basics of a callback function.

  console.log(status);
  console.log(response)
}

    </script>
</body>
</html>