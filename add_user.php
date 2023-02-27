<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
secure();
include("includes/header.php");

if (isset($_POST["username"])) {
    if ($stm = $connect->prepare("INSERT INTO users (username,email,password,active) VALUES (?,?,?,?)")) {
        $hashed = SHA1($_POST["password"]);
        $stm->bind_param("ssss", $_POST["username"], $_POST["email"], $hashed, $_POST["active"]);
        $stm->execute();

        set_message("A new user " . $_SESSION["username"] . " has been added");
        header("Location: users.php");
        $stm->close();
        die();
    } else {
        echo "Could not prepare statement";
    }
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
                    <h1 class="display-3 text-center">Add User</h1>
                    <!--Form-->
                    <form method="POST">
                        <!-- Username input -->
                        <div class="form-outline my-4">
                            <input type="text" id="username" name="username" class="form-control" />
                            <label class="form-label" for="username">Username</label>
                        </div>
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <input type="email" id="email" name="email" class="form-control" />
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
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php



include("includes/footer.php");


?>