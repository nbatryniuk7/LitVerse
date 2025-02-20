<?php

session_start();

include '../server/connection.php';

if(!isset($_SESSION['admin_logged_in'])){
    header('location: login.php');
    exit();
}


if(isset($_GET['book_id'])){
    $book_id = $_GET['book_id'];
    $stmt = $conn->prepare("DELETE FROM books WHERE book_id=?");
    $stmt->bind_param("i", $book_id);
    
    if($stmt->execute()){

        header('location: books.php?deleted_successfully=Product has been deleted successfully');

    }else{
        header('location: books.php?deleted_failure=Could not delete product');
    }
}

?>