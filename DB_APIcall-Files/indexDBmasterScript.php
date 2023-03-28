
<?php
//accesskey & endpoint variable declaration
$accessKey = '/*key has been removed*/';
$endpoint = 'https://api.bing.microsoft.com/v7.0/images/search';

//variable declaration for search keyterms
$term = 'Chicago Illinois';
$term2 = 'Miami Florida';
$term3 = 'Orlando Florida';
$term4 = 'Los Angeles California';
$term5 = 'Nashville Tennessee';


//FUNCTION DEFINITION---executes a call to bingimagesearchapi, returns json response
function BingWebSearch ($url, $key, $query) {
    $headers = "Ocp-Apim-Subscription-Key: $key\r\n";
    $options = array ('http' => array (
                          'header' => $headers,
                           'method' => 'GET'));

    $context = stream_context_create($options);
    $result = file_get_contents($url . "?q=" . urlencode($query), false, $context);

    $headers = array();
    foreach ($http_response_header as $k => $v) {
        $h = explode(":", $v, 2);
        if (isset($h[1]))
            if (preg_match("/^BingAPIs-/", $h[0]) || preg_match("/^X-MSEdge-/", $h[0]))
                $headers[trim($h[0])] = trim($h[1]);
    }

    return array($headers, $result);
}






//term1 call to bingimagesearch api
list($headers, $json) = BingWebSearch($endpoint, $accessKey, $term);
//printing term1's json response
echo json_encode(json_decode($json), JSON_PRETTY_PRINT);
//assigning variable to json response decoded as array
$stringt = json_decode($json, true);

//Connection to MySQL database!
$dsn = 'mysql:host=localhost;dbname=capstone';
$username = 'root';
$password = '';

    try {
        $db = new PDO($dsn, $username, $password);
        print("Database Connection Successful!");
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        print($error_message);
        exit();
    }

//assigning variable to mysql query to drop table bingimages
$query2 = "DROP TABLE IF EXISTS bingimage";
//assinging variable to mysql query to create table bingimages, after drop
$mktable = "CREATE TABLE `capstone`.`bingimage` 
                    (`image_id` INT NOT NULL AUTO_INCREMENT , 
                     `image` VARCHAR(255) NOT NULL , 
                     `name` VARCHAR(255) NOT NULL , 
                     `encodingFormat` VARCHAR(9) NOT NULL , 
                     `familyFriendly` VARCHAR(10) NOT NULL , 
                      PRIMARY KEY (`image_id`)) ENGINE = InnoDB;";
    
    //executing query2 and mktable, drops & creates
    $db->exec($query2);
    $db->exec($mktable);

//term1 query inserting into database table
$stringt = $stringt['value'];
for($i=0;$i<1;$i++){
    $items=$stringt[$i];
    $image=$items['contentUrl'];
    $name='Chicago, Illinois';
    $encodefmt=$items['encodingFormat'];
    $famfriend=$items['isFamilyFriendly'];

    $query = "INSERT INTO bingimage
              (image, name, encodingFormat, familyFriendly)
              VALUES
              ('$image', '$name', '$encodefmt', '$famfriend')";
    $db->exec($query);
}

//------------------------------------------------------------------------------
//term2 call to bingimageapi, recieves json response
list($headers, $json2) = BingWebSearch($endpoint, $accessKey, $term2);
//echo json_encode(json_decode($json2), JSON_PRETTY_PRINT);
$stringq = json_decode($json2, true);

//term2 inserting into database table
$stringq = $stringq['value'];
for($i=0;$i<1;$i++){
    $items=$stringq[$i];
    $image=$items['contentUrl'];
    $name= 'Miami, Florida';
    $encodefmt=$items['encodingFormat'];
    $famfriend=$items['isFamilyFriendly'];

    $query = "INSERT INTO bingimage
              (image, name, encodingFormat, familyFriendly)
              VALUES
              ('$image', '$name', '$encodefmt', '$famfriend')";
    $db->exec($query);
}

//------------------------------------------------------------------------------
//term3 call to binimageapi, recieves json response
list($headers, $json3) = BingWebSearch($endpoint, $accessKey, $term3);
//echo json_encode(json_decode($json3), JSON_PRETTY_PRINT);
$stringw = json_decode($json3, true);

//term3 inserting into database table
$stringw = $stringw['value'];
for($i=0;$i<1;$i++){
    $items=$stringw[$i];
    $image=$items['contentUrl'];
    $name='Orlando, Florida';
    $encodefmt=$items['encodingFormat'];
    $famfriend=$items['isFamilyFriendly'];

    $query = "INSERT INTO bingimage
              (image, name, encodingFormat, familyFriendly)
              VALUES
              ('$image', '$name', '$encodefmt', '$famfriend')";
    $db->exec($query);
}

//------------------------------------------------------------------------------
//term4 call to bingimageapi
list($headers, $json4) = BingWebSearch($endpoint, $accessKey, $term4);
//echo json_encode(json_decode($json4), JSON_PRETTY_PRINT);
$stringz = json_decode($json4, true);

//term4 inserting into database table
$stringz = $stringz['value'];
for($i=0;$i<1;$i++){
    $items=$stringz[$i];
    $image=$items['contentUrl'];
    $name='Los Angeles, California';
    $encodefmt=$items['encodingFormat'];
    $famfriend=$items['isFamilyFriendly'];

    $query = "INSERT INTO bingimage
              (image, name, encodingFormat, familyFriendly)
              VALUES
              ('$image', '$name', '$encodefmt', '$famfriend')";
    $db->exec($query);
}
//-------------------------------------------------------------------------------

//term5 call to bingimageapi 
list($headers, $json5) = BingWebSearch($endpoint, $accessKey, $term5);
//echo json_encode(json_decode($json5), JSON_PRETTY_PRINT);
$stringv = json_decode($json5, true);

//term5 inserting into database table
$stringv = $stringv['value'];
for($i=0;$i<1;$i++){
    $items=$stringv[$i];
    $image=$items['contentUrl'];
    $name='Nashville, Tennessee';
    $encodefmt=$items['encodingFormat'];
    $famfriend=$items['isFamilyFriendly'];

    $query = "INSERT INTO bingimage
              (image, name, encodingFormat, familyFriendly)
              VALUES
              ('$image', '$name', '$encodefmt', '$famfriend')";
    $db->exec($query);
}






//Alex Aviation API

$iata_code = "LAX";
$iata_code2 = "MCO";
$iata_code3 = "MIA";
$iata_code4 = "ORD";
$iata_code5 = "BNA";
$type = "arrival";
$date= "2023-04-29";
$dep_iataCode	="JFK";

$queryString = http_build_query([
                    "access_key" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiYTIzYzlkYjk1YjRhOWY1ZGZjYzA3YzE0YjhmNTdkOGNlMjVmNDg0MDg0M2I5YTU5YTY2MjkwYTNkMTY1MjJiMzgyZjEwOTAzN2E2NmQ5YjkiLCJpYXQiOjE2NzYzODc2MjQsIm5iZiI6MTY3NjM4NzYyNCwiZXhwIjoxNzA3OTIzNjI0LCJzdWIiOiIyMDA3OCIsInNjb3BlcyI6W119.aYt3ixJR5PqS5bvyNH4zttsOhtYTrxnC7Ppex0VV_LOoPhkfbSkLohxPuSLLJicZ6wWu1RWGraNB8FARDBlD1A" ,
                    "iataCode" => $iata_code ,
                    "type" => $type , 
                    "date" => $date ,
                    "dep_iataCode" => $dep_iataCode	
                  ]);
$queryString2 = http_build_query([
                      "access_key" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiYTIzYzlkYjk1YjRhOWY1ZGZjYzA3YzE0YjhmNTdkOGNlMjVmNDg0MDg0M2I5YTU5YTY2MjkwYTNkMTY1MjJiMzgyZjEwOTAzN2E2NmQ5YjkiLCJpYXQiOjE2NzYzODc2MjQsIm5iZiI6MTY3NjM4NzYyNCwiZXhwIjoxNzA3OTIzNjI0LCJzdWIiOiIyMDA3OCIsInNjb3BlcyI6W119.aYt3ixJR5PqS5bvyNH4zttsOhtYTrxnC7Ppex0VV_LOoPhkfbSkLohxPuSLLJicZ6wWu1RWGraNB8FARDBlD1A" ,
                      "iataCode" => $iata_code2 ,
                      "type" => $type , 
                      "date" => $date ,
                      "dep_iataCode" => $dep_iataCode
                  ]);
$queryString3 = http_build_query([
                      "access_key" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiYTIzYzlkYjk1YjRhOWY1ZGZjYzA3YzE0YjhmNTdkOGNlMjVmNDg0MDg0M2I5YTU5YTY2MjkwYTNkMTY1MjJiMzgyZjEwOTAzN2E2NmQ5YjkiLCJpYXQiOjE2NzYzODc2MjQsIm5iZiI6MTY3NjM4NzYyNCwiZXhwIjoxNzA3OTIzNjI0LCJzdWIiOiIyMDA3OCIsInNjb3BlcyI6W119.aYt3ixJR5PqS5bvyNH4zttsOhtYTrxnC7Ppex0VV_LOoPhkfbSkLohxPuSLLJicZ6wWu1RWGraNB8FARDBlD1A" ,
                      "iataCode" => $iata_code3 ,
                      "type" => $type , 
                      "date" => $date ,
                      "dep_iataCode" => $dep_iataCode
                  ]);  
$queryString4 = http_build_query([
                    "access_key" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiYTIzYzlkYjk1YjRhOWY1ZGZjYzA3YzE0YjhmNTdkOGNlMjVmNDg0MDg0M2I5YTU5YTY2MjkwYTNkMTY1MjJiMzgyZjEwOTAzN2E2NmQ5YjkiLCJpYXQiOjE2NzYzODc2MjQsIm5iZiI6MTY3NjM4NzYyNCwiZXhwIjoxNzA3OTIzNjI0LCJzdWIiOiIyMDA3OCIsInNjb3BlcyI6W119.aYt3ixJR5PqS5bvyNH4zttsOhtYTrxnC7Ppex0VV_LOoPhkfbSkLohxPuSLLJicZ6wWu1RWGraNB8FARDBlD1A" ,
                    "iataCode" => $iata_code4 ,
                    "type" => $type , 
                    "date" => $date ,
                    "dep_iataCode" => $dep_iataCode
                ]);  
$queryString5 = http_build_query([
                    "access_key" => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiYTIzYzlkYjk1YjRhOWY1ZGZjYzA3YzE0YjhmNTdkOGNlMjVmNDg0MDg0M2I5YTU5YTY2MjkwYTNkMTY1MjJiMzgyZjEwOTAzN2E2NmQ5YjkiLCJpYXQiOjE2NzYzODc2MjQsIm5iZiI6MTY3NjM4NzYyNCwiZXhwIjoxNzA3OTIzNjI0LCJzdWIiOiIyMDA3OCIsInNjb3BlcyI6W119.aYt3ixJR5PqS5bvyNH4zttsOhtYTrxnC7Ppex0VV_LOoPhkfbSkLohxPuSLLJicZ6wWu1RWGraNB8FARDBlD1A" ,
                    "iataCode" => $iata_code5 ,
                    "type" => $type , 
                    "date" => $date ,
                    "dep_iataCode" => $dep_iataCode
              ]);                            

                    $ch = curl_init(sprintf("%s?%s", "https://app.goflightlabs.com/advanced-future-flights", $queryString));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                    $query1 = curl_exec($ch);
                    $err = curl_error($ch);
                                    
                    $flight1 = json_decode($query1, true);
                    echo json_encode(json_decode($query1), JSON_PRETTY_PRINT);


                    //var_dump($flight1); 
                    
                    
                    $ch2 = curl_init(sprintf("%s?%s", "https://app.goflightlabs.com/advanced-future-flights", $queryString2));
                    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

                    $query2 = curl_exec($ch2);
                    $err = curl_error($ch2);

                    $flight2 = json_decode($query2, true);
                    echo json_encode(json_decode($query2), JSON_PRETTY_PRINT);

                    //var_dump($flight2);

                    $ch3 = curl_init(sprintf("%s?%s", "https://app.goflightlabs.com/advanced-future-flights", $queryString3));
                    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);

                    $query3 = curl_exec($ch3);
                    $err = curl_error($ch3);

                    $flight3 = json_decode($query3, true);
                    echo json_encode(json_decode($query3), JSON_PRETTY_PRINT);

                    //var_dump($flight2);
                    
                    $ch4 = curl_init(sprintf("%s?%s", "https://app.goflightlabs.com/advanced-future-flights", $queryString4));
                    curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);

                    $query4 = curl_exec($ch4);
                    $err = curl_error($ch4);

                    $flight4 = json_decode($query4, true);
                    echo json_encode(json_decode($query4), JSON_PRETTY_PRINT);

                    //var_dump($flight3);

                    $ch5 = curl_init(sprintf("%s?%s", "https://app.goflightlabs.com/advanced-future-flights", $queryString5));
                    curl_setopt($ch5, CURLOPT_RETURNTRANSFER, true);

                    $query5 = curl_exec($ch5);
                    $err = curl_error($ch5);

                    $flight5 = json_decode($query5, true);
                    echo json_encode(json_decode($query5), JSON_PRETTY_PRINT);

                    //var_dump($flight5);
              
                    if($err){
                      echo "cURL Error #:" . $err;
                    } else 
                    {
                      $servername = "localhost";
                      $username = "root";
                      $password = "";
                      $dbname = "capstone";                  
                  
                      $conn = mysqli_connect($servername, $username, $password, $dbname);
                  
                      if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                      }
                      $drop = "DROP TABLE IF EXISTS Aviation";
                      if ($conn->query($drop) === true){
                      $sql = "CREATE TABLE Aviation (
                      id INT(255) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                      depiataCode VARCHAR(500),
                      arriataCode VARCHAR(500),
                      terminal VARCHAR(500),
                      gate VARCHAR(500) NOT NULL,
                      scheduledTime VARCHAR(500),
                      name VARCHAR(500),
                      number INT(255)
                      )";

                    if ($conn->query($sql) === TRUE) {
                      echo "Table Aviation created successfully";
                    } else {
                      echo "Error creating table: " . $conn->error;
                    }
                  } else {
                    echo "Error dropping table: " . $conn->error;
                  }
                  
                  $flight1 = json_decode($query1, true);
                  $flight2 = json_decode($query2, true);
                  $flight3 = json_decode($query3, true);
                  $flight4 = json_decode($query4, true);
                  $flight5 = json_decode($query5, true);

                  $flight1 = $flight1["data"]; 
                  $flight2 = $flight2["data"]; 
                  $flight3 = $flight3["data"]; 
                  $flight4 = $flight4["data"]; 
                  $flight5 = $flight5["data"]; 

                  for ($x = 0; $x < 5; $x++){
                    
                    $items = $flight1[$x];
                    $depiataCode = $items["departure"]['iataCode'];
                    $arriataCode = $items["arrival"]['iataCode'];
                    $terminal = $items["departure"]["terminal"];
                    $gate = $items["arrival"]["gate"];
                    $scheduledTime = $items["departure"]["scheduledTime"];
                    $name = $items["codeshared"]["airline"]["name"];
                    $number = $items["flight"]["number"];

                    $ins = "INSERT INTO Aviation(depiataCode, arriataCode, terminal, gate, scheduledTime, name, number)
                    VALUES ('$depiataCode', '$arriataCode', '$terminal', '$gate', '$scheduledTime', '$name', '$number')";
                          
                    if($conn->query($ins) === true){
                    echo "Entered Data successfully";
                    }else{
                      echo "Error: " . $ins . "<br>" . $conn->error;
                    }
                  }
                  
                   for ($x = 0; $x < 5; $x++){
                  
                    $items = $flight2[$x];
                    $depiataCode = $items["departure"]['iataCode'];
                    $arriataCode = $items["arrival"]['iataCode'];
                    $terminal = $items["departure"]["terminal"];
                    $gate = $items["arrival"]["gate"];
                    $scheduledTime = $items["departure"]["scheduledTime"];
                    $name = $items["codeshared"]["airline"]["name"];
                    $number = $items["flight"]["number"];

                    $ins = "INSERT INTO Aviation(depiataCode, arriataCode, terminal, gate, scheduledTime, name, number)
                    VALUES ('$depiataCode', '$arriataCode', '$terminal', '$gate', '$scheduledTime', '$name', '$number')";
                          
                    if($conn->query($ins) === true){
                    echo "Entered Data successfully";
                    }else{
                      echo "Error: " . $ins . "<br>" . $conn->error;
                    }
                  }
                  
                  for ($x = 0; $x < 5; $x++){
                  
                    $items = $flight3[$x];
                    $depiataCode = $items["departure"]['iataCode'];
                    $arriataCode = $items["arrival"]['iataCode'];
                    $terminal = $items["departure"]["terminal"];
                    $gate = $items["arrival"]["gate"];
                    $scheduledTime = $items["departure"]["scheduledTime"];
                    $name = $items["codeshared"]["airline"]["name"];
                    $number = $items["flight"]["number"];

                    $ins = "INSERT INTO Aviation(depiataCode, arriataCode, terminal, gate, scheduledTime, name, number)
                    VALUES ('$depiataCode', '$arriataCode' , '$terminal', '$gate', '$scheduledTime', '$name', '$number')";
                          
                    if($conn->query($ins) === true){
                    echo "Entered Data successfully";
                    }else{
                      echo "Error: " . $ins . "<br>" . $conn->error;
                    }
                  }
                  
                  for ($x = 0; $x < 5; $x++){
                  
                    $items = $flight4[$x];
                    $depiataCode = $items["departure"]['iataCode'];
                    $arriataCode = $items["arrival"]['iataCode'];
                    $terminal = $items["departure"]["terminal"];
                    $gate = $items["arrival"]["gate"];
                    $scheduledTime = $items["departure"]["scheduledTime"];
                    $name = $items["codeshared"]["airline"]["name"];
                    $number = $items["flight"]["number"];

                    $ins = "INSERT INTO Aviation(depiataCode, arriataCode, terminal, gate, scheduledTime, name, number)
                    VALUES ('$depiataCode', '$arriataCode' , '$terminal', '$gate', '$scheduledTime', '$name', '$number')";
                          
                    if($conn->query($ins) === true){
                    echo "Entered Data successfully";
                    }else{
                      echo "Error: " . $ins . "<br>" . $conn->error;
                    }
                  }
                  
                  for ($x = 0; $x < 5; $x++){
                  
                    $items = $flight5[$x];
                    $depiataCode = $items["departure"]['iataCode'];
                    $arriataCode = $items["arrival"]['iataCode'];
                    $terminal = $items["departure"]["terminal"];
                    $gate = $items["arrival"]["gate"];
                    $scheduledTime = $items["departure"]["scheduledTime"];
                    $name = $items["codeshared"]["airline"]["name"];
                    $number = $items["flight"]["number"];

                    $ins = "INSERT INTO Aviation(depiataCode, arriataCode, terminal, gate, scheduledTime, name, number)
                    VALUES ('$depiataCode', '$arriataCode' , '$terminal', '$gate', '$scheduledTime', '$name', '$number')";
                          
                    if($conn->query($ins) === true){
                    echo "Entered Data successfully";
                    }else{
                      echo "Error: " . $ins . "<br>" . $conn->error;
                    }
                  }
                  
                  $conn->close();
                }         

                    


//Jordan YELP API


	$curl = curl_init();

	curl_setopt_array($curl, [
	  CURLOPT_URL => "https://api.yelp.com/v3/businesses/search?location=Chicago&sort_by=best_match&limit=5",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => [
		"Authorization: Bearer nWPR4f1JSxRcAfKtw6gX0mjS4sCjS0FoiQAOyI_xAtFSj0T2N4hfjX-PwapTez53fga4pA-ZWYMpF1B7S1vancl9npYQQXm0YL9mahaQ9bhwu1JF7_m3iz8IxiLLY3Yx",
		"accept: application/json"
	  ],
	]);

	$CHresponse = curl_exec($curl);
	$err = curl_error($curl);

	curl_setopt_array($curl, [
	  CURLOPT_URL => "https://api.yelp.com/v3/businesses/search?location=Miami&sort_by=best_match&limit=5",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => [
		"Authorization: Bearer nWPR4f1JSxRcAfKtw6gX0mjS4sCjS0FoiQAOyI_xAtFSj0T2N4hfjX-PwapTez53fga4pA-ZWYMpF1B7S1vancl9npYQQXm0YL9mahaQ9bhwu1JF7_m3iz8IxiLLY3Yx",
		"accept: application/json"
	  ],
	]);

	$MIresponse = curl_exec($curl);
	$err = curl_error($curl);

	curl_setopt_array($curl, [
	  CURLOPT_URL => "https://api.yelp.com/v3/businesses/search?location=Orlando&sort_by=best_match&limit=5",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => [
		"Authorization: Bearer nWPR4f1JSxRcAfKtw6gX0mjS4sCjS0FoiQAOyI_xAtFSj0T2N4hfjX-PwapTez53fga4pA-ZWYMpF1B7S1vancl9npYQQXm0YL9mahaQ9bhwu1JF7_m3iz8IxiLLY3Yx",
		"accept: application/json"
	  ],
	]);

	$ORresponse = curl_exec($curl);
	$err = curl_error($curl);

	curl_setopt_array($curl, [
	  CURLOPT_URL => "https://api.yelp.com/v3/businesses/search?location=Los%20Angeles&sort_by=best_match&limit=5",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => [
		"Authorization: Bearer nWPR4f1JSxRcAfKtw6gX0mjS4sCjS0FoiQAOyI_xAtFSj0T2N4hfjX-PwapTez53fga4pA-ZWYMpF1B7S1vancl9npYQQXm0YL9mahaQ9bhwu1JF7_m3iz8IxiLLY3Yx",
		"accept: application/json"
	  ],
	]);

	$LAresponse = curl_exec($curl);
	$err = curl_error($curl);

	curl_setopt_array($curl, [
	  CURLOPT_URL => "https://api.yelp.com/v3/businesses/search?location=Nashville&sort_by=best_match&limit=5",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => [
		"Authorization: Bearer nWPR4f1JSxRcAfKtw6gX0mjS4sCjS0FoiQAOyI_xAtFSj0T2N4hfjX-PwapTez53fga4pA-ZWYMpF1B7S1vancl9npYQQXm0YL9mahaQ9bhwu1JF7_m3iz8IxiLLY3Yx",
		"accept: application/json"
	  ],
	]);

	$NSresponse = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);


	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
		$servername = "localhost";
		$username = "root";
		$password = "";
		$mydb = "capstone";

		$conn = mysqli_connect($servername, $username, $password, $mydb);


		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}

		$drop = "DROP TABLE IF EXISTS yelp";
		
		if ($conn->query($drop) === true){		
			$sql = "CREATE TABLE Yelp (
			id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(30) NOT NULL,
			url LONGTEXT NOT NULL,
			rating FLOAT(3),
			street VARCHAR(50),
			city VARCHAR(50),
			zip VARCHAR(10)
			)";

			if ($conn->query($sql) === TRUE) {
			  echo "Table yelp created successfully";
			} else {
			  echo "Error creating table: " . $conn->error;
			}
		} else {
			echo "Error dropping table: " . $conn->error;
		}
		
		for ($x = 0; $x < 5; $x++){
	  
		  $CHarr = json_decode($CHresponse, true);
		  
		  $name = $CHarr["businesses"][$x]["name"];
		  $name = addslashes($name);
		  $url = $CHarr["businesses"][$x]["url"];
		  $rating = $CHarr["businesses"][$x]["rating"];
		  $street = $CHarr["businesses"][$x]["location"]["address1"];
		  $city = $CHarr["businesses"][$x]["location"]["city"];
		  $zip = $CHarr["businesses"][$x]["location"]["zip_code"];
		  
		  $ins = "INSERT INTO Yelp(name, url, rating, street, city, zip)
		  VALUES ('$name', '$url', '$rating', '$street', '$city', '$zip')";
		  		  
		  if($conn->query($ins) === true){
			echo "Entered Data successfully";
		  }else{
			  echo "Error: " . $ins . "<br>" . $conn->error;
		  }
		}
		
		for ($x = 0; $x < 5; $x++){
	  
		  $MIarr = json_decode($MIresponse, true);
		  
		  $name = $MIarr["businesses"][$x]["name"];
		  $name = addslashes($name);
		  $url = $MIarr["businesses"][$x]["url"];
		  $rating = $MIarr["businesses"][$x]["rating"];
		  $street = $MIarr["businesses"][$x]["location"]["address1"];
		  $city = $MIarr["businesses"][$x]["location"]["city"];
		  $zip = $MIarr["businesses"][$x]["location"]["zip_code"];
		  
		  $ins = "INSERT INTO Yelp(name, url, rating, street, city, zip)
		  VALUES ('$name', '$url', '$rating', '$street', '$city', '$zip')";
		  		  
		  if($conn->query($ins) === true){
			echo "Entered Data successfully";
		  }else{
			  echo "Error: " . $ins . "<br>" . $conn->error;
		  }
		}
		
		for ($x = 0; $x < 5; $x++){
	  
		  $ORarr = json_decode($ORresponse, true);
		  
		  $name = $ORarr["businesses"][$x]["name"];
		  $name = addslashes($name);
		  $url = $ORarr["businesses"][$x]["url"];
		  $rating = $ORarr["businesses"][$x]["rating"];
		  $street = $ORarr["businesses"][$x]["location"]["address1"];
		  $city = $ORarr["businesses"][$x]["location"]["city"];
		  $zip = $ORarr["businesses"][$x]["location"]["zip_code"];
		  
		  $ins = "INSERT INTO Yelp(name, url, rating, street, city, zip)
		  VALUES ('$name', '$url', '$rating', '$street', '$city', '$zip')";
		  		  
		  if($conn->query($ins) === true){
			echo "Entered Data successfully";
		  }else{
			  echo "Error: " . $ins . "<br>" . $conn->error;
		  }
		}
		
		for ($x = 0; $x < 5; $x++){
	  
		  $LAarr = json_decode($LAresponse, true);
		  
		  $name = $LAarr["businesses"][$x]["name"];
		  $name = addslashes($name);
		  $url = $LAarr["businesses"][$x]["url"];
		  $rating = $LAarr["businesses"][$x]["rating"];
		  $street = $LAarr["businesses"][$x]["location"]["address1"];
		  $city = $LAarr["businesses"][$x]["location"]["city"];
		  $zip = $LAarr["businesses"][$x]["location"]["zip_code"];
		  
		  $ins = "INSERT INTO Yelp(name, url, rating, street, city, zip)
		  VALUES ('$name', '$url', '$rating', '$street', '$city', '$zip')";
		  		  
		  if($conn->query($ins) === true){
			echo "Entered Data successfully";
		  }else{
			  echo "Error: " . $ins . "<br>" . $conn->error;
		  }
		}
		
		for ($x = 0; $x < 5; $x++){
	  
		  $NSarr = json_decode($NSresponse, true);
		  
		  $name = $NSarr["businesses"][$x]["name"];
		  $name = addslashes($name);
		  $url = $NSarr["businesses"][$x]["url"];
		  $rating = $NSarr["businesses"][$x]["rating"];
		  $street = $NSarr["businesses"][$x]["location"]["address1"];
		  $city = $NSarr["businesses"][$x]["location"]["city"];
		  $zip = $NSarr["businesses"][$x]["location"]["zip_code"];
		  
		  $ins = "INSERT INTO Yelp(name, url, rating, street, city, zip)
		  VALUES ('$name', '$url', '$rating', '$street', '$city', '$zip')";
		  		  
		  if($conn->query($ins) === true){
			echo "Entered Data successfully";
		  }else{
			  echo "Error: " . $ins . "<br>" . $conn->error;
		  }
		}
		$conn->close();
	}




//Kelly Weather API
$curl = curl_init();
//Get Chicago weather data
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://api.weatherapi.com/v1/forecast.json?key=01b9896d2fcb4c9caad163033232201&q=60601&days=1&aqi=no&alerts=no',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$CHresponse = curl_exec($curl);
$err = curl_error($curl);

//Get Miami weather data.
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://api.weatherapi.com/v1/forecast.json?key=01b9896d2fcb4c9caad163033232201&q=33101&days=1&aqi=no&alerts=no',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$MIresponse = curl_exec($curl);
$err = curl_error($curl);

//Get Orlando weather data.
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://api.weatherapi.com/v1/forecast.json?key=01b9896d2fcb4c9caad163033232201&q=32801&days=1&aqi=no&alerts=no',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$ORresponse = curl_exec($curl);
$err = curl_error($curl);

//Get Los Angeles weather data.
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://api.weatherapi.com/v1/forecast.json?key=01b9896d2fcb4c9caad163033232201&q=90001&days=1&aqi=no&alerts=no',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$LAresponse = curl_exec($curl);
$err = curl_error($curl);

//Get Nashville weather data.
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://api.weatherapi.com/v1/forecast.json?key=01b9896d2fcb4c9caad163033232201&q=37201&days=1&aqi=no&alerts=no',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$NASresponse = curl_exec($curl);


curl_close($curl);


//Connection to MySQL database!
$dsn = 'mysql:host=localhost;dbname=capstone';
$username = 'root';
$password = '';

    try {
        $db = new PDO($dsn, $username, $password);
        print("Database Connection Successful!");
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        print($error_message);
        exit();
    }

  //Make variable to drop table if exists
$query2 = "DROP TABLE IF EXISTS currentWeather";

 //Make variable to create table. 
$mktable = "CREATE TABLE currentWeather (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    City VARCHAR(30) NOT NULL,
    Region VARCHAR(30) NOT NULL,
    CurrentTemp FLOAT(26) NOT NULL,
    CurrentCondition VARCHAR(30) NOT NULL,
    CurrentImage VARCHAR(50) NOT NULL,
    HighTemp FLOAT(26) NOT NULL,
    LowTemp FLOAT(26) NOT NULL,
    TodayCondition VARCHAR(30) NOT NULL,
    TodayImage VARCHAR(50) NOT NULL,
   reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

$db->exec($query2);
$db->exec($mktable);

  //Parse data for Chicago and insert into table.

  $CHresponse = json_decode($CHresponse, true);

  $city = $CHresponse["location"]["name"];
  $currTemp = $CHresponse["current"]["temp_f"];
  $currCondition = $CHresponse["current"]["condition"]["text"];
  $state = $CHresponse["location"]["region"];
  $currentImage = $CHresponse["current"]["condition"]["icon"];
  $highTemp = $CHresponse["forecast"]["forecastday"][0]["day"]["maxtemp_f"];
  $lowTemp = $CHresponse["forecast"]["forecastday"][0]["day"]["mintemp_f"];
  $todayCondition = $CHresponse["forecast"]["forecastday"][0]["day"]["condition"]["text"];
  $todayIcon = $CHresponse["forecast"]["forecastday"][0]["day"]["condition"]["icon"];

  $ins = "INSERT INTO currentWeather (City, Region, CurrentTemp, CurrentCondition, CurrentImage, HighTemp, LowTemp, TodayCondition, TodayImage)
  VALUES ('$city', '$state', '$currTemp', '$currCondition', '$currentImage', '$highTemp', '$lowTemp', '$todayCondition', '$todayIcon')";

  $db->exec($ins);

   //Parse data for Miami and insert into table.

   $MIresponse = json_decode($MIresponse, true);

   $city = $MIresponse["location"]["name"];
   $currTemp = $MIresponse["current"]["temp_f"];
   $currCondition = $MIresponse["current"]["condition"]["text"];
   $state = $MIresponse["location"]["region"];
   $currentImage = $MIresponse["current"]["condition"]["icon"];
   $highTemp = $MIresponse["forecast"]["forecastday"][0]["day"]["maxtemp_f"];
   $lowTemp = $MIresponse["forecast"]["forecastday"][0]["day"]["mintemp_f"];
   $todayCondition = $MIresponse["forecast"]["forecastday"][0]["day"]["condition"]["text"];
   $todayIcon = $MIresponse["forecast"]["forecastday"][0]["day"]["condition"]["icon"];
 
   $ins = "INSERT INTO currentWeather (City, Region, CurrentTemp, CurrentCondition, CurrentImage, HighTemp, LowTemp, TodayCondition, TodayImage)
   VALUES ('$city', '$state', '$currTemp', '$currCondition', '$currentImage', '$highTemp', '$lowTemp', '$todayCondition', '$todayIcon')";
 
 $db->exec($ins);

    //Parse data for Orlando and insert into table.

  $ORresponse = json_decode($ORresponse, true);

  $city = $ORresponse["location"]["name"];
  $currTemp = $ORresponse["current"]["temp_f"];
  $currCondition = $ORresponse["current"]["condition"]["text"];
  $state = $ORresponse["location"]["region"];
  $currentImage = $ORresponse["current"]["condition"]["icon"];
  $highTemp = $ORresponse["forecast"]["forecastday"][0]["day"]["maxtemp_f"];
  $lowTemp = $ORresponse["forecast"]["forecastday"][0]["day"]["mintemp_f"];
  $todayCondition = $ORresponse["forecast"]["forecastday"][0]["day"]["condition"]["text"];
  $todayIcon = $ORresponse["forecast"]["forecastday"][0]["day"]["condition"]["icon"];

  $ins = "INSERT INTO currentWeather (City, Region, CurrentTemp, CurrentCondition, CurrentImage, HighTemp, LowTemp, TodayCondition, TodayImage)
  VALUES ('$city', '$state', '$currTemp', '$currCondition', '$currentImage', '$highTemp', '$lowTemp', '$todayCondition', '$todayIcon')";

$db->exec($ins);

   //Parse data for Los Angeles and insert into table.

   $LAresponse = json_decode($LAresponse, true);

   $city = $LAresponse["location"]["name"];
   $currTemp = $LAresponse["current"]["temp_f"];
   $currCondition = $LAresponse["current"]["condition"]["text"];
   $state = $LAresponse["location"]["region"];
   $currentImage = $LAresponse["current"]["condition"]["icon"];
   $highTemp = $LAresponse["forecast"]["forecastday"][0]["day"]["maxtemp_f"];
   $lowTemp = $LAresponse["forecast"]["forecastday"][0]["day"]["mintemp_f"];
   $todayCondition = $LAresponse["forecast"]["forecastday"][0]["day"]["condition"]["text"];
   $todayIcon = $LAresponse["forecast"]["forecastday"][0]["day"]["condition"]["icon"];
 
   $ins = "INSERT INTO currentWeather (City, Region, CurrentTemp, CurrentCondition, CurrentImage, HighTemp, LowTemp, TodayCondition, TodayImage)
   VALUES ('$city', '$state', '$currTemp', '$currCondition', '$currentImage', '$highTemp', '$lowTemp', '$todayCondition', '$todayIcon')";
 
 $db->exec($ins);

    //Parse data for Nashville and insert into table.

  $NASresponse = json_decode($NASresponse, true);

  $city = $NASresponse["location"]["name"];
  $currTemp = $NASresponse["current"]["temp_f"];
  $currCondition = $NASresponse["current"]["condition"]["text"];
  $state = $NASresponse["location"]["region"];
  $currentImage = $NASresponse["current"]["condition"]["icon"];
  $highTemp = $NASresponse["forecast"]["forecastday"][0]["day"]["maxtemp_f"];
  $lowTemp = $NASresponse["forecast"]["forecastday"][0]["day"]["mintemp_f"];
  $todayCondition = $NASresponse["forecast"]["forecastday"][0]["day"]["condition"]["text"];
  $todayIcon = $NASresponse["forecast"]["forecastday"][0]["day"]["condition"]["icon"];

  $ins = "INSERT INTO currentWeather (City, Region, CurrentTemp, CurrentCondition, CurrentImage, HighTemp, LowTemp, TodayCondition, TodayImage)
  VALUES ('$city', '$state', '$currTemp', '$currCondition', '$currentImage', '$highTemp', '$lowTemp', '$todayCondition', '$todayIcon')";

$db->exec($ins);

?>
    

