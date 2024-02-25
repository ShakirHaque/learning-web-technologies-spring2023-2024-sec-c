<html>
    <body>
        <table border="1" cellspacing="0" cellpadding="10" align="center">
            <tr>
                <td colspan="3" align="left" height="50"><img src="shakir.jpg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Loggedin as <a href="page1.html">Log out</a></td>
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
                <td width="300px" valign="top">  
                <form >
    <fieldset style="width: 280px; padding: 10px;">
        <legend>Date of Birth</legend>
        Name:
        <input type="text"  name="name" ><hr>
        Email:
        <input type="text"  name="name" ><hr>
       Gender: <input type="radio"  name="gender" value="male" required> Male
                        <input type="radio"  name="gender" value="female" required> Female
                        <input type="radio"  name="gender" value="Other" required> Other
                    <hr>
                    <input type="number"  name="day" style="width: 30px;" required min="1" max="31">&nbsp;/
                        <input type="number"  name="month" style="width: 30px;" required min="1" max="12">&nbsp;/
                        <input type="number"  name="year" style="width: 40px;" required min="1900" max="9999">(<i>dd/mm/yy</i>)
                        <hr><br>
    <input type="submit" value="Submit">

    </fieldset>
                </td>
               
            </tr>
            <tr>
                <td colspan="3" align="center">Copyright</td>
            </tr>
        </table>
    </body>
</html>
