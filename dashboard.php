<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
secure();
include("includes/header.php");


?>

<!--Form-->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <h1 class="display-1">Dashboard</h1>
            <a href="users.php" class="">Users management</a> |
            <a href="posts.php" class="">Posts management</a>
        </div>
    </div>
</div>


<?php
include("includes/footer.php");


?>