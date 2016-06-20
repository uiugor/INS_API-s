<?php # InternalServerReporting.php
# Copyright 2000-2008 Adobe Systems Incorporated. All rights reserved.
#
   print "<pre>\n";

#
   foreach ($_POST as $k => $v) 
   {
  	  if($k == "CompanyName")
	  {
	    $CompanyName = $v;
      }
      if($k == "DepartmentName")
	  {
	    $DepartmentName = $v;
      }
      if($k == "CourseName")
	  {
	    $CourseName = $v;
      }
      if($k == "Filename")
      {
      	$Filename = str_replace(array(','), '_' , $v);
      }
      if($k == "Filedata")
      {
      	if(get_magic_quotes_gpc())
		$Filedata = stripslashes($v);
		else
		$Filedata = $v;
      }
   }

	$ResultFolder = "./"."CaptivateResults";
	mkdir($ResultFolder);
	$CompanyFolder = $ResultFolder."//".$CompanyName;
	mkdir($CompanyFolder);
	$DepartmentFolder = $CompanyFolder."//".$DepartmentName;
	mkdir($DepartmentFolder);
	$CourseFolder = $DepartmentFolder."//".$CourseName;
	mkdir($CourseFolder);
	$FilePath = $CourseFolder."//".$Filename;
	$Handle = fopen($FilePath, 'w');
	fwrite($Handle, $Filedata);
	fclose($Handle);


   print "</pre>\n";
?>
