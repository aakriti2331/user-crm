<?php

include("conn.php");

class crm
{	

	function getTotalTask($conn,$company_id)
	{
		$query = "SELECT id FROM user_task WHERE company_id='{$company_id}' ORDER BY id DESC";
		if($sql_select=$conn->query($query))
		{
			return $sql_select->num_rows;
		}
	}
	
	function onTime($conn,$company_id)
	{
		$query = "SELECT id FROM user_task WHERE company_id='{$company_id}' AND status='Completed' AND DATE(task_end_date) >= DATE(task_com_date)";
		if($sql_select=$conn->query($query))
		{
			if($sql_select->num_rows>0)
			{
				return $sql_select->num_rows;
			}
			else
			{
				return 0;
			}
		}
	}
	
	function behindTime($conn,$company_id)
	{
		$query = "SELECT id FROM user_task WHERE company_id='{$company_id}' AND DATE(task_end_date) <= DATE(task_com_date)";
		if($sql_select=$conn->query($query))
		{
			if($sql_select->num_rows>0)
			{
				return $sql_select->num_rows;
			}
			else
			{
				return 0;
			}
		}
	}
	
	function getTask($conn,$company_id,$date)
	{
		$querycolorrecords = "SELECT task_name FROM user_task WHERE company_id='{$company_id}' AND DATE(task_start_date) = '{$date}' ORDER BY id DESC";
		if($sql_selectdata = $conn->query($querycolorrecords))
		{
			if($sql_selectdata->num_rows>0)
			{
				return $sql_selectdata;
			}
		}
	}
	
	function getRevenues($conn,$company_id)
	{
		$sql = "SELECT sum(revenue) as revenue FROM revenues WHERE company_id='$company_id'";
		if($qr_sql = $conn->query($sql))
		{
			if($qr_sql->num_rows> 0)
			{
				$result = $qr_sql->fetch_array(MYSQLI_ASSOC);
				$revenue = $result['revenue'];
				return number_format($revenue,2);				
			}
			else
			{
				return 0.00;	
			}
		}
	}
	
	function logo($conn,$table,$field)
	{
		$querylogo = "SELECT $field FROM `$table` WHERE status = 1 ORDER BY id DESC";
		if($sql_selectlogo = $conn->query($querylogo))
		{
			if($sql_selectlogo->num_rows>0)
			{
				$resultlogo = $sql_selectlogo->fetch_array(MYSQLI_ASSOC);
				return trim($resultlogo[$field]);
			}
		}
	}
	
	function getdatas($conn,$table,$field,$cond,$value)
	{
		$querydata = "SELECT $field FROM $table WHERE $cond = '".$value."' AND status = 1";
		if($sql_selectdata = $conn->query($querydata))
		{
			if($sql_selectdata->num_rows>0)
			{
				$resultdata = $sql_selectdata->fetch_array(MYSQLI_ASSOC);
				return trim($resultdata[$field]);
			}
		}
	}
	
	function getInfo($conn,$table,$field,$id)
	{
		$queryinfo = "SELECT $field FROM `$table` WHERE id = '".$id."'";
		if($sql_select = $conn->query($queryinfo))
		{
			if($sql_select->num_rows>0)
			{
				$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
				return trim($resultinfo[$field]);
			}
		}		
	}
	
	function getsinglerecord($conn,$table,$field,$cond)
	{
		$queryconrecord = "SELECT * FROM $table WHERE $cond";
		if($sql_selectconrecord=$conn->query($queryconrecord))
		{			
			if($sql_selectconrecord->num_rows>0)
			{
				$resultconrecord = $sql_selectconrecord->fetch_array(MYSQLI_ASSOC);
				return trim($resultconrecord[$field]);
			}
		}
	}
	
	function getInfoRig($conn,$table,$field,$id)
	{
		$queryinfo = "SELECT $field FROM `$table` WHERE id = '".$id."'";
		if($sql_select = $conn->query($queryinfo))
		{
			if($sql_select->num_rows>0)
			{
				$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
				return trim($resultinfo[$field]);
			}
		}		
	}

	function getdata($conn,$table,$field,$cond,$value)
	{
		$querydata = "SELECT $field FROM $table WHERE $cond = '".$value."' ORDER BY id DESC";
		if($sql_selectdata = $conn->query($querydata))
		{
			if($sql_selectdata->num_rows>0)
			{
				$resultdata = $sql_selectdata->fetch_array(MYSQLI_ASSOC);
				return trim($resultdata[$field]);
			}
		}
	}
	
	function getallrecord($conn,$table,$order)
	{
		$queryrecord = "SELECT * FROM `$table` WHERE status=1 $order";
		if($sql_selectrecord=$conn->query($queryrecord))
		{
			if($sql_selectrecord->num_rows>0)
			{
				$resultrecord=$sql_selectrecord->fetch_array(MYSQLI_ASSOC);
				return $resultrecord;
			}
		}
	}
	
	function getnumrows($conn,$table)
	{
		$querynumrows = "SELECT * FROM `$table`";
		if($sql_selectnumrows = $conn->query($querynumrows))
		{
			$num = $sql_selectnumrows->num_rows;
			return $num;
		}
	}
	
	function getallrecords($conn,$table,$order)
	{
		$queryrecords = "SELECT * FROM `$table` WHERE `status` = '1' $order";
		if($sql_selectrecords = $conn->query($queryrecords))
		{
			return $sql_selectrecords;
		}
	}
	function getevents($conn,$table,$order)
	{
		$queryrecords = "SELECT * FROM `$table` $order";
		if($sql_selectrecords = $conn->query($queryrecords))
		{
			return $sql_selectrecords;
		}
	}
	
	function getlimit($conn,$table,$order,$limit)
	{
		$querylimit = "SELECT * FROM $table WHERE status=1 $order $limit";
		if($sql_selectlimit = $conn->query($querylimit))
		{
			return $sql_selectlimit;
		}
	}
	
	function getconlimit($conn,$table,$cond,$order,$limit)
	{
		$queryconlimit = "SELECT * FROM $table WHERE $cond AND status=1 $order $limit";
		if($sql_selectconlimit = $conn->query($queryconlimit))
		{
			return $sql_selectconlimit;
		}
	}
	
	function getconrecords($conn,$table,$cond)
	{
		$queryconrecords = "SELECT * FROM `$table` WHERE $cond AND `status` = '1' ORDER BY id DESC";
		if($sql_selectconrecords = $conn->query($queryconrecords))
		{
			return $sql_selectconrecords;
		}
	}
	
	function getcondrecords($conn,$table,$cond,$order)
	{
		$querycolorrecords = "SELECT * FROM $table WHERE `status` = '1' AND $cond $order";
		if($sql_selectcolorrecords = $conn->query($querycolorrecords))
		{
			return $sql_selectcolorrecords;
		}
	}
	
	function getconrecord($conn,$table,$cond)
	{
		$queryconrecord = "SELECT * FROM $table WHERE $cond ORDER BY id DESC";
		if($sql_selectconrecord=$conn->query($queryconrecord))
		{			
			if($sql_selectconrecord->num_rows>0)
			{
				$resultconrecord = $sql_selectconrecord->fetch_array(MYSQLI_ASSOC);
				return $resultconrecord;
			}
		}
	}

	function getpaginaterecord($conn,$table,$limit)
	{
		$querypagirecord = "SELECT * FROM $table WHERE status=1 ORDER BY id DESC $limit";
		if($sql_selectpagirecord = $conn->query($querypagirecord))
		{
			return $sql_selectpagirecord;
		}
	}
	
	function getpaginateconrecord($conn,$table,$cond,$limit)
	{
		$querypagiconrecord = "SELECT * FROM $table WHERE $cond AND status=1 ORDER BY id DESC $limit";
		if($sql_selectconpagirecord = $conn->query($querypagiconrecord))
		{
			return $sql_selectconpagirecord;
		}
	}
	
	function gettotalitem($conn,$session_id)
	{
		$queryitem = "SELECT * FROM cart WHERE session_id='$session_id' && status=1";
		if($sql_selectitem = $conn->query($queryitem))	
		{
			$num = $sql_selectitem->num_rows;
			return $num;
		}
		else
		{
			return 0;
		}
	}
	
	function gettotalnum($conn,$table,$con)
	{
		$queryitem="SELECT * FROM $table WHERE $con && status=1";
		if($sql_selectitem=$conn->query($queryitem))	
		{
			$num=$sql_selectitem->num_rows;
			return $num;
		}
		else
		{
			return 0;
		}
	}
	
	function grossTotal($conn,$table,$field,$id)
	{
		$queryinfo = "SELECT $field FROM `$table` WHERE id = '".$id."'";
		if($sql_select = $conn->query($queryinfo))
		{
			if($sql_select->num_rows>0)
			{
				$resultinfo = $sql_select->fetch_array(MYSQLI_ASSOC);
				return trim($resultinfo[$field]);
			}
		}		
	}
	
	function subTotal($conn,$session_id)
	{
		$sql = "SELECT sum(total_price) as subamount FROM cart WHERE session_id='$session_id' AND status='1'";
		if($qr_sql = $conn->query($sql))
		{
			if($qr_sql->num_rows> 0)
			{
				$result = $qr_sql->fetch_array(MYSQLI_ASSOC);
				if($result['subamount']!=NULL)
				return $result['subamount'];
				else
				return 0.00;
			}
			else
			{
				return 0.00;
			}
		}
	}
	
	function shippingCharge($conn,$session_id)
	{
		$sql = "SELECT sum(total_price) as subamount FROM cart WHERE session_id='$session_id' AND status='1'";
		if($qr_sql = $conn->query($sql))
		{
			if($qr_sql->num_rows> 0)
			{
				$result = $qr_sql->fetch_array(MYSQLI_ASSOC);
				$sub_total = $result['subamount'];
				$sql_shipping_carge = "SELECT shipping_carge,price_upto FROM shipping WHERE status='1' ORDER BY id DESC";
				if($qr_sql_shipping_carge = $conn->query($sql_shipping_carge))
				{
					if($qr_sql_shipping_carge->num_rows> 0)
					{
						$result_shipping_carge = $qr_sql_shipping_carge->fetch_array(MYSQLI_ASSOC);
						$shipping_carge = $result_shipping_carge['shipping_carge'];
						$price_upto = $result_shipping_carge['price_upto'];
						if($sub_total>=$price_upto)
						{
							return $shipping_carge;
						}
						else
						{
							return 0;
						}
					}
				}
			}
		}
	}
	
	function getGrossTotal($conn,$session_id)
	{
		$sql = "SELECT sum(total_price) as subamount FROM cart WHERE session_id='$session_id' AND status='1'";
		if($qr_sql = $conn->query($sql))
		{
			if($qr_sql->num_rows> 0)
			{
				$result = $qr_sql->fetch_array(MYSQLI_ASSOC);
				$sub_total = $result['subamount'];
				$discount_total = $sub_total*(10/100);
				$sub_total = $sub_total - $discount_total;
				$sql_shipping_carge = "SELECT shipping_carge,price_upto FROM shipping WHERE status='1' ORDER BY id DESC";
				if($qr_sql_shipping_carge = $conn->query($sql_shipping_carge))
				{
					if($qr_sql_shipping_carge->num_rows> 0)
					{
						$result_shipping_carge = $qr_sql_shipping_carge->fetch_array(MYSQLI_ASSOC);
						$shipping_carge = $result_shipping_carge['shipping_carge'];
						$price_upto = $result_shipping_carge['price_upto'];
						if($sub_total>=$price_upto)
						{
							return $sub_total+$shipping_carge;
						}
						else
						{
							return $sub_total;
						}
					}
				}
				
			}
		}
	}
	
}

$newobject = new crm();

?>