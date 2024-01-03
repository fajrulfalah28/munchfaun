<?php
require 'config.php';
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=munchfaun.xls");

?>
<table class="min-w-full bg-white table table-striped table-bordered table-sm dt-responsive nowrap p-2" id="table_barang" width="100%">
                            <thead class="bg-gray-800 text-white ">
                                <tr>
                                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">No</th>
                                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">Item ID</th>
                                    <th class="w-3/12 text-left py-3 px-4 uppercase font-semibold text-sm">Item Name</th>
                                    <th class="w-2/12 text-left py-3 px-4 uppercase font-semibold text-sm">Price</th>
                                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">Quantity</th>
                                    <th class="w-1/12 text-left py-3 px-4 uppercase font-semibold text-sm">Category</th>
                                    <th class="w-2/12 text-left py-3 px-4 uppercase font-semibold text-sm">Input Date</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                            <?php 
                                $no = 1;
                                $data_barang = mysqli_query($conn,"select * from menu");
                                while($d = mysqli_fetch_array($data_barang)){
                            ?>
                                <tr>
                                    <td class="w-1/12 text-left py-3 px-4"><?php echo $no++; ?></td>
                                    <td class="w-1/12 text-left py-3 px-4"><?php echo $d['item_id']; ?></td>
                                    <td class="w-3/12 text-left py-3 px-4"><?php echo $d['name']; ?></td>
                                    <td class="w-2/12 text-left py-3 px-4"><?php echo $d['price']; ?></td>
                                    <td class="w-1/12 text-left py-3 px-4"><?php echo $d['quantity']; ?></td>
                                    <td class="w-1/12 text-left py-3 px-4"><?php echo $d['item_category']; ?></td>
                                    <td class="w-2/12 text-left py-3 px-4"><?php echo $d['input_date']; ?></td>

                                </tr>
                            <?php }?>
                            </tbody>
                        </table>