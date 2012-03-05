<div id="legend">
	<span id="legendtitle">Legend</span>
	<table id="legendtable">
		<tr>
			<td>
				<img src="<?php echo $_SESSION["themepath"]; ?>images/reservebutton.png" />
			</td>
			<td>
				 - Available
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo $_SESSION["themepath"]; ?>images/takenbutton.png" />
			</td>
			<td>
				 - Unavailable
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo $_SESSION["themepath"]; ?>images/cancelbutton.png" />
			</td>
			<td>
				 - Your Reservation
			</td>
		</tr>
		<tr>
			<td>
				<img src="<?php echo $_SESSION["themepath"]; ?>images/closedbutton.png" />
			</td>
			<td>
				 - Closed
			</td>
		</tr>
	</table>
	<script language="javaScript">
				
				function popUp(URL) {
				day = new Date();
				id = day.getTime();
				eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=500,height=500');");
				}

				</script>

				<center><a href="javascript:popUp('modules/policies.php');">Policies</a></center>
</div>
