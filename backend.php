<?php

include 'Config.php';
include 'User.php';


if($users = User::getAllUsers($conn))
{

echo '<table border="1">
	<tr>
	  <th>User Agent</th>
	  <th>Accept</th>
	  <th>AcceptLang</th>
	  <th>AcceptEncoding</th>
	  <th>IP address</th>
	  <th>Visits</th>
	</tr>
';

foreach($users as $user)
{
	echo '<tr>';
		echo "<td>$user->userAgent</td>";
		echo "<td>$user->accept</td>";
		echo "<td>$user->acceptLang</td>";
		echo "<td>$user->acceptEncoding</td>";
		echo "<td>$user->ipAddress</td>";
		echo "<td>$user->visits</td>";
	echo '<tr>';
}
echo '</tbody></table>';

}

echo '<br><br><a href="index.php">View frontend</a>';








