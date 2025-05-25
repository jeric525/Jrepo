<?php

include '../components/connect.php';

session_start();

// Check if the admin is already logged in
if (isset($_SESSION['admin_id'])) {
    header('location:dashboard.php');
    exit();
}

// Check if remember_me cookie is set
if (isset($_COOKIE['admin_remember_me'])) {
    $token = $_COOKIE['admin_remember_me'];

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE remember_me = ?");
    $select_admin->execute([$token]);
    
    if ($select_admin->rowCount() > 0) {
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];
        header('location:dashboard.php');
        exit();
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
    $select_admin->execute([$name, $pass]);
   
    if ($select_admin->rowCount() > 0) {
        $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
        $_SESSION['admin_id'] = $fetch_admin_id['id'];

        // Check if Remember Me checkbox is checked
        if (isset($_POST['remember']) && $_POST['remember'] == '1') {
            $token = bin2hex(random_bytes(32));
            $update_query = $conn->prepare("UPDATE `admin` SET remember_me = ? WHERE id = ?");
            $update_query->execute([$token, $fetch_admin_id['id']]);
            
            setcookie("admin_remember_me", $token, time() + 30 * 24 * 60 * 60);
        }

        header('location:dashboard.php');
        exit();
    } else {
        $message[] = 'Incorrect username or password!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

   <style>
      /* Adjust the style of the label for the Remember Me checkbox */
label[for="remember"] {
    display: block;
    margin-top: 10px;
    font-size: 14px;
    color: #333;
}

/* Style the checkbox itself */
input#remember {
    margin-right: 5px;
}

/* Customize the appearance of the checkbox (optional) */
input#remember[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 16px;
    height: 16px;
    border: 1px solid #ccc;
    border-radius: 3px;
    outline: none;
    cursor: pointer;
}

input#remember:checked {
    background-color: #2196F3;
    border: 1px solid #2196F3;
    color: #fff;
}

/* Style the message box for error messages */
.message {
    background-color: #f44336;
    color: white;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    position: relative;
}

.message i {
    position: absolute;
    top: 5px;
    right: 5px;
    cursor: pointer;
}
   </style>
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- admin login form section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>login now</h3>
      <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <label for="remember"><input type="checkbox" id="remember" name="remember" value="1">Remember Me</label><br><br>
      <input type="submit" value="login now" name="submit" class="btn">
   </form>

</section>

<!-- admin login form section ends -->

</body>
</html>
