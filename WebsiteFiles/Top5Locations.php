<!DOCTYPE html>
<html>
<head>
    <style>
        h1 {
            color: blue;
        }
		.wrapper {
			display: flex;
		}
		.wrapper > div {
			flex: 1;
		}


    </style>
</head>
<body>
    <center>
    
    <h1>TOP 5 US LOCATIONS TO VACATION </h1>
    <?php
        require 'connection.php';
		$conn = getDB();
		

        
        // BingImage API display via html
        echo "<h2>Where would you like to visit?</h2>";
        $sql2 = "SELECT image_id, image, name, encodingFormat, familyFriendly FROM bingimage";
        $result2 = $conn->query($sql2);

        if ($result2->num_rows > 0) {
			echo '<div class="wrapper">';
            while($row = $result2->fetch_assoc()){
				echo '<div class="box1">';
				$file = str_replace(" ",'_',$row["name"]);
				$file = (explode(",", $file));
				echo '<a href=' . $file[0] . ".php" . '>';
                echo "<b>" . $row["name"] . "</b><br>";
                echo '<img src="' . $row["image"] . '"alt = "bing image"  style = width:200px;height:200px> </a></div><br>';

            }
			echo '</div>';
        } else {
            echo "0 results";
        }


    $conn->close();
    ?>
    </center>
</body>
</html>
