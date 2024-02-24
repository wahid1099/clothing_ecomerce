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
                    <span>Login</span>
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
                    <h2>Login</h2>
                    <form action="login.php" method="post">
                        <div class="group-input">
                            <label for="username">Email *</label>
                            <input type="text" id="username" name="cemail" required>
                            <div id="email_error"></div>
                        </div>
                        <div class="group-input">
                            <label for="pass">Password *</label>
                            <input type="password" id="pass" name="password" required>
                            <div id="password_error"></div>
                        </div>

                        <button name="login" class="site-btn login-btn">Sign In</button>
                    </form>
                    <div class="switch-login">
                        <a href="register.php" class="or-login">Or Create An Account</a>
                    </div>
                    <div class="switch-login">
                        <a href="reset_email.php" class="or-login">Reset Password</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Register Form Section End -->


<?php
include('footer.php');
?>

</body>

</html>

<?php

if (isset($_POST['login'])) {


    $log_email = $_POST['cemail'];
    $log_pass = $_POST['password'];
    $c_id = $log_email;


    




    $sel_customer = "select * from customer where customer_email = '$log_email' AND customer_pass = '$log_pass'";

    $run_sel_c = mysqli_query($con, $sel_customer);

    $get_ip = getRealIpUser();

    $check_customer = mysqli_num_rows($run_sel_c);

    $select_cart = "select * from cart where c_id = '$c_id'";

    $run_sel_cart = mysqli_query($con, $select_cart);

    $check_cart = mysqli_num_rows($run_sel_cart);

    if ($check_customer == 0) {

        echo "
        <script>
                bootbox.alert({
                    message: 'Invalid Username or Password',
                    backdrop: true
                });
        </script>";
        exit();
    }

    if ($check_customer == 1 and $check_cart == 0) {
        $customer_data = mysqli_fetch_assoc($run_sel_c); // Fetch the customer data

        $_SESSION['customer_email'] = $log_email;
        $_SESSION['user_role'] = $customer_data['user_role']; // Set the user role in the session

        if ($customer_data['user_role'] == 'admin') {
            $_SESSION['admin'] = true;

            echo "<script>window.open('./admin/dashboard.php','_self')</script>";
        } else{
        echo  "<script>window.open('index.php?stat=1','_self')</script>";


        }

    } else {
        $_SESSION['customer_email'] = $log_email;

    
        echo  "<script>window.open('check-out.php?','_self')</script>";
    }
}

?>