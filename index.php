<?php

$data = json_decode(file_get_contents("data/route.json"),true);
//print_r($data);
$visited = array();
$from = "pokhara";
$to = "kathmandu";
$cost = 0;
$path =array();
$temp_from = $from;
do
{
	$loop = true;
	if(isset($data[$temp_from]))
	{
//		echo "<br>==$temp_from==<br>";
		$temp = find_shortest($data[$temp_from],$from,$to,$visited,$path);
		if(is_array($temp))
		{
			$temp_from = $temp[0];
			$cost += $temp[1];
			if($temp[0] == $to)
			{
				$loop = false;
				print_r($path);
				echo "<br>cost = $cost";
			}
		}
	}else{
		$cost = 0;
		$path = array();
		$temp_from = $from;
	}
}while($loop);

function find_shortest($data,$from,$to,&$visited,&$path)
{
    $smaller = NULL;
    $note = NULL;
    foreach($data as $a=>$b)
    {
    	if(!is_int(array_search($a,$visited)))
    	{
	    	if($smaller)
	    	{
	    		if($b[0] <= $smaller)
	    		{
	    			$smaller = $b[0];
	    			$note = $a;
	    		}
	    	}else{
	    		$smaller = $b[0];
	    		$note = $a;
	    	}
    		if($to == $a)
    		{
				$smaller = $b[0];
				$note = $a;
				break;
    		}
    	}
    }
    $path[count($path)] = $note;
    $visited[count($visited)] = $note;
    $return = ($smaller!=NULL && $note!=NULL)? array($note,$smaller) : NULL;
    return $return;
}

?>

