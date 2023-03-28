<style>
    h1 {
        color: green;
		text-align:center;
    }
	.grid-container {
		display: grid;
		grid-template-columns: auto auto auto;
	}
	.grid-item{
		text-align: center;
	}
</style>

<?php

	require 'connection.php';
	$conn = getDB();

    $sql = "SELECT id, City, Region, CurrentTemp, CurrentCondition, 
	CurrentImage, HighTemp, LowTemp, TodayCondition, TodayImage FROM 
	currentWeather WHERE id = '4'";
    $result = $conn->query($sql);
	
	//Weather
	$row = $result->fetch_assoc();
	echo "<h1> Weather for ". $row["City"]. ", " . $row["Region"] . "</h1><br>";
	echo '<div class="grid-container">';
	echo '<div class="grid-item">';
	echo "<b>Current Temperature: </b>" . $row["CurrentTemp"]. "<br><b>Current Condition: </b>" . $row["CurrentCondition"] . "<br>";
	echo '<img src=' . $row["CurrentImage"] . ' alt=Current Weather Condition/></div> <div class="grid-item">';
	echo "<b>High Temperature: </b>" . $row["HighTemp"] . "<br>" . "<b>Low Temperature: </b>" . $row["LowTemp"] . "<br>" . "<b>Today's Condition: </b>" . $row["TodayCondition"] ."<br>";
	echo '<img src=' . $row["TodayImage"] . ' alt=Current Weather Condition/> </div> </div>';
           
	//Flights
		echo "<h1> Flights departing From JFK to Los Angeles: </h1>";
        $sql3 = "SELECT id, depiataCode, arriataCode, terminal, gate, scheduledTime, name, number FROM aviation WHERE arriataCode = 'lax'";

        $result3 = $conn->query($sql3);

        if ($result3->num_rows > 0) {
          echo '<div class="grid-container">';
			while($row = $result3->fetch_assoc()){
				echo '<div class="grid-item">';
                echo "<h3>Flight Name: " . ucwords($row["name"]) . "</h3>";
                echo "<b>Gate</b>: " . $row["gate"] . "<br>" . "<b>Time</b>: " . $row["scheduledTime"] . "<br>" . "<b>Flight Number</b>: " . $row["number"] ."<br>";
                echo "<b>Terminal</b>: " . $row["terminal"] ."</div>";
				
            }
		echo '</div>';
        } else {
            echo "0 results";
        }

	//Yelp
		echo "<br><h1>Highly Rated Places in Los Angeles:</h1>";
        $sql4 = "SELECT id, name, url, rating, street, city, zip FROM yelp WHERE city = 'Los Angeles'";
        $result4 = $conn->query($sql4);

        if ($result4->num_rows > 0) {
       echo '<div class="grid-container">';
            while($row = $result4->fetch_assoc()){
				echo '<div class="grid-item">';
                echo '<br><h3><b><a href=' . $row["url"] . '>' . $row["name"] . '</a></b></h3>' ;         
                echo "Rating: " . $row["rating"] . " <br>" . "Street: " . $row["street"];
                echo "<br>City: " . $row["city"] . "   " . "Zip: " . $row["zip"]."</div>";                
            }
			echo '</div>';
        } else {
            echo "0 results";
        }
