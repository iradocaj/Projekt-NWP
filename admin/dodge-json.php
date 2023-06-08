<?php 
$API_KEY = "X-Api-Key: ayoxUzmWsR/Kag0iqdUd4g==jC8s6ngjW4qSwLYo";
$url = 'https://api.api-ninjas.com/v1/cars?limit=15&make=dodge';


$conn = curl_init($url);


curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);
curl_setopt($conn, CURLOPT_HTTPHEADER, [$API_KEY]);


$result = curl_exec($conn);


curl_close($conn);


$json_data = json_decode($result,true);

function filterUniqueByModel($data)
{
    $filteredData = [];
    $models = [];
    foreach ($data as $item) {
        $model = $item['model'];
        if (!in_array($model, $models)) {
            $filteredData[] = $item;
            $models[] = $model;
        }
    }
    return $filteredData;
}

$unique_data = filterUniqueByModel($json_data);
		
print '
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bootstrap Example</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
        table {
            width: 100%;
            font-size: 16px; /* Povećajte font na željenu veličinu */
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
    </style>
	
</head>
	<body>
		
			<table class="table">
				<thead>
					<tr>
                        <th width="16">Make</th>
						<th width="16">Model</th>
                        <th width="16">Number of cylinders</th>
                        <th width="16">Year</th>
                        <th width="16">Body class</th>
						
					</tr>
				</thead>
				<tbody>';
				foreach($unique_data as $key => $value) { 
						
				print '
				<tr>
					
					<td>' . $unique_data[$key]["make"] . '</td>
                    <td>' . $unique_data[$key]["model"] . '</td>
                    <td>' . $unique_data[$key]["cylinders"] . '</td>
                    <td>' . $unique_data[$key]["year"] . '</td>
                    <td>' . $unique_data[$key]["class"] . '</td>
				</tr>';
			}
			print '
			</tbody>
		</table>
	</body>
	<form action="http://localhost/project-nwp/index.php?menu=1">
</form>
</html>';
	
?>
