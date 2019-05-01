<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="../resources/favicon-train.ico" />
    <title>BOOkit-Home</title>

    <link rel="stylesheet" type="text/css" href="../fontawesome/css/all.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">

    <link rel="stylesheet" type="text/css" href="../Style/style-custom.css">
    <link rel="stylesheet" type="text/css" href="../Style/style-custom-nav.css">


    <script src="../Script/jquery-3.3.1.min.js"></script>
    <script src="../Script/Header.js"></script>

    <!--mdb-->
    <script src="../ExternalResources/MDB/js/popper.min.js"></script>
    <link href="../ExternalResources/MDB/css/mdb.min.css" rel="stylesheet">


    <!--Boostrap-->
    <link href="../ExternalResources/bootstrap-4.3.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="../ExternalResources/bootstrap-4.3.1/js/bootstrap.min.js"></script>


    <!--Jquery confirm-->
    <script src="../Script/jquery-confirm.min.js"></script>
    <link rel="stylesheet" href="../Style/jquery-confirm.min.css" />

    <script src="../Script/login.js"></script>
    <link rel="stylesheet" type="text/css" href="../Style/style-login.css"  >

    <script>

        //Jquery function for load nevigation to page

        $(document).ready(function () {
            //hide warning messages
            $('#spnPassWarning').hide();
            $('#spnReqWarning').hide();
        });


        $(function () {
            $('#Header').html(getHeaderLG());
            $('#footerID').html(getFooter());

            var verificationMail = readQueryString()["varificationMail"];
            if(verificationMail != null){
                $.ajax({
                    url: '../Controller/BIZ/logic.php',
                    type: 'post',
                    data: { "verificationEmail": verificationMail},
                    success: function(response) {

                        if(response == 'true'){
                            displayVerificationMessage(verificationMail);
                        }

                    }
                });
            }

        });

        function displayVerificationMessage(email) {
            $.confirm({
                title: 'Congratulations!',
                content: 'Your BOOKit account is Verified.\nYou are now a verified Bookit user('+email+'). You can now book unlimited Train Tickets with Bookit account.Also you ' +
                    'eligible for our mass discount offers.stay tuned with us.\n',
                type: 'blue',
                columnClass: 'medium',
                typeAnimated: true,
                theme: 'supervan',
                buttons: {
                    ok: {
                        text: 'OK',
                        btnClass: 'btn-green',
                        action: function(){
                        }
                    }
                }
            });
        }


        function readQueryString() {
            var vars = [], hash;

            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

            for (var i = 0; i < hashes.length; i++) {

                hash = hashes[i].split('=');

                vars.push(hash[0]);

                vars[hash[0]] = hash[1];

            }
            return vars;
        }

        function setSessionData($email) {
            $.ajax({
                url: '../Controller/BIZ/logic.php',
                type: 'get',
                data: { "getUserByEmail": $email},
                success: function(response) {
                    var userObj = $.parseJSON(response);

                    if(sessionStorage){
                        // Store data
                        sessionStorage.setItem("UserID", userObj["UserID"]);
                        sessionStorage.setItem("RoleID", userObj["FK_RoleID"]);
                        sessionStorage.setItem("FirstName", userObj["FirstName"]);
                        sessionStorage.setItem("LastName", userObj["LastName"]);
                        sessionStorage.setItem("Email", userObj["Email"]);
                        sessionStorage.setItem("Gender", userObj["FK_GenderID"]);
                        sessionStorage.setItem("ContactNo", userObj["ContactNo"]);
                        sessionStorage.setItem("DOB", userObj["DOB"]);
                        sessionStorage.setItem("DOB", userObj["DOB"]);

                        alert(sessionStorage.getItem("UserID"));
                    } else{
                        alert("Sorry, your browser do not support session storage.Please try another browser.");
                    }

                }
            });
        }

        function authenticateUser() {
            var email = $('#txtEmail').val();
            var password = $('#txtPassword').val();

            if(email.length == 0 || password.length == 0){
                $('#spnReqWarning').show();
                return;
            }

            var data = {     // create object
                AuthEmail    : email,
                AuthPassword    : password

            }

            $.ajax({
                url: '../Controller/BIZ/logic.php',
                type: 'post',
                data: data,
                success: function(response) {
                    var ss = $.parseJSON(response);
                    //alert(ss["auth"]);

                    if(ss["auth"] == 'true'){
                        setSessionData(email);
                    }

                }
            });
        }



    </script>



</head>

<body>
    <!--Navigation Bar -->
    <div id='Header'>
    </div>

    <div>

        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <div class="login100-pic js-tilt" data-tilt>
                        <img src="../resources/user.png" alt="IMG">
                    </div>

                    <div class="login100-form validate-form">
					<span class="login100-form-title">
						Member Login
					</span>

                        <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" id="txtEmail" name="email" placeholder="Email">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate = "Password is required">
                            <input class="input100" type="password" id="txtPassword" name="pass" placeholder="Password">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                        </div>
                        <span class="text-danger ml-3" id="spnPassWarning">Incorrect username or password</span>
                        <span class="text-danger ml-3" id="spnReqWarning">Fill all fields.</span>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn" onclick="authenticateUser()">
                                Login
                            </button>
                        </div>

                        <div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
                            <a class="txt2" href="#">
                                Username / Password?
                            </a>
                        </div>

                        <div class="text-center p-t-136">
                            <a class="txt2" href="#">
                                Create your Account
                                <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <footer id="footerID">

    </footer>
        <!--cannot read property 'addeventlistener' of null mdb
- This is probably because the script is executed before the page loads. By placing the script at the bottom of the page, I circumvented the problem.
-->
        <script src="../ExternalResources/MDB/js/mdb.min.js"></script>

</body>

</html>