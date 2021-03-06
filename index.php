<?php
	require_once('header.php'); 
	require_once('navmenu.php');
	require_once('constants.php');
?>
    <h1><?=TITLE?><br />Volunteer Management System</h1>
		
		<div id="last_activities">
			<h2>Ultimele Activități</h2>
			<ul>
<?php
	//Query database
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$query="SELECT id,name,date FROM activity ORDER BY date DESC";
	$data = mysqli_query($dbc, $query);
	
	//Cycle through activities
	while($row=mysqli_fetch_array($data)){
		echo "				".'<li><a href="show_activity.php?id='.$row['id'].'">'.$row['name'].'</a> - '.date("d.m.Y",$row['date']).'</li>'."\r\n";
	}
?>
			</ul>
		</div>
		
		<div id="top_volunteers"><h2>Top Voluntari</h2>
			<ol>
<?php
			
	//Query database
  //Get volunteers with points
	$query = "SELECT v.id,v.nume,SUM(p.points) AS total
FROM points AS p
INNER JOIN voluntar AS v ON p.id_volunteer=v.id
GROUP BY v.id
ORDER BY total DESC";
  $data = mysqli_query($dbc, $query);
  
  //Get all volunteers
  $query = "SELECT id, nume FROM voluntar";
  $volunteers = mysqli_query($dbc, $query);

	mysqli_close($dbc);

  $volunteers_with_points = array();
	
	//Cycle through users
	while($row = mysqli_fetch_array($data)){
		echo "				".'<li><a href="show_volunteer.php?id='.$row['id'].'">'.$row['nume'].'</a> - '.$row['total'].' puncte</li>'."\r\n";
    $volunteers_with_points[$row['id']] = true;
  }

  while($row = mysqli_fetch_array($volunteers)){
    if(!$volunteers_with_points[$row['id']]){
      echo "        ".'<li><a href="show_volunteer.php?id='.$row['id'].'">'.$row['nume'].'</a> - 0 puncte</li>'."\r\n";
    }
  }
?>
			</ol>
		</div>
		
<?php 
	require_once('footer.php'); 
?>
