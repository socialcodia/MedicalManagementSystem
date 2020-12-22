<?php require_once dirname(__FILE__).'/include/outer/header.php'; ?>
<?php require_once dirname(__FILE__).'/include/api.php'; ?>

<?php
    if(isset($_POST['login']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $api = new Api();
        $loginResponse = $api->doLogin($email,$password);
        if(!$loginResponse->error)
        {
            $token = $loginResponse->user->token;
            setcookie("token",$token);
            $_SESSION['id'] = $loginResponse->user->id;
            $_SESSION['name'] = $loginResponse->user->name;
            $_SESSION['username'] = $loginResponse->user->username;
            $_SESSION['email'] = $loginResponse->user->email;
            $_SESSION['image'] = $loginResponse->user->image;
            header("LOCATION:dashboard");
        }
        else
        {
            $error = true;
            $message = $loginResponse->message;
        }
    }
?>
    <div class="row">
        <div class="col l4 offset-l4 m6 offset-m3 s12">
            <div class="card hoverable" style="border-radius: 20px; border: 10px ridge #9ea0a2; padding: 10px; margin-top: 160px; opacity: 2">
                <div class="card-content">
                    <h5 style="font-weight: bold;">Login</h5>
                    <p class="grey-text" style=" margin-bottom: 30px;">Login into your account to continue...</p>
                    <p class="red-text center-align"><b><?php if(isset($error) && $error==1 || isset($error) && $error==0) { echo $message; } ?></b></p>
                    <form action="" method="post">
                        <div class="input-field">
                            <i class="material-icons prefix red-text"><img src="src/icons/email_1.png" width="35" height="35"></i>
                            <input type="text"  name="email" id="email">
                            <label for="email">Enter Email</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix red-text"><img src="src/icons/password.png"  width="35" height="35"></i>
                            <input type="password" name="password" id="password">
                            <label for="password">Enter Password</label>
                        </div>
                        <div class="input-field center">
                            <input class="btn blue  " style="border-radius: 20px; height: 40px; width:90%;" value="Login" type="submit" name="login" id="login" >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php require_once dirname(__FILE__).'/include/outer/footer.php'; ?>
