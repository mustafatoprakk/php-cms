<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
secure();
include("includes/header.php");

// Update user
if (isset($_POST["username"])) {
    $stm = $connect->prepare("UPDATE users SET username=?,email=?,active=? WHERE id=?");
    $stm->bind_param("sssi", $_POST["username"], $_POST["email"], $_POST["active"], $_GET["id"]);
    $stm->execute();

    $stm->close();

    // Update password
    if ($_POST["password"]) {
        $stm = $connect->prepare("UPDATE users SET password=? WHERE id=?");
        $hashed = SHA1($_POST["password"]);
        $stm->bind_param("si", $hashed, $_GET["id"]);
        $stm->execute();

        $stm->close();
    } else {
        echo "Could not prepare password update statement!";
    }

    set_message("A user " . $_POST["username"] . " has been updated");
    header("Location: users.php");
} else {
    echo "Could not prepare user update statement!";
}



// Get user
if (isset($_GET["id"])) {
    $stm = $connect->prepare("SELECT * FROM users WHERE id=?");
    $stm->bind_param("s", $_GET['id']);
    $stm->execute();

    $result = $stm->get_result();
    $user = $result->fetch_assoc();
} else {
    echo "No user selected";
    die();
}

?>

<!--Form-->
<div class="container mt-5">
    <div class="row mb-3">
        <div class="col-md-6 offset-md-3">
            <div class="">
                <a href="users.php" class="btn btn-primary float-end">Back Users</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h1 class="display-3 text-center">Edit User</h1>
                    <!--Form-->
                    <form method="POST">
                        <!-- Username input -->
                        <div class="form-outline my-4">
                            <input type="text" id="username" name="username" class="form-control" value="<?= $user['username'] ?>" />
                            <label class="form-label" for="username">Username</label>
                        </div>
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="email" name="email" class="form-control " value="<?= $user['email'] ?>" />
                            <label class="form-label" for="email">Email address</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-4">
                            <input type="password" id="password" name="password" class="form-control" />
                            <label class="form-label" for="password">Password</label>
                        </div>
                        <!-- Active input -->
                        <div class="form-outline mb-4">
                            <select name="active" id="active" class="form-select">
                                <option <?= ($user['active']) ? "selected" : "" ?> value="1">Active</option>
                                <option <?= ($user['active']) ? "" : "selected" ?> value="0">Inactive</option>
                            </select>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php



include("includes/footer.php");


?>