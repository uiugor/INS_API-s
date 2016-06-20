<?php #Leitura dos Resultados#
# Editado e Remodelado por Igor Confetti - Inside Sistemas#
switch($_POST['API'])
{
	case 1: getCompanies();
			break;
	case 2: getDepartments($_POST['Empresa']);
			break;
	case 3: getCourses($_POST['Empresa'],$_POST['Departamento']);
			break;
	case 4: getXMLs($_POST['Empresa'],$_POST['Departamento'],$_POST['Modulo']);
			break;
	case 5: downloadXML($_POST['Empresa'],$_POST['Departamento'],$_POST['Modulo'],$_POST['xmlname']);
			break;
	default:break;
}
function getCompanies()
{
	$dir = @opendir("ResultadosCaptivate");
	if($dir != "")
	{
		while(($file = readdir($dir)) !== false)
		{
			if(!is_file($file))
			echo $file.";";
		}
		closedir($dir);
	}
	else
	echo "Nenhum Resultado Encontrado;";
}
function getDepartments($comp)
{
	$dir = @opendir("ResultadosCaptivate"."/".$comp);
	while (($file = readdir($dir)) !== false)
	{
		if(!is_file($file))
		echo $file.";";
	}
	closedir($dir);
}
function getCourses($comp,$dept)
{
	$dir = @opendir("ResultadosCaptivate"."/".$comp."/".$dept);
	while (($file = readdir($dir)) !== false)
	{
		if(!is_file($file))
		echo $file.";";
	}
	closedir($dir);
}
function getXMLs($comp,$dept,$course)
{
	$dir = @opendir("ResultadosCaptivate"."/".$comp."/".$dept."/".$course);
	$directory = "ResultadosCaptivate"."/".$comp."/".$dept."/".$course;
	while (($file = readdir($dir)) !== false)
	{
		if(!(is_dir($file)) && findexts($file) == 'xml')
		{
			echo $file.",".number_format(filectime($directory."/".$file),0, '.', '').";";
		}
	}
	closedir($dir);
}
function downloadXML($comp,$dept,$course,$name)
{
	$dir = "ResultadosCaptivate"."/".$comp."/".$dept."/".$course."/".$name;
	$handle = fopen($dir, "r");
	$contents = fread($handle, filesize($dir));
	fclose($handle);
	echo $contents;
}
function findexts ($filename)
{
	$filename = strtolower($filename) ;
	$exts = explode(".", $filename);
	$n = count($exts)-1;
	$exts = $exts[$n];
	return $exts;
} 
?>

