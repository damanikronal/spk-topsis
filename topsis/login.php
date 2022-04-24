<?php
echo "
<form method='post' action='ceklogin.php'>
  <table align='left' width='100' border='0'>
    <tr>
      <td>Username</td>
      <td>:</td>
      <td><input type='text' name='username' size='15'></td>
    </tr>
    <tr>
      <td>Password</td>
      <td>:</td>
      <td><input type='password' name='password' size='15'></td>
    </tr>
    <tr>
      <td colspan='2'>&nbsp;</td>
      <td><input type='submit' name='Submit' value='Login'></td>
    </tr>
  </table>
</form>";
?>