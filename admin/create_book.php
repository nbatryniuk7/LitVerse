<?php include '../server/connection.php'; 

if (isset($_POST['create_book'])) {

    $book_title = $_POST['title'];
    $book_description = $_POST['description'];
    $genre = $_POST['genre'];
    $book_price = $_POST['price'];
    $author = $_POST['author'];

    $image1 = $_FILES['image1']['tmp_name'];
    $image2 = $_FILES['image2']['tmp_name'];
    $image3 = $_FILES['image3']['tmp_name'];
    $image4 = $_FILES['image4']['tmp_name'];
    // $file_name = $_FILES['image1']['name'];

    $image_name1 = $book_title.'1.png';
    $image_name2 = $book_title.'2.png';
    $image_name3 = $book_title.'3.png';
    $image_name4 = $book_title.'4.png';

    // upload images
    move_uploaded_file($image1,"../assets/imgs/".$image_name1);
    move_uploaded_file($image2,"../assets/imgs/".$image_name2);
    move_uploaded_file($image3,"../assets/imgs/".$image_name3);
    move_uploaded_file($image4,"../assets/imgs/".$image_name4);

    //create a new user
    $stmt = $conn->prepare("INSERT INTO books (book_title, book_description, book_price, 
    book_image, book_image2, book_image3, book_image4, genre, author) 
    VALUES (?,?,?,?,?,?,?,?,?)");

    $stmt->bind_param('sssssssss', $book_title, $book_description, $book_price, 
    $image_name1, $image_name2, $image_name3, $image_name4, $genre, $author);

    if($stmt->execute()){
        header('location: books.php?book_created=Book has been created successfully!');
    }else{
        header('location: books.php?book_failed=Error occured, try again');
    }




}

?>