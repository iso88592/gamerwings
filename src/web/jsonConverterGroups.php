<?php

require_once("mysqlConn.php");

$ObjForJSON = new stdClass;

$sql = "SELECT * FROM elgg8n_groups_entity";
$result = $conn->query($sql);

if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        $ObjForJSON->guid = $row["guid"];
        $ObjForJSON->name = $row["name"];
        $ObjForJSON->description = $row["description"];
        $JSON = json_encode($ObjForJSON);
        echo $JSON;
        echo "<br><br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>