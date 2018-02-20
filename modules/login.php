<script type="text/javascript">
    function ajaxAuthenticate() {
        var xmlHttp;
        try {
            // Firefox, Opera 8.0+, Safari
            xmlHttp = new XMLHttpRequest();
        }
        catch (e) {
            // Internet Explorer
            try {
                xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e) {
                try {
                    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                catch (e) {
                    alert("Your browser does not support AJAX!");
                    return false;
                }
            }
        }

        xmlHttp.onreadystatechange = function () {
            if (xmlHttp.readyState == 4) {
                var xmldoc = xmlHttp.responseXML;
                var authenticated = xmldoc.getElementsByTagName('authenticated')[0].firstChild.nodeValue;
                var errormessage = xmldoc.getElementsByTagName('errormessage')[0].firstChild;

                if (authenticated == "false") {
                    if (errormessage.nodeValue == "No such object") errormessage.nodeValue = "Incorrect username or password.";
                    document.getElementById('errormessage').style.visibility = "visible";
                    document.getElementById('errormessage').innerHTML = ("<strong>Error: <\/strong>" + errormessage.nodeValue);
                }
                else {
                    window.location.href = "index.php";
                }
            }
        };
        urlstring = "or-authenticate.php";

        params = "username=" + encodeURIComponent(document.getElementById("authentication").username.value) + "&password=" + encodeURIComponent(document.getElementById("authentication").password.value) + "&ajax_indicator=TRUE";

        xmlHttp.open("POST", urlstring, true);
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlHttp.send(params);
    }

    function init() {
        document.getElementsByTagName('input')[0].focus();
    }

    window.onload = init;

</script>

<div id="loginform">
    <form id="authentication" onsubmit="return false" action="">
          <div id="loginusername" class = "row">
              <div class = "col-lg-4 usernamelabel">
                  <span id="loginusernamelabel">Olivet Username:</span>
              </div>
              <div class = "col-lg-8 usernamefield">
                  <input alt="Enter your Olivet Username" type="text" name="username" id="usernamefield"
                         class="textfield" placeholder="Your Olivet Username" autofocus="autofocus"/>
              </div>
          </div>

          <div id="loginpassword" class = "row">
              <div class = "col-lg-4">
                  <span id="loginpasswordlabel">Password:</span>
              </div>
              <div class = "col-lg-8">
                  <input alt="Enter your Olivet Password" type="password" name="password" id="passwordfield"
                         class="textfield" placeholder="Your Olivet password"/>
              </div>
          </div>
          <div class = "row">
              <div class = "col-lg-8">
                  <input id="loginsubmitbutton" class="button btn btn-primary" type="submit" value="Log In"
                         onclick="ajaxAuthenticate()"/><br/>
                  <?php
                  if ($settings["login_method"] == "normal") {
                      echo "<span class=\"registrationlink\"><a href=\"createaccount.php\">Create Account</a></span><br/><br/>";
                  }
                  ?>
            </div>
          </div>
        <!--</ul>-->
    </form>
    <div id="errormessage"></div>
</div>
