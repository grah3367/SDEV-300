<?php

	function check_input($data)
	{
	    global $ret_data;
	    $data = trim($data);
	    $ret_data = htmlspecialchars($data);
	    return $ret_data;
	}
	
	function getLocation($data)
	{
		$ret_data="Online";
	   if ($data=="Y")   
	    $ret_data = "F2F (Largo, MD)";
	  return $ret_data;
	}
	// Look-up for the Group Letter
	function getGroupCourses($group)
	{
		$value="";
		switch ($group) {
    case 'A':
        $value="CMIS102";
        break;
    case 'B':
         $value="CMIS141,CMIS242,CMSC350";
        break;
    case 'C':
         $value="CMIS125";
        break;
    case 'D':
         $value="CMIS310,CMIS325";
         break;
         break;
    case 'E':
         $value="CMIS170,CMIS320";
         break;    
    case 'F':
         $value="CMSC150";
         break;       
    case 'G':
         $value="IFSM201";
         break;               
    }
	  return $value;
	}
	


	
	
?>