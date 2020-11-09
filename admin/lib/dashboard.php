<?php
$folder ="..".DIRECTORY_SEPARATOR;
$files = $_REQUEST['file'];
if ((file_exists($folder."store/".$files.".data")) && (file_exists($folder."store/".$files.".lay" ))) {
		//do nothing 
	} else {
	die ("Error: File missing");
}

$xml=simplexml_load_file($folder."store/".$files.".data") or die("Error: File missing");
$layout=simplexml_load_file($folder."store/".$files.".lay") or die("Error: File missing");


$xmlfile = '../data/version.xml';
$xmlinfo=simplexml_load_file($xmlfile);
$xmlinfo->asXML($xmlfile);
$languagefile = include('../language/'.$xmlinfo->language.'.php');
define ('_TEXT',$languagefile);



include ('layout.php');
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> <!-- Bootstrap CSS file, change the path accordingly -->
<style>

.panel-heading {line-height:0.7em;}
#number {font-size:34px; font-weight:bold;text-align:center;}
#number_legand {font-size:11px; color:#999;text-align:center;}
.panel-body {  box-shadow: 5px 5px 35px  #e0e0e0;color:#787b80;}
.page-header {margin-top:-30px;}
</style>
</head>
<body> 
<br/>
<div class="container-fluid main-container">
<div class="col-md-12 col-lg-12 col-xs-12">
<?php 
$col12 = 0;
$j=0;
foreach ($result as $value){

	$coloffset=$layout->left[$j];
	 
	$defaultcharttitle = ucwords($xml->col[$j]->type) . " Chart";
	if ($xml->col[$j]->title==''){ $xml->col[$j]->title = $defaultcharttitle ;}

	if (($col12 == 0 )) {
	  echo '<div class="row">';
	}

	echo '<div class="col-md-'.((int) $layout->width[$j]).' col-lg-'.((int)$layout->width[$j]).' col-xs-12 id'.$j.'">';
	echo '<div class="panel panel-default">';
	echo '	<div class="panel-body">';
	echo '	<span>'.$xml->col[$j]->title.'</span>';
	echo $result[$j];?>
	</div>
	</div>
	</div>
	<?php
	$col12 = ($layout->width[$j])+ $col12;
	
	if ($col12 > 11) {
		echo '</div>'; 
		$col12 = 0;
	}
	
	$j++;
} // end_for

if (($col12 > 0) and ($col12 < 12)) { 
    echo '    </div>'; 
}

?>
</div>
</div>
</body>
</html>
	


