<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
secure();
include("includes/header.php");

if (isset($_GET["delete"])) {
    $stm = $connect->prepare("DELETE FROM posts WHERE id=?");
    $stm->bind_param("i", $_GET["delete"]);
    $stm->execute();

    set_message("A post " . $_GET["delete"] . " has been deleted!");
    header("Location: posts.php");
    $stm->close();
    $die();
}

if ($stm = $connect->prepare("SELECT * FROM posts")) {
    $stm->execute();

    $result = $stm->get_result();
    if ($result->num_rows > 0) {


?>

        <!--Form-->
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h1 class="display-1">Posts Management</h1>
                    <table class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Content</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= $record["id"] ?></td>
                                    <td><?= $record["title"] ?></td>
                                    <td><?= $record["author"] ?></td>
                                    <td><?= $record["content"] ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="edit_post.php?id=<?= $record["id"] ?>" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="posts.php?delete=<?= $record["id"] ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="float-end mt-4">
                        <a href="add_post.php" class="btn btn-primary">Add New User</a>
                    </div>
                </div>
            </div>
        </div>


<?php
    } else {
        echo "No posts found";
    }
    $stm->close();
} else {
    echo "Could not prepare statement";
}


include("includes/footer.php");


?>