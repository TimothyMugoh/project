<?php
	require('includes/config.php');
	session_start();
$username = "";
$email = "";
$errors = [];
	if(!empty($_POST))
	{   if (empty($_POST['fnm'])) {
        $errors['fnm'] = 'your name required';
    }
	if(!empty($_POST))
	{   if (empty($_POST['unm'])) {
        $errors['unm'] = 'Username required';
    }
	if (empty($_POST['pwd'])) {
        $errors['pwd'] = 'Password required';
    }
    if (isset($_POST['pwd']) && $_POST['pwd'] !== $_POST['cpwd']) {
        $errors['cpwd'] = 'The two passwords do not match';
    }
	if(!empty($_POST))
	{   if (empty($_POST['gender'])) {
        $errors['gender'] = 'gender required';
    }
    if (empty($_POST['mail'])) {
        $errors['mail'] = 'Email required';
    }
	if (empty($_POST['contact'])) {
        $errors['contact'] = 'contact required';
    }
	if (empty($_POST['city'])) {
        $errors['city'] = 'city required';
    }
    

    $fname = $_POST['fnm'];
    $gender = $_POST['gender'];
	$city = $_POST['city'];
    
	$username = $_POST['unm'];
    $email = $_POST['mail'];
	$contact = $_POST['contact'];
    $token = bin2hex(random_bytes(50)); // generate unique token
    $password = password_hash($_POST['pwd'], PASSWORD_DEFAULT); //encrypt password

    // Check if email already exists
    

    if (count($errors) === 0) {
        $query = "INSERT INTO users SET fnm=?,unm=?,u_pwd=?,u_gender=?, u_email=?,u_contact=?,u_city=?, token=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssssss', $fname,$username,$password,$gender, $email,$contact, $city,$token );
        $result = $stmt->execute();

        if ($result) 
            $user_id = $stmt->insert_id;
            $stmt->close();

            // TO DO: send verification email to user
            // sendVerificationEmail($email, $token);

            $_SESSION['u_id'] = $user_id;
            $_SESSION['fnm'] = $username;
            $_SESSION['mail'] = $email;
            $_SESSION['verified'] = false;
            $_SESSION['message'] = 'You are logged in!';
            $_SESSION['type'] = 'alert-success';
            header('location: index.php');
        } else {
            $_SESSION['error_msg'] = "Database error: Could not register user";
			
        }
    }
	}}
		
?>