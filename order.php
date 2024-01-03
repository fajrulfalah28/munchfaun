<?php 
include "config.php";
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
            <a href="order.php" class="flex items-center text-white py-4 pl-6 nav-item active-nav-link">
                <i class="fas fa-table mr-3"></i>
                Order Management
            </a>
        </nav>
    </aside>

    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Desktop Header -->
        <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
        <h1 class="w-1/2 text-3xl text-black flex">Order Management</h1>
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
                <a href="pos.php" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
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

                <div class="w-full mt-6">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-list mr-3"></i> List of Order
                    </p>
                    <div class="bg-white overflow-auto p-5">
                        <table class="min-w-full bg-white table table-striped table-bordered table-sm dt-responsive nowrap p-2" id="table_barang" width="100%">
                            <thead class="bg-gray-800 text-white ">
                                <tr>
                                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">No</th>
                                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">Order ID</th>
                                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">Admin ID</th>
                                    <th class="w-4/12 text-left py-3 px-4 uppercase font-semibold text-sm">Order Date</th>
                                    <th class="w-4/12 text-left py-3 px-4 uppercase font-semibold text-sm">Total Price</th>
                                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">Check</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                            <?php 
                            $no = 1;

                            $query = "SELECT order_id, admin_id, order_date, total_price FROM `order` WHERE order_date <> '0';";

                            $data = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_array($data)) {
                                $order_id = $row['order_id'];
                                $admin_id = $row['admin_id'];
                                $order_date = $row['order_date'];
                                $total_price = $row['total_price'];
                                ?>
                                <tr>
                                    <td class="w-1/12 text-left py-3 px-4"><?php echo $no++; ?></td>
                                    <td class="w-1/12 text-left py-3 px-4"><?php echo $order_id; ?></td>
                                    <td class="w-1/12 text-left py-3 px-4"><?php echo $admin_id; ?></td>
                                    <td class="w-4/12 text-left py-3 px-4"><?php echo $order_date; ?></td>
                                    <td class="w-4/12 text-left py-3 px-4"><?php echo $total_price; ?></td>
                                    <td class="w-1/12 text-left py-3 px-4">
                                        <a class="btn btn-primary btn-xs inset-0 bg-blue-200 px-3 py-1 rounded-full" href="orderlist.php?order_id=<?php echo $order_id; ?>">
                                            <i class="fa fa-search fa-xs"></i> Check Data
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
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
    $(document).ready(function() {
        $('#table_barang').DataTable( {
        } );
    } );
    </script>

<?php 
	include 'config.php';
	if(!empty($_GET['order_id'])){
		$id= $_GET['order_id'];
		$check_data = mysqli_query($conn, "SELECT * FROM orderlist WHERE order_id ='$id'");
		echo '<script>window.location="order.php"</script>';
	}

?>
</body>
</html>