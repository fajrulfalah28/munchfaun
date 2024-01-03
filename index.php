<?php
	@ob_start();
	session_start();
	if(isset($_POST['proses'])){
		require 'config.php';
			
		$user = mysqli_real_escape_string($conn,($_POST['user']));
		$pass = md5($_POST['pass']);

        $data = mysqli_query($conn,"SELECT * FROM admin WHERE username='$user' AND password ='$pass'");
        $cek = mysqli_num_rows($data);
        if($cek > 0){
            $_SESSION['username'] = $user;
            $_SESSION['status'] = "login";
            echo '<script>alert("Login Sukses");window.location="pos.php"</script>';
        }
        else if (empty($user) || empty($pass)) {
            echo '<script>alert("Maaf! Harap lengkapi semua data.");history.go(-1);</script>';
        }
        else{
            echo '<script>alert("Maaf! data yang anda masukan salah.");history.go(-1);</script>';
        }
	}

    if(isset($_SESSION['status']))
    {header('location: pos.php');
    }
    
    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        header('location: index.php');
        exit();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MunchFaun</title>
    <meta name="author" content="David Grzyb">
    <meta name="description" content="">

    <!-- Tailwind -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #3d68ff; }
        .cta-btn { color: #3d68ff; }
        .upgrade-btn { background: #1947ee; }
        .upgrade-btn:hover { background: #0038fd; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
        .account-link:hover { background: #3d68ff; }
    </style>
</head>
<body>
<div class="flex flex-col bg-blue-100 items-center justify-center h-screen light">
  <div class="w-full max-w-xs bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Login</h2>

    <form method="POST" class="flex flex-col">
      <input placeholder="Username" name="user" type="text" class="bg-gray-100 text-gray-800 border-0 rounded-md p-2 mb-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150" type="text">
      <input placeholder="Password" name="pass" type="password" class="bg-gray-100 text-gray-800 border-0 rounded-md p-2 mb-4 focus:bg-gray-200 focus:outline-none focus:ring-1 focus:ring-blue-500 transition ease-in-out duration-150" type="email">
    
      <button name="proses" type="submit" class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white font-bold py-2 px-4 rounded-md mt-4 hover:bg-indigo-600 hover:to-blue-600 transition ease-in-out duration-150" type="submit">Submit</button>
    </form>
  </div>
</div>

<script src="assets/js/jquery.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 1000);
</script>
</body>