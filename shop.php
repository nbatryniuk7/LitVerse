<?php

include "server/connection.php";




// use the search section
if(isset($_POST["search"])){

        // 1. determine page no
    if(isset($_GET['page_no']) && $_GET['page_no'] != ""){

        // if user has already entered page then page number is the one that they selected
        $page_no = $_GET['page_no'];

    } else {
        // if user just entered the page then default page is 1
        $page_no = 1;
    }

        $category = $_POST["category"];
        $price = $_POST["price"];

        // 2. return number of products
        $stmt1 = $conn->prepare("SELECT COUNT(*) AS total_records FROM books WHERE genre=? AND book_price<=?");
        $stmt1->bind_param("si",$category,$price);
        $stmt1->execute();
        $stmt1->bind_result($total_records);
        $stmt1->store_result();
        $stmt1->fetch();

        
        
        // 3. products per page
        $total_records_per_page = 8;

        $offset = ($page_no - 1) * $total_records_per_page;
    
        $previous_page = $page_no - 1;
        $next_page = $page_no + 1;
    
        $adjacents = "2";
        
        $total_no_of_pages = ceil($total_records/$total_records_per_page);


    // 4. get all products
    
    $stmt2 = $conn->prepare("SELECT * FROM books WHERE genre=? AND book_price<=? LIMIT $offset, $total_records_per_page");
    $stmt2->bind_param("si", $category,$price);
    $stmt2->execute();
    $books = $stmt2-> get_result();

    
    
    
        // return all products
    } else{
        // 1. determine page no
    if(isset($_GET['page_no']) && $_GET['page_no'] != ""){

        // if user has already entered page then page number is the one that they selected
        $page_no = $_GET['page_no'];

    } else {
        // if user just entered the page then default page is 1
        $page_no = 1;
    }


        
        // 2. return number of products
        $stmt = $conn->prepare("SELECT COUNT(*) AS total_records FROM books WHERE genre=? AND book_price<=?");
        $stmt->bind_param("si",$category,$price);
        $stmt->execute();
        $stmt->bind_result($total_records);
        $stmt->store_result();
        $stmt->fetch();

        
        
        // 3. products per page
    $total_records_per_page = 8;

    $offset = ($page_no - 1) * $total_records_per_page;

    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $adjacents = "2";

    $total_no_of_pages = ceil($total_records/$total_records_per_page);

        
    
    
    // 4. get all products

    $stmt2 = $conn->prepare("SELECT * FROM books LIMIT $offset, $total_records_per_page");
    $stmt2->execute();
    $books = $stmt2-> get_result();

}

?>

<?php include"layouts/header.php"; ?>

    <!--Shop-->
    <section id = "featured" class = "my-5 py-5">
        <div class = "container mt-5 py-5">
          <h3>Our books</h3>
          <hr>
          <p>Here you can check out our featured books</p>
        </div>

        <div class = "row mx-auto container">
                    <?php while($row = $books->fetch_assoc()){ ?>
                        <div onclick="window.location.href='<?php echo "single_product.php?book_id=". $row['book_id']; ?>';" class = "product text-center col-lg-3 col-md-4 col-sm-12">
                            <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['book_image']; ?>"/>
                            <h5 class="p-name"><?php echo $row['book_title']; ?></h5>
                            <h4 class="p-price">₴ <?php echo $row['book_price']; ?></h4>
                            <a href="<?php echo "single_product.php?book_id=". $row['book_id'];?>"><button class = "buy-btn">Buy Now</button></a>
                        </div>
                    <?php } ?>
       

         <!--Pagination-->           
            <nav aria-label="Page navigation example" class="mx-auto">
                <ul class="pagination mt-5 mx-auto">

                <li class="page-item <?php if($page_no<=1){echo 'disabled';} ?>">
                  <a class="page-link" href="<?php if($page_no <= 1){echo '#';} else{echo "page_no=".($page_no-1);} ?>">Previous</a>
                </li>

                <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
                <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>

                <?php if($page_no >= 3){ ?>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="<?php echo "?page_no=".$page_no;?>"><?php echo $page_no;?></a></li>
                <?php } ?>

                <li class="page-item <?php if($page_no >= $total_no_of_pages){echo 'disabled';}?>">
                    <a class="page-link" href="<?php if($page_no >= $total_no_of_pages){echo '#';} else{echo "page_no=".($page_no+1);} ?>">Next</a>
                </li>

            </ul>
            </nav>

       
       
        </div>

    </section>


    <?php include"layouts/footer.php"; ?>