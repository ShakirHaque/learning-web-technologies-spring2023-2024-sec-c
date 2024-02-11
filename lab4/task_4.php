<?php
 echo "your number1 is ". $number1=25 . "<br>";
 echo "your number2 is ". $number2=55 . "<br>";
 echo "your number3 is ". $number3=35 . "<br>";

 if($number1>$number2)
 {
    if($number1>$number3)

    {
        echo $number1;
    }
 }
 elseif($number2>$number3)
 {
    echo $number2;
 }
 else
 echo $number3;

?>