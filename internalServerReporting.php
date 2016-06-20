<?php # InternalServerReporting.php
# Copyright 2000-2008 Adobe Systems Incorporated. All rights reserved.
#
# Editado e Remodelado por Igor Confetti - Inside Sistemas#
   print "<pre>\n";

#
   foreach ($_POST as $k => $v) 
   {
  	  if($k == "Nome da Empresa")
	  {
	    $CompanyName = $v;
      }
      if($k == "Nome do Departamento")
	  {
	    $DepartmentName = $v;
      }
      if($k == "Modulo")
	  {
	    $CourseName = $v;
      }
      if($k == "Nome do Arquivo")
      {
      	$Filename = str_replace(array(','), '_' , $v);
      }
      if($k == "Local do Arquivo")
      {
      	if(get_magic_quotes_gpc())
		$Filedata = stripslashes($v);
		else
		$Filedata = $v;
      }
   }

	$ResultFolder = "./"."ResultadosCaptivate";
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
