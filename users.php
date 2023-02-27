<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
secure();
include("includes/header.php");

if (isset($_GET["delete"])) {
    $stm = $connect->prepare("DELETE FROM users WHERE id=?");
    $stm->bind_param("i", $_GET["delete"]);
    $stm->execute();

    set_message("A user " . $_GET["delete"] . " has been deleted!");
    header("Location: users.php");
    $stm->close();
    $die();
}

if ($stm = $connect->prepare("SELECT * FROM users")) {
    $stm->execute();

    $result = $stm->get_result();
    if ($result->num_rows > 0) {


?>

        <!--Form-->
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <h1 class="display-1">Users Management</h1>
                    <table class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>Id</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($record = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?= $record["id"] ?></td>
                                    <td><?= $record["username"] ?></td>
                                    <td><?= $record["email"] ?></td>
                                    <td><?= $record["active"] ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="edit_user.php?id=<?= $record["id"] ?>" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="users.php?delete=<?= $record["id"] ?>" class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class="float-end mt-4">
                        <a href="add_user.php" class="btn btn-primary">Add New User</a>
                    </div>
                </div>
            </div>
        </div>


<?php
    } else {
        echo "No users found";
    }
    $stm->close();
} else {
    echo "Could not prepare statement";
}


include("includes/footer.php");


?>