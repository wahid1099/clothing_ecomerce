<?php
$active = "Login";
include("db.php");
include("functions.php");
include("header.php");
?>


<!-- Breadcrumb Section Begin -->
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="index.php"><i class="fa fa-home"></i> Home</a>
                    <span>Reset Password</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Form Section Begin -->

<!-- Register Section Begin -->
<div class="register-login-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="login-form">
                    <h2>Reset Password</h2>
                    <form action="reset_email.php" method="post">
                        <div class="group-input">
                            <label for="useremail">Email *</label>
                            <input type="text" id="useremail" name="useremail" placeholder="Enter email to get reset link" required>
                            <div id="email_error"></div>
                        </div>
                      

                        <button name="login" class="site-btn login-btn">Reset Password</button>
                    </form>
                   
                   

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Reset mail Form Section End -->


<?php
include('footer.php');
?>

</body>

</html>

<?php

if (isset($_POST['reset_email'])) {

}

?>