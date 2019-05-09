<!DOCTYPE html>
<html>
<head>
<?php
session_start();
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 10px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
.button {
  border-top: 1px solid #96d1f8;
  background: #65a9d7;
  background: -webkit-gradient(linear, left top, left bottom, from(#3e779d), to(#65a9d7));
  background: -webkit-linear-gradient(top, #3e779d, #65a9d7);
  background: -moz-linear-gradient(top, #3e779d, #65a9d7);
  background: -ms-linear-gradient(top, #3e779d, #65a9d7);
  background: -o-linear-gradient(top, #3e779d, #65a9d7);
  padding: 5px 10px;
  -webkit-border-radius: 8px;
  -moz-border-radius: 8px;
  border-radius: 8px;
  -webkit-box-shadow: rgba(0, 0, 0, 1) 0 1px 0;
  -moz-box-shadow: rgba(0, 0, 0, 1) 0 1px 0;
  box-shadow: rgba(0, 0, 0, 1) 0 1px 0;
  text-shadow: rgba(0, 0, 0, .4) 0 1px 0;
  color: white;
  font-size: 23px;
  font-family: Helvetica, Arial, Sans-Serif;
  text-decoration: none;
  vertical-align: middle;
}

</style>
</head>
<body>

<h2>Spark Credit Management</h2>

<div class="row">
  <div class="column" style="background-color:#aaa;">
    <h2>Users of Spark Credit System</h2>
    <p>
      <?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'spark_creditmanagement');
define('DB_USER','root');
define('DB_PASSWORD','');

$con=mysql_connect(DB_HOST,DB_USER,DB_PASSWORD) or die("Failed to connect to MySQL: " . mysql_error());
$db=mysql_select_db(DB_NAME,$con) or die("Failed to connect to MySQL: " . mysql_error());

 echo "<table id=user class=row>";
  
// sql query to fetch all the data 
$query = "SELECT Name,current_credit FROM `user`"; 
if ($is_query_run = mysql_query($query)) 
{ 
    // echo "Query Executed"; 
    // loop will iterate until all data is fetched 
    $i=0;
    while ($query_executed = mysql_fetch_assoc ($is_query_run)) 
    { 
        echo "<tr id=$i><td>" . $query_executed["Name"]. "</td><td>" . $query_executed["current_credit"].  "</td></tr>";


         $i++;
            } 
} 

else
{ 
    echo "Error in execution"; 
} 
echo "</table>";

//$con.close();
?>
    </p>
  </div>
  <div class="column" style="background-color:#bbb;">
    <h2>Details to transfer Credits</h2>
    <p>
      <form name="frmTest" method="post">
Select the users from the given list of users  <input type="text" name="name"><br>
Select user to transfer credit from the given list <input type="text" name="transfer_name"><br>
Enter credits to be transfered <input type="text" name="credit"><br>
<input type="submit"  class="button" > 
</form>

    </p>
  </div>
</div>

<?php

$select_user=mysql_real_escape_string($_POST['name']);
$transfer_user=mysql_real_escape_string($_POST['transfer_name']);
$credit=mysql_real_escape_string($_POST['credit']); 



  $query1 = "SELECT current_credit FROM `user` where user.Name='". $select_user. "'"; 

  
$result = mysql_query($query1);
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$row = mysql_fetch_row($result);
$t=$row[0];
$query2 = "SELECT current_credit FROM `user` where user.Name='". $transfer_user. "'"; 
$result2 = mysql_query($query2);
if (!$result2) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$row2 = mysql_fetch_row($result2);
$tt=$row2[0];
$credit1=$t-$credit;
$credit2=$tt+$credit;
 $sql = "UPDATE user ". "SET current_credit = $credit1 ". 
               "WHERE Name = '". $select_user. "'" ;
           
            $retval = mysql_query( $sql, $con );
            
            
$sql2 = "UPDATE user ". "SET current_credit = $credit2 ". 
               "WHERE Name ='". $transfer_user. "'" ;
           
            $retval2 = mysql_query( $sql2, $con );
            
            if(! $retval2 || !$retval ) {
               die('Could not update data: ' . mysql_error());
            }
            echo "Updated data successfully\n";

            ?>

</body>

</html>

