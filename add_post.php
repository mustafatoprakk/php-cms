<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
secure();
include("includes/header.php");

if (isset($_POST["title"])) {
    if ($stm = $connect->prepare("INSERT INTO posts (title,content,author,date) VALUES (?,?,?,?)")) {
        $stm->bind_param("ssis", $_POST["title"], $_POST["content"], $_POST["author"], $_POST["date"]);
        $stm->execute();

        set_message("A new post " . $_SESSION["username"] . " has been added");
        header("Location: posts.php");
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
                <a href="posts.php" class="btn btn-primary float-end">Back Posts</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-body">
                    <h1 class="display-3 text-center">Add Post</h1>
                    <!--Form-->
                    <form method="POST">
                        <!-- title input -->
                        <div class="form-outline my-4">
                            <input type="text" id="title" name="title" class="form-control" />
                            <label class="form-label" for="title">Title</label>
                        </div>
                        <!-- Author input -->
                        <div class="form-outline mb-4">
                            <input type="number" id="author" name="author" class="form-control" />
                            <label class="form-label" for="author">Author</label>
                        </div>

                        <!-- content input -->
                        <div class="form-outline mb-4">
                            <textarea name="content" id="content"></textarea>
                            <label class="form-label" for="content">Content</label>
                        </div>

                        <!-- date input -->
                        <div class="form-outline mb-4">
                            <input type="date" id="date" name="date" class="form-control" />
                            <label class="form-label" for="date">Date</label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block">Add Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: '#content'
    });
</script>

<?php
include("includes/footer.php");
?>