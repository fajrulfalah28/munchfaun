<?php 
include "config.php";

if (isset($_POST['get'])) {
    $id = $_POST['admin_id'];
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $result = mysqli_query($conn, "UPDATE admin SET first_name='$fname', last_name='$lname', username='$user', password='$pass' WHERE admin_id = '$id'") or die(mysqli_connect_error());
}
?>

  <?php
  $result1 = mysqli_query($conn, "SELECT * FROM admin");
  while($data = mysqli_fetch_array($result1))
  {
      $id = $data['admin_id'];
      $fname = $data['first_name'];
      $lname = $data['last_name'];
      $user = $data['username'];
      $pass = $data['password'];
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
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
<body class="bg-gray-100 font-family-karla flex">

<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a href="pos.php" class="text-white text-xl font-semibold uppercase hover:text-gray-300"><i class="fa fa-store mr-3"></i>MunchFaun</a>

        </div>
        <nav class="text-white text-base font-semibold pt-3">
            <a href="pos.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fa fa-credit-card mr-3"></i>
                Point of Sale
            </a>
            <a href="item.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fa fa-layer-group mr-3"></i>
                Item Storage
            </a>
            <a href="order.php" class="flex items-center text-white py-4 pl-6 nav-item">
                <i class="fas fa-table mr-3"></i>
                Order Management
            </a>
        </nav>
    </aside>

    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
        <h1 class="w-1/2 text-3xl text-black flex">Item Storage</h1>
            <div class="w-1/2"></div>
            <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
                <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                    <img src="https://source.unsplash.com/uJ8LNVCBjFQ/400x400">
                </button>
                <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
                <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                    <a href="account.php" class="block px-4 py-2 account-link hover:text-white">Account</a>
                    <a href="index.php?logout" class="block px-4 py-2 account-link hover:text-white" onclick="return confirm('Ingin Log-Out?')">Sign Out</a>
                </div>
            </div>
        </header>

        <!-- Mobile Header & Nav -->
        <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
            <div class="flex items-center justify-between">
                <a href="pos.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
                <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                    <i x-show="!isOpen" class="fas fa-bars"></i>
                    <i x-show="isOpen" class="fas fa-times"></i>
                </button>
            </div>

            <!-- Dropdown Nav -->
            <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
            <a href="pos.php" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
                    <i class="fas fa-credit-card mr-3"></i>
                    Point of Sale
                </a>
                <a href="item.php" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
                    <i class="fas fa-layer-group mr-3"></i>
                    Item Storage
                </a>
                <a href="order.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                    <i class="fas fa-table mr-3"></i>
                    Order Management
                </a>
            </nav>

        </header>
    
        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <div class="w-full pl-0">
                    <div class="leading-loose">
                    <form method="POST" class="p-10 bg-white rounded shadow-xl">
                    <fieldset>
                        <p class="text-lg text-gray-800 font-bold pb-4 pr-10">Account Setting</p>
                        <input type="hidden" name="admin_id" value="<?php echo $id; ?>">
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600">First Name</label>
                            <input type="text" name="first_name" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" value="<?php echo $fname; ?>" required>
                        </div>
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600">Last Name</label>
                            <input type="text" name="last_name" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" value="<?php echo $lname; ?>" required>
                        </div>
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600">Username</label>
                            <input type="text" name="username" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" value="<?php echo $user; ?>" required>
                        </div>
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600">New Password</label>
                            <input type="password" name="password" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" placeholder="****" required>
                        </div>
                        <div class="mt-6 flex">
                            <button name="get" class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" type="submit">Update</button>
                        </div>
                    </fieldset>
                </form>
                    </div>
                </div>
            </main>
    
        </div>
        
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
    

    <script src="assets/js/popper.min.js"></script>
    <script type="text/javascript">
    </script>
</body>
</html>