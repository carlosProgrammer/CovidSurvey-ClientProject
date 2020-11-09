<!-- Chart Update -->
<?php
include("../inc/dashboard_dist.php");  // copy this file to inc folder 
$data = new dashboardbuilder(); 
$call_result = false;

$i=0;
	if ($_REQUEST['type']) {
		foreach($_REQUEST['type'] as $value){
		   $data->type[$i]=  $value;
		   $i++;
		}
	}

if ($_REQUEST['source']=='ADatabase') {
  $source = 'Database';
  } else  {
  $source = 'upload';
}

$data->source =  $source; 
$data->rdbms =  $_REQUEST['rdbms']; 
$data->servername =  $_REQUEST['servername'];
$data->username =  $_REQUEST['username'];
$data->password =  $_REQUEST['password'];
$data->dbname =  $_REQUEST['dbname'];
$data->sql[0] =  $_REQUEST['sql'];

		
 if ($_REQUEST['type'][0]=='map'){
	$i=0;
	if (isset($_REQUEST['maptype'])) {
		foreach($_REQUEST['maptype'] as $value){
			$data->maptype[$i] = $value;
			$i++;
		}
	}
 } // end if map
 
if ($source =="upload"){
		$i=0;
		foreach($_REQUEST['xvalues'] as $value){
		 if ($value){
			 
			if (substr($value,0,3) =="XLS"){
				 $call_result= true;
			 }
				 
			  preg_match('~{data}([^{]*){/data}~i', $value, $match);
				  if (!empty($match[1])){
					$data->xaxis[$i] = array_map('strval', explode(',', $match[1]));
					// Analytics
					if (empty($_REQUEST['xsort'][$i])) {
						$data->xsort[$i]=  '';
					} else {
						$data->xsort[$i]=  $_REQUEST['xsort'][$i];
					}
					if (empty($_REQUEST['xmodel'][$i])) {
						$data->xmodel[$i]=  '';
					} else {
						$data->xmodel[$i]=  $_REQUEST['xmodel'][$i];
					}
					// Analytics
				  }
		  }
		  $i++;
		}
		$i=0;
		foreach($_REQUEST['yvalues'] as $value){
		 if ($value){
			 
			 if (substr($value,0,3) =="SQL"){
				 $call_result= false;
			 }
			 
			  preg_match('~{data}([^{]*){/data}~i', $value, $match);
				if (!empty($match[1])){
					$data->yaxis[$i] = array_map('strval', explode(',', $match[1]));
					// Analytics
					if (empty($_REQUEST['ysort'][$i])) {
						$data->ysort[$i]=  '';
					} else {
						$data->ysort[$i]=  $_REQUEST['ysort'][$i];
					}
					
					if (empty($_REQUEST['ymodel'][$i])) {
					$data->ymodel[$i]=  '';
					} else {
						$data->ymodel[$i]=  $_REQUEST['ymodel'][$i];
					}
					// Analytics
				}
		  }
		  $i++;
		}
		if (($_REQUEST['type'][0] == 'bubble') || ($_REQUEST['type'][0] == 'sankey') || ($_REQUEST['type'][0] == 'scatter3d') || ($_REQUEST['type'][0] == 'sunburst')){
				$i=0;
				foreach($_REQUEST['sizevalues'] as $value){
				 if ($value){
					   preg_match('~{data}([^{]*){/data}~i', $value, $match);
						  if (!empty($match[1])){
							$data->size[$i] = array_map('strval', explode(',', $match[1]));
						}
				  }
				  $i++;
				}
		} // end if bubble
		if (($_REQUEST['type'][0]=='bubble') || ($_REQUEST['type'][0]=='map') || ($_REQUEST['type'][0]=='heatmap') || ($_REQUEST['type'][0] == 'sankey')){
			$i=0;
			foreach($_REQUEST['textvalues'] as $value){
			 if ($value){
				  preg_match('~{data}([^{]*){/data}~i', $value, $match);
					if (!empty($match[1])){
							$data->text[$i] = array_map('strval', explode(',', $match[1]));
					 }
			  }
			  $i++;
			}
		} // end if bubble
		
	if (($_REQUEST['type'][0]=='table') ){
			$call_result=true; 
	}
	
} else { // if ADabase
	$i=0;
	if (($_REQUEST['type'][0]=='table') ){
			$call_result=true; //if table and SQL then show result
	}
	
	foreach($_REQUEST['xvalues'] as $value){
		if (substr($value,0,3) =="SQL"){
				 $call_result= true;
		}
			 
		preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
		preg_match('~{col}([^{]*){/col}~i', $value, $match);
		$data->xaxisSQL[$i]=  $sqlmatch[1];
		$data->xaxisCol[$i]=  $match[1];
			// Analytics
			if (empty($_REQUEST['xsort'][$i])) {
				$data->xsort[$i]=  '';
			} else {
				$data->xsort[$i]=  $_REQUEST['xsort'][$i];
			}
			
			if (empty($_REQUEST['xmodel'][$i])) {
				$data->xmodel[$i]=  '';
			} else {
				$data->xmodel[$i]=  $_REQUEST['xmodel'][$i];
			}
			// Analytics
					
		$i++;
	}
	$i=0;
	foreach($_REQUEST['yvalues'] as $value){
		if (substr($value,0,3) =="XLS"){
				 $call_result= false;
		}
		
		preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
		preg_match('~{col}([^{]*){/col}~i', $value, $match);
		$data->yaxisSQL[$i]=  $sqlmatch[1];
		$data->yaxisCol[$i]=  $match[1];
				// Analytics
				if (empty($_REQUEST['ysort'][$i])) {
					$data->ysort[$i]=  '';
				} else {
					$data->ysort[$i]=  $_REQUEST['ysort'][$i];
				}
				
				if (empty($_REQUEST['ymodel'][$i])) {
					$data->ymodel[$i]=  '';
				} else {
					$data->ymodel[$i]=  $_REQUEST['ymodel'][$i];
				}
				// Analytics
		$i++;
	}
	if (($_REQUEST['type'][0] == 'bubble') || ($_REQUEST['type'][0] == 'sankey') || ($_REQUEST['type'][0] == 'scatter3d') || ($_REQUEST['type'][0] == 'sunburst')){
		$i=0;
		foreach($_REQUEST['sizevalues'] as $value){
			preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
			preg_match('~{col}([^{]*){/col}~i', $value, $match);
			$data->sizeSQL[$i]=  $sqlmatch[1];
			$data->sizeCol[$i]=  $match[1];
			$i++;
		}
	}
	if (($_REQUEST['type'][0]=='bubble') || ($_REQUEST['type'][0]=='map') || ($_REQUEST['type'][0]=='heatmap') || ($_REQUEST['type'][0]== 'sankey')){
		$i=0;
		foreach($_REQUEST['textvalues'] as $value){
			preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
			preg_match('~{col}([^{]*){/col}~i', $value, $match);
			$data->textSQL[$i]=  $sqlmatch[1];
			$data->textCol[$i]=  $match[1];
			$i++;
		}
	}
}

/*
$i=0;
if (isset($_REQUEST['xsort'])) {
	foreach($_REQUEST['xsort'] as $value){
			$data->xsort[$i]=  $value;
		$i++;
	}
}

$i=0;
if (isset($_REQUEST['ysort'])) {
	foreach($_REQUEST['ysort'] as $value){
			$data->ysort[$i]=  $value;
		$i++;
	}
}
*/

$i=0;
foreach($_REQUEST['tracenamevalues'] as $value){
	//if (!empty($value)){
		$data->tracename[$i]=  $value;
	//}
	$i++;
}

$i=0;
if (isset($_REQUEST['yntitlevalues'])) {
	foreach($_REQUEST['yntitlevalues'] as $value){
		//if (!empty($value)){
			$data->yntitle[$i]=  $value;
		//}
		$i++;
	}
}

$i=0;
foreach($_REQUEST['colorvalues'] as $value){
	//if (!empty($value)){
		$data->color[$i]=  $value;
	//}
	$i++;
}
	
$data->name = "layoutsettings";
$data->orientation = $_REQUEST['orientation'];
$data->dropdown = $_REQUEST['dropdown'];
$data->legposition = $_REQUEST['legposition'];
$data->xaxistitle = $_REQUEST['xaxistitle'];
$data->yaxistitle = $_REQUEST['yaxistitle'];
$data->showgrid = $_REQUEST['showgrid'];
$data->showline = $_REQUEST['showline'];
$data->height = "260";
$data->width = "";
$data->col = "layoutsettings";
$data->folder = "../";



$xmlfile = '../data/version.xml';
$xmlinfo=simplexml_load_file($xmlfile);
$xmlinfo->asXML($xmlfile);
$languagefile = include ('../language/'.$xmlinfo->language.'.php');
define ('_TEXT',$languagefile);

$data->toImage = _TEXT['TOIMAGE'];
$data->zoomin = _TEXT['ZOOMIN'];
$data->zoomout = _TEXT['ZOOMOUT'];
$data->autoscale = _TEXT['AUTOSCALE'];


if ($call_result) {
	echo  $data->result();
}
?>