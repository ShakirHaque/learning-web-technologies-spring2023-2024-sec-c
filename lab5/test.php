<?php   
$username = $_POST['username'];
$password = $_POST['password'];
$testusername = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.-_';
$testpass = ['@', '#', '$', '%'];
$flag = 0;

if(strlen($username) >= 2)
{
    for($i = 0; $i < strlen($testusername); $i++)
    {
        for($j = 0; $j < strlen($username); $j++)
        {
            if($testusername[$i] == $username[$j])
            {
                $flag = 0;
            }
            else
            {
                $flag++;
            }
        }
    }
    if($flag > 0)
    {
        echo "retype";
    }
}
    

if($username == $password)
{
    echo "welcome";
}
?>
