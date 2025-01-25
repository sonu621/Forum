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
    $cat_id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` WHERE category_id=$cat_id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $cat_name = $row['category_name'];
        $cat_desc = $row['category_description'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == 'POST'){
        //Insert into thread DB
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];

        // $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$cat_id', '0', current_timestamp())";
        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$cat_id', '0', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your thread has been added! Please wait while someone response.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        }
    }
    ?>

    <div class="container my-4">
        <div class="jumbotron bg-secondary text-light p-4">
            <h4 class="display-4">Hello Welcome to the <?php echo $cat_name; ?> Forums!</h4>
            <p class="lead"><?php echo $cat_desc; ?></p>
            <hr class="my-4">
            <p>This is peer to peer forum for sharing the knowladge with each other. No spam / Adverstising /
                Self-promote in the forum is not allowed.</p>
            <a href="#" class="btn btn-light btn-lg">Learn More</a>
        </div>
    </div>

    <div class="container">
        <h1 class="py-2">Ask a Questions</h1>
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep your title as short and crisp</div>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Ask your query</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>

    </div>

    <div class="container my-4" style="height: 425px;">
        <h1 class="py-2">Browse Questions</h1>

        <?php
    
        $cat_id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $cat_id";
        $noResult = true;

        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
        $noResult = false;
        
        $threads_id = $row['thread_id'];
        $threads_title = $row['thread_title'];
        $threads_desc = $row['thread_desc'];
        $threads_time = $row['timestamp']; // Fetching comment time (Assuming it's in a column 'comment_time')

        // Formatting the comment time (optional)
        $formatted_time = date('F j, Y, g:i a', strtotime($threads_time));

        echo '<div class="media d-flex mb-3">
    <img src="https://img.freepik.com/free-photo/3d-white-man-standing-with-hands-hips-3d-rendering_1142-59083.jpg?semt=ais_hybrid"
         alt="..." width="30" height="30" style="border-radius: 50px;">
    <div class="media-body flex-grow-1 ms-3">
        <p class="fw-bold my-0">Anonymous User at '. $formatted_time .'</p>
        <h5 class="mt-0">
            <a style="text-decoration: none;" href="threadlist.php?thread_id='. $threads_id .'"> 
                '. $threads_title .'
            </a>
        </h5>
        <p style="line-height: 1.6; margin-top: -0.5rem;">
           '. $threads_desc .'
        </p>
    </div>
</div>

    ';
    }
    if($noResult){
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