<?php

include('server/connection.php');

if(isset($_GET['book_id'])){

  $book_id = $_GET['book_id'];

  $stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
  $stmt->bind_param("i", $book_id);

  $stmt->execute();

  $book = $stmt->get_result();


  //no product id was given
} else {
  header('location: index.php');
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LitVerse | Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://pro.frontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHt0A93w35dYTsvhLPVnYs9eStHfGJv0vKxVfEGroGkvsg+p" crossorigin="anonymous"/>
    
    <link rel="stylesheet" href="assets/css/style.css"/>

    <style>
   

    </style>

</head>
<body>

    <!--Navbar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 fixed-top">
        <div class="container">
          <img class="logo"src="assets/imgs/z1.png" />
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


    <!--Single product-->  
    <section class = "container single-product my-5 pt-5">
        <div class = "row mt-5">
          <?php while($row = $book->fetch_assoc()){?>

            <div class = "col-lg-5 col-md-6 col-sm-12">
                <img class = "img-fluid w-30 pb-1" src = "assets/imgs/<?php echo $row['book_image'];?>" id = "mainImg"/>
                <div class = "small-img-group">
                <div class = "small-img-col">
                        <img src = "assets/imgs/<?php echo $row['book_image'];?>" width="30%" class = "small-img"/>
                    </div>
                    <div class = "small-img-col">
                        <img src = "assets/imgs/<?php echo $row['book_image2'];?>" width="30%" class = "small-img"/>
                    </div>
                    <div class = "small-img-col">
                        <img src = "assets/imgs/<?php echo $row['book_image3'];?>" width="30%" class = "small-img"/>
                    </div>
                    <div class = "small-img-col">
                        <img src = "assets/imgs/<?php echo $row['book_image4'];?>" width="30%" class = "small-img"/>
                    </div>

                </div>
            </div>
      
            <div class="col-lg-6 col-md-12 col-12">
                <h6><?php echo $row['genre']?></h6>
                <h3 class = "py-4"><?php echo $row['book_title']?></h3>
                <h2>₴<?php echo $row['book_price']?></h2>

                <form method = "POST" action = "cart.php">
              <input type = "hidden" name = "book_image" value = "<?php echo $row['book_image'];?>"/>
              <input type = "hidden" name = "book_title" value = "<?php echo $row['book_title'];?>"/>
              <input type = "hidden" name = "book_price" value = "<?php echo $row['book_price'];?>"/>

                <input type = "number" name = "book_quantity" value = "1"/>
                <button class = "buy-btn" type = "submit" name = "add_to_cart">Add To Card</button>
                </form>

                <h4 class = "mt-5 mb-5"><?php echo $row['author']?></h4>
                <span><?php echo $row['book_description'];?>
              </span>
            </div>
            
            <?php } ?>
        </div>
    </section>

      <!--Related products-->
      <section id = "related-products" class = "my-5 pb-5">
        <div class = "container text-center mt-5 py-5">
          <h3>Related products</h3>
          <hr class = "mx-auto">
        </div>
        <div class = "row mx-auto container-fluid">

        <div class = "product text-center col-lg-3 col-md-4 col-sm-12">
          <img class = "img-fluid mb-3" src = "assets/imgs/b1.jpg"/>
          <h5 class = "p-name">Gerald's Game</h5>
          <h4 class = "p-price">₴400.00</h4>
          <button class = "buy-btn">Buy Now</button>
        </div>

        <div class = "product text-center col-lg-3 col-md-4 col-sm-12">
          <img class = "img-fluid mb-3" src = "assets/imgs/b2.png"/>
          <h5 class = "p-name">God Emperor of Dune</h5>
          <h4 class = "p-price">₴490.00</h4>
          <button class = "buy-btn">Buy Now</button>
        </div>

        <div class = "product text-center col-lg-3 col-md-4 col-sm-12">
          <img class = "img-fluid mb-3" src = "assets/imgs/b3.png"/>
          <h5 class = "p-name">Schatten im Paradies</h5>
          <h4 class = "p-price">₴330.00</h4>
          <button class = "buy-btn">Buy Now</button>
        </div>

        <div class = "product text-center col-lg-3 col-md-4 col-sm-12">
          <img class = "img-fluid mb-3" src = "assets/imgs/b4.png"/>
          <h5 class = "p-name">Royal Assassin</h5>
          <h4 class = "p-price">₴490.00</h4>
          <button class = "buy-btn">Buy Now</button>
        </div>
      </div>
      </section>



    <!-- Footer -->
<footer class="mt-5 py-5">
    <div class="row container mx-auto pt-5">
      <div class="footer-one col-lg-3 col-md-6 col-sm-12">
        <img class = "logo2" src="assets/imgs/Designer-removebg-preview.png"/>
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
          <img src="assets/imgs/Visa-Mastercard.png"/>
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


  <script>
    var mainImg = document.getElementById("mainImg");
    var smallImg = document.getElementsByClassName("small-img");


    for(let i = 0; i < 4; i++){
        smallImg[i].onclick = function(){
        mainImg.src = smallImg[i].src;
        }
      }


  </script>


</body>
</html>