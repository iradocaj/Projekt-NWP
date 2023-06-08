<?php
if (!isset($_POST['vin']) || $_POST['vin'] == '') {
    $_POST['vin'] = FALSE;
}

if ($_POST['vin'] == FALSE) {
    print '
    <h1>Vehicle search</h1>
    <form action="" method="POST">
        <label for="vin">Enter the VIN number</label>
        <input type="text" id="vin" placeholder="Enter the VIN number, example: 5TFUM5F18AX006026" name="vin" required>
        <input type="submit" value="Search">
    </form>';
} else {
    
    $vin = $_POST['vin'];

    
    $url = "https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVinExtended/{$vin}?format=json";
    $headers = array(
        "Content-Type: application/json",
        "User-Agent: YourAppName"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    
    $data = json_decode($response, true);

    if (isset($data['Results']) && count($data['Results']) > 0) {

        $vehicleInfo = $data['Results'];

        $make = '';
        $model = '';
        $year = '';
        $trim = '';
        $engine = '';
        $transmission = '';
        $drive = '';
        $fuelType = '';
        $bodyType = '';
        $vehicleClass = '';
        $countryOfOrigin = '';

        foreach ($vehicleInfo as $info) {
            $attributeName = $info['Variable'];
            $attributeValue = $info['Value'];

            switch ($attributeName) {
                case 'Make':
                    $make = $attributeValue;
                    break;
                case 'Model':
                    $model = $attributeValue;
                    break;
                case 'Model Year':
                    $year = $attributeValue;
                    break;
                case 'Fuel Type - Primary':
                    $fuelType = $attributeValue;
                    break;
                case 'Body Class':
                    $bodyType = $attributeValue;
                    break;
                case 'Vehicle Type':
                    $vehicleClass = $attributeValue;
                    break;
                case 'Plant Country':
                    $countryOfOrigin = $attributeValue;
                    break;
            }
        }

        echo '
        <h1>Vehicle information</h1>
        <p><strong>Make:</strong> ' . $make . '</p>
        <p><strong>Model:</strong> ' . $model . '</p>
        <p><strong>Year:</strong> ' . $year . '</p>
        <p><strong>Fuel type:</strong> ' . $fuelType . '</p>
        <p><strong>Vehicle type:</strong> ' . $bodyType . '</p>
        <p><strong>Body class:</strong> ' . $vehicleClass . '</p>
        <p><strong>Country of origin:</strong> ' . $countryOfOrigin . '</p>
        <p><a href="index.php?menu=9">BACK</a></p>
        ';
    } else {
        echo '<p>No vehicle information found for the given VIN.</p>';
    }
}
?>