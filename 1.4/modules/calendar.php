<?php
	if(!(isset($_SESSION["username"])) || empty($_SESSION["username"])){
		
	}
	else{
		?>
		<script language="javascript" type="text/javascript">
			document.getElementsByClassName = function(cl) {
				var retnode = [];
				var myclass = new RegExp('\\b'+cl+'\\b');
				var elem = this.getElementsByTagName('*');

				for (var i = 0; i < elem.length; i++) {
					var classes = elem[i].className;
					if (myclass.test(classes)) retnode.push(elem[i]);
				}

				return retnode;
			};
			
			var prevObj = "";
			var prevCur = "";
			
			function dayviewer(fromrange,torange,group,obj){
				allotherdays = document.getElementsByClassName('calendarday');
				for(var i=0; i<allotherdays.length; i++){
					if(obj != ''){
						allotherdays[i].style.background = "";
					}
				}
				if(document.getElementsByClassName('currentcalendarday')[0]){
					document.getElementsByClassName('currentcalendarday')[0].style.background = "";
				}
				if(obj != ""){
					//Set previous obj back to normal class
					if(prevObj != ''){
						if(prevCur == ""){
							prevObj.className = "calendarday";
						}
						else{
							prevObj.className = "currentcalendarday";
							prevCur = "";
						}
					}
					if(obj.className == "currentcalendarday"){
						prevCur = "yep";
					}
					//Change current obj to clicked class
					obj.className = "clickedday";
					//Save previous obj for later
					prevObj = obj;
				}
				
				
				//Get XML data from dayview.php
				try{
					req = new XMLHttpRequest();
				} catch(err1){
					try{
						req = new ActiveXObject("Msxm12.XMLHTTP");
					} catch(err2){
						try{
							req = new ActiveXObject("Microsoft.XMLHTTP");
						} catch(err3){
							req = false;
						}
					}
				}
				if(req != false) var xmlhttp = req;
				
				xmlhttp.onreadystatechange=function(){
					document.getElementById("rightside").innerHTML += "<div id='loader'></div>";
					if(xmlhttp.readyState==4){
						document.getElementById("loader").innerHTML = "";
						document.getElementById("dayviewModule").innerHTML = xmlhttp.responseText;
						if(xmlhttp.responseText == "Error: User is not logged in.") location.reload(true);
					}
					else{
						document.getElementById("dayviewModule").innerHTML = "";
						document.getElementById("loader").innerHTML = "<br\/><br\/><br\/><center><img src='<?php echo $_SESSION["themepath"]; ?>images\/ajax-loader.gif' \/><br\/>Please wait...<\/center>";
					}
				};
				
				urlstring = "modules/dayviewAJAX.php";
		
				params = "fromrange="+ fromrange +"&torange="+ torange +"&group="+ group +"&ajax_indicator=FALSE";
				
				xmlhttp.open("POST",urlstring,true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");	
				xmlhttp.send(params);
			};
			
			
			function ajaxFunction(month,year){
				try{
					req = new XMLHttpRequest();
				} catch(err1){
					try{
						req = new ActiveXObject("Msxm12.XMLHTTP");
					} catch(err2){
						try{
							req = new ActiveXObject("Microsoft.XMLHTTP");
						} catch(err3){
							req = false;
						}
					}
				}
				if(req != false) var xmlhttp = req;
				
				xmlhttp.onreadystatechange=function(){
					if(xmlhttp.readyState==4){
						document.getElementById("calendarModule").innerHTML = xmlhttp.responseText;
					}
				};
				
				var params = "";
				if(month != 0 && year != 0) params = "?month="+ month +"&year="+ year;
				
				xmlhttp.open("GET", "modules/calendarAJAX.php"+ params, true);
				xmlhttp.send(null);
			};
			
			ajaxFunction(0,0); //All params = 0 for current date to appear
			dayviewer(0,0,'',''); //All params = 0 or '' for current date's dayview to appear
		</script>
		<div id="calendarModule"></div>
		<?php
	}
?>
