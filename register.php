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





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LitVerse | Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://pro.frontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHt0A93w35dYTsvhLPVnYs9eStHfGJv0vKxVfEGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>

<body>
      <!--Navbar-->
      <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
        <div class="container">
          <img class="logo"src="assets/imgs/background/z1.png" />
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.html">Home</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="shop.html">Shop</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#">Blog</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Dropdown
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
              </li>
            </ul>
            <form class="d-flex">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

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
                    <a id = "register-url" class = "btn">Do you have an account? Login</a>
                </div>

            </form>
        </div>
      </section>
    


      <!-- Footer -->
      <footer class="mt-5 py-5">
        <div class="row container mx-auto pt-5">
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <img class = "logo2" src="assets/imgs/background/Designer-removebg-preview.png"/>
            <p class="pt-3">We provide the best books</p>
          </div>
      
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Featured</h5>
            <ul class="text-uppercase">
              <li><a href="#">Men</a></li>
              <li><a href="#">Women</a></li>
              <li><a href="#">Kids</a></li>
            </ul>
          </div>
      
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Contact Us</h5>
            <div>
              <h6 class="text-uppercase">Address</h6>
              <p>1234 Street Name, City</p>
            </div>
            <div>
              <h6 class="text-uppercase">Phone</h6>
              <p>123 456 7890</p>
            </div>
            <div>
              <h6 class="text-uppercase">Email</h6>
              <p>info@email.com</p>
            </div>
          </div>
      
          <div class="footer-one col-lg-3 col-md-6 col-sm-12">
            <h5 class="pb-2">Instagram</h5>
            <div class="row">
              <!-- <img src="img1.jpg" class="img-fluid w-25 h-100 m-2" alt="Instagram Image 1" /> -->
              <!-- <img src="img2.jpg" class="img-fluid w-25 h-100 m-2" alt="Instagram Image 2" /> -->
              <!-- <img src="img3.jpg" class="img-fluid w-25 h-100 m-2" alt="Instagram Image 3" /> -->
              <!-- <img src="img4.jpg" class="img-fluid w-25 h-100 m-2" alt="Instagram Image 4" /> -->
            </div>
          </div>
        </div>
      
        <div class="copyright mt-5">
          <div class="row container mx-auto">
      
            <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
              <img src="assets/imgs/background/--Navbar--Visa-Mastercard.png"/>
            </div>
      
            <div class="col-lg-3 col-md-5 col-sm-12 mb-4 text-nowrap mb-2">
              <p>eCommerce © 2025 All Rights Reserved</p>
            </div>
      
            <div class="col-lg-3 col-md-5 col-sm-12 mb-4">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
          </div>
        </div>
      </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>