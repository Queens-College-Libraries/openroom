<script language="javascript">
function ajaxFunction(){
		var xmlHttp;
		try{
			// Firefox, Opera 8.0+, Safari
			xmlHttp=new XMLHttpRequest();
		}
		catch (e){
			// Internet Explorer
			try{
				xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch (e){
				try{
					xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (e){
					alert("Your browser does not support AJAX!");
					return false;
				}
			}
		}
		
		xmlHttp.onreadystatechange=function(){
			if(xmlHttp.readyState==4){
				document.write(xmlHttp.responseText);
			}
		}
		
		urlstring = "../or-authenticate.php";
		
		params = "username=test&password=test&ajax_indicator=TRUE";
		
		xmlHttp.open("POST",urlstring,true);
		xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");	
		xmlHttp.send(params);
	}
</script>

<input type="button" onClick="ajaxFunction()" />
