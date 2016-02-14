<?php
include("include.php");

$sql = "SELECT * FROM question_answer ORDER BY rand() LIMIT 1";
$myrs=mysql_query($sql,$myconn);
$row = mysql_fetch_array($myrs);

echo "<table width=100% height=20><tr><td bgcolor=ffffff><input type='hidden' name='qid' id='qid' value='".$row['id']."'>".$row['question']."</td></tr><tr><td> &nbsp;<input type=text name=answer id=answer size=30><font color=red>*</font>ฃจว๋ฬ๎ะดฮสฬโด๐ฐธฃฉ</td></tr></table>";

?>