<?php

      
    $conn =new mysqli("localhost", "root", "root", "testdb3");

    $userteam = $conn->real_escape_string($_POST["team"]);
    $usernation = $conn->real_escape_string($_POST["nation"]);
    $usergroup = $conn->real_escape_string($_POST["group"]);
    $sql = "INSERT INTO users (nameteam, namenation, namegroup ) VALUES ('$userteam', '$usernation', $usergroup)";
    if($conn->query($sql)){
        echo "Данные успешно добавлены";
    } else{
        echo "Ошибка: " . $conn->error;
    }

    
    $conn->close();

?>
<!DOCTYPE html>
<html>
<p>

</p>
<a href="#" onclick="history.back();">Назад</a>

