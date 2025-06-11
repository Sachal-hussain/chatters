<?php
// include_once("connect_me.php");
error_reporting(0);
session_start();

$error = '';

if(isset($_SESSION['user_data']["type"]) && isset($_SESSION["user_data"]["department"]))
{
    
    if($_SESSION["user_data"]["type"]=='CSR'){
        header('location:agents/redeem_form.php');
        exit;
    }
    else if($_SESSION["user_data"]["department"]=='Redeem'){

        header('location:redeem/allpageslist.php');
        exit;
    }
}

if(isset($_POST['login']))
{
    $shifts = array(
        array('name' => 'Morning', 'start' => '08:00', 'end' => '16:00'),
        array('name' => 'Evening', 'start' => '16:00', 'end' => '00:00'),
        array('name' => 'Night', 'start' => '00:00', 'end' => '08:00')
    );

    $currentShift = getCurrentShift($shifts);

    require_once('database/ChatUser.php');

    $user_object = new ChatUser;

    $user_object->setUserName($_POST['txt_username']);

    $user_data = $user_object->get_user_data_by_email();

    if($currentShift!=$user_data['shift'] && ($user_data['type']!='Webmaster' && $user_data['type']!='Manager' && $user_data['type']!='Q&A' && $user_data['type']!='Verification')){
        $error='Your Shift has been Closed &#128523.Please reach out to the manager.';
        // header('location:index.php');
    }
    else{
        if(is_array($user_data) && count($user_data) > 0)
        {
            if($user_data['status'] == 'Active')
            {
                if($user_data['upass'] == md5($_POST['txt_password']) || $user_data['upass'] == $_POST['txt_password'])
                {
                    $last_active=date('Y-m-d H:i:s');

                    $user_object->setUserId($user_data['id']);

                    $user_object->setUserLoginStatus('Login');

                    $user_object->setLastLogin($last_active);

                    $user_token = md5(uniqid());

                    $user_object->setUserToken($user_token);

                    if($user_object->update_user_login_data())
                    {
                        $_SESSION['user_data'] = [
                            'id'        =>  $user_data['id'],
                            'fname'     =>  $user_data['fullname'],
                            'uname'     =>  $user_data['uname'],
                            'upass'     =>  $user_data['upass'],
                            'email'     =>  $user_data['email'],
                            'avtar'     =>  $user_data['avtar'],
                            'contact'   =>  $user_data['contact'],
                            'type'      =>  $user_data['type'],
                            'online'    =>  'Login',
                            'token'     =>  $user_token,
                            'reports'   =>  $user_data['reports'],
                            'department'   =>  $user_data['department'],
                            'shift'     =>  $user_data['shift'],
                            'pg_id'     =>  $user_data['pgid'],
                            'checklist' =>  $user_data['checklist'],
                            'storeright' =>  $user_data['store'],
                            'profitreport' =>  $user_data['profit']




                        ];
                        if($user_data['type']=='Webmaster'){

                            header('location:admin/dashboard');
                        }
                        if($user_data['type']=='CSR'){

                            header('location:agents/redeem_form');
                        }
                        if($user_data['department']=='Redeem'){

                            header('location:redeem/allpageslist');
                        }
                        if($user_data['type']=='Manager' && $user_data['department']=='Live Chat'){

                            header('location:manager/alluserdetails.php');
                        }
                        if($user_data['type']=='Q&A' || $user_data['type']=='Verification'){

                            header('location:qa/pendingredeemlist');
                        }
                        // print_r($_SESSION);

                    }
                }
                else
                {
                    $error = 'Wrong Password';
                }
            }
            else
            {
                $error = 'Your Account has been Deactivated.';
            }
        }
        else
        {
            $error = 'Wrong User Name';
        }
    }
}

?>
<!doctype html>
<html lang="en">

<head>

        <meta charset="utf-8" />
        <title>Chatters 2.0 | SHJ International</title>
        <?php require("links.html"); ?>
        <style >
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background: linear-gradient(10deg, #2c4766, #072a48);
            }
            .container {
                position: relative;
                width: 256px;
                height: 256px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .container span {
                position: absolute;
                left: 0;
                width: 32px;
                height: 6px;
                background: #2c4766;
                border-radius: 8px;
                transform-origin: 128px;
                transform: scale(2.2) rotate(calc(var(--i) * (360deg / 50)));
                animation: animateBlink 3s linear infinite;
                animation-delay: calc(var(--i) * (3s / 50));
            }
            @keyframes animateBlink {
                0% {
                    background: #0ef;
                }
                25% {
                    background: #2c4766;
                }
            }
            .login-box {
                position: absolute;
                width: 400px;
            }
            .login-box form {
                width: 100%;
                padding: 0 50px;
            }
            h2 {
                font-size: 2em;
                color: #0ef;
                text-align: center;
            }
            .input-box {
                position: relative;
                margin: 25px 0;
            }
            .input-box input {
                width: 100%;
                height: 50px;
                background: transparent;
                border: 2px solid #2c4766;
                outline: none;
                border-radius: 40px;
                font-size: 1em;
                color: #fff;
                padding: 0 20px;
                transition: .5s ease;
            }
            .input-box input:focus,
            .input-box input:valid {
                border-color: #0ef;
            }
            .input-box label {
                position: absolute;
                top: 50%;
                left: 20px;
                transform: translateY(-50%);
                font-size: 1em;
                color: #fff;
                pointer-events: none;
                transition: .5s ease;
            }
            .input-box input:focus~label,
            .input-box input:valid~label {
                top: 1px;
                font-size: .8em;
                background: #1f293a;
                padding: 0 6px;
                color: #0ef;
            }
            .forgot-pass {
                margin: -15px 0 10px;
                text-align: center;
            }
            .forgot-pass a {
                font-size: .85em;
                color: #fff;
                text-decoration: none;
            }
            .forgot-pass a:hover {
                text-decoration: underline;
            }
            .btn {
                width: 100%;
                height: 45px;
                background: #0ef;
                border: none;
                outline: none;
                border-radius: 40px;
                cursor: pointer;
                font-size: 1em;
                color: #1f293a;
                font-weight: 600;
            }
            .signup-link {
                margin: 20px 0 10px;
                text-align: center;
            }
            .signup-link a {
                font-size: 1em;
                color: #0ef;
                text-decoration: none;
                font-weight: 600;
            }
            .signup-link a:hover {
                text-decoration: underline;
            }
        </style>
    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->
       <!--  <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-xxl-4 col-lg-4 col-md-5">
                        <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5 text-center">
                                        <a href="index.html" class="d-block auth-logo">
                                            <img src="assets/images/logo-login.png" alt="" height="75"> <span class="logo-txt"></span>
                                        </a>
                                    </div>
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Welcome Back !</h5>
                                            <p class="text-muted mt-2">Sign in to continue to Chatter.</p>
                                        </div>
                                        <?php
                                            if($error != '')
                                            {
                                                echo '
                                                <div class="alert alert-danger">
                                                '.$error.'
                                                </div>
                                                ';
                                            }
                                        ?>
                                        <form action="#" method="post">
                                            <div class="mb-3">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control" name="txt_username" id="txt_username" placeholder="Enter username">
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Password</label>
                                                    </div>
                                                   
                                                </div>
                                                
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" class="form-control" name="txt_password" id="txt_password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                 
                                                </div>
                                            </div>
                                          
                                            <div class="mb-3">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit" name="login">Sign In</button>
                                            </div>
                                        </form>

                                        <div class="mt-4 pt-2 text-center">
                                            <div class="signin-other-title">
                                                <h5 class="font-size-14 mb-3 text-muted fw-medium">- Sign in with -</h5>
                                            </div>

                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="javascript:void()"
                                                        class="social-list-item bg-primary text-white border-primary">
                                                        <i class="mdi mdi-facebook"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void()"
                                                        class="social-list-item bg-info text-white border-info">
                                                        <i class="mdi mdi-twitter"></i>
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void()"
                                                        class="social-list-item bg-danger text-white border-danger">
                                                        <i class="mdi mdi-google"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                       
                                    </div>
                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Chatter <i class="mdi mdi-heart text-danger"></i> by SHJ INTERNATIONAL</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                   
                    <div class="col-xxl-8 col-lg-8 col-md-7">
                        <div class="auth-bg pt-md-5 p-4 d-flex">
                            <div class="bg-overlay bg-primary"></div>
                            <ul class="bg-bubbles">
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                                <li></li>
                            </ul>
                          
                            <div class="row justify-content-center align-items-center">
                                <div class="col-xl-7">
                                    <div class="p-0 p-sm-4 px-xl-0">
                                        <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators carousel-indicators-rounded justify-content-start ms-0 mb-0">
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
                                          
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“I feel confident
                                                            imposing change
                                                            on myself. It's a lot more progressing fun than looking back.
                                                            That's why
                                                            I ultricies enim
                                                            at malesuada nibh diam on tortor neaded to throw curve balls.”
                                                        </h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                           
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="carousel-item">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“Our task must be to
                                                            free ourselves by widening our circle of compassion to embrace
                                                            all living
                                                            creatures and
                                                            the whole of quis consectetur nunc sit amet semper justo. nature
                                                            and its beauty.”</h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                         
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="carousel-item">
                                                    <div class="testi-contain text-white">
                                                        <i class="bx bxs-quote-alt-left text-success display-6"></i>

                                                        <h4 class="mt-4 fw-medium lh-base text-white">“I've learned that
                                                            people will forget what you said, people will forget what you
                                                            did,
                                                            but people will never forget
                                                            how donec in efficitur lectus, nec lobortis metus you made them
                                                            feel.”</h4>
                                                        <div class="mt-4 pt-3 pb-5">
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
              
            </div>
          
        </div> -->
        <div class="container">

            <div class="login-box">
                <h2>CHATTER - LOGIN</h2>
                <?php
                    if($error != '')
                    {
                        echo '
                        <div class="alert alert-danger">
                        '.$error.'
                        </div>
                        ';
                    }
                ?>
                <form action="#" method="post">
                    <div class="input-box">
                       <input type="text" class="form-control" name="txt_username" id="txt_username"  required>
                        <label>Username</label>
                    </div>
                    <div class="input-box">
                        <!-- <input type="password" required> -->
                         <input type="password" class="form-control" name="txt_password" id="txt_password"  required>
                        <label>Password</label>
                    </div>
                   <!--  <div class="forgot-pass">
                        <a href="#">Forgot your password?</a>
                    </div> -->
                   <button class="btn btn-info w-100 waves-effect waves-light" type="submit" name="login">Login</button>
                   <!--  <div class="signup-link">
                        <a href="#">Signup</a>
                    </div> -->
                </form>
            </div>
            <span style="--i:0;"></span>
            <span style="--i:1;"></span>
            <span style="--i:2;"></span>
            <span style="--i:3;"></span>
            <span style="--i:4;"></span>
            <span style="--i:5;"></span>
            <span style="--i:6;"></span>
            <span style="--i:7;"></span>
            <span style="--i:8;"></span>
            <span style="--i:9;"></span>
            <span style="--i:10;"></span>
            <span style="--i:11;"></span>
            <span style="--i:12;"></span>
            <span style="--i:13;"></span>
            <span style="--i:14;"></span>
            <span style="--i:15;"></span>
            <span style="--i:16;"></span>
            <span style="--i:17;"></span>
            <span style="--i:18;"></span>
            <span style="--i:19;"></span>
            <span style="--i:20;"></span>
            <span style="--i:21;"></span>
            <span style="--i:22;"></span>
            <span style="--i:23;"></span>
            <span style="--i:24;"></span>
            <span style="--i:25;"></span>
            <span style="--i:26;"></span>
            <span style="--i:27;"></span>
            <span style="--i:28;"></span>
            <span style="--i:29;"></span>
            <span style="--i:30;"></span>
            <span style="--i:31;"></span>
            <span style="--i:32;"></span>
            <span style="--i:33;"></span>
            <span style="--i:34;"></span>
            <span style="--i:35;"></span>
            <span style="--i:36;"></span>
            <span style="--i:37;"></span>
            <span style="--i:38;"></span>
            <span style="--i:39;"></span>
            <span style="--i:40;"></span>
            <span style="--i:41;"></span>
            <span style="--i:42;"></span>
            <span style="--i:43;"></span>
            <span style="--i:44;"></span>
            <span style="--i:45;"></span>
            <span style="--i:46;"></span>
            <span style="--i:47;"></span>
            <span style="--i:48;"></span>
            <span style="--i:49;"></span>
        </div>
        <?php require("footer_links.html"); ?>
       
    </body>

</html>
<?php 

    // Function to determine the current shift
    function getCurrentShift($shifts) {
        date_default_timezone_set("Asia/Karachi");
        $currentTime = date('H:i'); // Get the current time in 24-hour format (e.g., "15:30")
        
        foreach ($shifts as $shift) {
            $shiftStart = $shift['start'];
            $shiftEnd = $shift['end'];
            
            if ($shiftStart <= $shiftEnd) {
                // Shift doesn't cross midnight
                if ($shiftStart <= $currentTime && $currentTime < $shiftEnd) {
                    return $shift['name']; // Return the name of the current shift
                }
            } else {
                // Shift crosses midnight
                if ($shiftStart <= $currentTime || $currentTime < $shiftEnd) {
                    return $shift['name']; // Return the name of the current shift
                }
            }
        }
        
        return 'No Shift'; // Return this if no shift is found
    }


?>