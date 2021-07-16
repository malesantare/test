<?php 

//функция buildgroupset возвращающая масив, в котором находятся все страны определённой группы
/*
пример:
Динамо Россия группа А
Шахтёр Россия Группа Б
Спартак Россия Группа А
Динамо1 Россия группа С
Шахтёр1 Россия Группа Б
Спартак1 Россия Группа D
Массив будет выглядеть как
[группа А][1] = Динамо Россия [группа А][2] = Спартак Россия
[Группа Б][1] = Шахтёр Россия [Группа Б][2] = Шахтёр1 Россия
[группа С][1] = Динамо1 Россия
[Группа D] = Спартак1 Россия
*/

function buildgroupset($count, $mass, $teammass)
{
for ($i=1; $i<=$count; $i++)
{

  $result[$teammass[$i]][0]++;
  $result[$teammass[$i]][$result[$teammass[$i]][0]]=$mass[$i];

}
return $result;
}

//функция findinmass возвращающая масив уникальных названий групп

function findinmass($sought, $mass)
{
  $bool = false;

  for ($i=1; $i<=count($mass); $i++)
  {
    if ($mass[$i] == $sought)
    {
      $bool = true;
    }
  }

  if ($bool==false) 
  {
    $mass[(count($mass)+1)] = $sought;
  }
return $mass;
}

//функция generatemass возвращает масив с цифрами вместо текста + добавляет заглушку в случае нечетного кол-во комманд

function generatemass($count)
{
  for ($i=1; $i<=$count ; $i++)
  {
    $array[$i] = $i;
  }
  
  if ($count % 2 != 0)
  {
    $array[$count+1]=NULL;
  }
  return  $array;
}

function main()
{
  //getdata
$conn =new mysqli("localhost", "root", "root", "testdb3");
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
$rowsCount = $result->num_rows;
 foreach($result as $row)
 {
    $i++;
    $userteam[$i] = $row['nameteam'].'('.$row['namenation'].')';
    $usergroup[$i]  = $row['namegroup'];
 }

$result = buildgroupset($rowsCount, $userteam, $usergroup);

$resultgroup[1] = $usergroup[1];

for ($i=1; $i<=$rowsCount;$i++)
{
 $resultgroup = findinmass($usergroup[$i],$resultgroup);
}


for ($counter=1; $counter<=count($resultgroup);$counter++)
{  echo "<center>".'Группа '.$resultgroup[$counter]. ' '."</center>";
  echo "<p></p>";
//rowsCount это число команд в отдельной группе
  $rowsCount = $result[$resultgroup[$counter]][0];
  //userteam названия команд в группе
$userteam = $result[$resultgroup[$counter]];
$array = generatemass($rowsCount);
//цикл пробегается по турам
for ($tour= 1; $tour <$rowsCount; $tour++)
{
  $array1 = $array;
  $userteam1 = $userteam;
  $usergroup1 = $usergroup;

  echo "<center>".'  Тур номер '.$tour. ' '."</center>";
  echo "<p></p>";
  //цикл для вывода сетки в определённом туре
  for ($i= 1;$i <=intdiv($rowsCount,2);$i++)
  {

    $j = $rowsCount-$i+1;
  //проверка на то, что какая то команда остаётся без соперника
    if (($array[$i]!=null ) && ($array[$j]!=null))
    {
    
     echo "<center>".$userteam[$i].'=>'.$userteam[$j]."</center>";
     echo "<p></p>";
    }

  }
  //перемещение масива по часовой стрелке
   for ($i=2; $i<=$rowsCount ; $i++)
  {
    if ($i==2)
    {
      $userteam[$i] =$userteam1[$rowsCount];
      $usergroup[$i] = $usergroup1[$rowsCount];
      $array[$i] = $array1[$rowsCount];
    }
   else
    {
      $userteam[$i] =$userteam1[$i-1];
      $usergroup[$i] = $usergroup1[$i-1];
      $array[$i] = $array1[$i-1];
    }
   }
  }
 }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>METANIT.COM</title>
<meta charset="utf-8" />
</head>
<body>



<h3>Добавление пользователя</h3>
<form  action="create.php" method="post">
    <p>Название команды:
    <input type="text" name="team" /></p>
    <p>название страны:
    <input type="text" name="nation" /></p>
    <p>название группы:
    <input type="number" name="group" /></p>
    <input type="submit" value="Добавить">


</form>

<form name="first_f" method="post" >
  <p>
<input type="submit"  name="btn1" value= 'Составить расписание турнира' />
</p>
</form>


</body>


<?php 
//запускает подсчёт турнирной таблицы при нажатии на клавишу
if ( isset ($_POST['btn1']) )
{
  main();
}

?>