<script language="javascript" type="text/javascript">
	function getScrollXY() {
		var scrOfX = 0, scrOfY = 0;
		if( typeof( window.pageYOffset ) == 'number' ){
			//Netscape compliant
			scrOfY = window.pageYOffset;
			scrOfX = window.pageXOffset;
		}
		else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ){
			//DOM compliant
			scrOfY = document.body.scrollTop;
			scrOfX = document.body.scrollLeft;
		} else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ){
			//IE6 standards compliant mode
			scrOfY = document.documentElement.scrollTop;
			scrOfX = document.documentElement.scrollLeft;
		}
		return [ scrOfX, scrOfY ];
	}
	
	function roomDetails(str){
		var roomDetails = document.getElementById("roomdetails");
		roomDetails.style.visibility = "visible";
		roomDetails.style.display = "block";
		roomDetails.innerHTML = str;
		var staticy = getScrollXY()[1] - 150;
		if(staticy < 0) staticy = 0;
		roomDetails.style.top = staticy +"px";
	}
</script>
<div id="roomdetails"></div>
