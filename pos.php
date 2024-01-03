<?php include 'config.php';?>

<?php
  $barang = mysqli_query($conn, "SELECT * FROM menu");
  $itemDetails = array();
  while ($row_brg = mysqli_fetch_array($barang)) {
    $item_name = $row_brg['name'];
    $item_price = addslashes($row_brg['price']);
    $item_id = addslashes($row_brg['item_id']);
    $item_category = addslashes($row_brg['item_category']);
    $itemDetails[$item_name] = array('price' => $item_price, 'item_id' => $item_id, 'item_category' => $item_category);
  }
  ?>

<?php 
$adminResult = mysqli_query($conn, "SELECT * FROM admin ORDER BY admin_id ASC");
while ($dat = mysqli_fetch_array($adminResult)) {
    $admin_id = $dat['admin_id'];
    $fname = $dat['first_name'];
    $lname = $dat['last_name'];
}
?>

<?php
    $maxOrderQuery = mysqli_query($conn, "SELECT MAX(order_id) AS max_order_id FROM `order`");
    $row = mysqli_fetch_assoc($maxOrderQuery);
    $ID = $row['max_order_id'];

    $date = date("d F Y, H:i");
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
<body class="bg-gray-100 font-family-karla flex">

<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a href="pos.php" class="text-white text-xl font-semibold uppercase hover:text-gray-300"><i class="fa fa-store mr-3"></i>MunchFaun</a>

        </div>
        <nav class="text-white text-base font-semibold pt-3">
            <a href="pos.php" class="flex items-center text-white py-4 pl-6 nav-item active-nav-link">
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
        <h1 class="w-1/2 text-3xl text-black flex">Point of Sale</h1>
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
    
        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <div class="flex flex-wrap">
                <div class="w-full lg:w-1/2 mt-6 pl-0 lg:pl-2">
                        <p class="text-xl pb-6 flex items-center">
                            <i class="fas fa-list mr-3"></i> Checkout Form
                        </p>
                        <div class="leading-loose">
                            <form class="p-10 bg-white rounded shadow-xl" method = "POST">
                            <div class="">
                                <label class="block text-sm text-gray-600">Item ID</label>
                                <div class="input-group">
                                <input type="text" name="item_id" id="item_id" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" readonly>
                                </div>
                            </div>
                            <div class="mt-2">
                                <label class=" block text-sm text-gray-600" >Item Name</label>
                                <input type="text" name="name" id="name" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" list="datalist1" onchange="changeValue(this.value)" aria-describedby="basic-addon2" required>
                                <datalist id="datalist1">
                                <?php
                                    mysqli_data_seek($barang, 0);
                                    if (mysqli_num_rows($barang)) {
                                        while ($row_brg = mysqli_fetch_array($barang)) {
                                            echo '<option value="' . $row_brg["name"] . '"> ' . $row_brg["item_id"] . '</option>';
                                        }
                                    }
                                    ?>
                                </datalist>
                            </div>
                            <div class="mt-2">
                                <label class=" block text-sm text-gray-600" >Price</label>
                                <input type="text" name="price" id="price" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" readonly>
                            </div>
                            <div class="mt-2">
                                <label class=" block text-sm text-gray-600">Quantity</label>
                                <input type="text" name="item_quantity" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" value="" required placeholder="Input the item quantity">
                            </div>
                            <div class="mt-2">
                                <label class=" block text-sm text-gray-600" >Category</label>
                                <input type="text" name="item_category" id="item_category" class="w-full px-2 py-2 text-gray-700 bg-gray-200 rounded" readonly>
                            </div>
                            <div class="mt-6">
                                <button name="save" value="save" class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" type="submit">Add</button>
                            </div>
                            </form>
                            <?php
                        if(isset($_POST['save'])) {
                            $item_id = $_POST['item_id'];
                            $name = $_POST['name'];
                            $item_quantity = $_POST['item_quantity'];
                            $realprice = $_POST['price'];
                            
                        
                            $checking = mysqli_query($conn, "SELECT COUNT(*) AS order_count FROM `order`");
                            $rowOrder = mysqli_fetch_assoc($checking);
                            $orderCount = $rowOrder['order_count'];

                            if ($orderCount == 0) {
                                $sql_insert = mysqli_query($conn, "INSERT INTO `order` (admin_id, order_date, total_price) VALUES ('$admin_id', '0', '0')");
                            }

                            $sql_update = "UPDATE menu SET quantity = quantity - '$item_quantity' WHERE item_id = '$item_id'";
                            $query_update = mysqli_query($conn, $sql_update) or die(mysqli_error($conn));

                            $price = $item_quantity * $realprice;

                            $cart_insert = mysqli_query($conn, "INSERT INTO ordercart (item_id, name, quantity, price) VALUES ('$item_id', '$name', '$item_quantity', '$price')");
                        
                            if($cart_insert){
                                echo '<script>window.location=""</script>';
                            } else {
                                echo "Error: " . mysqli_error($conn);
                            }
                        
                            mysqli_close($conn);
                        }?>
                        </div>
                    </div>

                    <form class="w-full lg:w-1/2 mt-6 pl-0 lg:pl-2" method="POST">
                        <p class="text-xl pb-6 flex items-center">
                            <i class="fas fa-list mr-3"></i> Checkout Form
                        </p>
                        <div class="leading-loose" id="print">             
                            <div class="p-10 bg-white rounded shadow-xl w-full" >
                                <h5 class='card-tittle mb-0 text-center'><b>FAUNMUNCH</b>
                                <p class='m-0 small text-center'><?php echo $date;?></p>
                                <p class='m-0 small text-center'>Kota Depok, Jawa Barat</p>
                                <p class='small text-center'>Telp. 081315509677</p>
                                <div class="row">
                                    <div class="col-8 col-sm-9 pr-0">
                                        <div class="flex justify-between">
                                        <ul class="pl-0 small list-none text-uppercase">
                                        <li>NOTA : <?php echo $ID; ?></li>
                                        </ul>
                                        <ul class="pl-0 small list-none text-uppercase">
                                        <li>KASIR : <?php echo $fname . ' ' . $lname ?></li>
                                        </ul>
                                        </div>
                                    </div>
                                </div>

                                <table class="min-w-full bg-white table table-striped table-bordered table-sm dt-responsive nowrap p-2 mt-5" id="table_barang" width="100%">
                                <thead class="text-black border-b-2 border-gray-400">
                                        <tr>
                                            <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">No</th>
                                            <th class="w-3/6 text-left py-3 px-4 uppercase font-semibold text-sm">Name</th>
                                            <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Quantity</th>
                                            <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700">
                                    <?php
                                    $no = 1;
                                    $data_barang = mysqli_query($conn, "SELECT * FROM ordercart");
                                    while ($d = mysqli_fetch_array($data_barang)) {
                                        ?>
                                        <tr>
                                            <td class="w-1/6 text-left py-3 px-4">
                                                <a href="?id=<?php echo $d['item_id']; ?>" onclick="return confirm('Hapus Data Barang?');">
                                                    <?php echo $no++; ?>
                                                </a>
                                            </td>
                                            <td class="w-3/6 text-left py-3 px-4"><?php echo $d['name']; ?></td>
                                            <td class="w-1/6 text-left py-3 px-4"><?php echo $d['quantity']; ?></td>
                                            <td class="w-1/6 text-left py-3 px-4"><?php echo $d['price']; ?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-8 col-sm-9 mt-4">
                                        <div class="flex justify-between">
                                        <ul class="pl-0 font-bold small list-none text-uppercase">
                                        <?php
                                        $ambilharga = mysqli_query($conn, "SELECT * FROM ordercart");

                                        $total_price = 0; 
                                        
                                        while ($harga = mysqli_fetch_array($ambilharga)) {
                                            $price = $harga['price'];
                                            $total_price += $price;
                                        }
                                        
                                        ?>
                                        <li>Total Pembayaran:</li>
                                        </ul>
                                        <ul class="pl-0 small list-none text-uppercase">
                                        <li><?php echo $total_price ?></li>
                                        </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex">
                            <div class="ml-auto">
                                <button class="px-4 py-2 text-white font-light tracking-wider bg-gray-900 rounded" type="submit" onclick="printContent('print')"><i class="fa fa-print mr-1"></i>Print</button>
                            </div>
                            <div class="ml-2">
                                <button name="done" value="done" class="px-4 py-2 text-white font-light tracking-wider bg-gray-900 rounded" type="submit" onclick="return confirm('Apakah anda sudah setuju untuk menyelesaikan pembayaran?');">Done Payment</button>
                            </div>
                        </div>
                    </form>

                    <?php
                    include 'config.php';
                    if (isset($_POST['done'])) {
                        $deleteAll = mysqli_query($conn, "DELETE FROM `ordercart`");

                        $ambilprice = mysqli_query($conn, "SELECT price FROM orderlist WHERE order_id = $ID AND order_status = 'active'");

                        $total_semua = 0; 
                                        
                        while ($loopambil = mysqli_fetch_array($ambilprice)) {
                            $dapetharga = $loopambil['price'];
                            $total_semua += $dapetharga;
                        }
                                        
                    
                        $sql_update = mysqli_query($conn, "UPDATE `order` SET admin_id = '$admin_id', order_date = '$date', total_price = '$total_semua' WHERE order_id = $ID");
                    
                        $sql_insert = mysqli_query($conn, "INSERT INTO `order` (admin_id, order_date, total_price) VALUES ('$admin_id', '0', '0')");

                    echo '<script>window.location="pos.php"</script>';
                    }


                    ?>
                    </main>
    
        </div>
        
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>

    <script type="text/javascript">
  var itemDetails = <?php echo json_encode($itemDetails); ?>;

function changeValue(item_name) {
  var item = itemDetails[item_name];
  if (item) {
    document.getElementById("price").value = item.price;
    document.getElementById("item_id").value = item.item_id;
    document.getElementById("item_category").value = item.item_category;
  } else {
    document.getElementById("price").value = "";
    document.getElementById("item_id").value = "";
    document.getElementById("item_category").value = ""
  }
}

function printContent(print){
			var restorepage = document.body.innerHTML;
			var printcontent = document.getElementById(print).innerHTML;
			document.body.innerHTML = printcontent;
			window.print();
			document.body.innerHTML = restorepage;
		}
</script>

<?php
include 'config.php';
if (!empty($_GET['id'])) {
    $id = $_GET['id'];

    $quantityResult = mysqli_query($conn, "SELECT quantity FROM ordercart WHERE item_id ='$id'");
    $quantityData = mysqli_fetch_array($quantityResult);
    $quantity = $quantityData['quantity'];

    $hapus_data = mysqli_query($conn, "DELETE FROM ordercart WHERE item_id ='$id'");

    $update_status = mysqli_query($conn, "UPDATE orderlist SET order_status = 'cancel' WHERE item_id ='$id'");
    
    $update_quantity = mysqli_query($conn, "UPDATE menu SET quantity = quantity + '$quantity' WHERE item_id ='$id'");

    echo '<script>window.location="pos.php"</script>';
}
?>

</body>
</html>