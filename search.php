<?php
include 'server/connection.php';  // Підключення до бази даних

$search = "";
if (isset($_GET['query'])) {
    $search = trim($_GET['query']);
    $sql = "SELECT * FROM books WHERE book_title LIKE ? OR author LIKE ?";
    $stmt = $conn->prepare($sql);
    $param = "%$search%";
    $stmt->bind_param("ss", $param, $param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM books";
    $result = $conn->query($sql);
}
?>


<!-- Navbar -->
<?php include"layouts/header.php"; ?>

<!-- Main Content -->
<div class="container mt-5 pt-5">
    <h2 class="text-center mb-4">Search Books</h2>

    <!-- Search Form -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="search.php" method="GET" class="input-group mb-4">
                <input type="text" name="query" class="form-control" placeholder="Enter book title or author" value="<?php echo htmlspecialchars($search); ?>" required>
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            </form>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="card mb-4 shadow-sm">
                        <img src="assets/imgs/<?php echo $row['book_image']; ?>" class="card-img-top" alt="<?php echo $row['book_title']; ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $row['book_title']; ?></h5>
                            <p class="card-text text-muted">by <?php echo $row['author']; ?></p>
                            <p class="card-text fw-bold text-danger">₴ <?php echo $row['book_price']; ?></p>
                            <a href="single_product.php?book_id=<?php echo $row['book_id']; ?>" class="btn btn-primary"><i class="fas fa-shopping-cart"></i> Buy Now</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted">No books found. Try another search.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Footer -->
<?php include"layouts/footer.php"; ?>
