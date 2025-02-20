    <?php include 'header.php'; ?>

    <?php

    if(!isset($_SESSION['admin_logged_in'])){
        header('location: login.php');
        exit();
    }


    ?>


    <?php 

    
        // 1. determine page no
    if(isset($_GET['page_no']) && $_GET['page_no'] != ""){

        // if user has already entered page then page number is the one that they selected
        $page_no = $_GET['page_no'];

    } else {
        // if user just entered the page then default page is 1
        $page_no = 1;
    }


        
        // 2. return number of products
        $stmt = $conn->prepare("SELECT COUNT(*) AS total_records FROM orders");
        $stmt->execute();
        $stmt->bind_result($total_records);
        $stmt->store_result();
        $stmt->fetch();

        
        
        // 3. products per page
    $total_records_per_page = 5;

    $offset = ($page_no - 1) * $total_records_per_page;

    $previous_page = $page_no - 1;
    $next_page = $page_no + 1;

    $adjacents = "2";

    $total_no_of_pages = ceil($total_records/$total_records_per_page);

        
    
    
    // 4. get all products

    $stmt2 = $conn->prepare("SELECT * FROM orders LIMIT $offset, $total_records_per_page");
    $stmt2->execute();
    $orders = $stmt2-> get_result();


    ?>



    <div class="container-fluid">
        <div class="row" style="min-height: 1000px">
            


        <?php include 'sidemenu.php'; ?>





        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"> 
                <h1 class="h2">Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                    </div>
                </div>
            </div>

            <p>Welcome to admin panel!</p>

        </main>
        </div>
        </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
</body>
</html>
