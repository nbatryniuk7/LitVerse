<?php include '../server/connection.php'; 

if (isset($_POST['update_images'])) {

    $book_title = $_POST['book_title'];
    $book_id = $_POST['book_id'];

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
    $stmt = $conn->prepare("UPDATE books SET book_image=?, book_image2=?, book_image3=?, book_image4=? WHERE book_id=?"); 

    $stmt->bind_param('ssssi', $image_name1, $image_name2, $image_name3, $image_name4, $book_id);

    if ($stmt->execute()) {
        header('location: books.php?images_updated=Images has been updated successfully');
        exit();
    } else {
        header('location: books.php?images_failed=Error occurred, try again');
        exit();
    }
    




}

?>