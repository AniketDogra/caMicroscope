<?php
include_once("connection.php"); 

switch ($_SERVER['REQUEST_METHOD']) 
{
    case 'GET':
	    if(isset($_GET["iid"]))
            {
		    $iid=$_GET["iid"];
		    $res = mysql_query("SELECT * FROM `state` WHERE iid='$iid'");	
            }
            else $res = mysql_query("SELECT * FROM `state`");
	    if (mysql_num_rows($res)<=0)
	    echo "No state IN DB";
	    else
	    {
	        while($row=mysql_fetch_array($res))
                {
		        $state=array('left'=>$row['left'],'top'=>$row['top'],'zoom'=>$row['zoom'],'iid'=>$row['iid']);
		        $stateList[]=$state;
                }
		echo json_encode($stateList);
	    }
	    break;
    case 'POST':
            if(isset($_POST["iid"]))
            {
 			$iid=$_POST["iid"];
                        $left=$_POST["left"];
			$top=$_POST["top"];
			$zoom=$_POST["zoom"];
                        // Formulate Query
			// This is the best way to perform an SQL query
			// For more examples, see mysql_real_escape_string()
			$query = sprintf("INSERT INTO state(iid,lft, top, zoom) VALUES ('%s','%s','%s','%s')",
			mysql_real_escape_string($iid),
			mysql_real_escape_string($left),
			mysql_real_escape_string($top),
			mysql_real_escape_string($zoom));
			// Perform Query
			$result = mysql_query($query);
			// Check result
			// This shows the actual query sent to MySQL, and the error. Useful for debugging.
			if (!$result) {
			    $message  = 'Invalid query: ' . mysql_error() . "\n";
			    $message .= 'Whole query: ' . $query;
			    die($message);
			}
                        else echo json_encode("saved");	
            }
	    else echo "Error";
            break;
}
?>
