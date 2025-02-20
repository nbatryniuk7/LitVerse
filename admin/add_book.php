<?php include 'header.php'; ?>

    <?php

    if(!isset($_SESSION['admin_logged_in'])){
        header('location: login.php');
        exit();
    }


    ?>



<div class="container-fluid">
        <div class="row" style="min-height: 1000px">
            


        <?php include 'sidemenu.php'; ?>

        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">  
           <h1 class="h2">Add Book</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
            </div>
        </div>
        </div>


            <div class="table-responsive">

            <div class="mx-auto container">
                <form id="create-form" enctype="multipart/form-data" method="POST" action="create_book.php">
                    <p style="color: red;"><?php if(isset($_GET['error'])){ echo $_GET['error'];} ?></p> 

                    <div class="form-group mt-2">
                        <label>Title</label>
                        <input type="text" class="form-control" id="book-name" name="title" placeholder="Title"/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Author</label>
                        <input type="text" class="form-control" id="author" name="author" placeholder="Author"/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Genre</label>
                        <select class="form-select" required name="genre">
                            <option value="Fiction">Fiction</option>
                            <option value="Nonfiction">Nonfiction</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Children`s literature">Children's literature</option>
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label>Price</label>
                        <input type="text" class="form-control" id="book-price" name="price" placeholder="Price"/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Description</label>
                        <input type="text" class="form-control" id="book-desc" name="description" placeholder="Description"/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Image 1</label>
                        <input type="file" class="form-control" id="image1" name="image1" placeholder="Image 1"/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Image 2</label>
                        <input type="file" class="form-control" id="image2" name="image2" placeholder="Image 2"/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Image 3</label>
                        <input type="file" class="form-control" id="image3" name="image3" placeholder="Image 3"/>
                    </div>

                    <div class="form-group mt-2">
                        <label>Image 4</label>
                        <input type="file" class="form-control" id="image4" name="image4" placeholder="Image 4"/>
                    </div>

                    <div class="form-group mt-3">
                        <input type="submit" class="btn btn-primary" name="create_book" value="Add"/>
                    </div>

        

                </form>

            </div>












            </div>