<?php 

session_start();

include'server/connection.php';

// if user has already logged in
if(isset($_SESSION['logged_in'])){
  header('location: account.php');
  exit;
}

if(isset($_POST['register'])) {

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

// if password dont match
if($password !== $confirmPassword) {
  header('location: register.php?error=Passwords dont match');

}

// if password is less than 6 char
elseif(strlen($password) < 6){
  header('location: register.php?error=Password must be at least 6 characters');
}

// if there is no error
else {
            // check whether there is a user with this email or not
            $stmt1 = $conn->prepare("SELECT count(*) FROM users where user_email=?");
            $stmt1->bind_param('s', $email);
            $stmt1->execute();
            $stmt1->bind_result($num_rows);
            $stmt1->store_result();
            $stmt1->fetch();

            // if there is a user already registered with this email
            if($num_rows != 0){
              header('location: register.php?error=User with this email already exists');
            }
            
            else{

            // create a new user
            $stmt = $conn->prepare("INSERT INTO users (user_name,user_email,user_password)
                  VALUES(?, ?, ?)");

            $stmt->bind_param('sss',$name,$email,md5($password));

            // if account was created successfully
            if($stmt->execute()){
                  $user_id = $stmt->insert_id;
                  $_SESSION['user_id'] = $user_id;
                  $_SESSION['user_email'] = $email;
                  $_SESSION['user_name'] = $name;
                  $_SESSION['logged_in'] = true;
                  header('location: account.php?register_success=You registered succesfully');
                  exit();

              // account could not be creared
            } else {
              header('location: register.php?error=Could not create an account at the moment');
          }
        }
      }
    } 
  


?>



<?php include"layouts/header.php"; ?>

      <!--Register-->
      <section class = "my-5 py-5">
        <div class = "container text-center mt-3 pt-5">
            <h2 class = "form-weight-bold">Register</h2>
            <hr class = "mx-auto">
        </div>
        <div class = "mx-auto container">
            <form id = "register-form" method="POST" action="register.php">
              <p style="color: red;"><?php if(isset($_GET['error'])) {echo $_GET['error']; }?></p>

                <div class = "form-group">
                    <label>Name</label>
                    <input type = "text" class = "form-control" id="register-name" name="name" placeholder="Name" required/>
                </div>
                
                <div class = "form-group">
                    <label>Email</label>
                    <input type = "text" class = "form-control" id="register-email" name="email" placeholder="Email" required/>
                </div>

                <div class = "form-group">
                    <label>Password</label>
                    <input type = "password" class = "form-control" id="register-password" name="password" placeholder="Password" required/>
                </div>

                <div class = "form-group">
                    <label>Confirm Password</label>
                    <input type = "password" class = "form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required/>
                </div>

                <div class = "form-group">
                    <input type = "submit" class = "btn" id="register-btn" name="register" value="Register"/>
                </div>

                <div class = "form-group">
                    <a id = "register-url" class = "btn" href="login.php">Do you have an account? Login</a>
                </div>

            </form>
        </div>
      </section>
    

      <?php include"layouts/footer.php"; ?>