<?php
include('config/function.php');
$html = "";
if(isset($_REQUEST['userId']) && $_REQUEST['userId']!="") 
{
	$userId = $_REQUEST['userId'];
	$query = "SELECT * FROM user_task WHERE company_id = '".$userId."' AND is_visited = '0' ORDER BY id DESC";
	if($sql_select=$conn->query($query))
	{
		if($sql_select->num_rows>0)
		{
			$html .='<ol>';
			while($result=$sql_select->fetch_array(MYSQLI_ASSOC))
			{
				$html .='<li>'.$result['task_name'].'</li>';
			}
			$html .='</ol>';
		}
	}
}
echo $html;
?>