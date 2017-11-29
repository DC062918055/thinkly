<?php
    $address="eu-cdbr-azure-west-a.cloudapp.net";
    $username="bdedfd9bc02f19";
    $password="b9b00b76";
    $name="prism";
    $conn=new mysqli($address,$username,$password,$name);
    if($conn->connect_error) {
        die();
    }
    $query="DESCRIBE members";
    $result=$conn->query($query);
    while($row=$result->fetch_assoc()) {
        print_r($row);
    }
    //$query="CREATE TABLE users (id BIGINT NOT NULL AUTO_INCREMENT, username VARCHAR(16), password VARCHAR(255), forename VARCHAR(255), surname VARCHAR(255), email VARCHAR(254))";
?>
