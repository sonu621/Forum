<?php
$showError = "false";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection
    include 'partials/_dbconnect.php';  // Make sure this path is correct

    // Get user inputs
    $user_name = mysqli_real_escape_string($conn, $_POST['signupName']);
    $user_email = mysqli_real_escape_string($conn, $_POST['signupEmail']);  // Correct email field
    $user_password = $_POST['signuppassword'];
    $user_cpassword = $_POST['signupcpassword'];
    
    // Check whether this email exists
    $existsSql = "SELECT * FROM `users` WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $existsSql);
    $numRows = mysqli_num_rows($result);

    if ($numRows > 0) {
        $showError = "Email already in use!";
    } else {
        // Password match check
        if ($user_password == $user_cpassword) {
            // Hash the password before storing it
            $hash = password_hash($user_password, PASSWORD_DEFAULT);
            
            // Insert the user into the database
            $sql = "INSERT INTO `users` (`user_name`, `user_email`, `user_password`, `user_times`) VALUES ('$user_name', '$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);  // Use the correct SQL for insertion

            if ($result) {
                // Redirect to index.php with success message
                header("Location: /forum/index.php?signupsuccess=true");
                exit();  // Exit to prevent further script execution
            } else {
                // In case of any database issue
                $showError = "Something went wrong, please try again.";
            }
        } else {
            $showError = "Passwords do not match!";
        }
    }
    
    // Redirect with error message if there was any issue
    header("Location: /forum/index.php?signupsuccess=false&error=$showError");
    exit();  // Exit to prevent further script execution
}
 ?>