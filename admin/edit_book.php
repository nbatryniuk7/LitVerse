<?php include 'header.php'; ?>

<?php 

    if($_GET['book_id']){

     $book_id = $_GET['book_id'];
    $stmt = $conn->prepare("SELECT * FROM books WHERE book_id=?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();

    $books = $stmt-> get_result();

    }elseif(isset($_POST['edit_btn'])){

    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $description = $_POST['description'];


    $stmt = $conn->prepare("UPDATE books SET book_title=?, author=?, genre=?, book_price=?, book_description=? 
    WHERE book_id=?");
    $stmt->bind_param("sssssi", $title, $author, $genre, $price, $description);

    if($stmt->execute()){
        header('location: books.php?edit_success_message=Product has been updated successfully');
    }else{
        header('location: books.php?edit_failure_message=Error occured, try again');
    }



}else{
    header('location: books.php');
    exit();
}

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

            <h2>Edit Book</h2>
            <div class="table-responsive">

            <div class="mx-auto container">
                <form id="edit-form" method="POST" action="edit_book.php">
                    <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];} ?></p> 

                    <?php foreach($books as $book){ ?>

                        <input type="hidden" name="book_id" value="<?php echo $book['book_id'];?>" />

                    <div class="form-group mt-2"></div>
                        <label>Title</label>
                        <input type="text" class="form-control" id="book-name" name="title" value="<?php echo $book['book_title'] ?>" placeholder="Title"/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Author</label>
                        <input type="text" class="form-control" id="author" name="author" value="<?php echo $book['author'] ?>" placeholder="Author"/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Genre</label>
                        <select class="form-select" required name="genre">
                            <option value="fiction">Fiction</option>
                            <option value="nonfiction">Nonfiction</option>
                            <option value="fantasy">Fantasy</option>
                            <option value="childrens-literature">Children`s literature</option>
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label>Price</label>
                        <input type="text" class="form-control" id="book-price" name="Price" value="<?php echo $book['book_price'] ?>" placeholder="Price"/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Description</label>
                        <input type="text" class="form-control" id="book-desc" name="description" value="<?php echo $book['book_description'] ?>" placeholder="Description"/>
                    </div>

                    <div class="form-group mt-3">
                        <input type="submit" class="btn btn-primary" name="edit-btn" value="Edit"/>
                    </div>

                    <?php } ?>

                </form>

            </div>

            



    </div>