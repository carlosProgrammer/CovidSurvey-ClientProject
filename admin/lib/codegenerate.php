<link href="../assets/css/jquery-linedtextarea.css" type="text/css" rel="stylesheet" />
<?php

$code = genfile();

?>

<div class="col-lg-12">
<div class="panel panel-default">
	<div class="panel-heading">
	&nbsp;&nbsp;
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:window.location.href = window.location.href;">&times;</button>
	&nbsp;&nbsp;
	<button class="close" onClick="copypast('hiddencode')"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;</button>
	&nbsp;&nbsp;
	</div>
	<div class="panel-body">
	
			<form  id="savefil" class="form-horizontal"  method="post">
									<textarea  id="phpcode" class="lined" rows="20" hresize><?php echo $code;?></textarea>
									
			<div class="modal-footer">
				<button type="button" class="btn btn-default" style="float:none;" data-dismiss="modal" onclick="javascript:window.location.href = window.location.href;"><?php echo _TEXT['CANCEL'];?></button>  
				<button type="button" class="btn btn-primary" onClick="copypast('hiddencode')" style="float:right;"><?php echo _TEXT['COPY'];?>&nbsp;<span class="fa fa-clipboard"></span></button>
			</div>
			</form>
	</div>
</div>
	

<?php 

function genfile(){

$xml=simplexml_load_file("../data/data.xml") or die("Error: Cannot create object");
$layout=simplexml_load_file("../data/layout.xml") or die("Error: Cannot create object");

// Code Generate Start 
$write = '
<?php
/**
 * DashboardBuilder
 *
 * @author Diginix Technologies www.diginixtech.com
 * Support <support@dashboardbuider.net> - https://www.dashboardbuilder.net
 * @copyright (C) 2016-2020 Dashboardbuilder.net
 * @version 4.2
 * @license: This code is under MIT license, you can find the complete information about the license here: https://dashboardbuilder.net/code-license
 */

include("inc/dashboard_dist.php");  // copy this file to inc folder 
';

// Col data

$no_col = count($xml->col);

$reuslt = array();
$name = array();
$height = array();

for ($j=0;$j<$no_col;$j++){


$write.='

// for chart #'.($j+1).'
$data = new dashboardbuilder(); '."\n";

$i=0;
	if (isset($xml->col[$j]->type)) {
		foreach($xml->col[$j]->type as $value){
		   $write.= '$data->type['.$i.']=  "'.$value.'";'."\n";
		   $i++;
		}
	}

// Check if source is Database
if ($xml->col[$j]->source=='ADatabase'){
if (empty($xml->col[$j]->ssl)){
	$servername =  $xml->col[$j]->servername;
	}
	else
	{
	$servername =  'https://'.$xml->col[$j]->servername;
}
$write.='
$data->source =  "Database"; 
$data->rdbms =  "'.$xml->col[$j]->rdbms.'"; 
$data->servername =  "'.$servername.'";
$data->username =  "'.$xml->col[$j]->username.'";
$data->password =  "'.$xml->col[$j]->password.'";
$data->dbname =  "'.$xml->col[$j]->dbname.'";
$data->toImage = "'._TEXT['TOIMAGE'].'";
$data->zoomin = "'._TEXT['ZOOMIN'].'";
$data->zoomout = "'._TEXT['ZOOMOUT'].'";
$data->autoscale = "'._TEXT['AUTOSCALE'].'";
';
	$i=0;
	
	$xml->col[$j]->source = "Database";
	    if (substr($xml->col[$j]->xaxis,0,3) =="SQL"){
			
			$i=0;
			foreach($xml->col[$j]->xaxis as $value){
				preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
				//preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->xaxis[$i], $match);
				preg_match('~{col}([^{]*){/col}~i', $value, $match);
				$write.='$data->xaxisSQL['.$i.']=  "'.$sqlmatch[1].'";'."\n";
				$write.='$data->xaxisCol['.$i.']=  "'.$match[1].'";'."\n";
				
				$write.='$data->xsort['.$i.']=  "'.$xml->col[$j]->xsort[$i].'";'."\n";
				$write.='$data->xmodel['.$i.']=  "'.$xml->col[$j]->xmodel[$i].'";'."\n";
			    if ($xml->col[$j]->type=='heatmap') {break;}  // if heatmap just take the first data
				$i++;
			}

			$i=0;
			if(!($xml->col[$j]->type[0]=='number')){
			foreach($xml->col[$j]->yaxis as $value){
				preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
				//preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->yaxis[$i], $match);
				preg_match('~{col}([^{]*){/col}~i', $value, $match);
				$write.='$data->yaxisSQL['.$i.']=  "'.$sqlmatch[1].'";'."\n";
				$write.='$data->yaxisCol['.$i.']=  "'.$match[1].'";'."\n";
				
				$write.='$data->ysort['.$i.']=  "'.$xml->col[$j]->ysort[$i].'";'."\n";
				$write.='$data->ymodel['.$i.']=  "'.$xml->col[$j]->ymodel[$i].'";'."\n";
				
				if ($xml->col[$j]->type=='heatmap') {break;}  // if heatmap just take the first data
				$i++;
				}
			}
	
			$i=0;
			if (($xml->col[$j]->type[0]=='bubble') || ($xml->col[$j]->type[0]=='sankey') || ($xml->col[$j]->type[0]=='scatter3d') || ($xml->col[$j]->type[0]=='sunburst')){
				foreach($xml->col[$j]->size as $value){
				    preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
					//preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->size[$i], $match);
					preg_match('~{col}([^{]*){/col}~i', $value, $match);
					$write.='$data->sizeSQL['.$i.']=  "'.$sqlmatch[1].'";'."\n";
					$write.='$data->sizeCol['.$i.']=  "'.$match[1].'";'."\n";
					$i++;
				}
			} // end if bubble
				
			if (($xml->col[$j]->type[0]=='bubble') || ($xml->col[$j]->type[0]=='map') || ($xml->col[$j]->type[0]=='heatmap') || ($xml->col[$j]->type[0]=='sankey')){
				$i=0;
				foreach($xml->col[$j]->text as $value){
				    preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
					//preg_match('~{col}([^{]*){/col}~i', $xml->col[$j]->text[$i], $match);
					preg_match('~{col}([^{]*){/col}~i', $value, $match);
					$write.='$data->textSQL['.$i.']=  "'.$sqlmatch[1].'";'."\n";
					$write.='$data->textCol['.$i.']=  "'.$match[1].'";'."\n";
					$i++;
				}
			}	// end if bubble and map
		} //end if SQL
		  // $write.='$data->sql['.$i.']=  "'.$value.'";'."\n";
		  
		  
		  if ($xml->col[$j]->type[0]=='table') {
		    if (!empty($xml->col[$j]->sql[0])){
			$write.='$data->sql[0] = "'.$xml->col[$j]->sql[0].'";'."\n";
			}
		}
		  
	} //if Database End
	elseif (($xml->col[$j]->source =="upload")){
		$i=0;
		foreach($xml->col[$j]->xaxis as $value){
		 if ($value){
			  preg_match('~{data}([^{]*){/data}~i', $value, $match);
			  if (!empty($match[1])){
			  	$a = array_map('strval', explode(',', $match[1]));
				$write.='$data->xaxis['.$i.']= '.json_encode($a).';'."\n";
				
				$write.='$data->xsort['.$i.']=  "'.$xml->col[$j]->xsort[$i].'";'."\n";
				$write.='$data->xmodel['.$i.']=  "'.$xml->col[$j]->xmodel[$i].'";'."\n";
			  }
		  }
		  $i++;
		}

		$i=0;
		foreach($xml->col[$j]->yaxis as $value){
		 if ($value){
			  preg_match('~{data}([^{]*){/data}~i', $value, $match);
			  if (!empty($match[1])){
			    $a = array_map('strval', explode(',', $match[1]));
				$write.='$data->yaxis['.$i.']= '.json_encode($a).';'."\n";
				
				$write.='$data->ysort['.$i.']=  "'.$xml->col[$j]->ysort[$i].'";'."\n";
				$write.='$data->ymodel['.$i.']=  "'.$xml->col[$j]->ymodel[$i].'";'."\n";
			}
		  }
		  $i++;
		}	
		if (($xml->col[$j]->type[0]== 'bubble') || ($xml->col[$j]->type[0] == 'sankey')  || ($xml->col[$j]->type[0]=='scatter3d') || ($xml->col[$j]->type[0]=='sunburst')){
		
				$i=0;
				foreach($xml->col[$j]->size as $value){
				 if ($value){
					  preg_match('~{data}([^{]*){/data}~i', $value, $match);
					  if (!empty($match[1])){
						$a = array_map('strval', explode(',', $match[1]));
						$write.='$data->size['.$i.']= '.json_encode($a).';'."\n";
					}
				  }
				  $i++;
				}	
		 } // end if bubble
				
		 if (($xml->col[$j]->type[0]=='bubble') || ($xml->col[$j]->type[0]=='map') || ($xml->col[$j]->type[0]=='heatmap') || ($xml->col[$j]->type[0] == 'sankey')){
				$i=0;
				foreach($xml->col[$j]->text as $value){
				 if ($value){
					  preg_match('~{data}([^{]*){/data}~i', $value, $match);
					  if (!empty($match[1])){
						$a = array_map('strval', explode(',', $match[1]));
						$write.='$data->text['.$i.']= '.json_encode($a).';'."\n";
					}
				  }
				  $i++;
				}	
		}// end if bubble and map
		
		
		if (($xml->col[$j]->type[0]=='table') ){
			$write.='$data->sql[0] = "'.$xml->col[$j]->file.'";'."\n";
			$write.='$data->source = "upload";';
		}
		
	}
	
	else
	{
	$i=0;
	foreach($xml->col[$j]->xaxis as $value){
		if (!empty($value)){
		   $write.='$data->xaxis['.$i.']= array_map("strval", explode(",", "'.$value.'"));'."\n";
		   if ($xml->col[$j]->type[0]=='heatmap') {break;}  // if heatmap just take the first data
		   $i++;
		  }
	}
	$i=0;
	foreach($xml->col[$j]->yaxis as $value){
		if (!empty($value)){
		  $write.='$data->yaxis['.$i.']= array_map("strval", explode(",", "'.$value.'"));'."\n";
		   if ($xml->col[$j]->type[0]=='heatmap') {break;}  // if heatmap just take the first data
		   $i++;
		  }
	}
} // Else Database End
if (!empty($xml->col[$j]->height)) {
	$h= $xml->col[$j]->height;
} else {
	$h= $layout->height[$j]-70;
}

if ($xml->col[$j]->type=='gauge') {
	$w = "" ;
} else {
	$w = $xml->col[$j]->width ;
}

$write.='
$data->name = "'.$xml->col[$j]->name.'";
$data->title = "'.$xml->col[$j]->title.'";
$data->orientation = "'.$xml->col[$j]->orientation.'";
$data->dropdown = "'.$xml->col[$j]->dropdown.'";
$data->legposition = "'.$xml->col[$j]->legposition.'";
$data->xaxistitle = "'.$xml->col[$j]->xaxistitle.'";
$data->yaxistitle = "'.$xml->col[$j]->yaxistitle.'";
$data->showgrid = "'.$xml->col[$j]->showgrid.'";
$data->showline = "'.$xml->col[$j]->showline.'";
$data->height = "'.$h.'";
$data->width = "'.$w.'";
$data->col = "'.$j.'";



';

$i=0;
	foreach($xml->col[$j]->tracename as $value){
	   if (!empty($value)){
		   $write.='$data->tracename['.$i.']=  "'.$value.'";'."\n"; 
	   }
	   $i++;
	}
	

$i=0;
if ($xml->col[$j]->yntitle) {
		foreach($xml->col[$j]->yntitle as $value){
		   if (!empty($value)) {
				$write.='$data->yntitle['.$i.']=  "'.$value.'";'."\n"; 
		   }
		   $i++;
		}
}
	
$i=0;
	foreach($xml->col[$j]->color as $value){
		if (!empty($value)){
		   $write.='$data->color['.$i.']=  "'.$value.'";'."\n";
	   }
	    $i++;
	}
	
$i=0;
	if ($xml->col[$j]->type=='map'){
		foreach($xml->col[$j]->maptype as $value){
			$write.='$data->maptype['.$i.']=  "'.$value.'";'."\n";
			$i++;
		}
	} // end if map
	
$i=0;

$write.='
$result['.$j.'] = $data->result();';

$name[$j]=$xml->col[$j]->name;
//$height[$j]=$xml->col[$j]->height;
} // End For Loop

$write.='?>

<!DOCTYPE html>
<html>
<head>
	<script src="assets/js/dashboard.min.js"></script> <!-- copy this file to assets/js folder -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"> <!-- Bootstrap CSS file, change the path accordingly -->
	';


$write.='
<style>

.panel-heading {line-height:0.7em;}
#number {font-size:34px; font-weight:bold;text-align:center;}
#number_legand {font-size:11px; color:#999;text-align:center;}
.panel-body {  box-shadow: 5px 5px 35px  #e0e0e0;color:#787b80;}
.page-header {margin-top:-30px;}
</style>
</head>
<body> 
<div class="container-fluid main-container">
<div class="col-md-12 col-lg-12 col-xs-12">';

$col12 = 0;
for ($j=0;$j<$no_col;$j++){

	//$coloffset=$layout->left[$j] / $_POST['col'];
	$coloffset=$layout->left[$j];
	 
	$defaultcharttitle = ucwords($xml->col[$j]->type) . " Chart";
	if ($xml->col[$j]->title==''){ $xml->col[$j]->title = $defaultcharttitle ;}

	if (($col12 == 0 )) {
	$write.='
	<div class="row">';
	}


	$write.='
	<div class="col-md-'.((int) $layout->width[$j]).' col-lg-'.((int)$layout->width[$j]).' col-xs-12 id'.$j.'">
	<div class="panel panel-default">
		<div class="panel-body">
		<span>'.$xml->col[$j]->title.'</span>
			<?php echo $result['.$j.'];?>
		</div>
	</div>
	</div>';
	
	$col12 = ($layout->width[$j])+ $col12;
	
	if ($col12 > 11) { $write.='
	</div>'; 
	$col12 = 0;}

} // end_for

if (($col12 > 0) and ($col12 < 12)) { $write.='
        </div>'; }

$write.='
</div>
</div>
</body>
';

return $write;
}// End Function


?>
<script src="../assets/js/jquery-linedtextarea.js"></script>
<script>
$(function() {
	$(".lined").linedtextarea(
		{selectedLine: 1}
	);
});

function copypast(id){
	document.getElementById('phpcode').select();
    document.execCommand('copy');
};

</script>

