<?php
/*
$myObj = new stdClass;
$myObj->name = "John";
$myObj->age = 30;
$myObj->city = "New York";

$myJSON = json_encode($myObj);

echo $myJSON;

$decodedJSON = json_decode($myJSON);
echo "<br>";
echo "<br>";
echo "Name: " . $decodedJSON->name;
echo "<br>";
echo "Age: " . $decodedJSON->age;
echo "<br>";
echo "City: " . $decodedJSON->city;
*/

require_once("mysqlConn.php");

$ObjForJSON = new stdClass;

$sql = "SELECT * FROM elgg8n_users_entity";
$result = $conn->query($sql);

if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        $ObjForJSON->guid = $row["guid"];
        $ObjForJSON->name = $row["name"];
        $ObjForJSON->username = $row["username"];
        $ObjForJSON->password = $row["password"];
        $ObjForJSON->salt = $row["salt"];
        $ObjForJSON->password_hash = $row["password_hash"];
        $ObjForJSON->email = $row["email"];
        $ObjForJSON->language = $row["language"];
        $ObjForJSON->banned = $row["banned"];
        $ObjForJSON->admin = $row["admin"];
        $ObjForJSON->last_action = $row["last_action"];
        $ObjForJSON->prev_last_action = $row["prev_last_action"];
        $ObjForJSON->last_login = $row["last_login"];
        $ObjForJSON->prev_last_login = $row["prev_last_login"];
        $JSON = json_encode($ObjForJSON);
        echo $JSON;
        echo "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>