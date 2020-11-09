<?php 
$folder ="..".DIRECTORY_SEPARATOR;
echo '<script src="'.$folder.'assets/js/dashboard.min.js"></script>';
require_once($folder."inc/dashboard_dist.php"); 

// Col data

$no_col = count($xml->col);

$col = array();
$reuslt = array();
$name = array();
$height = array();

$xmlfile = '../data/version.xml';
$xmlinfo=simplexml_load_file($xmlfile);
$xmlinfo->asXML($xmlfile);

// Read Language File
//$languagefile = '../language/'.$xmlinfo->language.'.ini';
//define ('_TEXT',parse_ini_file($languagefile));		



for ($j=0;$j<$no_col;$j++){
	$call_result = false;
	$data = new dashboardbuilder();
	$data->col = $j; 
	$i=0;
	if (isset($xml->col[$j]->type)) {
		foreach($xml->col[$j]->type as $value){
		   $data->type[$i]=  $value;
		   $i++;
		}
	}
	
	$data->source =  $xml->col[$j]->source; 
	if (empty($xml->col[$j]->ssl)){
				$data->servername =  $xml->col[$j]->servername;
				}
				else
				{
				$data->servername =  'https://'.$xml->col[$j]->servername;
			}

	$data->username =  $xml->col[$j]->username;
	$data->password =  $xml->col[$j]->password;
	$data->dbname =  $xml->col[$j]->dbname;
	$data->rdbms =  $xml->col[$j]->rdbms;
	
	$data->name = $xml->col[$j]->name;
	$data->title = $xml->col[$j]->title;
	$data->orientation = $xml->col[$j]->orientation;
	$data->dropdown = $xml->col[$j]->dropdown;
	$data->legposition = $xml->col[$j]->legposition;
	$data->xaxistitle = $xml->col[$j]->xaxistitle;
	$data->yaxistitle = $xml->col[$j]->yaxistitle;
	//$data->height = $xml->col[$j]->height;
	$data->height = $layout->height[$j]-70;
	$data->width = $xml->col[$j]->width;
	$data->showgrid = $xml->col[$j]->showgrid;
	$data->showline = $xml->col[$j]->showline;
	$data->folder = "../";
	
	$data->toImage = _TEXT['TOIMAGE'];
	$data->zoomin = _TEXT['ZOOMIN'];
	$data->zoomout = _TEXT['ZOOMOUT'];
	$data->autoscale = _TEXT['AUTOSCALE'];

	
	$i=0;
	if ($xml->col[$j]->source =="ADatabase"){
		foreach($xml->col[$j]->sql as $value){
		   $data->sql[$i]=  $value;
		   $i++;
		}
	}
	
	$i=0;
	if ($xml->col[$j]->tracename) {
		foreach($xml->col[$j]->tracename as $value){
		   $data->tracename[$i]=  $value;
		   $i++;
		}
	}
	
	$i=0;
	if ($xml->col[$j]->yntitle) {
		foreach($xml->col[$j]->yntitle as $value){
		   $data->yntitle[$i]=  $value;
		   $i++;
		}
	}
	
	$i=0;
	if ($xml->col[$j]->color) {
		foreach($xml->col[$j]->color as $value){
		   $data->color[$i]=  $value;
		   $i++;
		}
	}
	
	$i=0;
	if ($xml->col[$j]->xsort) {
		foreach($xml->col[$j]->xsort as $value){
		   $data->xsort[$i]=  $value;
		   $i++;
		}
	}
	
	$i=0;
	if ($xml->col[$j]->ysort) {
		foreach($xml->col[$j]->ysort as $value){
		   $data->ysort[$i]=  $value;
		   $i++;
		}
	}
	
	$i=0;
	if ($xml->col[$j]->xmodel) {
		foreach($xml->col[$j]->xmodel as $value){
		   $data->xmodel[$i]=  $value;
		   $i++;
		}
	}
	
	$i=0;
	if ($xml->col[$j]->ymodel) {
		foreach($xml->col[$j]->ymodel as $value){
		   $data->ymodel[$i]=  $value;
		   $i++;
		}
	}
	
	
	$i=0;
	if (!empty($xml->col[$j]->type)) {
		foreach($xml->col[$j]->type as $value){
		   $data->type[$i]=  $value;
		   if ($data->type[$i]=='map'){
					$data->maptype[$i] = $xml->col[$j]->maptype;
			} // end if map
			
			
			if (($data->type[$i]=='bubble') || ($data->type[$i]=='sankey' ) || ($data->type[$i]=='scatter3d' ) || ($data->type[$i]=='sunburst' ) ){
			if (substr($xml->col[$j]->size,0,3) =="SQL"){
				foreach($xml->col[$j]->size as $value){
				    preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
					preg_match('~{col}([^{]*){/col}~i', $value, $match);
					$data->sizeSQL[$i] = $sqlmatch[1];
					$data->sizeCol[$i] = $match[1];
				}
			} // end if SQL
			}// end if bubble


			if (($data->type[$i]=='bubble') || ($data->type[$i]=='map') || ($data->type[$i]=='heatmap') || ($data->type[$i]=='sankey') ){
			if (substr($xml->col[$j]->text,0,3) =="SQL"){
				foreach($xml->col[$j]->text as $value){
				    preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
					preg_match('~{col}([^{]*){/col}~i', $value, $match);
					$data->textSQL[$i] = $sqlmatch[1];
					$data->textCol[$i] = $match[1];
				}
			} // end if SQL
			}// end if bubble and map
			
			
		   $i++;
		} //end foreach
	} //end if type

	if (($xml->col[$j]->source =="ADatabase")){
		$xml->col[$j]->source = "Database";
	    if (substr($xml->col[$j]->xaxis,0,3) =="SQL"){
			$call_result=true; //if database and SQL then show result
			
			$i=0;
			foreach($xml->col[$j]->xaxis as $value){
				preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
				preg_match('~{col}([^{]*){/col}~i', $value, $match);
				$data->xaxisSQL[$i] = $sqlmatch[1];
				$data->xaxisCol[$i] = $match[1];
			
				$i++;
			}
			
			//
			$i=0;
			if(!($xml->col[$j]->type=='number')){
			     if (substr($xml->col[$j]->yaxis,0,3) =="SQL"){
						foreach($xml->col[$j]->yaxis as $value){
							preg_match('~{data}([^{]*){/data}~i', $value, $sqlmatch);
							preg_match('~{col}([^{]*){/col}~i', $value, $match);
							$data->yaxisSQL[$i] = $sqlmatch[1];
							$data->yaxisCol[$i] = $match[1];
					
							$i++;
						}
				} else {
				$call_result=false; //if database and SQL then show result
				}
			} //not KPI
			//

		} 
		if ($xml->col[$j]->type=='table') {
		    if (!empty($xml->col[$j]->sql[0])){
			$data->source = $xml->col[$j]->source;
			$data->sql[$j] = $xml->col[$j]->sql[0];
			$call_result=true; //if table and SQL then show result
			} else {
			$call_result=false; //if table and No SQL then dont show result
			}
		}
		
	}
	
		
	if (($xml->col[$j]->source =="upload")){
		 if ((substr($xml->col[$j]->xaxis,0,3) =="XLS") && (substr($xml->col[$j]->yaxis,0,3) !="SQL")){
			$call_result=true; //if files and XLS then show result
			$i=0;
			foreach($xml->col[$j]->xaxis as $value){
			 if ($value){
				  preg_match('~{data}([^{]*){/data}~i', $value, $match);
				  if (!empty($match[1])){
					$data->xaxis[$i] = array_map('strval', explode(',', $match[1]));
					
					// Analytics
					if (empty($xml->col[$j]->xsort[$i])) {
						$data->xsort[$i]=  '';
					} else {
						$data->xsort[$i]=  $xml->col[$j]->xsort[$i];
					}
					if (empty($xml->col[$j]->xmodel[$i])) {
						$data->xmodel[$i]=  '';
					} else {
						$data->xmodel[$i]=  $xml->col[$j]->xmodel[$i];
					}
					// Analytics

				  }
			  }
			  $i++;
			}
	
			$i=0;
			foreach($xml->col[$j]->yaxis as $value){
			 if (!empty($value)){
				  preg_match('~{data}([^{]*){/data}~i', $value, $match);
				  if (!empty($match[1])){
					$data->yaxis[$i] = array_map('strval', explode(',', $match[1]));
					
					// Analytics
					if (empty($xml->col[$j]->ysort[$i])) {
						$data->ysort[$i]=  '';
					} else {
						$data->ysort[$i]=  $xml->col[$j]->ysort[$i];
					}
					if (empty($xml->col[$j]->ymodel[$i])) {
						$data->ymodel[$i]=  '';
					} else {
						$data->ymodel[$i]=  $xml->col[$j]->ymodel[$i];
					}
					// Analytics
				}
			  }
			  $i++;
			}
			
			// Checking Types 
			$i=0;
			foreach ($xml->col[$j]->type as $types) {
				if (($types=='bubble') || ($types=='sankey' )  || ($types=='scatter3d' ) || ($types=='sunburst' )){
					foreach($xml->col[$j]->size as $value){
						 if (!empty($value)){
							  preg_match('~{data}([^{]*){/data}~i', $value, $match);
							  if (!empty($match[1])){
								$data->size[$i] = array_map('strval', explode(',', $match[1]));
							}
						  }
						  $i++;
					}
				} // end if bubble
				$k=0;
				if (($types=='bubble') || ($types=='map') || ($types=='heatmap') || ($types=='sankey')){
					foreach($xml->col[$j]->text as $value){
						 if (!empty($value)){
							  preg_match('~{data}([^{]*){/data}~i', $value, $match);
							  if (!empty($match[1])){
								$data->text[$k] = array_map('strval', explode(',', $match[1]));
								}
						  }
						  $k++;
					}
				} // end if bubble and map
				
			$i++;
			}
			
			// Checking Types end
			
		}
		if (($xml->col[$j]->type=='table') ){
			$data->source = $xml->col[$j]->source;
			$data->sql[0] = $xml->col[$j]->file;
			$data->sql[0] = str_replace("\\", '~', $data->sql[0]);
			$call_result=true; //if table and SQL then show result
		}
	}

	if ($call_result) {
			$result[$j] = $data->result(); 
			$name[$j] = $data->name;
			$height[$j] = $data->height;
		} else {
		$result[$j] = "";
		$name[$j] = "";
		$height[$j] = "";
	}
  
}// for end

function str_replace_first($from, $to, $subject)
{

    $from = '/'.preg_quote($from, '/').'/';

	return preg_replace($from, $to, $subject, 1);
}
?>

<?php //include ('col.php');?>
