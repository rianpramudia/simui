<?php
include("../includes/config.php");
$filter = $_GET['filter'];
$item = $_GET['item'];
$result="";
switch($filter){
case "select_org":
	$org=$_GET['org'];
	$query = pg_query($conn, "select id,nama from pembuat_event where tingkatan='$item' and id in (select id_organisasi from organisasi)");
	while($row=pg_fetch_row($query)){
		if($org==$row[0]){
		$result.="<option selected='selected' value='".$row[0]."'>".$row[1]."</option>";
	} else{
		$result.="<option value='".$row[0]."'>".$row[1]."</option>";
	}
	}
	echo $result;
	break;

	case "select_kep":
	$id_pembuat="";
	$id_pembuat=$_GET['kep'];
	$query = pg_query("select id,nama from kepanitiaan,pembuat_event where id=id_kepanitiaan and id_organisasi='$item' group by id ");
				$result = "<option></option>";
				while($cat_result = pg_fetch_row($query)){
					if($id_pembuat !== ""){
						if($id_pembuat == $cat_result[0]){
							$result .="<option selected='selected' value='".$cat_result[0]."'>".$cat_result[1]."</option>";
						} else{
						$result .="<option value='".$cat_result[0]."'>".$cat_result[1]."</option>";}
					} else{
					$result .="<option value='".$cat_result[0]."'>".$cat_result[1]."</option>";
					}
				}
	echo $result;			
	break;
}
?>