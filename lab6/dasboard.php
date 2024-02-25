<?php 
    session_start();

    if(!isset($_SESSION['flag'])){
        header('location: login.php');
    }
?>


<html>
    <body>
        <table border="1" cellspacing="0" cellpadding="10" align="center">
            <tr>
                <td colspan="3" align="left" height="50"><img src="shakir.jpg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Loggedin as <?php echo $_SESSION['username'];?> 
                <a href="page1.html">Log out</a></td>
            </tr>
            <tr height="270px">
                <td width="150px" valign="top">
                    Account
                    <hr>
                    <a href="page1.html">Dashboard</a><br>
                    <a href="page2.html">View Profile</a><br>
                    <a href="page1.html">Edit Profile</a><br>
                    <a href="page2.html">Change Profile Picture</a><br>
                    <a href="page1.html">Change Password</a><br>
                    <a href="page2.html">Logout</a><br>
                </td>
                <td width="300px" valign="top"> <b>Welcome</b> <br><br>
                </td>
               
            </tr>
            <tr>
                <td colspan="3" align="center">Copyright</td>
            </tr>
        </table>
    </body>
</html>
