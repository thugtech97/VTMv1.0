<?php

include "../simplexlsx/src/SimpleXLSX.php";

$conn = mysqli_connect("localhost", "root", "", "vas-vas");
$filen = mysqli_real_escape_string($conn, $_GET['filen']);

if(isset($_GET['files'])){
	//$filen = mysqli_real_escape_string($_GET['filen']);
	$files = array();
	$uploaddir = '../UPLOADED/';
	foreach($_FILES as $file){
		//$filen = $file['name'];
		$filename = $file['name'];
		if(move_uploaded_file($file['tmp_name'], $uploaddir .basename($file['name']))){
			if($xlsx = SimpleXLSX::parse($uploaddir.$filename)){
				$i = 0;
				foreach($xlsx->rows(1) as $elt){
					if($i == 0){
						$i++;
					}else{
						if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_data WHERE vaccination_date = '".$elt[17]."' AND fname = '".$elt[5]."' AND mname = '".$elt[6]."' AND lname = '".$elt[4]."'")) == 0){
							mysqli_query($conn, "INSERT INTO tbl_data(category, deferral, vaccination_date, vaccine, 1st_dose, 2nd_dose, tally_name, fname, mname, lname) VALUES('".$elt[0]."', '".$elt[15]."', '".$elt[17]."', '".$elt[18]."', '".$elt[23]."', '".$elt[24]."', '".$filen."', '".$elt[5]."', '".$elt[6]."', '".$elt[4]."')");
						}
					}
				}
			}else{
				echo SimpleXLSX::parseError();
			}
		}
	}

	$columns = "";
	$table = "";

	$get_col = mysqli_query($conn, "SELECT DISTINCT category FROM tbl_data WHERE tally_name = '$filen'");
	$doses = array("1st_dose", "2nd_dose");
	$get_vac = mysqli_query($conn, "SELECT DISTINCT vaccine FROM tbl_data WHERE tally_name = '$filen'");
	$vaccines = array();
	while($row = mysqli_fetch_assoc($get_vac)){
		array_push($vaccines, $row["vaccine"]);
	}

	while($row = mysqli_fetch_assoc($get_col)){
		foreach ($doses AS $dose) {
			foreach ($vaccines AS $vaccine) {
				$columns.="<td><b>".$row["category"]."(".$dose.")(".(($vaccine == "") ? "NONE" : $vaccine).")</b></td>";
			}
		}
	}

	$table.="<thead><tr><td><b>DATES</b></td>".$columns."<td><b>Total 1st Dose</b></td><td><b>Total 2nd Dose</b></td><td><b>Deferrals</b></td></tr></thead>";
	$query1 = mysqli_query($conn, "SELECT DISTINCT vaccination_date FROM tbl_data WHERE tally_name = '$filen' ORDER BY vaccination_date ASC");
	while($row = mysqli_fetch_assoc($query1)){
		$vaccination_date = $row["vaccination_date"];
		$query2 = mysqli_query($conn, "SELECT DISTINCT category FROM tbl_data WHERE tally_name = '$filen'");
		$content = "";
		while($rowt = mysqli_fetch_assoc($query2)){
			$category = $rowt["category"];
			foreach ($doses AS $dose) {
				foreach ($vaccines AS $vaccine) {
					$num_vac = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_data WHERE tally_name = '$filen' AND category = '$category' AND vaccination_date = '$vaccination_date' AND deferral = 'N' AND vaccine = '$vaccine' AND ".$dose." = 'Y'"));
					$content.="<td>".$num_vac."</td>";
				}
			}
		}
		$num_fd = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_data WHERE tally_name = '$filen' AND vaccination_date = '$vaccination_date' AND 1st_dose = 'Y' AND deferral = 'N'"));
		$num_sd = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_data WHERE tally_name = '$filen' AND vaccination_date = '$vaccination_date' AND 2nd_dose = 'Y' AND deferral = 'N'"));
		$num_df = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tbl_data WHERE tally_name = '$filen' AND vaccination_date = '$vaccination_date' AND deferral = 'Y'"));
		$table.="<tr style=\"text-align:center;\"><td>".substr($vaccination_date, 0, 10)."</td>".$content."<td>".$num_fd."</td><td>".$num_sd."</td><td>".$num_df."</td></tr>";
	}
	echo json_encode(array("filename"=>$filen, "table"=>$table));
}

?>