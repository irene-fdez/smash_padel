<?php
include '../Models/DB/BdAdmin.php';
$this->mysqli = ConnectDB();
$sql = "SELECT * FROM departamento 
		WHERE nombre LIKE '%".$_GET['q']."%'
		LIMIT 10"; 
$result = $mysqli->query($sql);
$json = [];
while($row = $result->fetch_assoc()){
     $json[] = ['id'=>$row['id'], 'text'=>$row['nombre']];
}
echo json_encode($json);