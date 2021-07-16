<?php
$conn = new mysqli("localhost", "root", "root");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}
// Создаем базу данных testdb2
$sql = "CREATE DATABASE testdb2";
if($conn->query($sql)){
    echo "База данных успешно создана";
} else{
    echo "Ошибка: " . $conn->error;
}
$conn = mysqli_connect("localhost", "root", "root", "testdb2");
$sql = "CREATE TABLE players
 (id INTEGER AUTO_INCREMENT PRIMARY KEY,
 nameteam VARCHAR(255),
 namenation VARCHAR(255),
 namegroup VARCHAR(255)
)";

if(mysqli_query($conn, $sql)){
    echo "Таблица players успешно создана";
} else{
    echo "Ошибка: " . mysqli_error($conn);
}
$conn->close();
?>