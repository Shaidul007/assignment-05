<?php
session_start();
// Check Login requset
if(isset($_GET['logout'])){
    logout();
}
// Login Request Check
if(isset($_GET['login'])){
    login();
}

// Form Request Method Check
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // registration Form Check
    if(isset($_POST['registration'])){
        registration();
    }

    if(isset($_POST['login'])){
        login();
    }
    //create new user
    if(isset($_POST['createUser'])){
        createUser();
    }
    //user update

    if(isset($_POST['updateUser'])){
        $id = $_POST['id'];
        updateUser($id);
    }
//delete user


}

//registration function
function registration(){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Collection Error Message Array
    $errors = [];

    // User Name Not Empty Check
    if(empty($username)){
        $errors['username'] = "User Name is Required";
    }

    // Email Not Empty Check
    if(empty($email)){
        $errors['email'] = "Email is Required";
    }
    // Password Not Empty Check
    if(empty($password)){
        $errors['password'] = "Password is Required";
    }
    // Password Length Check
    if (empty($password) || strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // Password Match Check 
    if ($password != $_POST['confirm_password']) {
        $errors[] = "Password did not match.";
    }

    // Email Already Exists Check
    if(isset($_SESSION['email'])){
        $data = file_get_contents('./Data/user.json');
        $data = json_decode($data, true);
        foreach ($data as $key => $value) {
            if($value['email'] == $email){
                $errors['email'] = "Email already exists";
            }
        }
    }

    // If No Error Found Then Save Data
    if(empty($errors)){
        // password encription
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        // Save Data to user.json file
        $data = file_get_contents('./Data/user.json');
        $data = json_decode($data, true);
        unset($_POST['confirm_password']);
        $_POST['id'] = rand( 100000, 999999);
        $_POST['password'] = $password;
        $_POST['role'] = 'user';
        $data[] = $_POST;
        file_put_contents('./Data/user.json', json_encode($data, JSON_PRETTY_PRINT));
        
        // Send Notification
        $_SESSION['notification'] = "User Registration Successful";
        $_SESSION['notification_type'] = "success";
        
        header("Location: login.php", true, 301);
    }else{
        $_SESSION['errors'] = $errors;
        header("Location: registration.php", true, 301);
    }
}


// login function
function login(){
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Collection Error Message Array
    $errors = [];

    // Email Not Empty Check
    if(empty($email)){
        $errors['email'] = "Email is Required";
    }
    // Password Not Empty Check
    if(empty($password)){
        $errors['password'] = "Password is Required";
    }
   
    //if no error found save data in Session

    if(empty($errors)){
        
        $data = file_get_contents('./Data/user.json');
        $data = json_decode($data, true);
        foreach ($data as $key => $value) {
            if($value['email'] == $email && password_verify($password, $value['password'])){
                $_SESSION['auth_id'] = $value['id'];
                $_SESSION['auth_username'] = $value['username'];
                $_SESSION['auth_email'] = $value['email'];
                $_SESSION['auth_password'] = $value['password'];
                $_SESSION['auth_role'] = $value['role'];

                // Send Notification
                $_SESSION['notification'] = "User Registration Successful";
                $_SESSION['notification_type'] = "success";
                
                header("Location: index.php", true, 301);
            }else{
                $errors['message'] = "Email or Password is incorrect";
                $_SESSION['errors'] = $errors;
                header("Location: login.php", true, 301);
            }
        }
    }else{
        $_SESSION['errors'] = $errors;
        header("Location: login.php", true, 301);
    }
}
//for login


// Logout Request function
function logout(){
    // Destroy Auth Session
    unset($_SESSION['auth_id']);
    unset($_SESSION['auth_username']);
    unset($_SESSION['auth_email']);
    unset($_SESSION['auth_password']);
    unset($_SESSION['auth_role']);

    // Send Notification
    $_SESSION['notification'] = "User Logout Successful";
    $_SESSION['notification_type'] = "success";
    header("Location: index.php", true, 301);
}

//create user function
function createUser(){

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Collection Error Message Array
    $errors = [];

    // User Name Not Empty Check
    if(empty($username)){
        $errors['username'] = "User Name is Required";
    }

    // Email Not Empty Check
    if(empty($email)){
        $errors['email'] = "Email is Required";
    }
    // Password Not Empty Check
    if(empty($password)){
        $errors['password'] = "Password is Required";
    }
    // Password Length Check
    if (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters.";
    }
    if ($password != $_POST['confirm_password']) {
        $errors[] = "Password did not match.";
    }

    // Role Match Check 
    if (empty($role)) {
        $errors['role'] = "Role is Required.";
    }

    // Email Already Exists Check
    if(isset($_SESSION['email'])){
        $data = file_get_contents('./Data/user.json');
        $data = json_decode($data, true);
        foreach ($data as $key => $value) {
            if($value['email'] == $email){
                $errors['email'] = "Email already exists";
            }
        }
    }

    // If No Error Found Then Save Data
    if(count($errors) >= 1){
        // Send Notification
        $_SESSION['notification'] = "User Create Failed!";
        $_SESSION['notification_type'] = "error";
        header("Location: dashboard.php", true, 301);
    }else{
        // password encription
        $password = password_hash($password, PASSWORD_DEFAULT);
        // Save Data to user.json file
        $data = file_get_contents('./Data/user.json');
        $data = json_decode($data, true);
        $_POST['id'] = rand( 100000, 999999);
        $_POST['password'] = $password;
        $_POST['role'] = $role;
        $data[] = $_POST;
        file_put_contents('./Data/user.json', json_encode($data, JSON_PRETTY_PRINT));
        
        // Send Notification
        $_SESSION['notification'] = "User Created Successful";
        $_SESSION['notification_type'] = "success";

        header("Location: dashboard.php", true, 301);
    }
}

//update user function
function updateUser($id){
    $username = $_POST["username"];
    $email = $_POST["email"];
    $role = $_POST["role"];

    // Collection Error Message Array
    $errors = [];

    // User Name Not Empty Check
    if(empty($username)){
        $errors['username'] = "User Name is Required.";
    }

    // Email Not Empty Check
    if(empty($email)){
        $errors['email'] = "Email is Required.";
    }

    // Role Match Check 
    if (empty($role)) {
        $errors['role'] = "Role is Required.";
    }

    // Email Already Exists Check
    if(isset($_SESSION['email'])){
        $data = file_get_contents('./Data/user.json');
        $data = json_decode($data, true);
        foreach ($data as $key => $value) {
            if($value['email'] == $email){
                $errors['email'] = "Email already exists.";
            }
        }
    }

    // If No Error Found Then Save Data
    if(count($errors) >= 1){
        // Send Notification
        $_SESSION['notification'] = "User Update Failed!";
        $_SESSION['notification_type'] = "error";
        header("Location: dashboard.php", true, 301);
    }else{
        // Save Data to user.json file
        $data = file_get_contents('./Data/user.json');
        $data = json_decode($data, true);
        foreach ($data as $key => $value) {
            if($value['id'] == $id){
                $data[$key]['username'] = $username;
                $data[$key]['email'] = $email;
                $data[$key]['role'] = $role;
            }
        }
        file_put_contents('./Data/user.json', json_encode($data, JSON_PRETTY_PRINT));
        
        // Send Notification
        $_SESSION['notification'] = "User Update Successful.";
        $_SESSION['notification_type'] = "success";

        header("Location: dashboard.php", true, 301);
    }
}

// delete user function

// if(isset($_GET['delete'])){
    
//     $id = $_GET['delete'];
//     $data = file_get_contents('./Data/user.json');
//     $data = json_decode($data, true);
//     foreach ($data as $key => $value) {
//         if($value['id'] == $id){
//             unset($data[$key]);
//         }
//     }
//     file_put_contents('./Data/user.json', json_encode($data, JSON_PRETTY_PRINT));
//     // Send Notification
//     $_SESSION['notification'] = "User Deleted Successful.";
//     $_SESSION['notification_type'] = "success";
//     header("Location: dashboard.php", true, 301);
// }

// 

if(isset($_GET['delete'])){
    $id= $_GET['delete'];
    $data = file_get_contents('./Data/user.json');
    $data = json_decode($data, true);
    foreach( $data as $key => $value){
        if($value ['id']== $id){
            unset($data[$key]);
        }
    }
file_put_contents('./Data/user.json', json_encode($data, JSON_PRETTY_PRINT));
    //set notification
    $_SESSION['notification'] = "User Deleted Successful.";
    $_SESSION['notification_type'] = "success";
    header("Location: dashboard.php", true, 301);
}