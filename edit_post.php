<?php
include("includes/database.php");
include("includes/config.php");
include("includes/functions.php");
secure();
include("includes/header.php");

// Update post
if (isset($_POST["title"])) {
    $stm = $connect->prepare("UPDATE posts SET title=?, content=?, author=?, date=? WHERE id=?");
    $stm->bind_param("ssisi", $_POST["title"], $_POST["content"], $_POST["author"], $_POST["date"], $_GET["id"]);
    $stm->execute();

    $stm->close();

    set_message("A post " . $_POST["title"] . " has been updated");
    header("Location: posts.php");
} else {
    echo "Could not prepare post update statement!";
}



// Get post
if (isset($_GET["id"])) {
    $stm = $connect->prepare("SELECT * FROM posts WHERE id=?");
    $stm->bind_param("s", $_GET['id']);
    $stm->execute();

    $result = $stm->get_result();
    $post = $result->fetch_assoc();
} else {
    echo "No post selected";
    die();
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
                    <h1 class="display-3 text-center">Edit Post</h1>
                    <!--Form-->
                    <form method="POST">
                        <!-- title input -->
                        <div class="form-outline my-4">
                            <input type="text" id="title" name="title" class="form-control" value="<?= $post['title'] ?>" />
                            <label class="form-label" for="title">Title</label>
                        </div>
                        <!-- Author input -->
                        <div class="form-outline mb-4">
                            <input type="number" id="author" name="author" class="form-control " value="<?= $post['author'] ?>" />
                            <label class="form-label" for="author">Author</label>
                        </div>

                        <!-- content input -->
                        <div class="form-outline mb-4">
                            <textarea name="content" id="content"><?= $post['content'] ?></textarea>
                            <label class="form-label" for="content">Content</label>
                        </div>

                        <!-- date input -->
                        <div class="form-outline mb-4">
                            <input type="date" id="date" name="date" value="<?= $post['date'] ?>" class="form-control" />
                            <label class="form-label" for="date">Date</label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary btn-block">Update Post</button>
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