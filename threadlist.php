<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iDiscuss - Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <?php include 'partials/_header.php'; ?>
    <?php include 'partials/_dbconnect.php'; ?>

    <?php
    $cat_id = $_GET['thread_id'];
    $sql = "SELECT * FROM `threads` WHERE thread_id = $cat_id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $threads_title = $row['thread_title'];
        $threads_desc = $row['thread_desc'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        //Insert into comment DB
        $comment = $_POST['comment'];

        $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$cat_id', '0', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> Your comment has been added!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
';
        }
    }
    ?>

    <div class="container my-4">
        <div class="jumbotron bg-secondary text-light p-4">
            <h4 class="display-4"><?php echo $threads_title; ?></h4>
            <p class="lead"><?php echo $threads_desc; ?></p>
            <hr class="my-4">
            <p>This is peer to peer forum for sharing the knowladge with each other. No spam / Adverstising /
                Self-promote in the forum is not allowed.</p>
            <p>Posted By: <b>Sonu</b></p>
        </div>
    </div>

    <div class="container">
        <h1 class="py-2">Post a Comment</h1>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>

    </div>


    <div class="container" style="height: 425px;">
        <h1 class="py-2">Discussions</h1>

        <?php
    
    $cat_id = $_GET['thread_id']; // Fetching thread ID from the URL
    $sql = "SELECT * FROM `comments` WHERE thread_id = $cat_id"; // Query to fetch comments based on thread_id
    $result = mysqli_query($conn, $sql);
    $noResult = true;

    while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        $comment_id = $row['comment_id']; // Fetching comment ID
        $content = $row['comment_content']; // Fetching comment content
        $comment_time = $row['comment_time']; // Fetching comment time (Assuming it's in a column 'comment_time')

        // Formatting the comment time (optional)
        $formatted_time = date('F j, Y, g:i a', strtotime($comment_time));

        echo '<div class="media d-flex">
                <img src="https://img.freepik.com/free-photo/3d-white-man-standing-with-hands-hips-3d-rendering_1142-59083.jpg?semt=ais_hybrid"
                    alt="..." width="30" height="30" style="border-radius: 50px;">
                <div class="media-body flex-grow-1 ms-2">
                <p class="fw-bold my-0">Anonymous User at ' . $formatted_time . '</p>
                    ' . $content . '
                </div>
            </div>';
    }

    if ($noResult) {
        echo '
        <h5 class="h5 text-left text-primary font-weight-bold mb-2">No Threads Found</h5>
            <p class="lead text-left text-muted font-italic mb-2">Be the first person to ask a question</p>
        ';
    }
?>

    </div>

    <?php include 'partials/_footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>