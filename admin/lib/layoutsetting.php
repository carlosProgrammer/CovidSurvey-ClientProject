<link rel="stylesheet" href="../assets/css/bootstrap-select.min.css">
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/bootstrap-select.min.js"></script>

<script>
document.getElementsByClassName('demo').style.display = "none";
</script>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Layout setting</title>  

 <!-- Modal -->
 <?php if (isset($_REQUEST['col'])) {
  $col = (int) $_REQUEST['col'];
  $request_col =  $_REQUEST['col'];
  } else {
  $col = 0;
  $request_col=0;
  }
 $rs="";
 $url =  $_SERVER['REQUEST_URI'];
 $sql = "";
  
if (isset($_POST['save'])=='true') {

		savedata($col);
		$_POST['save']='';
		//header('Location: ' . $_SERVER["HTTP_REFERER"] );
		?>
		<script>
		window.location.replace('<?php echo $url;?>');
		</script> 
		<?php
}

if (!empty($_POST['cleardata']) && ($_POST['cleardata']=="true")) {
		cleardata($col);
		$_POST['cleardata']=''; 
		?>
		<script>
		window.location.replace('<?php echo $url;?>');
		</script> 
		<?php
}
 
 $type = array();
 //$type[0]="";

 $cols = array();
 $xaxis = array();
 $yaxis = array();
 $size = array();
 $text = array();
 $maptype = array();
 $yntitle = array();
 $tracename = array();
 $color = array();
 $hsl = array();
 $xmodel= array();
 $xsort= array();
 $ymodel= array();
 $ysort=array();
 $title = "";
 $name = "";
 $xaxistitle="";
 $yaxistitle="";
 $height="";
 $width="";
 $showgrid="";
 $showline="";
 $dropdown="";
 $orientation="";
 $legposition="";
 $columnCount=0;
 $Xdatatype=array();
 $Ydatatype=array();
 
 
 $xmlDoc=simplexml_load_file($folder.'data/data.xml');
 dbc();

$query = array();
$lastSQL = array();
$noofquery = 1;

// Assign initial values //
if (isset($_POST['runquery'])=='true') {
	

	// Check $_POST data 
		if (isset($_POST['tabs'])){
			$tbdsp = $_POST['tabs'];
			$tb = $_POST['tabs'] -1; // taking tab count
		}
		
		if (!empty($_POST['query'])){
				$x=0;
					 foreach($_POST['query'] as $value){
					  $value = preg_replace('/\s+/S', " ", $value); 
					  $value = str_replace('"', "'", $value);
					  $query[$x] = trim($value);
					  $x++;
					 }
				$noofquery = $x;
		}
		if (!empty($_POST['X'])){
			 $x=0;
			 foreach($_POST['X'] as $value){
				 if (!empty($value)){
					$xaxis[$x] = $value;
					
					
						// Analytics 
						 if (isset($_POST['xanalytics'][$x])){
								$j=0;
								 foreach($_POST['xanalytics'][$x] as $value) {
									if (($value=="ASC") || ($value=="DSC")) {
										$xsort[$x] = $value; 
									} else {
										$xmodel[$x] = $value;
									}
									$j++;
								 }
						 } else {
							 $xsort[$x] = '';
							 $xmodel[$x] = '';
						 }
						 // Analytics
					
					
					
					
					$x++;
				 }
			 }
		}
		
		
		if (!empty($_POST['Y'])){
				$x=0;
				 foreach($_POST['Y'] as $value){
					 if (!empty($value)){
						$yaxis[$x] = $value;
						
						// Analytics 
						 if (isset($_POST['yanalytics'][$x])){
								$j=0;
								 foreach($_POST['yanalytics'][$x] as $value) {
									if (($value=="ASC") || ($value=="DSC")) {
										$ysort[$x] = $value; 
									} else {
										$ymodel[$x] = $value;
									}
									$j++;
								 }
						 } else {
							 $ysort[$x] = '';
							 $ymodel[$x] = '';
						 }
						 // Analytics
		 
						$x++;
					 }
				 }
		}
	
		if (!empty($_POST['size'])){
				$x=0;
				 foreach($_POST['size'] as $value){
					 if (!empty($value)){
						$size[$x] = $value;
						$x++;
					 }
				 }
		}
		
		if (!empty($_POST['text'])){
				$x=0;
				 foreach($_POST['text'] as $value){
					 if (!empty($value)){
						$text[$x] = $value;
						$x++;
					 }
				 }
		}
		
		if (!empty($_POST['query'])){
			$sql = trim($query[$tb]);
			if (!empty($sql)) {		
				
			try{
				if ($xmlDoc->col[$col]->rdbms == 'oci') {
					$stid = oci_parse($conn, $sql);
					$rs = oci_execute($stid);	
					$columnCount = oci_num_fields($stid);
					for ($i = 0; $i < $columnCount; $i++) { 				
						$cols[$i] = oci_field_name($stid, $i+1);
					}
				} else {
					$rs = $conn->query($sql);
					$columnCount = $rs->columnCount();
					for ($i = 0; $i < $rs->columnCount(); $i++) { 
						$colm = $rs->getColumnMeta($i);
						$cols[$i] = $colm['name'];
					}
			    }
					

						} catch(Exception $e){
							echo '<div class="alert alert-danger alert-dismissable">
										<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
										<strong>Error! Invalid Query </strong> '.$sql .
									  '</div>';
							}
		} }						
		
		
		if (isset($_POST['tracename'])){
				$x=0;
				 foreach($_POST['tracename'] as $value){
						$tracename[$x] = $value;
						$x++;
				 }
		}
		
		if (isset($_POST['yntitle'])){
				$x=0;
				 foreach($_POST['yntitle'] as $value){
						$yntitle[$x] = $value;
						$x++;
				 }
		}
		
		if (isset($_POST['color'])){
				$x=0;
				 foreach($_POST['color'] as $value){
						$color[$x] = $value;
						$x++;
				 }
		}
		
		if (isset($_POST['type'])){
				$x=0;
				 foreach($_POST['type'] as $value){
					 if (!empty($value)){
						$type[$x] = $value;
						$x++;
					 }
				 }
		}
		
		
		if (!empty($_POST['title'])){
			$title = $_POST['title'];
		}
		if (!empty($_POST['name'])){
			$name = $_POST['name'];
		}
		if (!empty($_POST['xaxistitle'])){
			$xaxistitle = $_POST['xaxistitle'];
		}
		if (!empty($_POST['yaxistitle'])){
			$yaxistitle = $_POST['yaxistitle'];
		}
		if (!empty($_POST['height'])){
			$height = $_POST['height'];
		}
		if (!empty($_POST['width'])){
			$width = $_POST['width'];
		}
		if (!empty($_POST['showgrid'])){
			$showgrid = $_POST['showgrid'];
		}
		if (!empty($_POST['showline'])){
			$showline = $_POST['showline'];
		}
		if (!empty($_POST['orientation'])){
			$orientation = $_POST['orientation'];
		}
		
		if (!empty($_POST['dropdown'])){
			$dropdown = $_POST['dropdown'];
		}
		
		if (!empty($_POST['legposition'])){
			$legposition = $_POST['legposition'];
		}

		?><script>updateChart();</script><?php
		} // Check $_POST data end
		

		else { // Checking xml data
		
		$title = $xmlDoc->col[$col]->title;
		$name =  $xmlDoc->col[$col]->name;
		
		foreach($xmlDoc->col[$col]->xaxis as $value){
			$xaxis[] = $value;
		}
		foreach($xmlDoc->col[$col]->yaxis as $value){
			$yaxis[] = $value;
		}
		foreach($xmlDoc->col[$col]->xmodel as $value){
			$xmodel[] = $value;
		}
					
		
		foreach($xmlDoc->col[$col]->xsort as $value){
			$xsort[] = $value;
		}

		
		foreach($xmlDoc->col[$col]->ymodel as $value){
			$ymodel[] = $value;
		}
		
		foreach($xmlDoc->col[$col]->ysort as $value){
			$ysort[] = $value;
		}
		
		foreach($xmlDoc->col[$col]->size as $value){
			$size[] = $value;
		}
		foreach($xmlDoc->col[$col]->text as $value){
			$text[] = $value;
		}
		foreach($xmlDoc->col[$col]->tracename as $value){
			$tracename[] = $value;
		}
		
		foreach($xmlDoc->col[$col]->yntitle as $value){
				$yntitle[] = $value;
		}
	
		foreach($xmlDoc->col[$col]->color as $value){
			$color[] = $value;
		}

		foreach($xmlDoc->col[$col]->type as $value){
			$type[] = $value;
		}

		if (!empty($xmlDoc->col[$col]->sql)){
				$x=0;
					 foreach($xmlDoc->col[$col]->sql as $value){
					  $query[$x] = $value;
					  $x++;
					 }
				$noofquery = $x;
				$tb = $x;
		}


		$xaxistitle = $xmlDoc->col[$col]->xaxistitle;
		$yaxistitle = $xmlDoc->col[$col]->yaxistitle;
		$height = $xmlDoc->col[$col]->height;
		$width = $xmlDoc->col[$col]->width;
		$showgrid = $xmlDoc->col[$col]->showgrid;
		$showline = $xmlDoc->col[$col]->showline;
		$orientation = $xmlDoc->col[$col]->orientation;	
		$dropdown = $xmlDoc->col[$col]->dropdown;	
		$legposition = $xmlDoc->col[$col]->legposition;	
		$maptype = $xmlDoc->col[$col]->maptype;
		
} // Assigining initila values


if (isset($type[0])) 
 {  }
else { $type[0]="";}
												
if ($xmlDoc->col[$col]->source=="upload"){
	$Reader ="";
	if (file_exists($xmlDoc->col[$col]->file)) {
			$filename = $xmlDoc->col[$col]->file;
			if (!(function_exists('GetInt4d'))){
				require('../assets/class/excel_reader2.php');
				require('../assets/class/SpreadsheetReader.php');
				}
				$Reader = new SpreadsheetReader($filename);
			

	}
	
	// Google Drive
	if (substr($xmlDoc->col[$col]->file,0,6)=="https:" ) {
				    $spreadsheet_url = $xmlDoc->col[$col]->file;
					
					if (!ini_set('default_socket_timeout', 15)) 
					{
						echo "<!-- unable to change socket timeout -->";
					}

					if (($handle = fopen($spreadsheet_url, "r")) !== FALSE) {
						while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
							 $spreadsheet_data[] = $data;
						}
						fclose($handle);
					}
					else
						die("Problem reading csv");

					$Reader = $spreadsheet_data;
			
	}
	// Google Drive
	
			
		if (!empty($Reader)) {	
			$i=0;
			$XLSCol = array();
			foreach ($Reader as $XLS)
				{
				 
					$j=0;
					foreach ($XLS as $HDS)
						{
						   $HDS = str_replace(array(","), '~', $HDS);  // newly added
						   if (!isset($HDS)) {
						   echo  $HDS;
						   }					
							// Remove special chart from XLS file 
							$string = str_replace(array('[\', \']'), '', $HDS );
							$string = preg_replace('/\[.*\]/U', '', $string);
							$string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
							$string = htmlentities($string, ENT_COMPAT, 'utf-8');
							$string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
							$XLSCol[$j][$i]= preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);	
							$j++;
						}
					$i++;
				}
		}
}

if (!empty($sql)){
	$sql = str_replace("'", "^", $sql); 
}

?>

		    <div class="modal-header" style="height:40px;padding-top:7px;padding-bottom:0;" id="main">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="javascript:window.location.replace('<?php echo $url;?>')">&times;</button>
				<a data-toggle="modal" id="#dbModal-0" style="float:right;margin:5px 5px 5px 5px;" onclick="$('#settingModal-0').modal('hide');" href="dbsetting.php?layout=1&col=<?php echo  $request_col;?>" data-target="#dbModal-0"><button class="btn-xs btn-danger" ><?php echo _TEXT['CHANGE_DATABASE'];?></button></a>
                 <h4 class="modal-title"><?php echo _TEXT['CHART_SETTING'];?></h4>
            </div>			<!-- /modal-header -->
			 <div class="modal-body">
			 <div class="se-pre-modal"></div>
			 <form id="layoutsetting" class="form-horizontal" method="post" action="<?php echo $url;?>" onsubmit="return validateForm();">
			  <input type="hidden" name="node" value="<?php if (isset($_POST['node'])) { echo $_POST['node'];}?>"/>

				<!-- Navigation -->
				<div class="row" >
				<div class="col-md-3" style="background-color:#F7F7F7; padding-top:10px;">
				
	<div class="side-menu2">
    <nav class="navbar navbar-default2" role="navigation">
			<!-- Main Menu -->
			<!-- filed_wrapper -->
		<div class="field_wrapper">
			<div class="side-menu-container" >
			
			<!-- Trace Start 1 -->
			<ul class="nav nav-tabs">
				<li class="active" ><a href="#1a" data-toggle="tab">Trace 1</a></li>
				<li><a href="#1b" data-toggle="tab"><?php echo _TEXT['DATA_ANALYSIS'];?></a></li>
				<a href="javascript:void(0);" id="add_trace" class="add_button col-sm-offset-12" title="Add Trace"  style="color:#000000; float:right;margin-top:-25px;"> <span class="fa fa-plus-square-o" ></span></a>
			</ul>
	 
				<div class="tab-content">
				<div class="tab-pane fade in active tb-analysis" id="1a">
				<!-- Dropdown level 1 -->

<div class="panel-body" style="padding: 0; padding-top:15px;">
									<!-- Type -->
									<div class="form-group">
									  <label for="sel2" class="col-sm-3 col-md-3 col-lg-3 control-label"><?php echo _TEXT['TYPE'];?></label>
									  <div class="col-sm-8">
									  <select class="form-control" id="type" name="type[]" style="height:25px; width:100%; padding:0;" value="<?php if(!empty($type[0])) {echo $type[0];}?>" onchange="mySelection()">
										<option value="area" <?php if (($type[0]=='area') || ($type[0]=='')){?> selected <?php }?>>Area</option>
										<option value="bar" <?php if ($type[0]=='bar'){?> selected <?php }?>>Bar</option>
										<option value="line" <?php if ($type[0]=='line'){?> selected <?php }?>>Line</option>
										<option value="stack" <?php if ($type[0]=='stack'){?> selected <?php }?>>Stack</option>
									  </select>
									  </div>
									</div>
								<!-- Type End -->
										
											<div id="XGroup" class="form-group" >
											  <label for="sel2" class="col-sm-3  col-md-3 col-lg-3 control-label" id="x">X: </label>
											  <div class="col-sm-8">
											  <select class="form-control" id="X" name="X[]" style="height:25px; width:100%; padding:0;" onChange="updateChart();">
												 <?php  
													if ($xmlDoc->col[$col]->source=="ADatabase"){
														if (!empty($xaxis[0])){
																preg_match('~{col}([^{]*){/col}~i', $xaxis[0], $match);
																echo '<option value ="'.$xaxis[0].'">'.$match[1].'</option>';
														}
														if (isset($_POST['query'])){				
														for ($x = 0; $x < $i ; $x++) { ?>
															<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
															echo '{data}';
															echo $sql;
															echo '{/data}';
															?>">
															<?php 
															echo $cols[$x]; ?>
															</option>
														<?php
														}
														} 
													}?>
													
													<?php  
													if ($xmlDoc->col[$col]->source=="upload"){
													if (!empty($Reader)) {
															if (!empty($xaxis[0])){
																	preg_match('~{col}([^{]*){/col}~i', $xaxis[0], $match);
																	echo '<option value ="'.$xaxis[0].'" selected="selected">'.$match[1].'</option>';
															}
															$i=0;
															for ($i=0; $i<count($XLSCol); $i++)
															{
															?>
															 <option value="XLS:<?php 
																			echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																			echo implode (',',array_slice($XLSCol[$i], 1));
																			echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
															<?php 
															} 
													   }
													}?>
											  </select>										  
											 
											  </div>
											</div>
											
											<div  id="YGroup" class="form-group" >
											  <label for="sel2" class="col-sm-3  control-label" id="y" >Y: </label>
											  <div class="col-sm-8" >
											  <select class="form-control" id="Y" name="Y[]" style="height:25px; width:100%; padding:0;" onChange="updateChart();">
												 <?php  
												 if ($xmlDoc->col[$col]->source=="ADatabase"){
														if (!empty($yaxis[0])){
																preg_match('~{col}([^{]*){/col}~i', $yaxis[0], $match);
																echo '<option value ="'.$yaxis[0].'">'.$match[1].'</option>';
														}
														if (isset($_POST['query'])){										
														for ($x = 0; $x < $i ; $x++) { ?>
															<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
															echo '{data}';
															echo $sql;
															echo '{/data}';?>"><?php echo $cols[$x]; ?></option>
														<?php
														}
														} 
													}?>
													
													<?php  
													if ($xmlDoc->col[$col]->source=="upload"){
													if (!empty($Reader)) {
														if (!empty($yaxis[0])){
																preg_match('~{col}([^{]*){/col}~i', $yaxis[0], $match);
																echo '<option value ="'.$yaxis[0].'" selected="selected">'.$match[1].'</option>';
														}
															$i=0;
															for ($i=0; $i<count($XLSCol); $i++)
															{
															
															?>
															 <option value="XLS:<?php 
																			echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																			echo implode (',',array_slice($XLSCol[$i], 1));
																			echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
															<?php 
															} 
													   }
													}?>
											  </select>
											  </div>
											</div>
												
											<!-- Bubble size and text -->
											<div id="IDbubble">
											
											<div class="form-group" id="IDsize" style="display:none;">
											  <label class="col-sm-3 control-label" style="margin:0 -15px 0 15px; "><span id="sankey-label"><?php echo _TEXT['SIZE'];?>:&nbsp; </span></label>
											  <div class="col-sm-8">
														<select class="form-control" id="size" name="size[]"  style="height:25px; width:100%; padding:0;" onChange="updateChart();">
												 <?php  
												 if ($xmlDoc->col[$col]->source=="ADatabase"){
														if (!empty($size[0])){
																preg_match('~{col}([^{]*){/col}~i', $size[0], $match);
																echo '<option value ="'.$size[0].'">'.$match[1].'</option>';
														}
														if (isset($_POST['query'])){										
														for ($x = 0; $x < $i ; $x++) { ?>
															<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
															echo '{data}';
															echo $sql;
															echo '{/data}';?>"><?php echo $cols[$x]; ?></option>
														<?php
														}
														} 
													}?>
													
													<?php  
													if ($xmlDoc->col[$col]->source=="upload"){
													if (!empty($Reader)) {
														if (!empty($size[0])){
																preg_match('~{col}([^{]*){/col}~i', $size[0], $match);
																echo '<option value ="'.$size[0].'" selected="selected">'.$match[1].'</option>';
														}
															$i=0;
															for ($i=0; $i<count($XLSCol); $i++)
															{
															
															?>
															 <option value="XLS:<?php 
																			echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																			echo implode (',',array_slice($XLSCol[$i], 1));
																			echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
															<?php 
															} 
													   }
													}?>
											  </select>
											  </div>
											</div>
											
											<div class="form-group" id="IDtext" style="display:none;">
											  <label id="TextLabel" class="col-sm-3 control-label" style="margin:0 -15px 0 15px; "><?php echo _TEXT['TEXT'];?>:&nbsp; </label>
											  <div class="col-sm-8">
													   <!-- <input class="form-control input-sm" style="width:100%; margin-left:10px;" type="text" id="text" name="text[]" value="<?php //if(!empty($text[0])){echo $text[0];}?>" placeholder="'Pizza 30%', 'Burger 44%', 'Orange 8%', 'Banana 12%'" />  -->
													<select class="form-control" id="text" name="text[]"  style="height:25px; width:100%; padding:0;" onChange="updateChart();">
													 <?php  
													 if ($xmlDoc->col[$col]->source=="ADatabase"){
															if (!empty($text[0])){
																	preg_match('~{col}([^{]*){/col}~i', $text[0], $match);
																	echo '<option value ="'.$text[0].'">'.substr($text[0],0,5).$match[1].'</option>';
															}
															if (isset($_POST['query'])){										
															for ($x = 0; $x < $i ; $x++) { ?>
																<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
																echo '{data}';
																echo $sql;
																echo '{/data}';?>"><?php echo $cols[$x]; ?></option>
															<?php
															}
															} 
														}?>
														
														<?php  
														if ($xmlDoc->col[$col]->source=="upload"){
															if (!empty($Reader)) {
															if (!empty($text[0])){
																	preg_match('~{col}([^{]*){/col}~i', $text[0], $match);
																	echo '<option value ="'.$text[0].'" selected="selected">'.$match[1].'</option>';
															}
																$i=0;
																for ($i=0; $i<count($XLSCol); $i++)
																{
																
																?>
																 <option value="XLS:<?php 
																				echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																				echo implode (',',array_slice($XLSCol[$i], 1));																		
																				echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
																<?php 
																} 
														   }
														}?>
												  </select>
											  </div>
											</div>
											
											</div>
											<!-- Bubble size and text -->
											
											<!-- Map Type Starts -->
											
											<div class="form-group" id="IDmaptype" style="display:none; ">
											  <label class="col-sm-3 control-label" style="margin:0 -15px 0 15px; "><?php echo _TEXT['MAP'];?>:&nbsp; </label>
											  <div class="col-sm-8">
														<select class="form-control" id="maptype" name="maptype[]"  style="height:25px; width:100%; padding:0;">
															<option value="world" <?php if ($maptype=='world') {echo "selected";}?>>World</option>
															<option value="usa" <?php if ($maptype=='usa') {echo "selected";}?>>USA</option>
															<option value="africa" <?php if ($maptype=='africa') {echo "selected";}?>>Africa</option>
															<option value="asia" <?php if ($maptype=='asia') {echo "selected";}?>>Asia</option>
															<option value="europe" <?php if ($maptype=='europe') {echo "selected";}?>>Europe</option>
															<option value="north america" <?php if ($maptype=='north america') {echo "selected";}?>>North America</option>
															<option value="south america" <?php if ($maptype=='south america') {echo "selected";}?>>South America</option>
														</select>
											  </div>
											</div>
											
											<!-- Map Type Ends -->
				
											<div class="form-group" style="padding:0 15px; ">
											  <label class="col-sm-3 control-label">Legend:&nbsp; </label>
											  <div class="col-sm-8">
													   <input class="form-control input-sm" style="width:100%; margin-left:10px;" type="text" id="tracename" name="tracename[]" value="<?php if(!empty($tracename[0])) {echo $tracename[0];}?>" placeholder="" oninput="updateChart();"/> 
											  </div>
											</div>
											
											<!-- Yn-Title -->
											<div class="form-group" style="padding:0 15px; display:none">
											  <label class="col-sm-3 control-label" style="padding:0;margint:0;padding-right:5px;">Y0-<?php echo _TEXT['TITLE'];?>:&nbsp; </label>
											  <div class="col-sm-8">
													   <input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="yntitle" name="yntitle[]" value="<?php if (!empty($yntitle[0])) {echo $yntitle[0];};?>" placeholder="" onChange="updateChart();" /> 
											  </div>
											</div>

											<!-- Color -->
											<div class="form-group custom-color" style="padding:0 15px; display:none;">
											<label class="col-sm-3 control-label"><?php echo _TEXT['COLOR'];?>&nbsp; </label> 
											
											<div class="col-sm-8">
												<div class="input-group">
													<span class="input-group-addon"><div class="swatch" id="swatch0" style="background-color: <?php if (!empty($color[0])) {echo $color[0];} else {echo '#FFFFFF';}?>"></div></span>
													<input class="form-control input-sm" style="width:100%; margin-left:10px;"  type="text" id="color0" name="color[]" value="<?php if(!empty($color[0])) {echo $color[0];}?>" placeholder="default" onChange="updateChart();"/> 
												 </div>
												 
												 
												  <div class="hue" style="width:104%;"><input id="hue0" name="hue" type="range" min="1" max="300" value="130" onchange="colorChange(hue0.value, 0);updateChart();"/></div>
												
											</div>
		  
											</div>

											<!-- Color End -->
											
											<input type="hidden" id="sql" name="sql[]" value="" placeholder=""/> 
										
									</div>
				</div>
				
				<div class="tab-pane fade in tb-analysis" id="1b" style="padding: 0; padding-top:15px;padding-left:30px;">
					<select class="selectpicker" multiple title="X" data-style="btn-default" name="xanalytics[0][]" id="xanalytics0" onchange="analytics('x',0);updateChart();">
						  <optgroup label="Model" data-max-options="1" id="xmodel0">
							<option value="SUM" class="xselectnum0" <?php if(isset($xmodel[0])) {if ($xmodel[0]=="SUM") echo 'selected';}?>>SUM</option>
							<option value="AVG" class="xselectnum0" <?php if(isset($xmodel[0])) {if ($xmodel[0]=="AVG") echo 'selected';}?>>AVG</option>
							<option value="COUNT" class="xselectnum0" <?php if(isset($xmodel[0])) {if ($xmodel[0]=="COUNT") echo 'selected';}?>>COUNT</option>
							<option value="MAX" class="xselectnum0" <?php if(isset($xmodel[0])) {if ($xmodel[0]=="MAX") echo 'selected';}?>>MAX</option>
							<option value="MIN" class="xselectnum0" <?php if(isset($xmodel[0])) {if ($xmodel[0]=="MIN") echo 'selected';}?>>MIN</option>
							<option value="VAR" class="xselectnum0" <?php if(isset($xmodel[0])) {if ($xmodel[0]=="VAR") echo 'selected';}?>>VAR</option>
							<option value="STD" class="xselectnum0" <?php if(isset($xmodel[0])) {if ($xmodel[0]=="STD") echo 'selected';}?>>STDEV</option>
							<option value="YEAR" class="xselectdate0" <?php if(isset($xmodel[0])) {if ($xmodel[0]=="YEAR") echo 'selected';}?>>YEAR</option>
							<option value="QTR" class="xselectdate0" <?php if(isset($xmodel[0])) {if ($xmodel[0]=="QTR") echo 'selected';}?>>QUARTER</option>
							<option value="MON" class="xselectdate0" <?php if(isset($xmodel[0])) {if ($xmodel[0]=="MON") echo 'selected';}?>>MONTH</option>
						  </optgroup>
						  <optgroup label="Sort" data-max-options="1" id="xsort0" >
							<!--<option data-icon="fa-heart" value="ASC">ASC</option> how ot use icon-->
							<option value="ASC" <?php if(isset($xsort[0])) {if ($xsort[0]=="ASC") echo 'selected';}?>>ASC</option>
							<option value="DSC" <?php if(isset($xsort[0])) {if ($xsort[0]=="DSC") echo 'selected';}?>>DSC</option>
						  </optgroup>
						</select> 
						<div><br/></div>
						<select class="selectpicker" multiple title="Y" data-style="btn-default" name="yanalytics[0][]" id="yanalytics0" onchange="analytics('y',0);updateChart();">
						  <optgroup label="Model" data-max-options="1" id="ymodel0">
							<option value="SUM" class="yselectnum0" <?php if(isset($ymodel[0])) {if ($ymodel[0]=="SUM") echo 'selected';}?>>SUM</option>
							<option value="AVG" class="yselectnum0" <?php if(isset($ymodel[0])) {if ($ymodel[0]=="AVG") echo 'selected';}?>>AVG</option>
							<option value="COUNT" class="yselectnum0" <?php if(isset($ymodel[0])) {if ($ymodel[0]=="COUNT") echo 'selected';}?>>COUNT</option>
							<option value="MAX" class="yselectnum0" <?php if(isset($ymodel[0])) {if ($ymodel[0]=="MAX") echo 'selected';}?>>MAX</option>
							<option value="MIN" class="yselectnum0" <?php if(isset($ymodel[0])) {if ($ymodel[0]=="MIN") echo 'selected';}?>>MIN</option>
							<option value="VAR" class="yselectnum0" <?php if(isset($ymodel[0])) {if ($ymodel[0]=="VAR") echo 'selected';}?>>VAR</option>
							<option value="STD" class="yselectnum0" <?php if(isset($ymodel[0])) {if ($ymodel[0]=="STD") echo 'selected';}?>>STDEV</option>
							<option value="YEAR" class="yselectdate0" <?php if(isset($ymodel[0])) {if ($ymodel[0]=="YEAR") echo 'selected';}?>>YEAR</option>
							<option value="QTR" class="yselectdate0" <?php if(isset($ymodel[0])) {if ($ymodel[0]=="QTR") echo 'selected';}?>>QUARTER</option>
							<option value="MON" class="yselectdate0" <?php if(isset($ymodel[0])) {if ($ymodel[0]=="MON") echo 'selected';}?>>MONTH</option>>
						  </optgroup>
						  <optgroup label="Sort" data-max-options="1" id="ysort0" >
							<option value="ASC" <?php if(isset($ysort[0])) {if ($ysort[0]=="ASC") echo 'selected';}?>>ASC</option>
							<option value="DSC" <?php if(isset($ysort[0])) {if ($ysort[0]=="DSC") echo 'selected';}?>>DSC</option>
						  </optgroup>
						</select>
						<div><br/></div>

				</div>
				</div>

			<!-- Trace Start 1 End-->
				
			</div><!-- /.navbar-collapse -->
			
			<!-- Dynamic Dropdown Tracing -->
			<?php 
			
			//if (!empty($_POST['X'])){			
			if (!empty($xaxis[1])){			
			$w=0;  // bypass 1st one
			 foreach($xaxis as $value){ 
			
			if (!empty($value) && ($w > 0)) { 
			
			?>
			
			<div id="div-remove" class="side-menu-container" >
			
			<ul class="nav nav-tabs">
				<li class="active" ><a href="#1a<?php echo $w+1?>" data-toggle="tab">Trace <?php echo $w+1;?> </a></li>
				<li><a href="#1b<?php echo $w+1?>" data-toggle="tab"><?php echo _TEXT['DATA_ANALYSIS'];?></a></li>
				<a href="javascript:void(0);" class="remove_button col-sm-offset-12" title="Remove field" style="color:#000000; float:right;margin-top:-25px;"> <span class="fa fa-minus-square-o" ></span></a>
			</ul>
	 
				<div class="tab-content">
				<div class="tab-pane fade in active tb-analysis" id="1a<?php echo $w+1?>">
				<!-- Dropdown level 1 -->
				<div id="dropdown-chs<?php echo $w+1;?>" >

							<div class="panel-body" style="padding: 0; padding-top:15px;">
									<!-- Type -->
									
									<div class="form-group type-dynamic">
									  <label for="sel2" class="col-sm-3 col-md-3 col-lg-3 control-label"><?php echo _TEXT['TYPE'];?></label>
									  <div class="col-sm-8">
									  <?php
									  if (isset($type[$w])) { }
									  else {
									  $type[$w] = "area";
									  }
										  
									  ?>
									  <select class="form-control" id="type" name="type[]" style="height:25px; width:100%; padding:0;" value="<?php echo $type[$w];?>" onchange="mySelection()">
										<option value="area" <?php if ($type[$w]=='area'){?> selected <?php }?>>Area</option>
										<option value="bar" <?php if ($type[$w]=='bar'){?> selected <?php }?>>Bar</option>
										<option value="histogram" <?php if ($type[$w]=='histogram'){?> selected <?php }?>>Histogram</option>
										<option value="line" <?php if ($type[$w]=='line'){?> selected <?php }?>>Line</option>
										<option value="stack" <?php if ($type[$w]=='stack'){?> selected <?php }?>>Stack</option>
									  </select>
									  </div>
									</div>
								<!-- Type End -->
									
									
									<div class="form-group XGroup2" >
									  <label for="sel2" class="col-sm-3 col-md-3 col-lg-3 control-label x2">X: </label>
									  <div class="col-sm-8">
									  <select class="form-control" id="X" name="X[]"  style="height:25px; width:100%; padding:0;" onChange="updateChart();">
										<?php 
											if ($xmlDoc->col[$col]->source=="ADatabase"){
												if (!empty($xaxis)){
														preg_match('~{col}([^{]*){/col}~i', $xaxis[$w], $match);
														echo '<option value ="'.$xaxis[$w].'">'.$match[1].'</option>';
												}
												if (isset($_POST['query'])){				
												for ($x = 0; $x < $i ; $x++) { ?>
													<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
														echo '{data}';
														echo $sql;
														echo '{/data}';
														?>">
														<?php 
														echo $cols[$x]; ?>
													</option>
												<?php
												}
												} 
											}?>
											
											<?php
											if ($xmlDoc->col[$col]->source=="upload"){
											if (!empty($Reader)) {
													if (!empty($xaxis[$w])){
															preg_match('~{col}([^{]*){/col}~i', $xaxis[$w], $match);
															echo '<option value ="'.$xaxis[$w].'" selected="selected">'.$match[1].'</option>';
													}
													$i=0;
													for ($i=0; $i<count($XLSCol); $i++)
													{
													
													?>
													 <option value="XLS:<?php 
																	echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																	echo implode (',',array_slice($XLSCol[$i], 1));
																	echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
													<?php 
													} 
											   }
											}?>
									  </select>
									 
									  </div>
									</div>
									
									<div  class="form-group YGroup2" >
									  <label for="sel2" class="col-sm-3  control-label y2" >Y: </label>
									  <div class="col-sm-8" >
									  <select class="form-control" id="Y" name="Y[]"   style="height:25px; width:100%; padding:0;" onChange="updateChart();">
										<?php  
										if ($xmlDoc->col[$col]->source=="ADatabase"){
												if (!empty($yaxis)){
														preg_match('~{col}([^{]*){/col}~i', $yaxis[$w], $match);
														echo '<option value ="'.$yaxis[$w].'">'.$match[1].'</option>';
												}
												if (isset($_POST['query'])){										
												for ($x = 0; $x < $i ; $x++) { ?>
													<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
														echo '{data}';
														echo $sql;
														echo '{/data}';
														?>">
														<?php 
														echo $cols[$x]; ?>
													</option>
												<?php
												}
												}
											} ?>
											
											<?php
											if ($xmlDoc->col[$col]->source=="upload"){	
											if (!empty($Reader)) {
													if (!empty($yaxis[$w])){
															preg_match('~{col}([^{]*){/col}~i', $yaxis[$w], $match);
															echo '<option value ="'.$yaxis[$w].'" selected="selected">'.$match[1].'</option>';
													}

													$i=0;
													for ($i=0; $i<count($XLSCol); $i++)
													{
													
													?>
													 <option value="XLS:<?php 
																	echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																	echo implode (',',array_slice($XLSCol[$i], 1));
																	echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
													<?php 
													} 
											   }
											}?>

									  </select>
									  </div>
									</div>
									
									
								
								
								
								<!-- Bubble size and text -->
									<div class="IDbubble">
									
									<div class="form-group IDsize2" >
									  <label class="col-sm-3 control-label SizeLabel2" style="margin:0 -15px 0 15px; "><span id="sankey-label"><?php echo _TEXT['SIZE'];?>&nbsp; </span></label>
									  <div class="col-sm-8">
											 <select class="form-control" id="size" name="size[]"  style="height:25px; width:100%; padding:0;" onChange="updateChart();">
												<?php 
													if ($xmlDoc->col[$col]->source=="ADatabase"){
														if (!empty($size)){
																preg_match('~{col}([^{]*){/col}~i', $size[$w], $match);
																echo '<option value ="'.$size[$w].'">'.$match[1].'</option>';
														}
														if (isset($_POST['query'])){				
														for ($x = 0; $x < $i ; $x++) { ?>
															<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
																echo '{data}';
																echo $sql;
																echo '{/data}';
																?>">
																<?php 
																echo $cols[$x]; ?>
															</option>
														<?php
														}
														} 
													}?>
													
													<?php
													if ($xmlDoc->col[$col]->source=="upload"){
													if (!empty($Reader)) {
															if (!empty($size[$w])){
																	preg_match('~{col}([^{]*){/col}~i', $size[$w], $match);
																	echo '<option value ="'.$size[$w].'" selected="selected">'.$match[1].'</option>';
															}
															$i=0;
															for ($i=0; $i<count($XLSCol); $i++)
															{
															
															?>
															 <option value="XLS:<?php 
																			echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																			echo implode (',',array_slice($XLSCol[$i], 1));
																			echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
															<?php 
															} 
													   }
													}?>
											  </select>
									 
									  </div>
									</div>
									
									<div class="form-group IDtext2" >
									  <label class="col-sm-3 control-label TextLabel2" style="margin:0 -15px 0 15px; "><?php echo _TEXT['TEXT'];?>:&nbsp; </label>
									  <div class="col-sm-8">
											   <!-- <input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="text" name="text[]" value="<?php// if (!empty($text[$w])) {echo $text[$w];}?>" placeholder="'Pizza 30%', 'Burger 44%', 'Orange 8%', 'Banana 12%'" /> --> 
									 		<select class="form-control" id="text" name="text[]"  style="height:25px; width:100%; padding:0;" onChange="updateChart();">
												<?php 
													if ($xmlDoc->col[$col]->source=="ADatabase"){
														if (!empty($text)){
																preg_match('~{col}([^{]*){/col}~i', $text[$w], $match);
																echo '<option value ="'.$text[$w].'">'.$match[1].'</option>';
														}
														if (isset($_POST['query'])){				
														for ($x = 0; $x < $i ; $x++) { ?>
															<option value="SQL<?php echo $tbdsp.':{col}'.$cols[$x].'{/col}';
																echo '{data}';
																echo $sql;
																echo '{/data}';
																?>">
																<?php 
																echo $cols[$x]; ?>
															</option>
														<?php
														}
														} 
													}?>
													
													<?php
													if ($xmlDoc->col[$col]->source=="upload"){
													if (!empty($Reader)) {
															if (!empty($text[$w])){
																	preg_match('~{col}([^{]*){/col}~i', $text[$w], $match);
																	echo '<option value ="'.$text[$w].'" selected="selected">'.$match[1].'</option>';
															}
															$i=0;
															for ($i=0; $i<count($XLSCol); $i++)
															{
															
															?>
															 <option value="XLS:<?php 
																			echo '{col}'.$XLSCol[$i][0].'{/col}{data}';
																			echo implode (',',array_slice($XLSCol[$i], 1));
																			echo '{/data}';?>"><?php echo $XLSCol[$i][0];?></option>
															<?php 
															} 
													   }
													}?>
											  </select>
									 
									 
									  </div>
									</div>
									</div>
									<!-- Bubble size and text -->
								

								
								<!-- Map Type Starts -->
									
									<div class="form-group IDmaptype2" style="display:none; ">
									  <label class="col-sm-3 control-label" style="margin:0 -15px 0 15px; "><?php echo _TEXT['MAP'];?>:&nbsp; </label>
									  <div class="col-sm-8">
									  			<select class="form-control" id="maptype" name="maptype[]"  style="height:25px; width:100%; padding:0;">
													<option value="world" selected>World</option>
													<option value="usa">USA</option>
													<option value="africa">Africa</option>
													<option value="asia">Asia</option>
													<option value="europe">Europe</option>
													<option value="north america">North America</option>
													<option value="south america">South America</option>
									  			</select>
									  </div>
									</div>
									
									<!-- Map Type Ends -->
									
									<div class="form-group" style="padding:0 15px; ">
									  <label class="col-sm-3 control-label">Legend:&nbsp; </label>
									  <div class="col-sm-8">
											   <input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="tracename" name="tracename[]" value="<?php if (!empty($tracename[$w])) {echo $tracename[$w];};?>" placeholder="" oninput="updateChart();" /> 
									  </div>
									</div>
									
									<!-- Yn-Title -->
									<div class="form-group yn-title" style="padding:0 15px; ">
									  <label class="col-sm-3 control-label" style="padding:0;margint:0;padding-left:5px;">Y<?php echo $w+1;?>-<?php echo _TEXT['TITLE'];?>:&nbsp; </label>
									  <div class="col-sm-8">
											   <input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="yntitle" name="yntitle[]" value="<?php if (!empty($yntitle[$w])) {echo $yntitle[$w];};?>" placeholder="" oninput="updateChart();" /> 
									  </div>
									</div>
									
																		
									<!-- Color -->
									<div class="form-group custom-color" style="padding:0 15px; display:none;">
									<label class="col-sm-3 control-label"><?php echo _TEXT['COLOR'];?>&nbsp; </label> 
									
									<div class="col-sm-8">
										<div class="input-group">
											<span class="input-group-addon"><div class="swatch" id="swatch<?php echo $w;?>" style="background-color: <?php if (!empty($color[$w])) {echo $color[$w];} else {echo '#FFFFFF';}?>"></div></span>
											<input class="form-control input-sm" style="width:100%; margin-left:10px;"  type="text" id="color<?php echo $w;?>" name="color[]" value="<?php if(!empty($color[$w])) {echo $color[$w];}?>" placeholder="default" onChange="updateChart();"/> 
										 </div>
										 
										  <div class="hue" style="width:104%;"><input id ="hue<?php echo $w;?>" name="hue" type="range" min="1" max="300" value="130" onchange="colorChange(hue<?php echo $w;?>.value, <?php echo $w;?>);updateChart();"></div>
									</div>
  
									</div>
									<!-- Color End -->
																
									
								 	<input type="hidden" id="sql" name="sql[]" value="<?php // echo $sqlvalue;?>" placeholder="<?php //echo $sqlvalue;?>"/> 	
									
									

										
							</div> <!-- Drop level 1 -->
							</div>
				</div>
				<div class="tab-pane fade in tb-analysis" id="1b<?php echo $w+1?>" style="padding: 0; padding-top:15px;padding-left:30px;">
		
					<select class="selectpicker" multiple title="X" data-style="btn-default" name="xanalytics[<?php echo $w;?>][]" id="xanalytics<?php echo $w;?>" onchange="analytics('x',<?php echo $w;?>);updateChart();">
						  <optgroup label="Model" data-max-options="1" id="xmodel<?php echo $w;?>">
							<option value="SUM" class="xselectnum<?php echo $w;?>" <?php if(isset($xmodel[$w])) {if ($xmodel[$w]=="SUM") echo 'selected';}?>>SUM</option>
							<option value="AVG" class="xselectnum<?php echo $w;?>" <?php if(isset($xmodel[$w])) {if ($xmodel[$w]=="AVG") echo 'selected';}?>>AVG</option>
							<option value="COUNT" class="xselectnum<?php echo $w;?>" <?php if(isset($xmodel[$w])) {if ($xmodel[$w]=="COUNT") echo 'selected';}?>>COUNT</option>
							<option value="MAX" class="xselectnum<?php echo $w;?>" <?php if(isset($xmodel[$w])) {if ($xmodel[$w]=="MAX") echo 'selected';}?>>MAX</option>
							<option value="MIN" class="xselectnum<?php echo $w;?>" <?php if(isset($xmodel[$w])) {if ($xmodel[$w]=="MIN") echo 'selected';}?>>MIN</option>
							<option value="VAR" class="xselectnum<?php echo $w;?>" <?php if(isset($xmodel[$w])) {if ($xmodel[$w]=="VAR") echo 'selected';}?>>VAR</option>
							<option value="STD" class="xselectnum<?php echo $w;?>" <?php if(isset($xmodel[$w])) {if ($xmodel[$w]=="STD") echo 'selected';}?>>STDEV</option>
							<option value="YEAR" class="xselectdate<?php echo $w;?>" <?php if(isset($xmodel[$w])) {if ($xmodel[$w]=="YEAR") echo 'selected';}?>>YEAR</option>
							<option value="QTR" class="xselectdate<?php echo $w;?>" <?php if(isset($xmodel[$w])) {if ($xmodel[$w]=="QTR") echo 'selected';}?>>QUARTER</option>
							<option value="MON" class="xselectdate<?php echo $w;?>" <?php if(isset($xmodel[$w])) {if ($xmodel[$w]=="MON") echo 'selected';}?>>MONTH</option>
						  </optgroup>
						  <optgroup label="Sort" data-max-options="1" id="xsort<?php echo $w;?>">
							<!--<option data-icon="fa-heart" value="ASC">ASC</option> how ot use icon-->
							<option value="ASC" <?php if(isset($xsort[$w])) {if ($xsort[$w]=="ASC") echo 'selected';}?>>ASC</option>
							<option value="DSC" <?php if(isset($xsort[$w])) {if ($xsort[$w]=="DSC") echo 'selected';}?>>DSC</option>
						  </optgroup>
						</select>
						<div><br/></div>
						<select class="selectpicker" multiple title="Y" data-style="btn-default" name="yanalytics[<?php echo $w;?>][]" id="yanalytics<?php echo $w;?>" onchange="analytics('y',<?php echo $w;?>);updateChart();">
						  <optgroup label="Model" data-max-options="1" id="ymodel<?php echo $w;?>">
						  <option value="SUM" class="yselectnum<?php echo $w;?>" <?php if(isset($ymodel[$w])) {if ($ymodel[$w]=="SUM") echo 'selected';}?>>SUM</option>
							<option value="AVG" class="yselectnum<?php echo $w;?>" <?php if(isset($ymodel[$w])) {if ($ymodel[$w]=="AVG") echo 'selected';}?>>AVG</option>
							<option value="COUNT" class="yselectnum<?php echo $w;?>" <?php if(isset($ymodel[$w])) {if ($ymodel[$w]=="COUNT") echo 'selected';}?>>COUNT</option>
							<option value="MAX" class="yselectnum<?php echo $w;?>" <?php if(isset($ymodel[$w])) {if ($ymodel[$w]=="MAX") echo 'selected';}?>>MAX</option>
							<option value="MIN" class="yselectnum<?php echo $w;?>" <?php if(isset($ymodel[$w])) {if ($ymodel[$w]=="MIN") echo 'selected';}?>>MIN</option>
							<option value="VAR" class="yselectnum<?php echo $w;?>" <?php if(isset($ymodel[$w])) {if ($ymodel[$w]=="VAR") echo 'selected';}?>>VAR</option>
							<option value="STD" class="yselectnum<?php echo $w;?>" <?php if(isset($ymodel[$w])) {if ($ymodel[$w]=="STD") echo 'selected';}?>>STDEV</option>
							<option value="YEAR" class="yselectdate<?php echo $w;?>" <?php if(isset($ymodel[$w])) {if ($ymodel[$w]=="YEAR") echo 'selected';}?>>YEAR</option>
							<option value="QTR" class="yselectdate<?php echo $w;?>" <?php if(isset($ymodel[$w])) {if ($ymodel[$w]=="QTR") echo 'selected';}?>>QUARTER</option>
							<option value="MON" class="yselectdate<?php echo $w;?>" <?php if(isset($ymodel[$w])) {if ($ymodel[$w]=="MON") echo 'selected';}?>>MONTH</option>>
						  </optgroup>
						  <optgroup label="Sort" data-max-options="1" id="ysort<?php echo $w;?>">
							<option value="ASC" <?php if(isset($ysort[$w])) {if ($ysort[$w]=="ASC") echo 'selected';}?>>ASC</option>
							<option value="DSC" <?php if(isset($ysort[$w])) {if ($ysort[$w]=="DSC") echo 'selected';}?>>DSC</option>
						  </optgroup>
						</select>
						<div><br/></div>

				</div>
			</div>

			</div><!-- /.navbar-collapse -->
			
			
			
			
			
			
			
				<script>
				var t = document.getElementById("type").value;

					if ((t == 'bubble') || (t == 'map') || (t == 'heatmap') || (t == 'sankey') || (t == 'scatter3d') || (t == 'sunburst') ){ //Check if bubble is selected
					// don't do anything
					}
					else
					{
						var y = document.getElementsByClassName("IDbubble");
						var i;
						for (i = 0; i < y.length; i++) {
							y[i].style.display = "none";
						}
					}
					
					
					
					//Color
				   var y = document.getElementsByClassName("custom-color");
				   if ((t == 'line') || (t == 'bar') || (t =='area') || (t =='bubble') || (t =='histogram')  || (t =='stack') || (t == 'scatter3d') || (t == 'sunburst') ) {
					   
								for (i = 0; i < y.length; i++) {
									y[i].style.display = "block";
								};	   
				   } else {
								for (i = 0; i < y.length; i++) {
									y[i].style.display = "none";
								};
				   }

				</script>
					<?php
					
					}
					$w++;
				}
			}
			?>
		</div> <!-- End filed_wrapper -->								
		<!-- Dynamic Dropdown Tracking End -->			

			<!-- Properties -->

			<div class="side-menu-container" >
				<ul class="nav navbar-nav" >
									
					<li class="active panel panel-default" id="dropdown">
					
						<!--<div class="setting-menu" style="background-color:#E5E5E5; width:100%; height:2em; padding:5px;" >-->
						
						<div class="setting-menu">
							<a data-toggle="collapse" href="#dropdown-properties">
								<span class="fa fa-sliders"></span> <?php echo _TEXT['PROPERTIES'];?> <span class="caret"></span>
							</a>
								<div class="col-sm-offset-12" >
								  &nbsp;   
								</div>
						</div>
					
						<div id="dropdown-properties" class="panel-collapse collapse" style="padding:0 15px; ">
						<br/>
						<!-- Dropdown level 1 -->
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo _TEXT['CAPTION'];?></label> 
								<div class="col-sm-9">
								   <input class="form-control input-sm"  type="text" id="title" name="title" value="<?php echo $title;?>" placeholder="Chart Title" />    
								</div>
							</div>
				
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo _TEXT['NAME'];?>:</label> 
								<div class="col-sm-9">
								   <input class="form-control input-sm" type="text" id="name" name="name" value="<?php echo $name;?>" placeholder="Pie1" size="10" />    
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">X-<?php echo _TEXT['TITLE'];?>:</label> 
								<div class="col-sm-9">
								   <input class="form-control input-sm" type="text" id="xaxistitle" name="xaxistitle" value="<?php echo $xaxistitle;?>" placeholder="Sales"  onChange="chartProperties();"/>    
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Y-<?php echo _TEXT['TITLE'];?>:</label> 
								<div class="col-sm-9">
								   <input class="form-control input-sm" type="text" id="yaxistitle" name="yaxistitle" value="<?php echo $yaxistitle;?>" placeholder="Products"  onChange="chartProperties();"/>    
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo _TEXT['HEIGHT'];?>:</label> 
								<div class="col-sm-9">
								   
								
								<select class="form-control" id="height" name="height" value="<?php echo $height;?>" style="height:25px; width:100%; padding:0;" >
									<option value="" <?php if ($height==''){?> selected <?php }?>><?php echo _TEXT['AUTO'];?></option>
									<option value="100" <?php if ($height=='100'){?> selected <?php }?>>100</option>
									<option value="200" <?php if ($height=='200'){?> selected <?php }?>>200</option>
									<option value="250" <?php if ($height=='250'){?> selected <?php }?>>250</option>
									<option value="300" <?php if ($height=='300'){?> selected <?php }?>>300</option>
									<option value="350" <?php if ($height=='350'){?> selected <?php }?>>350</option>
									<option value="400" <?php if ($height=='400'){?> selected <?php }?>>400</option>
									<option value="450" <?php if ($height=='450'){?> selected <?php }?>>450</option>
									<option value="500" <?php if ($height=='500'){?> selected <?php }?>>500</option>
									<option value="550" <?php if ($height=='550'){?> selected <?php }?>>550</option>
									<option value="600" <?php if ($height=='600'){?> selected <?php }?>>600</option>
									<option value="650" <?php if ($height=='650'){?> selected <?php }?>>650</option>
									<option value="700" <?php if ($height=='700'){?> selected <?php }?>>700</option>
								</select>
								      
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo _TEXT['WIDTH'];?>:</label> 
								<div class="col-sm-9">
								   
								
								<select class="form-control" id="width" name="width" value="<?php echo $width;?>" style="height:25px; width:100%; padding:0;" >
									<option value="" <?php if ($width==''){?> selected <?php }?>><?php echo _TEXT['AUTO'];?></option>
									<option value="100" <?php if ($width=='100'){?> selected <?php }?>>100</option>
									<option value="200" <?php if ($width=='200'){?> selected <?php }?>>200</option>
									<option value="250" <?php if ($width=='250'){?> selected <?php }?>>250</option>
									<option value="300" <?php if ($width=='300'){?> selected <?php }?>>300</option>
									<option value="350" <?php if ($width=='350'){?> selected <?php }?>>350</option>
									<option value="400" <?php if ($width=='400'){?> selected <?php }?>>400</option>
									<option value="450" <?php if ($width=='450'){?> selected <?php }?>>450</option>
									<option value="500" <?php if ($width=='500'){?> selected <?php }?>>500</option>
									<option value="550" <?php if ($width=='550'){?> selected <?php }?>>550</option>
									<option value="600" <?php if ($width=='600'){?> selected <?php }?>>600</option>
									<option value="650" <?php if ($width=='650'){?> selected <?php }?>>650</option>
									<option value="700" <?php if ($width=='700'){?> selected <?php }?>>700</option>
								</select>
								      
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Legend:</label> 
								<div class="col-sm-9">
								   
								
								<select class="form-control" id="legposition" name="legposition" value="<?php echo $legposition;?>" style="height:25px; width:100%; padding:0;" onChange="chartProperties();" >
									<option value="bottomcenter" <?php if ($legposition=='bottomcenter'){?> selected <?php }?> ><?php echo _TEXT['BOTTOM_CENTER'];?></option>
									<option value="bottomleft" <?php if ($legposition=='bottomleft'){?> selected <?php }?> ><?php echo _TEXT['BOTTOM_LEFT'];?></option>
									<option value="topcenter" <?php if ($legposition=='topcenter'){?> selected <?php }?> ><?php echo _TEXT['TOP_CENTER'];?></option>
									<option value="topleft" <?php if ($legposition=='topleft'){?> selected <?php }?> ><?php echo _TEXT['TOP_LEFT'];?></option>
									<option value="" <?php if ($legposition==''){?> selected <?php }?> ><?php echo _TEXT['RIGHT'];?></option>
								</select>
								      
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Dropdown:</label> 
								<div class="col-sm-offset-4">
									<div class="switch-field">
									  <input type="radio" id="dropdown_show" name="dropdown" value="true" <?php if ($dropdown=="true"){ echo 'checked';}?> onChange="chartProperties();" />
									  <label for="dropdown_show"><?php echo _TEXT['SHOW'];?></label>
									  <input type="radio" id="dropdown_hide" name="dropdown" value="false" <?php if(!($dropdown=="true")){ echo 'checked';}?> onChange="chartProperties();" />
									  <label for="dropdown_hide"><?php echo _TEXT['HIDE'];?></label>
									</div> 
								</div>
							</div>
							
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo _TEXT['GRID'];?>:</label> 
								<div class="col-sm-offset-4">
									<div class="switch-field">
									  <input type="radio" id="showgrid_show" name="showgrid" value="true" <?php if (!($showgrid=="false")){ echo 'checked';}?> onChange="chartProperties();" />
									  <label for="showgrid_show"><?php echo _TEXT['SHOW'];?></label>
									  <input type="radio" id="showgrid_hide" name="showgrid" value="false" <?php if($showgrid=="false"){ echo 'checked';}?> onChange="chartProperties();" />
									  <label for="showgrid_hide"><?php echo _TEXT['HIDE'];?></label>
									</div> 
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo _TEXT['BORDER'];?></label> 
								<div class="col-sm-offset-4">
									<div class="switch-field">
									  <input type="radio" id="showline_show" name="showline" value="true" <?php if(!($showline=="false")){ echo 'checked';}?> onChange="chartProperties();"/>
									  <label for="showline_show"><?php echo _TEXT['SHOW'];?></label>
									  <input type="radio" id="showline_hide" name="showline" value="false" <?php if($showline=="false"){ echo 'checked';}?> onChange="chartProperties();" />
									  <label for="showline_hide"><?php echo _TEXT['HIDE'];?></label>
									</div> 
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo _TEXT['LAYOUT'];?>:</label> 
								<div class="col-sm-offset-4">
									<div class="switch-field" >
									  <input type="radio" id="orientation_h" name="orientation" value="h" <?php if($orientation=="h"){ echo 'checked';}?> onChange="updateChart();"/>
									  <label for="orientation_h"><?php echo _TEXT['HORIZ'];?></label>
									  <input type="radio" id="orientation_v" name="orientation" value="v" <?php if(!($orientation=="h")){ echo 'checked';}?> onChange="updateChart();" />
									  <label for="orientation_v"><?php echo _TEXT['VERT'];?></label>
									</div> 
								</div>
							</div>

						</div><!-- padding -->
						<!-- Drop Level 1 -->
					</li>
					<!-- Propoerties End -->
			</ul>
			</div>
		</nav>
		</div>
				
				<!-- Left Navi End -->
				
				
				</div>
				<div class="col-md-9 col-lg-9" id="wraplayoutsettingchart">
					<?php 
					 if ($xmlDoc->col[$col]->source=='ADatabase'){ ?>
						<div class="panel panel-default">
							<div class="panel-body panel-resizable" style="height:135px;" >
								<ul class="nav nav-tabs sql-nav-tabs">
										  <li <?php if (empty($tb)) {echo 'class="active"';}?> >
												  <a data-toggle="tab" href="#tab1" id="myclick" onclick="tabvalue(1)" style="float:left;"> &nbsp;&nbsp;  SQL 1         
												  &nbsp;&nbsp;<a href="javascript:void(0);" class="add-tab" title="Add SQL" style="float:right;"> <span class="fa fa-plus-square-o" ></span></a>
										  </a> 
										  </li>
										  <?php
										  
											if ($noofquery>1){									
											for ($x = 1; $x < $noofquery ; $x++) { ?>
											<li <?php if ($x==($tbdsp-1)) {echo 'class="active"';}?>  id="div-tabs-remove<?php echo $x+1;?>">
												  <a data-toggle="tab" href="#tab<?php echo $x+1;?>" onclick="tabvalue(<?php echo $x+1;?>)" style="float:left;"> &nbsp;&nbsp;  SQL <?php echo $x+1;?>    </a>      
												  &nbsp;&nbsp;<a href="javascript:void(0);" class="remove-tab" title="Remove field" style="float:right;"> <span class="fa fa-minus-square-o" ></span></a>
										  	</li>
										  
											<?php }}
											?>
								  
								  <input type="hidden" id="tabs" name="tabs" value="<?php if(empty($tbdsp)) {echo '1';}else {echo $tbdsp;}?>" />
								  
								</ul>
				 
								<div class="col-md-8 tab-content sql-tab-content">
										<div id="tab1" class="tab-pane fade in <?php if (empty($tb)) {echo 'active';}?> ">
											 <div class="form-group" style="margin-bottom:5px;">											
											  <textarea class="form-control form-sql" rows="2" id="query1" name="query[]"  ><?php if (!empty($query[0])) { echo $query[0]; }?> </textarea>
											</div> 
											<button id="btnrunquery" type="submit" class="btn-xs btn-primary" name="runquery" value="true"><?php echo _TEXT['RUN_QUERY'];?></button>
										</div>	
										
										
										<?php
										
											if ($noofquery>1) {
											
											for ($x = 1; $x < $noofquery ; $x++) { ?>
											
											<div id="tab<?php echo $x+1;?>" class="tab-pane fade in <?php if ($x==$tb) {echo 'active';}?> ">
											 <div class="form-group" style="margin-bottom:5px;">											
											  <textarea class="form-control form-sql" rows="2" id="query<?php echo $x+1;?>" name="query[]"  ><?php  echo $query[$x];?> </textarea>
											</div> 
											<button type="submit" class="btn-xs btn-primary" name="runquery" value="true"><?php echo _TEXT['RUN_QUERY'];?></button>
											</div>
										  
											<?php }}
											?>
								</div>
							
								
								<div class="col-md-4">
									<label for="table" style="font-size:9px;position:relative;top:-20px;"> <?php echo _TEXT['TABLE_FROM'].$xmlDoc->col[$col]->dbname;?></label>
								</div>
								<div class="col-md-4" style="margin-top:-20px;">
								<?php 
	
	
										
								if ($xmlDoc->col[$col]->rdbms == 'sqlite'){
									$sqltbl = "SELECT name  FROM sqlite_master WHERE type='table';";
								    }
									else if ($xmlDoc->col[$col]->rdbms == 'pgsql') {
										$sqltbl = "SELECT table_name FROM information_schema.tables WHERE table_schema='public'";
									}
									else if ($xmlDoc->col[$col]->rdbms == 'sqlsrv') {
										$sqltbl = "SELECT  TABLE_NAME FROM  INFORMATION_SCHEMA.TABLES";
									}
									else if ($xmlDoc->col[$col]->rdbms == 'oci') {
										$sqltbl = "select object_name from user_objects where object_type='TABLE'";
									}
									else {
										$sqltbl = "SHOW TABLES FROM $DB_NAME";
								}
									
								?>
										<select class="form-control panel-body panel-resizable" id="table"  name="table" size="5" onchange="tableSelection()" style="font-size:0.8em; padding-top:0;">
										<?php
										if ($xmlDoc->col[$col]->dbconnected==1){ 
										if ($xmlDoc->col[$col]->rdbms == 'oci') {
										$stidtbl = oci_parse($conn, $sqltbl);
										$r = oci_execute($stidtbl);
											while ($row = oci_fetch_array($stidtbl, OCI_RETURN_NULLS+OCI_ASSOC)) {
												foreach ($row as $item) {
													echo '<option>'.$item.'</option>';
												}
											}
										} else {
											foreach ($conn->query($sqltbl) as $row) {
												echo '<option>'.$row[0].'</option>';
											}
										}
										}?>
										</select>
								</div>
							</div> <!-- panel-body panel-resizable end -->
						</div> <!-- panel panel-default end -->
					<?php } // ADatabase Ends?>
					<!-- Show Chart -->
					<div class="panel panel-default TableQueryPanel" id="layoutsettingchart" >
						<div class="panel-body" >		
						<div id="chartupdate" >		
							<!-- Chart will go here Starts -->
							<!-- Chart will go here End -->
							</div>			
						</div>
					</div>
					<!-- Show Chart End -->
					
						<!-- Showing SQL Result -->
						<div>
						<ul class="nav" >	
						<li class="active panel panel-default" id="dropdown">
							<a data-toggle="collapse" href="#dropdown-sql-result" style="line-height:5px; height:5px; text-align:center;color:#000;font-size:11px;">
								<span class="fa fa-expand" style="margin-top:-5px;"></span>
							</a>
						
						
							<div class="panel-body panel-resizable panel-collapse collapse"  id="dropdown-sql-result"  >
							<div class="table-responsive">
							
								<table id="tabledata" class="table table-bordered" style="font-size:0.8em;">
								<thead style="background-color:#E5E5E5; font-weight:bold; ">
								  <tr>
								  <?php  
								  if ($xmlDoc->col[$col]->source=='ADatabase'){ 
										if (isset($_POST['query'])){
										//$sql = $_POST['query'] ;
										//// -> $sql = $query[trim($_POST['tabs']) -1];
										if (!empty(trim($sql))) {?>
										<center><label for="table" style="font-size:10px;margin-top:-15px;"><?php echo _TEXT['SHOWING_SQL_RESULT']; echo $tb+1;?>: </label></center>
										<?php
										//$rs = $conn->query($sql);
										

					for ($i = 0; $i < $columnCount; $i++) { 				
						echo '<td style="line-height:0.5em;">'.$cols[$i].'</td>';
								}
										}}
								
								 }?>
								 
								  <?php  
								  if ($xmlDoc->col[$col]->source=='upload'){ 
									if (!empty($Reader)) {

										
										foreach ($Reader as $XLS)
										{
											foreach ($XLS as $HDS)
												{
													echo '<td style="line-height:0.5em;">'.$HDS.'</td>';
												}
											break;
										}
								   }
								 }
								 
								 ?>
								 
								 
								  </tr>
								</thead>
								<tbody>
								
								  
								  <?php 
								  if ($xmlDoc->col[$col]->source=='ADatabase'){ 
										  if (isset($_POST['query'])){
										  $lastSQL = $query[trim($_POST['tabs']) -1];
										  if (!empty(trim($lastSQL))) {
											  
												  if (!empty($rs)) {
												 // check if oricle 
													if ($xmlDoc->col[$col]->rdbms == 'oci') {
													oci_execute($stid);														
													  while ($rs = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
														   echo '<tr>';
														   foreach ($rs as $item) {
															   echo '<td style="line-height:0.5em;" data-type="'.isData($item).'">'.$item .'</td>';
														   }
														   echo '</tr>';
														}
													  
													} else {
													  foreach ($rs as $row) {
													   echo '<tr>'; 
														for ($i =0; $i < $columnCount; $i++) {
															echo '<td style="line-height:0.5em;" data-type="'.isData($row[$i]).'">'.$row[$i].'</td>';
														}
													   echo '</tr>';
													   }
												    }
												  }
												  
											 }
										   }
								  }?>
								  
								  <?php
								  if ($xmlDoc->col[$col]->source=='upload'){ 
										if (!empty($Reader)) {

										$i=0;
										foreach ($Reader as $XLS)
										{
											if ($i>0){
											 echo '<tr>'; 
												foreach ($XLS as $HDS)
													{
														echo '<td style="line-height:0.5em;" data-type="'.isData($HDS).'">'.$HDS.'</td>';
													}
											echo '</tr>';
											}
										$i++;
									   }
								   }
								 }?>
								  
								 </tbody>
								</table>
							</div>
							</div>
						</li>
						</ul>
						</div>
						<!-- Showing SQL Result End -->
				</div>
				</div>
				<!-- Navi End -->
			 </div>
			 
			 <div class="modal-footer">
			 
			    <input type="hidden" name="col" value="<?php echo $request_col;?>" />
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:window.location.replace('<?php echo $url;?>')"><?php echo _TEXT['CANCEL'];?></button>
				<input type="hidden" name="cleardata" id="cleardata" value="">
				<button type="submit" class="btn btn-success" name="clear" value="true" onclick="javascript:document.getElementById('cleardata').value='true';"><?php echo _TEXT['CLEAR_DATA'];?></button>
               	<button type="submit" class="btn btn-primary" name="save" value="true"><?php echo _TEXT['SAVE_CHANGES'];?></button>
            </div>
			
	  		</form>

</body>
</html>

<?php
function cleardata($col) {
	 // $xmlfile = 'data/layout'.$_GET['layout'].'.xml';
	 $xmlfile = '../data/data.xml';
	 $xmlDoc=simplexml_load_file($xmlfile);
 
 	//initializing yaxis
	 unset($xmlDoc->col[$col]->xaxis);
	 $xmlDoc->col[$col]->addChild('xaxis', '');
	 
	 //initializing yaxis
     unset($xmlDoc->col[$col]->yaxis);
	 $xmlDoc->col[$col]->addChild('yaxis', '');


	 //initializing query.
	 unset($xmlDoc->col[$col]->sql);
	 $xmlDoc->col[$col]->addChild('sql', '');
	 
	  //initializing size..
	 unset($xmlDoc->col[$col]->size);
	 $xmlDoc->col[$col]->addChild('size', '');

	 //initializing text
	 unset($xmlDoc->col[$col]->text);
	 $xmlDoc->col[$col]->addChild('text', '');
	 
	  //initializing maptype
	 unset($xmlDoc->col[$col]->maptype);
	 $xmlDoc->col[$col]->addChild('maptype', '');
	 
	 //initializing text
	 unset($xmlDoc->col[$col]->text);
	 $xmlDoc->col[$col]->addChild('text', '');
	
	  //initializing tracename
	 unset($xmlDoc->col[$col]->tracename);
	 $xmlDoc->col[$col]->addChild('tracename', '');
	 
	 //initializing yntitle
	 unset($xmlDoc->col[$col]->yntitle);
	 $xmlDoc->col[$col]->addChild('yntitle', '');
	 
	 //initializing color
	 unset($xmlDoc->col[$col]->color);
	 $xmlDoc->col[$col]->addChild('color', '');
	 
	  //initializing type
	 unset($xmlDoc->col[$col]->type);
	 $xmlDoc->col[$col]->addChild('type', '');

	 $xmlDoc->col[$col]->title = "";
	 $xmlDoc->col[$col]->name = "";
	 if (empty($xmlDoc->col[$col]->name)){
	 	$xmlDoc->col[$col]->name = "";
	}
	
	 $xmlDoc->col[$col]->xaxistitle = "";
	 $xmlDoc->col[$col]->yaxistitle = "";
	 $xmlDoc->col[$col]->height ="";
	 $xmlDoc->col[$col]->width = "";
	 $xmlDoc->col[$col]->showgrid = "";
	 $xmlDoc->col[$col]->showline = "";
	 
	 $xmlDoc->col[$col]->orientation = "";
	 $xmlDoc->col[$col]->dropdown = "";
	 $xmlDoc->col[$col]->legposition = "";
	 
	 $xmlDoc->col[$col]->source = "";
	 $xmlDoc->col[$col]->servername = "";
	 $xmlDoc->col[$col]->username = "";
	 $xmlDoc->col[$col]->dbname = ""; 
	 $xmlDoc->col[$col]->password = "";
	 $xmlDoc->col[$col]->rdbms = "";
	 $xmlDoc->col[$col]->file = "";
	 $xmlDoc->col[$col]->source = "";
	 $xmlDoc->col[$col]->dbconnected = "";

	 $xmlDoc->asXML($xmlfile);

}


function savedata($col) {
	// $xmlfile = 'data/layout'.$_GET['layout'].'.xml';
	 $xmlfile = '../data/data.xml';
	 $xmlDoc=simplexml_load_file($xmlfile);

	 //initializing yaxis
	 unset($xmlDoc->col[$col]->xaxis);
	 $xmlDoc->col[$col]->addChild('xaxis', '');
	 
	 //initializing yaxis
     unset($xmlDoc->col[$col]->yaxis);
	 $xmlDoc->col[$col]->addChild('yaxis', '');
	 
	 //initializing xmodel
     unset($xmlDoc->col[$col]->xmodel);
	 $xmlDoc->col[$col]->addChild('xmodel', '');
	 
	 //initializing xsort
     unset($xmlDoc->col[$col]->xsort);
	 $xmlDoc->col[$col]->addChild('xsort', '');
	 
	 //initializing ymodel
     unset($xmlDoc->col[$col]->ymodel);
	 $xmlDoc->col[$col]->addChild('ymodel', '');
	 
	 //initializing ysort
     unset($xmlDoc->col[$col]->ysort);
	 $xmlDoc->col[$col]->addChild('ysort', '');


	 //initializing query.
	 unset($xmlDoc->col[$col]->sql);
	 $xmlDoc->col[$col]->addChild('sql', '');
	 
	  //initializing size..
	 unset($xmlDoc->col[$col]->size);
	 $xmlDoc->col[$col]->addChild('size', '');

	 //initializing text
	 unset($xmlDoc->col[$col]->text);
	 $xmlDoc->col[$col]->addChild('text', '');
	 
	  //initializing maptype
	 unset($xmlDoc->col[$col]->maptype);
	 $xmlDoc->col[$col]->addChild('maptype', '');
	 
	 //initializing text
	 unset($xmlDoc->col[$col]->text);
	 $xmlDoc->col[$col]->addChild('text', '');
	
	  //initializing tracename
	 unset($xmlDoc->col[$col]->tracename);
	 $xmlDoc->col[$col]->addChild('tracename', '');
	 
	  //initializing yntitle
	 unset($xmlDoc->col[$col]->yntitle);
	 $xmlDoc->col[$col]->addChild('yntitle', '');
	 
	  //initializing color
	 unset($xmlDoc->col[$col]->color);
	 $xmlDoc->col[$col]->addChild('color', '');
	
	 //initializing type
	 unset($xmlDoc->col[$col]->type);
	 $xmlDoc->col[$col]->addChild('type', '');
	 
	 $i=0;
	 if (!empty($_POST['X'])){
	 foreach($_POST['X'] as $value){
	 $xmlDoc->col[$col]->xaxis[$i] = $value;
	 
		 // Analytics 
		 if (isset($_POST['xanalytics'][$i])){
				$j=0;
				 foreach($_POST['xanalytics'][$i] as $value) {
					if (($value=="ASC") || ($value=="DSC")) {
						$xmlDoc->col[$col]->xsort[$i] = $value; 
					} else {
						$xmlDoc->col[$col]->xmodel[$i] = $value;
					}
					$j++;
				 }
		 } else {
			 $xmlDoc->col[$col]->xsort[$i] = '';
			 $xmlDoc->col[$col]->xmodel[$i] = '';
		 }
		 // Analytics
		 
	  $i++;
		}
	 }

	 if (!empty($_POST['type'])){
	  $i=0;
	 foreach($_POST['type'] as $value){
      $xmlDoc->col[$col]->type[$i] = $value;
		  if (($_POST['type'][0]=='bubble') ||  ($_POST['type'][0]=='heatmap') ||  ($_POST['type'][0]=='sankey') || ($_POST['type'][0]=='map') || ($_POST['type'][0]=='scatter3d') || ($_POST['type'][0]=='sunburst')){
			   $xmlDoc->col[$col]->type[$i] = $_POST['type'][0]; //repeat same type to all trace
		  }
	  $i++;
	 }}
	 
	$i=0;
	if (!empty($_POST['Y'])){
	 foreach($_POST['Y'] as $value){
	 $xmlDoc->col[$col]->yaxis[$i] = $value;
	 
	 // Analytics 
		 if (isset($_POST['yanalytics'][$i])){
				$j=0;
				 foreach($_POST['yanalytics'][$i] as $value) {
					if (($value=="ASC") || ($value=="DSC")) {
						$xmlDoc->col[$col]->ysort[$i] = $value; 
					} else {
						$xmlDoc->col[$col]->ymodel[$i] = $value;
					}
					$j++;
				 }
		 } else {
			 $xmlDoc->col[$col]->ysort[$i] = '';
			 $xmlDoc->col[$col]->ymodel[$i] = '';
		 }
		 // Analytics
		 
	  $i++;
	 }
	 }
	
/*	$i=0;
	if (!empty($_POST['xanalytics'])){
	 foreach($_POST['xanalytics'] as $values){ 
			$j=0;
			 foreach($values as $value) {
				if (($value=="ASC") || ($value=="DSC")) {
					$xmlDoc->col[$col]->xsort[$i] = $value; 
				} else {
					$xmlDoc->col[$col]->xmodel[$i] = $value;
				}
				$j++;
			 }
		  $i++;
		 }
	 }
	*/
	 
/*	$i=0;
	if (!empty($_POST['yanalytics'])){
	 foreach($_POST['yanalytics'] as $values){ 
			$j=0;
			 foreach($values as $value) {
				if (($value=="ASC") || ($value=="DSC")) {
					$xmlDoc->col[$col]->ysort[$i] = $value; 
				} else {
					$xmlDoc->col[$col]->ymodel[$i] = $value;
				}
				$j++;
			 }
		  $i++;
		 }
	 }
	 */
	 
	 if (!empty($_POST['query'])){
	 $i=0;
		 foreach($_POST['query'] as $value){
		  $xmlDoc->col[$col]->sql[$i] = $value;
		  $i++;
		 }
	 }
	 
		 if (($_POST['type'][0]=='bubble') || ($_POST['type'][0]=='sankey') || ($_POST['type'][0]=='scatter3d') || ($_POST['type'][0]=='sunburst')) {
			    $i=0;
				foreach($_POST['size'] as $value){
					$xmlDoc->col[$col]->size[$i] = $value;
					$i++;
				}
		}
		 if (($_POST['type'][0]=='bubble') ||  ($_POST['type'][0]=='heatmap') ||  ($_POST['type'][0]=='sankey') || ($_POST['type'][0]=='map')){
			  $i=0;
			  foreach($_POST['text'] as $value){
				  $xmlDoc->col[$col]->text[$i] =$value;
				  $i++;
			  }
		  }	
		  
		  if ($_POST['type'][0]=='map'){
			  	$i=0;
				foreach($_POST['maptype'] as $value){
				  $xmlDoc->col[$col]->maptype[$i] = $value;
				 $i++;
				 }
			}
	
	 
	 if (isset($_POST['tracename'])){
	  $i=0;
	 foreach($_POST['tracename'] as $value){ 
      $xmlDoc->col[$col]->tracename[$i] = $value;
	  $i++;
	 }}
	 
	 if (isset($_POST['yntitle'])){
	  $i=0;
	 foreach($_POST['yntitle'] as $value){ 
      $xmlDoc->col[$col]->yntitle[$i] = $value;
	  $i++;
	 }}
	 
	 if (isset($_POST['color'])){
	  $i=0;
	 foreach($_POST['color'] as $value){
      $xmlDoc->col[$col]->color[$i] = $value;
	  $i++;
	 }}

	 
	 $xmlDoc->col[$col]->title = $_POST['title'];
	 $xmlDoc->col[$col]->name = $_POST['name'];
	 if (empty($xmlDoc->col[$col]->name)){
	 	$xmlDoc->col[$col]->name = $col;
	}
	 $xmlDoc->col[$col]->xaxistitle = $_POST['xaxistitle'];
	 $xmlDoc->col[$col]->yaxistitle = $_POST['yaxistitle'];
	 $xmlDoc->col[$col]->height = $_POST['height'];
	 $xmlDoc->col[$col]->width = $_POST['width'];
	 $xmlDoc->col[$col]->showgrid = $_POST['showgrid'];
	 $xmlDoc->col[$col]->showline = $_POST['showline'];
	 
	 $xmlDoc->col[$col]->orientation = $_POST['orientation'];
	 $xmlDoc->col[$col]->dropdown = $_POST['dropdown'];
	 $xmlDoc->col[$col]->legposition = $_POST['legposition'];
	  
	 $xmlDoc->asXML($xmlfile);
}


function dbc (){
			global $xmlDoc,  $col, $conn, $DB_NAME, $folder;

			if (!isset ($xmlDoc->col[$col]->rdbms)) {
				$xmlDoc->col[$col]->source = $xmlDoc->col[0]->source;
				$xmlDoc->col[$col]->rdbms = $xmlDoc->col[0]->rdbms;
	 			$xmlDoc->col[$col]->servername  = $xmlDoc->col[0]->servername ;
	 			$xmlDoc->col[$col]->ssl = $xmlDoc->col[0]->ssl;
	 			$xmlDoc->col[$col]->username = $xmlDoc->col[0]->username ;
	 			$xmlDoc->col[$col]->password = $xmlDoc->col[0]->password;
	 			$xmlDoc->col[$col]->dbname = $xmlDoc->col[0]->dbname;
				$xmlDoc->col[$col]->dbconnected = $xmlDoc->col[0]->dbconnected ;
				$xmlDoc->col[$col]->file = $xmlDoc->col[0]->file;
			    $xmlDoc->asXML($folder.'data/data.xml');
			}
			
			if ($xmlDoc->col[$col]->dbconnected=='1'){
			$DB_TYPE = $xmlDoc->col[$col]->rdbms; //Type of database<br>
			$DB_HOST = $xmlDoc->col[$col]->servername; //Host name<br>
			$DB_USER = $xmlDoc->col[$col]->username; //Host Username<br>
			$DB_PASS = $xmlDoc->col[$col]->password; //Host Password<br>
			$DB_NAME = $xmlDoc->col[$col]->dbname; //Database name<br><br>
			$PORT = "";
			if (!empty(parse_url($DB_HOST, PHP_URL_PORT))) {
				$PORT = 'port='.parse_url($DB_HOST, PHP_URL_PORT).';';
				$DB_HOST=parse_url($DB_HOST, PHP_URL_HOST);
			}


			$SERVER='host';
			$DATABASE='dbname';
			
			if ($DB_TYPE=='sqlsrv') {
				$SERVER='Server';
				$DATABASE='Database';
			}

				if ($DB_TYPE=='oci'){
						$DB_HOST = $DB_HOST."/".$DB_NAME;
						$conn = oci_connect($DB_USER, $DB_PASS, $DB_HOST);
						if (!$conn) {
						   $xmlDoc->col[$col]->dbconnected = '0';
						}
					} else {
					
					try{
							if ($DB_TYPE=='sqlite'){
								$conn = new PDO("$DB_TYPE:$DB_NAME");
							}
							else {
								$conn = new PDO("$DB_TYPE:$SERVER=$DB_HOST;$DATABASE=$DB_NAME; $PORT", $DB_USER, $DB_PASS);
							}
						} catch(Exception $e){
							//echo $e;
							echo '<div class="alert alert-danger alert-dismissable">
												<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
												<strong>Error! Invalid Database Connection </strong> '.$DB_TYPE .
											  '</div>';
							return;
							
							}

						$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				} // if oci

			} // end if (!$xmlDoc->col[$col]->db=='')
}

function isData($_data) {
	
	if (is_numeric($_data)) {
		$type = "number";
	} else {
		if (strtotime($_data)) {
			$type ="date";
		} else {
			$type="string";
		}
	}
	return $type;
}


?>

<script>
function mySelection() {
	

    var x = document.getElementById("type").value;
	
	document.getElementById('XGroup').style.display="block";
	document.getElementById('YGroup').style.display="block";
	document.getElementById("TextLabel").innerHTML = "Text : ";
	document.getElementById("x").innerHTML = "X : ";
	document.getElementById("y").innerHTML = "Y : ";
	document.getElementById('IDmaptype').style.display="none";
	document.getElementById('YGroup').style.display="block";
	
	
	var y = document.getElementsByClassName("XGroup2");
	var y2 = document.getElementsByClassName("YGroup2");
	var y3 = document.getElementsByClassName("TextLabel2");
	var y4 = document.getElementsByClassName("IDbubble");
	var y5 = document.getElementsByClassName("IDtext2");
	var y6 = document.getElementsByClassName("x2");
	var y7 = document.getElementsByClassName("y2");
	var y8 = document.getElementsByClassName("IDmaptype2");
	var tj = document.getElementsByClassName("type-dynamic");
	var ynt = document.getElementsByClassName("yn-title");
		var i;
		for (i = 0; i < y3.length; i++) {
			y[i].style.display = "block";
			y2[i].style.display = "block";
			y3[i].innerText = "Text : ";
			y4[i].style.display = "block";
			y5[i].style.display = "block";
			y6[i].innerHTML = "X : ";
			y7[i].innerHTML = "Y : ";
			y8[i].style.display = "none";
			tj[i].style.display = "block";
			ynt[i].style.display = "block";
		} 
	
	
	if(x == 'bubble'){ //Check if bubble is selected
	
			document.getElementById('IDsize').style.display="block";
			document.getElementById('IDtext').style.display="block";
			document.getElementById('IDbubble').style.display="block";
			document.getElementById('sankey-label').innerHTML="<?php echo _TEXT['SIZE'];?>: ";

			var y = document.getElementsByClassName("IDsize2");
			var y2 = document.getElementsByClassName("IDbubble");
			var tj = document.getElementsByClassName("type-dynamic");
					var i;
					for (i = 0; i < y.length; i++) {
						y[i].style.display = "block";
						y2[i].style.display = "block";
						tj[i].style.display = "none";
						ynt[i].style.display = "none";
					} 
	}
	
	if(x == 'sankey'){ //Check if sankey is selected
	 		document.getElementById('IDbubble').style.display="block";
			document.getElementById('IDsize').style.display="block";
			document.getElementById('sankey-label').innerHTML="<?php echo _TEXT['VALUE'];?>: ";
			document.getElementById('IDtext').style.display="block";

			var y = document.getElementsByClassName("IDsize2");
			var y2 = document.getElementsByClassName("IDtext2");
			var tj = document.getElementsByClassName("type-dynamic");
					var i;
					for (i = 0; i < y.length; i++) {
						y[i].style.display = "block";
						y2[i].style.display = "block";
						tj[i].style.display = "none";
						ynt[i].style.display = "none";
					} 
	}
	
	
	if (x == 'map' ) {
		

		document.getElementById('IDtext').style.display="block";
		document.getElementById('IDsize').style.display="none"; 		 
		
		document.getElementById("x").innerHTML = "<?php echo _TEXT['LOC'];?> : ";
		document.getElementById("y").innerHTML = "Z : ";
		document.getElementById('IDmaptype').style.display="block";	
		document.getElementById('IDbubble').style.display="block";
		
			var y1 = document.getElementsByClassName("x2");
			var y2 = document.getElementsByClassName("y2");
			var y3 = document.getElementsByClassName("IDtext2");
			//var y4 = document.getElementsByClassName("IDsize2");
			var y5 = document.getElementsByClassName("IDmaptype2");
			var tj = document.getElementsByClassName("type-dynamic");
			var ynt = document.getElementsByClassName("yn-title");
			
					var i;
					for (i = 0; i < y1.length; i++) {
						y1[i].innerHTML = "<?php echo _TEXT['LOC'];?> : ";
						y2[i].innerHTML = "Z : ";
						y3[i].style.display = "block";
						y4[i].style.display = "none";
						y5[i].style.display = "block";
						tj[i].style.display = "none";
						ynt[i].style.display = "none";
					} 
			
	}
			
	if (x == 'heatmap') {
					document.getElementById('IDtext').style.display="block";
					document.getElementById('IDsize').style.display="none";
					document.getElementById("TextLabel").innerHTML = "Z : ";
					
					var y = document.getElementsByClassName("XGroup2");
					var y2 = document.getElementsByClassName('YGroup2');
					var y3 = document.getElementsByClassName("TextLabel2");
					var y4 = document.getElementsByClassName("IDtext2");
					var y5 = document.getElementsByClassName("IDsize2");
							//document.getElementsByClassName("TextLabel2").innerText = "Z : ";
							var tj = document.getElementsByClassName("type-dynamic");
						var i;
						for (i = 0; i < y3.length; i++) {
							y[i].style.display = "none";
							y2[i].style.display = "none";
							y3[i].innerText = "Z : ";
							y4[i].style.display = "block";
							y5[i].style.display = "none";
							tj[i].style.display = "none";
							ynt[i].style.display = "none";
					} 

	}
			//
		
     if (!((x == 'bubble') || (x == 'map') || (x =='heatmap') || (x =='sankey') )) {
			document.getElementById('IDtext').style.display="none";
			document.getElementById('IDsize').style.display="none";
			var y = document.getElementsByClassName("IDsize2");
			var y2 = document.getElementsByClassName("IDtext2");
			var y3 = document.getElementsByClassName("IDbubble");
					var i;
					for (i = 0; i < y.length; i++) {
						y[i].style.display = "none";
						y2[i].style.display = "none";
						y3[i].style.display = "none";
					};
			
			document.getElementById('XGroup').style.display="block";
			document.getElementById('YGroup').style.display="block";
			document.getElementById("TextLabel").innerHTML = "<?php echo _TEXT['TEXT'];?> : ";

     }
	 
	 if(x == 'scatter3d') { //Check if scatter3d or sunburst is selected
			document.getElementById('IDsize').style.display="block";
			document.getElementById('sankey-label').innerHTML="Z: ";
			document.getElementById('IDtext').style.display="none";
			
			
			document.getElementById('IDbubble').style.display="block";

			var y = document.getElementsByClassName("IDsize2");
			var y2 = document.getElementsByClassName("IDbubble");
			var y3 = document.getElementsByClassName("SizeLabel2"); 
			var tj = document.getElementsByClassName("type-dynamic");
					var i;
					for (i = 0; i < y.length; i++) {
						y[i].style.display = "block";
						y2[i].style.display = "block";
						y3[i].innerText = "Z : "; 
						tj[i].style.display = "none";
					} 
					
			
	}
	
	 if(x == 'sunburst'){ //Check if scatter3d or sunburst is selected
			document.getElementById('IDsize').style.display="block";
			document.getElementById('sankey-label').innerHTML="<?php echo _TEXT['LABEL'];?>: ";
			document.getElementById('IDtext').style.display="none";
			
			document.getElementById("x").innerHTML = " Ids:";
		    document.getElementById("y").innerHTML = " Parent:";
			
			
			document.getElementById('IDbubble').style.display="block";

			var y = document.getElementsByClassName("IDsize2");
			var y2 = document.getElementsByClassName("IDbubble");
			var y3 = document.getElementsByClassName("SizeLabel2"); 
	
	}
	
	 //KPI
	 if (x == 'number') {
	
					document.getElementById('x').innerHTML="Num:";
					document.getElementById('YGroup').style.display="none";			
	   }
	   
	 //Gauge
	 if (x == 'gauge') {
	
					document.getElementById('x').innerHTML="<?php echo _TEXT['VALUE'];?>:";
					document.getElementById("y").innerHTML = "<?php echo _TEXT['MAX'];?>";
	  }
	   
	   // Hide Add Trce 
	   	 if ((x == 'number') || (x == 'map') || (x == 'sunburst') || (x == 'gauge'))  {		
			document.getElementById("add_trace").style.display="none";
					
	   } else {
		   document.getElementById("add_trace").style.display="block";
	   }
	   
	   //Color
	   
	   var y = document.getElementsByClassName("custom-color");
	   if ((x == 'line') || (x == 'bar') || (x =='area') || (x =='bubble') || (x =='histogram')  || (x =='stack')  || (x =='scatter3d') || (x =='sunburst') || (x =='table')) {
					for (i = 0; i < y.length; i++) {
						y[i].style.display = "block";
					};	   
	   } else {
					for (i = 0; i < y.length; i++) {
						y[i].style.display = "none";
					};
	   }
	   
	   updateChart();
}
</script>

<script>
function tabvalue(tabvalue) {
	document.getElementById("tabs").value = tabvalue;
}

function tableSelection() {
var x = document.getElementById("table").value;
var queryid = 'query'+ document.getElementById("tabs").value;

//document.getElementById(queryid).value = "SELECT * FROM  " + x + " LIMIT 10;";	
document.getElementById(queryid).value = "SELECT * FROM  " + x;	

}
</script>

<script>

$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var x = <?php if (!empty($w)){echo $w;}else {echo '1' ;}?>;
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
	
	$(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
			var fieldHTML = '<div id="div-remove" class="side-menu-container" >';
				fieldHTML = fieldHTML + '<div class="side-menu-container" >';
				fieldHTML = fieldHTML + '<ul class="nav nav-tabs">';
				fieldHTML = fieldHTML + '<li class="active" >';		
				fieldHTML = fieldHTML + '<a data-toggle="tab" href="#1ad'+x+'"  data-toggle="tab"> ';
				fieldHTML = fieldHTML + 'Trace <span id="trno">' + x +'</span>';
				fieldHTML = fieldHTML + '</a></li>';
				fieldHTML = fieldHTML +'<li><a href="#1c'+x+'" data-toggle="tab"><?php echo _TEXT['DATA_ANALYSIS'];?></a></li>';
				fieldHTML = fieldHTML + '<a href="javascript:void(0);" class="remove_button col-sm-offset-12" title="Del field" style="color:#000000; float:right;margin-top:-25px;"> <span class="fa fa-minus-square-o" ></span></a>';
				fieldHTML = fieldHTML + '</ul><span class="col-lg-12"></span>';
				fieldHTML = fieldHTML + '<div class="tab-content">';
				fieldHTML = fieldHTML + '<div id="1ad'+x+'" class="tab-pane fade in active tb-analysis">';
				fieldHTML = fieldHTML + '<div id="dropdown-chs'+x+'" >';
				fieldHTML = fieldHTML + '<div class="panel-body" style="padding: 0; padding-top:15px;">';
				
				<!-- Type -->
				fieldHTML = fieldHTML + '<div class="form-group type-dynamic" >';
				fieldHTML = fieldHTML + '<label for="sel2" class="col-sm-3 col-md-3 col-lg-3 control-label"><?php echo _TEXT['TYPE'];?></label>';
				fieldHTML = fieldHTML + '<div class="col-sm-8 col-md-8 col-lg-8">';
				fieldHTML = fieldHTML + '<select class="form-control" id="type" name="type[]" style="height:25px; width:100%; padding:0;" selected onchange="mySelection()">';
				fieldHTML = fieldHTML + '<option value="area" selected>Area</option>';
				fieldHTML = fieldHTML + '<option value="bar">Bar</option>';
				fieldHTML = fieldHTML + '<option value="histogram" >Histogram</option>';
				fieldHTML = fieldHTML + '<option value="line" >Line</option>';
				fieldHTML = fieldHTML + '<option value="stack" >Stack</option>';
				fieldHTML = fieldHTML + ' </select>';
				fieldHTML = fieldHTML + '</div>';
				fieldHTML = fieldHTML + '</div>';
				<!-- Type End -->
				
				
				<!-- X -->
				
				fieldHTML = fieldHTML + '<div class="form-group XGroup2" >';
				fieldHTML = fieldHTML + '<label for="sel2" class="col-sm-3  control-label x2">X: </label>';
				fieldHTML = fieldHTML + '<div class="col-sm-8">';
				fieldHTML = fieldHTML + '<select class="form-control" id="X" name="X[]" style="height:25px; width:100%; padding:0;" onChange="updateChart();">';
				
						<?php 
						if ($xmlDoc->col[$col]->source=="ADatabase"){
						if (!empty($xaxis[0])){ 
								 preg_match('~{col}([^{]*){/col}~i', $xaxis[0], $match);
								?>
								 fieldHTML = fieldHTML +  '<option value="<?php echo $xaxis[0];?>"><?php echo $match[1];?></option>';
								<?php 
						}
				
						if (isset($_POST['query'])){
							for ($x = 0; $x < $i ; $x++) { ?>
								 fieldHTML = fieldHTML +  '<option value="SQL<?php echo $tbdsp;?>:{col}<?php echo $cols[$x];?>';
								 fieldHTML = fieldHTML + '{/col}{data}';
								 fieldHTML = fieldHTML + "<?php echo $sql;?>";
								 fieldHTML = fieldHTML + '{/data}';
								 fieldHTML = fieldHTML + '">';
								 fieldHTML = fieldHTML + '<?php echo $cols[$x]; ?>';
								 fieldHTML = fieldHTML +  '</option>';
						<?php } }};?>
						
						<?php 
						if ($xmlDoc->col[$col]->source=="upload"){
							if (!empty($Reader)) {
									$i=0;
									for ($i=0; $i<count($XLSCol); $i++)
									{
									?>
									 fieldHTML = fieldHTML + '<option value="XLS:';
									 fieldHTML = fieldHTML + '{col}<?php echo $XLSCol[$i][0];?>{/col}{data}';
									 fieldHTML = fieldHTML + '<?php echo implode (",",array_slice($XLSCol[$i], 1));?>';
									 fieldHTML = fieldHTML + '{/data}"><?php echo $XLSCol[$i][0];?></option>';
									<?php 
									} 
							   }
						};?>

				fieldHTML = fieldHTML + '</select>';
				fieldHTML = fieldHTML + '</div></div>';
				<!-- X End -->
				
				<!-- Y -->
				fieldHTML = fieldHTML + '<div class="form-group YGroup2" >';
				fieldHTML = fieldHTML + '<label for="sel2" class="col-sm-3  control-label y2" >Y: </label>';
				fieldHTML = fieldHTML + '<div class="col-sm-8" >';
				fieldHTML = fieldHTML + '<select class="form-control" id="Y" name="Y[]" style="height:25px; width:100%; padding:0;" onChange="updateChart();">';
				
						<?php 
						if ($xmlDoc->col[$col]->source=="ADatabase"){
						if (!empty($yaxis[0])){
								 preg_match('~{col}([^{]*){/col}~i', $yaxis[0], $match);
								?>
								 fieldHTML = fieldHTML +  '<option value="<?php echo $yaxis[0];?>"><?php echo $match[1];?></option>';
								<?php 
						}
				
						if (isset($_POST['query'])){
							for ($x = 0; $x < $i ; $x++) { ?>
								 fieldHTML = fieldHTML +  '<option value="SQL<?php echo $tbdsp;?>:{col}<?php echo $cols[$x];?>';
								 fieldHTML = fieldHTML + '{/col}{data}';
								 fieldHTML = fieldHTML + "<?php echo $sql;?>";
								 fieldHTML = fieldHTML + '{/data}';
								 fieldHTML = fieldHTML + '">';
								 fieldHTML = fieldHTML + '<?php echo $cols[$x]; ?>';
								 fieldHTML = fieldHTML +  '</option>';
						<?php }} };?>
						
						<?php 
						if ($xmlDoc->col[$col]->source=="upload"){
								if (!empty($Reader)) {
									$i=0;
									for ($i=0; $i<count($XLSCol); $i++)
									{
									?>
									 fieldHTML = fieldHTML + '<option value="XLS:';
									 fieldHTML = fieldHTML + '{col}<?php echo $XLSCol[$i][0];?>{/col}{data}';
									 fieldHTML = fieldHTML + '<?php echo implode (",",array_slice($XLSCol[$i], 1));?>';
									 fieldHTML = fieldHTML + '{/data}"><?php echo $XLSCol[$i][0];?></option>';
									<?php 
									} 
							   }
						};?>
						
				fieldHTML = fieldHTML + '</select>';
				fieldHTML = fieldHTML + '</div></div>';
				<!-- Y End -->
				
				
				<!-- Bubble size and text -->
				
					fieldHTML = fieldHTML +  '<div class="IDbubble">';
									
					fieldHTML = fieldHTML +  '<div class="form-group IDsize2" >';
					fieldHTML = fieldHTML +  '<label class="col-sm-3 control-label" style="margin:0 -15px 0 15px; "><span id="sankey-label" class="SizeLabel2"><?php echo _TEXT['SIZE'];?>:&nbsp; </span></label>';
					fieldHTML = fieldHTML +  '<div class="col-sm-8">';
					fieldHTML = fieldHTML + '<select class="form-control" id="size" name="size[]"  style="height:25px; width:100%; padding:0;" onChange="updateChart();">';
				
						<?php 
						if ($xmlDoc->col[$col]->source=="ADatabase"){
						if (!empty($size[0])){ 
								 preg_match('~{col}([^{]*){/col}~i', $size[0], $match);
								?>
								 fieldHTML = fieldHTML +  '<option value="<?php echo $size[0];?>"><?php echo $match[1];?></option>';
								<?php 
						}
				
						if (isset($_POST['query'])){
							for ($x = 0; $x < $i ; $x++) { ?>
								 fieldHTML = fieldHTML +  '<option value="SQL<?php echo $tbdsp;?>:{col}<?php echo $cols[$x];?>';
								 fieldHTML = fieldHTML + '{/col}{data}';
								 fieldHTML = fieldHTML + "<?php echo $sql;?>";
								 fieldHTML = fieldHTML + '{/data}';
								 fieldHTML = fieldHTML + '">';
								 fieldHTML = fieldHTML + '<?php echo $cols[$x]; ?>';
								 fieldHTML = fieldHTML +  '</option>';
						<?php } }};?>
						
						<?php 
						if ($xmlDoc->col[$col]->source=="upload"){
								if (!empty($Reader)) {
									$i=0;
									for ($i=0; $i<count($XLSCol); $i++)
									{
									?>
									 fieldHTML = fieldHTML + '<option value="XLS:';
									 fieldHTML = fieldHTML + '{col}<?php echo $XLSCol[$i][0];?>{/col}{data}';
									 fieldHTML = fieldHTML + '<?php echo implode (",",array_slice($XLSCol[$i], 1));?>';
									 fieldHTML = fieldHTML + '{/data}"><?php echo $XLSCol[$i][0];?></option>';
									<?php 
									} 
							   }
						};?>

					fieldHTML = fieldHTML + '</select>';
			
					fieldHTML = fieldHTML +  '</div></div>';
										
					fieldHTML = fieldHTML +  '<div class="form-group IDtext2" >';
					fieldHTML = fieldHTML +  '<label class="col-sm-3 control-label TextLabel2" style="margin:0 -15px 0 15px; ">Text:&nbsp; </label>'
					fieldHTML = fieldHTML +  '<div class="col-sm-8">'
					//fieldHTML = fieldHTML +  '<input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="text" name="text[]" value="" placeholder="Pizza 30%, Burger 44%, Orange 8%, Banana 12%" /> ';
					fieldHTML = fieldHTML + '<select class="form-control" id="text" name="text[]"  style="height:25px; width:100%; padding:0;" onChange="updateChart();">';
				
						<?php 
						if ($xmlDoc->col[$col]->source=="ADatabase"){
						if (!empty($text[0])){ 
								 preg_match('~{col}([^{]*){/col}~i', $text[0], $match);
								?>
								 fieldHTML = fieldHTML +  '<option value="<?php echo $text[0];?>"><?php echo $match[1];?></option>';
								<?php 
						}
				
						if (isset($_POST['query'])){
							for ($x = 0; $x < $i ; $x++) { ?>
								 fieldHTML = fieldHTML +  '<option value="SQL<?php echo $tbdsp;?>:{col}<?php echo $cols[$x];?>';
								 fieldHTML = fieldHTML + '{/col}{data}';
								 fieldHTML = fieldHTML + "<?php echo $sql;?>";
								 fieldHTML = fieldHTML + '{/data}';
								 fieldHTML = fieldHTML + '">';
								 fieldHTML = fieldHTML + '<?php echo $cols[$x]; ?>';
								 fieldHTML = fieldHTML +  '</option>';
						<?php } }};?>
						
						<?php 
						if ($xmlDoc->col[$col]->source=="upload"){
								if (!empty($Reader)) {
									$i=0;
									for ($i=0; $i<count($XLSCol); $i++)
									{
									?>
									 fieldHTML = fieldHTML + '<option value="XLS:';
									 fieldHTML = fieldHTML + '{col}<?php echo $XLSCol[$i][0];?>{/col}{data}';
									 fieldHTML = fieldHTML + '<?php echo implode (",",array_slice($XLSCol[$i], 1));?>';
									 fieldHTML = fieldHTML + '{/data}"><?php echo $XLSCol[$i][0];?></option>';
									<?php 
									} 
							   }
						};?>

					fieldHTML = fieldHTML + '</select>';
					
					
					
					fieldHTML = fieldHTML +  '</div></div>';
					fieldHTML = fieldHTML +  '</div>';
				
									<!-- Bubble size and text -->
				
				
				<!-- Map Type Starts -->
									
					fieldHTML = fieldHTML +  '<div class="form-group IDmaptype2" style="display:none; ">';
					  fieldHTML = fieldHTML +  '<label class="col-sm-3 control-label" style="margin:0 -15px 0 15px; "><?php echo _TEXT['MAP'];?>:&nbsp; </label>';
					  fieldHTML = fieldHTML +  '<div class="col-sm-8">';
								fieldHTML = fieldHTML +  '<select class="form-control" id="maptype" name="maptype[]"  style="height:25px; width:100%; padding:0;">';
									fieldHTML = fieldHTML +  '<option value="world" selected>World</option>';
									fieldHTML = fieldHTML +  '<option value="usa">USA</option>';
									fieldHTML = fieldHTML +  '<option value="africa">Africa</option>';
									fieldHTML = fieldHTML +  '<option value="asia">Asia</option>';
									fieldHTML = fieldHTML +  '<option value="europe">Europe</option>';
									fieldHTML = fieldHTML +  '<option value="north america">North America</option>';
									fieldHTML = fieldHTML +  '<option value="south america">South America</option>';
								fieldHTML = fieldHTML +  '</select>';
					  fieldHTML = fieldHTML +  '</div>';
					fieldHTML = fieldHTML +  '</div>';
									
				<!-- Map Type Ends -->
				
				
				<!-- Legend -->
				fieldHTML = fieldHTML + '<div class="form-group" style="padding:0 15px; ">';
				fieldHTML = fieldHTML + '<label class="col-sm-3 control-label">Legend:&nbsp; </label>';
				fieldHTML = fieldHTML + '<div class="col-sm-8">';
				fieldHTML = fieldHTML + '<input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="tracename" name="tracename[]" value="" placeholder="" oninput="updateChart();"/> ';
				fieldHTML = fieldHTML + '</div>';
				fieldHTML = fieldHTML + '</div>';
				<!-- Legend end -->
				
				<!-- Yn-Title -->
				fieldHTML = fieldHTML + '<div class="form-group yn-title" style="padding:0 15px; ">';
				fieldHTML = fieldHTML + '<label class="col-sm-3 control-label" style="padding:0;margint:0;padding-left:5px;">Y<span id="ytitle-no">'+x+'</span>-<?php echo _TEXT['TITLE'];?>:</label>';
				fieldHTML = fieldHTML + '<div class="col-sm-8">';
				fieldHTML = fieldHTML + '<input class="form-control input-sm" style="width:100%; margin-left:5px;" type="text" id="yntitle" name="yntitle[]" value="" placeholder="" oninput="updateChart();"/> ';
				fieldHTML = fieldHTML + '</div>';
				fieldHTML = fieldHTML + '</div>';					
				<!-- Yn-Title End -->
				
				<!-- Color -->
				fieldHTML = fieldHTML + '<div class="form-group custom-color" style="padding:0 15px; display:none;">';
				fieldHTML = fieldHTML + '<label class="col-sm-3 control-label"><?php echo _TEXT['COLOR'];?>:&nbsp; </label>'; 
									
				fieldHTML = fieldHTML + '<div class="col-sm-8">';
				fieldHTML = fieldHTML + '<div class="input-group">';
				fieldHTML = fieldHTML + '<span class="input-group-addon"><div class="swatch" id="swatch'+x+'" style="background-color: #FFFFFF;"></div></span>';
				fieldHTML = fieldHTML + '<input class="form-control input-sm" style="width:100%; margin-left:10px;"  type="text" id="color'+x+'" name="color[]" value="" placeholder="default" onchange="updateChart();"/> ';
				fieldHTML = fieldHTML + '</div>';
										 
				fieldHTML = fieldHTML + '<div class="hue" style="width:104%;"><input name="hue'+x+'" name="hue" type="range" min="1" max="300" value="130" onchange="colorChange(hue'+x+'.value, '+x+');updateChart();"/></div>';
				fieldHTML = fieldHTML + '</div>';
  
				fieldHTML = fieldHTML + '</div>';

				<!-- Color End -->
				
				fieldHTML = fieldHTML + '</div>';
				fieldHTML = fieldHTML + '</div>';
				fieldHTML = fieldHTML + '</div>';
		
<!-- Data Analyst Starts -->				
				fieldHTML =  fieldHTML + '<div class="tab-pane fade in tb-analysis" id="1c'+x+'" style="padding: 0; padding-top:15px;padding-left:30px;">';
			    fieldHTML = fieldHTML + '<select class="selectpicker" multiple title="X" data-style="btn-default" name="xanalytics['+(x-1)+'][]" id="xanalytics'+(x-1)+'" onchange="analytics(`x`,'+(x-1)+');updateChart();">';
				fieldHTML = fieldHTML + '<optgroup label="Model" data-max-options="1" id="xmodel'+(x-1)+'">';
				fieldHTML = fieldHTML + '			<option value="SUM" class="xselectnum'+(x-1)+'">SUM</option>';
				fieldHTML = fieldHTML + '			<option value="AVG" class="xselectnum'+(x-1)+'">AVG</option>';
				fieldHTML = fieldHTML + '			<option value="COUNT" class="xselectnum'+(x-1)+'">COUNT</option>';
				fieldHTML = fieldHTML + '			<option value="MAX" class="xselectnum'+(x-1)+'">MAX</option>';
				fieldHTML = fieldHTML + '			<option value="MIN" class="xselectnum'+(x-1)+'">MIN</option>';
				fieldHTML = fieldHTML + '			<option value="VAR" class="xselectnum'+(x-1)+'">VAR</option>';
				fieldHTML = fieldHTML + '			<option value="STD" class="xselectnum'+(x-1)+'">STDEV</option>';
				fieldHTML = fieldHTML + '			<option value="YEAR" class="xselectdate'+(x-1)+'">YEAR</option>';
				fieldHTML = fieldHTML + '			<option value="QTR" class="xselectdate'+(x-1)+'">QUARTER</option>';
				fieldHTML = fieldHTML + '			<option value="MON" class="xselectdate'+(x-1)+'">MONTH</option>';
				fieldHTML = fieldHTML + '		  </optgroup>';
				fieldHTML = fieldHTML + '		  <optgroup label="Sort" data-max-options="1" id="xsort'+(x-1)+'">';
				fieldHTML = fieldHTML + '			<option value="ASC">ASC</option>';
				fieldHTML = fieldHTML + '			<option value="DSC">DSC</option>';
				fieldHTML = fieldHTML + '		  </optgroup>';
				fieldHTML = fieldHTML + '		</select> ';
				fieldHTML = fieldHTML + '		<div><br/></div>';
				fieldHTML = fieldHTML + '		<select class="selectpicker" multiple title="Y" data-style="btn-default" name="yanalytics['+(x-1)+'][]" id="yanalytics'+(x-1)+'" onchange="analytics(`y`,'+(x-1)+');updateChart();">';
				fieldHTML = fieldHTML + '		  <optgroup label="Model" data-max-options="1" id="ymodel'+(x-1)+'">';
				fieldHTML = fieldHTML + '			<option value="SUM" class="yselectnum'+(x-1)+'">SUM</option>';
				fieldHTML = fieldHTML + '			<option value="AVG" class="yselectnum'+(x-1)+'">AVG</option>';
				fieldHTML = fieldHTML + '			<option value="COUNT" class="yselectnum'+(x-1)+'">COUNT</option>';
				fieldHTML = fieldHTML + '			<option value="MAX" class="yselectnum'+(x-1)+'">MAX</option>';
				fieldHTML = fieldHTML + '			<option value="MIN" class="yselectnum'+(x-1)+'">MIN</option>';
				fieldHTML = fieldHTML + '			<option value="VAR" class="yselectnum'+(x-1)+'">VAR</option>';
				fieldHTML = fieldHTML + '			<option value="STD" class="yselectnum'+(x-1)+'">STDEV</option>';
				fieldHTML = fieldHTML + '			<option value="YEAR" class="yselectdate'+(x-1)+'">YEAR</option>';
				fieldHTML = fieldHTML + '			<option value="QTR" class="yselectdate'+(x-1)+'">QUARTER</option>';
				fieldHTML = fieldHTML + '			<option value="MON" class="yselectdate'+(x-1)+'">MONTH</option>';
				fieldHTML = fieldHTML + '		  </optgroup>';
				fieldHTML = fieldHTML + '		  <optgroup label="Sort" data-max-options="1" id="ysort'+(x-1)+'">';
				fieldHTML = fieldHTML + '			<option value="ASC">ASC</option>';
				fieldHTML = fieldHTML + '			<option value="DSC">DSC</option>';
				fieldHTML = fieldHTML + '		  </optgroup>';
				fieldHTML = fieldHTML + '		</select>';
				fieldHTML = fieldHTML + '<div><br/></div>';
		
				fieldHTML = fieldHTML + '</div>'; //Data Analyst end

				fieldHTML = fieldHTML + '</div>'; //tab-content End
				fieldHTML = fieldHTML + '</div>'; //End
				
  
				$(wrapper).append(fieldHTML); // Add field html

			mySelection();
			//updateChart();
	
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked for PHP dynamic
        e.preventDefault();	
		document.getElementById("div-remove").remove();
		updateChart();
        x--; //Decrement field counter
		document.getElementById("trno").innerHTML = x;
		document.getElementById("ytitle-no").innerHTML = x;
		
		
    });
	
	 $('#div-remove').on('click', '.remove_button', function(e){ //Once remove button is clicked for JS 
        e.preventDefault();	
		document.getElementById("div-remove").remove();
		updateChart();
        x--; //Decrement field counter
		document.getElementById("trno").innerHTML = x;
		document.getElementById("ytitle-no").innerHTML = x;
		
    });

	/* SQL Buttons */
	var maxSQL = 10; //Input fields increment limitation
    var s = <?php echo $noofquery;?> ; //Initial field counter is 1
    var addSQLButton = $('.add-tab'); //Add button selector
    var sqlwrapper = $('.sql-tab-content'); //Input field wrapper
	var tabsinput = $('.sql-nav-tabs');
	
	$(addSQLButton).click(function(){ //Once add button is clicked
	
        if(s < maxSQL){ //Check maximum number of input fields
            s++; //Increment field counter
			   var SQLfieldHTML = '<li id="div-tabs-remove'+s+'">';;
				   SQLfieldHTML = SQLfieldHTML + '<a data-toggle="tab" href="#tab'+s+'" onclick="tabvalue('+s+')" style="float:left;"> &nbsp;&nbsp;  SQL '+s+'    </a>  ';    
				   SQLfieldHTML = SQLfieldHTML + '&nbsp;&nbsp;<a href="javascript:void(0);" class="remove-tab" title="Remove field" style="float:right;"> <span class="fa fa-minus-square-o" ></span></a>';
				   SQLfieldHTML = SQLfieldHTML + '</li>';
			       $(tabsinput).append(SQLfieldHTML); // Add field html
				   
				   
				   SQLfieldHTML = '<div id="tab'+s+'" class="tab-pane fade in">';
				   SQLfieldHTML = SQLfieldHTML +  '<div class="form-group" style="margin-bottom:5px;">';
				   SQLfieldHTML = SQLfieldHTML +  '<textarea class="form-control form-sql" rows="2" id="query'+s+'" name="query[]"  > </textarea>';
				   SQLfieldHTML = SQLfieldHTML +  '</div>';
				   SQLfieldHTML = SQLfieldHTML +  '<button type="submit" class="btn-xs btn-primary" name="runquery" value="true"><?php echo _TEXT['RUN_QUERY'];?></button>';
				   SQLfieldHTML = SQLfieldHTML +  '</div>';	
			       $(sqlwrapper).append(SQLfieldHTML); // Add field html
			   
			
			  }
    });
		     
			$(tabsinput).on('click', '.remove-tab', function(e){ //Once remove button is clicked
				e.preventDefault();	
				var tabsremove = 'div-tabs-remove'+s;
				document.getElementById(tabsremove).remove();
				var tabno = 'tab'+s;
				document.getElementById(tabno).remove();
				document.getElementById("query1").focus();
				var l = document.getElementById('myclick');
  				l.click();
				s--; //Decrement field counter			
			});	

});

function updateChart(){
	   		<?php 
	   			$source = $xmlDoc->col[$col]->source;
				$rdbms = $xmlDoc->col[$col]->rdbms;
	 			$servername  = $xmlDoc->col[$col]->servername ;
	 			$username = $xmlDoc->col[$col]->username ;
	 			$password = $xmlDoc->col[$col]->password;
	 			$dbname = $xmlDoc->col[$col]->dbname;
				$dbconnected = $xmlDoc->col[$col]->dbconnected;
				//$sql = $xmlDoc->col[$col]->sql[0];
				if ($source=="upload") {
					$sql = $xmlDoc->col[$col]->file;
					$sql = str_replace("\\", '~', $sql); 
				}
			?>
	  //var sql = "<?php echo $sql;?>";
	  var types = document.getElementsByName("type[]");
	  var xname = document.getElementsByName("X[]");
	  var yname = document.getElementsByName("Y[]");
	  var sizename = document.getElementsByName("size[]");
	  var textname = document.getElementsByName("text[]");
	  var tracename = document.getElementsByName("tracename[]");
	  var yntitle = document.getElementsByName("yntitle[]");
	  var colorname = document.getElementsByName("color[]");

	  var xtitle = document.getElementById('xaxistitle').value;
	  var ytitle = document.getElementById('yaxistitle').value;
		
	  if (document.getElementById('showgrid_hide').checked) {
			var showgrid = false;
			} else {
			var showgrid = true;
	   }

	   if (document.getElementById('showline_hide').checked) {
			var showline = false;
			} else {
			var showline = true;
	   }
	   
	   if (document.getElementById('orientation_v').checked) {
			var orientation = "v";
			} else {
			var orientation = "h";
		}
		
		if (document.getElementById('dropdown_show').checked) {
			var dropdown = "true";
			} else {
			var dropdown = "false";
		}
	  
	  var legposition  = document.getElementById('legposition').value;
	  
	  var typevalues = new Array();
	  var xvalues = new Array();
	  var yvalues = new Array();
	  var sizevalues = new Array();
	  var textvalues = new Array();
	  var tracenamevalues = new Array();
	  var yntitlevalues = new Array();
	  var colorvalues = new Array();
	  var maptypevalues = new Array();
	  var xmodel = new Array();
	  var ymodel = new Array();
	  var xsort = new Array();
	  var ysort = new Array();
	  
	  var i;
	  for (i = 0; i < types.length; i++) {
				if ((types[0].value == 'scatter3d') || (types[0].value == 'sunburst')) {
					typevalues[i] = types[0].value;
				} else {
					typevalues[i] = types[i].value;
				}
	  }


	  
	  for (i = 0; i < xname.length; i++) {
		  
				xvalues[i] = xname[i].value;
				//v = xname[i].options[xname[i].selectedIndex].text;
						
				v = getCol(xvalues[i]);

				s = document.getElementById('xanalytics'+i);
			    s.setAttribute('title', v);
				
				if (isType(v)=="number"){
					$('.xselectdate'+i).hide();
					$('.xselectnum'+i).show();
					s.options[0].setAttribute("title","SUM("+v+")");
					s.options[1].setAttribute("title","AVG("+v+")");
					s.options[2].setAttribute("title","COUNT("+v+")");
					s.options[3].setAttribute("title","MAX("+v+")");
					s.options[4].setAttribute("title","MIN("+v+")");
					s.options[5].setAttribute("title","VAR("+v+")");	
					s.options[6].setAttribute("title","STDEV("+v+")");	
									
				} else  {
					if (isType(v)=="date"){
						$('.xselectdate'+i).show();
						$('.xselectnum'+i).hide();
						s.options[7].setAttribute("title","YEAR("+v+")");
						s.options[8].setAttribute("title","QRT("+v+")");
						s.options[9].setAttribute("title","MONTH("+v+")");				
					} else {
						$('.xselectdate'+i).hide();
						$('.xselectnum'+i).hide();
					}
				}
				
				$(document).ready(function() {
				 $('#xanalytics'+i)
					.selectpicker({
					  title: v
					});

				//$('#xanalytics'+i).selectpicker('deselectAll');
				$('#xanalytics'+i).selectpicker('refresh');
				});
				
				
				
			// Analytics 
				var sortname  = "#xsort"+i;				
				var selected = $(sortname+' option:selected');
				xsort[i] = selected.val();
				
				var modelname  = "#xmodel"+i;				
				var selected = $(modelname+' option:selected');
				xmodel[i] = selected.val();
	  } 
	  

	  
	  for (i = 0; i < yname.length; i++) {
				yvalues[i] = yname[i].value;
				
				//v = yname[i].options[yname[i].selectedIndex].text;
				
				v = getCol(yvalues[i]);

				s = document.getElementById('yanalytics'+i);
			    s.setAttribute('title', v);
				
				
				if (isType(v)=="number"){
					$('.yselectdate'+i).hide();
					$('.yselectnum'+i).show();
					s.options[0].setAttribute("title","SUM("+v+")");
					s.options[1].setAttribute("title","AVG("+v+")");
					s.options[2].setAttribute("title","COUNT("+v+")");
					s.options[3].setAttribute("title","MAX("+v+")");
					s.options[4].setAttribute("title","MIN("+v+")");
					s.options[5].setAttribute("title","VAR("+v+")");	
					s.options[6].setAttribute("title","STDEV("+v+")");						
				} else  {
					if (isType(v)=="date"){
						$('.yselectdate'+i).show();
						$('.yselectnum'+i).hide();
						s.options[7].setAttribute("title","YEAR("+v+")");
						s.options[8].setAttribute("title","QRT("+v+")");
						s.options[9].setAttribute("title","MONTH("+v+")");					
					} else {
						$('.yselectdate'+i).hide();
						$('.yselectnum'+i).hide();
					}
				}
				
				$(document).ready(function() {
					 $('#yanalytics'+i)
						.selectpicker({
						  title: v
						});
					

				//x$('#yanalytics'+i).selectpicker('deselectAll');
				$('#yanalytics'+i).selectpicker('refresh');
				});
				
				// Analytics 
				var sortname  = "#ysort"+i;				
				var selected = $(sortname+' option:selected');
				ysort[i] = selected.val();
				
				var modelname  = "#ymodel"+i;				
				var selected = $(modelname+' option:selected');
				ymodel[i] = selected.val();
				
				
	  } 

	  
	  for (i = 0; i < sizename.length; i++) {
				sizevalues[i] = sizename[i].value;
	  } 
	  
	  for (i = 0; i < textname.length; i++) {
				textvalues[i] = textname[i].value;
	  }
	  
	  for (i = 0; i < tracename.length; i++) {
				tracenamevalues[i] = tracename[i].value;
	  }
	  
	  for (i = 0; i < yntitle.length; i++) {
				yntitlevalues[i] = yntitle[i].value;
	  }
	  
	  for (i = 0; i < colorname.length; i++) {
				colorvalues[i] = colorname[i].value;
	  }
	
	
	  if (types[0].value=='map') {
		  var maptype = document.getElementsByName("maptype[]");
		  for (i = 0; i < maptype.length; i++) {
					maptypevalues[i] = maptype[i].value;
		  }
	  }
	 
	  if ((xvalues[0] !='') || (types[0].value=='table')){
	 	$( "#chartupdate" ).load( "chartupdate.php" , { "type": typevalues, "source": "<?php echo $source ;?>", "rdbms": "<?php echo $rdbms;?>", "servername": "<?php echo $servername;?>", "username": "<?php echo $username;?>", "password": "<?php echo $password;?>", "dbname": "<?php echo $dbname;?>", "dbconnected": "<?php echo $dbconnected;?>","xvalues[]": xvalues, "yvalues[]": yvalues, "xmodel[]": xmodel, "xsort[]": xsort, "ymodel[]": ymodel, "ysort[]": ysort, "sizevalues[]": sizevalues, "textvalues[]": textvalues, "tracenamevalues[]": tracenamevalues,"yntitlevalues[]": yntitlevalues, "colorvalues[]": colorvalues, "orientation": orientation, "dropdown": dropdown, "legposition": legposition, "xaxistitle": xtitle, "yaxistitle": ytitle, "showgrid": showgrid, "showline": showline, "maptype": maptypevalues, "sql": "<?php echo $sql;?>" });
	  }
}

function analytics(_x, _trno) {

	var xsort = "#"+_x+"sort"+_trno;
	
	if (_x=="x") {
		var ysort = "#ysort"+_trno;
	} else {
		var ysort = "#xsort"+_trno;
	}

	 // Select Picker //
	$(".selectpicker").change(function(){

				var selected = $(xsort+' option:selected');
				if ((selected.val()=="ASC") || (selected.val()=="DSC")) { 
					$(ysort+" option:selected").removeAttr("selected");
				}

			$('.selectpicker').selectpicker('refresh');
	});
	
}

function isType(_data){
	table = document.getElementById("tabledata");
	td = table.rows[1].cells;
	search = _data;
	result = 'string';

	for (i = 0; i < td.length; i++) {
		x = document.getElementById("tabledata").rows[0].cells[i];
		y = document.getElementById("tabledata").rows[1].cells[i];	
		if (x.innerHTML==search) {
			return y.getAttribute("data-type");
			exit;
		}
	}
		return result;
}

function getCol (_data){ 
		var str = _data.replace("{col}", "<b>");
		    str = str.replace("{/col}", "</b>");
			var result = str.match(/<b>(.*?)<\/b>/g).map(function(val){
				   return val.replace(/<\/?b>/g,'');
				});
				return result;
}

	
$('#type').change(function(){
   //updateChart();
});

function chartProperties() {
   // restyle a single trace using attribute strings

		var xtitle = document.getElementById('xaxistitle').value;
		var ytitle = document.getElementById('yaxistitle').value;
		
		if (document.getElementById('showgrid_hide').checked) {
			var showgrid = false;
			} else {
			var showgrid = true;
		}

		if (document.getElementById('showline_hide').checked) {
			var showline = false;
			} else {
			var showline = true;
		}
		
		if (document.getElementById('dropdown_show').checked) {
			var dropdownmenu = true;
			} else {
			var dropdownmenu = false;
		}

		var leglayout = "v";
		var xleglayout = "";
		var yleglayout = "";
		
		if (document.getElementById('legposition').value == "bottomleft") {
			var leglayout = "h";
		} else if (document.getElementById('legposition').value == "topleft"){
			var leglayout = "h";
			var xleglayout = "0.0";
			var yleglayout = "1.2";
		} else if (document.getElementById('legposition').value == "topcenter"){
			var leglayout = "h";
			var xleglayout = "0.4";
			var yleglayout = "1.2";
		} else if (document.getElementById('legposition').value == "bottomcenter"){
			var leglayout = "h";
			var xleglayout = "0.4";
			var yleglayout = "0.-2";
		}
		
		else {
			var leglayout = "v";
			var xleglayout = "";
			var yleglayout = "";
		}

		var tracename = document.getElementsByName("tracename[]");
		var battonstext = new Array();
        var updatemenus =null;
		

		
		if (dropdownmenu==true) {
				for (i = 0; i < tracename.length; i++) {
				
				var vs = new Array(tracename.length).fill(false);
				vs[i] = [true];
				
				if (tracename[i].value=='') {
					tracename[i].value = 'Trace '+(i+1);
				}
				
				battonstext[i] = {method: "restyle",args: ["visible", vs],label: tracename[i].value};		
				}

				var updatemenus = [{
								y: 1.2,
								x:0.1,
								yanchor: 'right',
								buttons: battonstext
								}]
				
				var vs = new Array(tracename.length).fill(false);
				vs[0] = [true];				
				var update = {'visible':vs};
								
								
		}
		
		//var update = [];
		
		if (dropdownmenu==false) {
			var update = {visible:true};
		}

		 if(xtitle=='') {
		      xtitle ='X-axis';
		  }
		  if(ytitle=='') {
		      ytitle ='Y-axis';
		  }
		  
			var layout_update = {
				updatemenus: updatemenus,
				legend: {
					orientation: leglayout,
					x: xleglayout,
					y: yleglayout
					},
				xaxis: {
					title: xtitle, 
					showticklabels:true,
					showgrid: showgrid, 
					showline: showline	
					},
				yaxis: {
					title: ytitle, 
					showticklabels:true,
					showgrid: showgrid, 
					showline: showline	
					}
			};
		
		
		var gd = document.getElementById("collayoutsettings");
		Plotly.update(gd, update, layout_update);
}

</script>

<script>

$('#layoutsetting').submit(function() {
    $('.se-pre-modal').show();
});

  mySelection();
  //updateChart(); 
  

</script>
<?php 

if (empty($_POST['query'])){
	if(!empty($query[0])) {?>
	<script>
	
			document.getElementById("query1").focus();
			var l = document.getElementById('myclick');
  			l.click();
			var l = document.getElementById('btnrunquery');
  			l.click();
	</script>
	<?php	
	}
}
?>


