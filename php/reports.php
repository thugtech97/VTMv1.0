<?php

$conn = mysqli_connect("localhost", "root", "", "vas-vas");

function get_tally(){
	global $conn;

	$filen = mysqli_real_escape_string($conn, $_POST['filen']);

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

function get_tally_sheets(){
	global $conn;
	echo "<option></option>";
	$sql = mysqli_query($conn, "SELECT DISTINCT tally_name FROM tbl_data ORDER BY tally_name ASC");
	while($row = mysqli_fetch_assoc($sql)){
		echo "<option>".$row["tally_name"]."</option>";
	}
}

$call_func = mysqli_real_escape_string($conn, $_POST["call_func"]);
switch($call_func){
	case "get_tally_sheets":
		get_tally_sheets();
		break;
	case "get_tally":
		get_tally();
		break;
}

?>