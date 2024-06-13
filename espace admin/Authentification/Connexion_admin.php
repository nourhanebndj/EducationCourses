<?php 
require("../php/Connexion_bdd.php"); 

function input_filter($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if form is submitted
if(isset($_POST['login'])) {
    $Admin_Name = input_filter($_POST['Admin_Name']);
    $Admin_Pass = input_filter($_POST['Admin_Pass']);

    $Admin_Name = mysqli_real_escape_string($con, $Admin_Name);
    $Admin_Pass = mysqli_real_escape_string($con, $Admin_Pass);
    $query = "SELECT * FROM `admin_login` WHERE `Admin_Name`=? AND `Admin_password`=?";

    if($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt, 'ss', $Admin_Name, $Admin_Pass);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1) {
            session_start();
            $_SESSION['AdminLoginId'] = $Admin_Name;
            header("location: ../Dashboard.php");

        } else {
            echo "<script>alert('Invalid Admin Name or Password');</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('SQL Query cannot be prepared');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Connexion Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>

<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="login-form">
                <h2>Connexion Admin</h2>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <input type="text" placeholder="Admin Username" name="Admin_Name" required>
                    <input type="password" placeholder="mot de passe" name="Admin_Pass" required>
                    <button type="submit" name="login">Connexion</button>
                </form>
            </div>
            <div class="login-image">
                <img src="../images/education.jpg">
            </div>
        </div>
    </div>
</body>

</html>