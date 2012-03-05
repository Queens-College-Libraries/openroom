<?php
	session_start();
	
	include("../includes/or-dbinfo.php");
	
	if(!(isset($_SESSION["username"])) || $_SESSION["username"] == ""){
		echo "You are not logged in. Please <a href=\"../index.php\">click here</a> and login with an account that is an authorized administrator or reporter.";
	}
	elseif($_SESSION["isadministrator"] != "TRUE"){
		echo "You must be authorized as an administrator to view this page. Please <a href=\"../index.php\">go back</a>.<br/>If you believe you received this message in error, contact an administrator.";
	}
	elseif($_SESSION["systemid"] != $settings["systemid"]){
		echo "You are not logged in. Please <a href=\"../index.php\">click here</a> and login with an account that is an authorized administrator or reporter.";
	}
	else{
		
		$op = isset($_REQUEST["op"])?$_REQUEST["op"]:"";
		$optionformname = isset($_REQUEST["optionformname"])?$_REQUEST["optionformname"]:"";
		
		$successmsg = "";
		$errormsg = "";
		
		switch($op){
			case "deleteoption":
				//Delete from the table and subtract 1 from the optionorder of all fields with a higher order
				$record = mysql_fetch_array(mysql_query("SELECT * FROM optionalfields WHERE optionformname='". $optionformname ."';"));
				if(mysql_query("DELETE FROM optionalfields WHERE optionformname='". $optionformname ."';")){
					$allrecs = mysql_query("SELECT * FROM optionalfields;");
					while($arec = mysql_fetch_array($allrecs)){
						if($arec["optionorder"] > $record["optionorder"]){
							mysql_query("UPDATE optionalfields SET optionorder=". ($arec["optionorder"] - 1) ." WHERE optionformname='". $arec["optionformname"] ."';");
						}
					}
					
					mysql_query("DELETE FROM reservationoptions WHERE optionname='". $record["optionname"] ."';");
					
					$successmsg = $record["optionname"] ." has been deleted. <strong>You may want to update On Condition Emails under <a href=\"email.php\">Email Setup</a> if this field was set up as a condition.</strong>";
				}
				else{
					$errormsg = "There was a problem deleting the ". $record["optionname"] ." field. Please try again.";
				}
				//Delete all related records from the reservationoptions table
				break;
			case "addoption":
				$optionname = isset($_REQUEST["optionname"])?$_REQUEST["optionname"]:"";
				$optionquestion = isset($_REQUEST["optionquestion"])?$_REQUEST["optionquestion"]:"";
				$optiontype = isset($_REQUEST["optiontype"])?$_REQUEST["optiontype"]:"";
				$optionchoices = isset($_REQUEST["optionchoices"])?$_REQUEST["optionchoices"]:"";
				$optionprivate = isset($_REQUEST["optionprivate"])?$_REQUEST["optionprivate"]:"";
				$optionrequired = isset($_REQUEST["optionrequired"])?$_REQUEST["optionrequired"]:"";
				
				if($optionname != ""){
					if($optionquestion != ""){
						if(preg_match("/^[a-z]/", $optionformname)){
							if($optiontype == "0" || $optiontype == "1"){
								if($optiontype == "1" && $optionchoices != ""){
									$optionchoices = trim($optionchoices);
									$optionchoices = str_replace(" ", "", $optionchoices);
								}
								elseif($optiontype == "1" && $optionchoices == ""){
									$errormsg .= "Make sure to add Choices if you've chosen the Selection type.";
								}
								if($optionprivate == "0" || $optionprivate == "1"){
									if($optionrequired == "0" || $optionrequired == "1"){
										//Get highest order
										$ordera = mysql_fetch_array(mysql_query("SELECT * FROM optionalfields ORDER BY optionorder DESC;"));
										$highestorder = $ordera["optionorder"];
										if(mysql_query("INSERT INTO optionalfields VALUES('". $optionname ."','". $optionformname ."','". $optiontype ."','". $optionchoices ."',". ($highestorder + 1) .",'". $optionquestion ."',". $optionprivate .",". $optionrequired .");")){
											$successmsg = "New Custom Field has been added!";
										}
										else{
											$errormsg = "There was a problem adding this field to the database. Please try again.";
										}
									}
									else{
										$errormsg .= "Please select Yes or No for the Required field.";
									}
								}
								else{
									$errormsg .= "Please select Yes or No for the Private field.";
								}
							}
							else{
								$errormsg .= "Please select Text or Selection for the Type field.";
							}
						}
						else{
							$errormsg .= "Form Name may only be lowercase letters. No spaces allowed.";
						}
					}
					else{
						$errormsg .= "Please enter a Form Question.";
					}
				}
				else{
					$errormsg .= "The Name field is empty!";
				}
				break;
			case "incorder":
				$allcount = mysql_num_rows(mysql_query("SELECT * FROM optionalfields;"));
				$thisop = mysql_fetch_array(mysql_query("SELECT * FROM optionalfields WHERE optionformname='". $optionformname ."';"));
				$thispos = $thisop["optionorder"];
				if($thispos < ($allcount-1)){
					$nextop = mysql_fetch_array(mysql_query("SELECT * FROM optionalfields WHERE optionorder=". ($thispos + 1) .";"));
					$nextname = $nextop["optionformname"];
					mysql_query("UPDATE optionalfields SET optionorder=". $thispos ." WHERE optionformname='". $nextname ."';");
					mysql_query("UPDATE optionalfields SET optionorder=". ($thispos + 1) ." WHERE optionformname='". $optionformname ."';");
				}
				break;
			case "decorder":
				$allcount = mysql_num_rows(mysql_query("SELECT * FROM optionalfields;"));
				$thisop = mysql_fetch_array(mysql_query("SELECT * FROM optionalfields WHERE optionformname='". $optionformname ."';"));
				$thispos = $thisop["optionorder"];
				if($thispos > 0){
					$nextop = mysql_fetch_array(mysql_query("SELECT * FROM optionalfields WHERE optionorder=". ($thispos - 1) .";"));
					$nextname = $nextop["optionformname"];
					mysql_query("UPDATE optionalfields SET optionorder=". $thispos ." WHERE optionformname='". $nextname ."';");
					mysql_query("UPDATE optionalfields SET optionorder=". ($thispos - 1) ." WHERE optionformname='". $optionformname ."';");
				}
				break;
		}
		
		$lmresult = mysql_query("SELECT * FROM settings WHERE 1;");
		while($lmrecord = mysql_fetch_array($lmresult)){
			$settings[$lmrecord["settingname"]] = $lmrecord["settingvalue"];
		}
		
		
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title><?php echo $settings["instance_name"]; ?> - Administration - Custom Fields</title>
	<link rel="stylesheet" type="text/css" href="adminstyle.css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<script language="javascript" type="text/javascript">
		function confirmdelete(optionformname,optionname){
			var answer = confirm("Are you sure you want to delete the "+ optionname +" field?\n\nNOTE: Deleting this field will remove all references to it. Therefore, it will no longer appear in reports and there is no way to get this data back. PLEASE be absolutely sure you would like to delete this field.");
			if(answer){
				window.location = "customfields.php?op=deleteoption&optionformname="+optionformname;
			}
			else{
				
			}
		}
		
		function changer(value){
			if(value == 0){
				document.addoption.optionchoices.value="";
				document.addoption.optionchoices.disabled=true;
			}
			else{
				document.addoption.optionchoices.disabled=false;
			}
		}
	</script>
</head>

<body>
	<div id="heading"><span class="username"><?php echo isset($_SESSION["username"])?"<strong>Logged in as</strong>: ". $_SESSION["username"]:"&nbsp;"; ?></span>&nbsp;<?php echo ($_SESSION["isadministrator"] == "TRUE")?"<span class=\"isadministrator\">(Admin)</span>&nbsp;":""; echo ($_SESSION["isreporter"] == "TRUE")?"<span class=\"isreporter\">(Reporter)</span>&nbsp;":""; ?>|&nbsp;<a href="../index.php">Public View</a>&nbsp;|&nbsp;<a href="../modules/logout.php">Logout</a></div>
	<div id="container">
	<center>
	<?php if($_SESSION["isadministrator"] == "TRUE"){
		if($successmsg != ""){
			echo "<div id=\"successmsg\">". $successmsg ."</div>";
		}
		if($errormsg != ""){
			echo "<div id=\"errormsg\">". $errormsg ."</div>";
		}
	?>
	</center>
	<h3><a href="index.php">Administration</a> - Custom Fields</h3>
	<br/><br/>
	<table id="customfieldstable">
	<tr>
		<td class="tableheader">&nbsp;</td>
		<td class="tableheader">Name</td>
		<td class="tableheader">Form Name</td>
		<td class="tableheader">Form Question</td>
		<td class="tableheader">Type</td>
		<td class="tableheader">Choices*</td>
		<td class="tableheader">Private?</td>
		<td class="tableheader">Required?</td>
		<td class="tableheader">Delete</td>
	</tr>
	<?php
		$ofa = mysql_query("SELECT * FROM optionalfields ORDER by optionorder ASC;");
		$ofn = mysql_num_rows($ofa);
		$orderstr = "";
		$count = 0;
		while($of = mysql_fetch_array($ofa)){
			if($of["optiontype"] == 0){
				$oftype = "Text";
			}
			else{
				$oftype = "Selection";
			}
			
			if($of["optionprivate"] == 0){
				$ofprivate = "No";
			}
			else{
				$ofprivate = "Yes";
			}
			
			if($of["optionrequired"] == 0){
				$ofrequired = "No";
			}
			else{
				$ofrequired = "Yes";
			}
			
			if($count == 0){
				$orderstr = "<a href=\"customfields.php?op=incorder&optionformname=". $of["optionformname"] ."\"><img src=\"images/movedown.gif\" style=\"display: inline;border: 0px;\" /></a>";
			}
			elseif($count > 0 && $count < ($ofn - 1)){
				$orderstr = "<a href=\"customfields.php?op=incorder&optionformname=". $of["optionformname"] ."\"><img src=\"images/movedown.gif\" style=\"display: inline;border: 0px;\" /></a>&nbsp;<a href=\"customfields.php?op=decorder&optionformname=". $of["optionformname"] ."\"><img src=\"images/moveup.gif\" style=\"display: inline;border: 0px;\" /></a>";
			}
			else{
				$orderstr = "<a href=\"customfields.php?op=decorder&optionformname=". $of["optionformname"] ."\"><img src=\"images/moveup.gif\" style=\"display: inline;border: 0px;\" /></a>";
			}
			
			$thechoices = $of["optionchoices"];
			$choices = explode(';', $thechoices);
			$choicestr = "";
			foreach($choices as $choice){
				if($choice != ""){
					$choicestr .= $choice ." ";
				}
				else{
					$choicestr .= $choice;
				}
			}
			
			echo "<tr><td>". $orderstr.
				"</td><td><strong>". $of["optionname"].
				"</strong></td><td>". $of["optionformname"].
				"</td><td>". $of["optionquestion"].
				"</td><td>". $oftype .
				"</td><td>". $choicestr.
				"</td><td>". $ofprivate.
				"</td><td>". $ofrequired.
				"</td><td><a href=\"javascript:confirmdelete('". $of["optionformname"] ."','". $of["optionname"] ."');\">X</a></td></tr>";
			
			$count++;
		}
	?>
	</table>
	<br/>
	<br/>
	<h3>Add New Custom Field</h3><br/>
	<form name="addoption" action="customfields.php" method="POST">
		<table border="0">
			<tr>
				<td><strong>Name</strong></td><td><input type="text" name="optionname" /></td><td></td>
			</tr>
			<tr>
				<td><strong>Form Name</strong></td><td><input type="text" name="optionformname" /></td><td><span class="notetext">Must be all lowercase using only letters a-z, no spaces.</span></td>
			</tr>
			<tr>
				<td><strong>Form Question</strong></td><td><input type="text" name="optionquestion" /></td><td><span class="notetext">This is the prompt that will appear on the form.</span></td>
			</tr>
			<tr>
				<td><strong>Type</strong></td><td><select name="optiontype" onchange="changer(this.value);"><option value="0">Text</option><option value="1">Selection</option></select></td><td><span class="notetext">Select "Text" to allow any user input. Choose "Selection" to provide limited options.</span></td>
			</tr>
			<tr>
				<td><strong>Choices</strong></td><td><input type="text" name="optionchoices" disabled="disabled" /></td><td><span class="notetext">If you chose "Selection" above, type the available options here, separated by a semi-colon.<br/><em>(Ex.: Choice1;Choice2)</em></span></td>
			</tr>
			<tr>
				<td><strong>Private?</strong></td><td><select name="optionprivate"><option value="0">No</option><option value="1">Yes</option></select></td><td><span class="notetext">Will this field appear for all other users (when a reservation is clicked or when a search is performed)?</span></td>
			</tr>
			<tr>
				<td><strong>Required?</strong></td><td><select name="optionrequired"><option value="0">No</option><option value="1">Yes</option></select></td><td><span class="notetext">Is this field required before a user can make a reservation?</span></td>
			</tr>
			<tr>
				<td colspan="3">
					<input type="hidden" name="op" value="addoption" />
					<input type="submit" value="Add Custom Field" />
				</td>
			</tr>
		</table>
	</form>
	<?php
	}
	?>
	</div>
</body>
</html>
		<?php
	}
?>
