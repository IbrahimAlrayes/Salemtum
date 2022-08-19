<?php
include "includes/head.php";
?>

<body>
    <?php
    include "includes/header.php"
    ?>


  
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        
        <div class="container">
            <div class="row align-items-start">
                <div class="col">
                    <br>
                    <h2>Orders </h2>
                    <br>
                </div>
                <div class="col">
                </div>
                <div class="col">
                    <br>
                    
                    <br>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">User ID</th>
                        <th scope="col">product ID</th>
                        <th scope="col">Product quantity</th>
                        <th scope="col">Order date</th>
                        <th scope="col">Order status</th>
                </thead>

                <tbody>
                    <?php
                    function query_($query)
                    {
                        global $connection;
                        $run = mysqli_query($connection, $query);
                        if ($run) {
                            while ($row = $run->fetch_assoc()) {
                                $data[] = $row;
                            }
                            return $data;
                        } else {
                            return 0;
                        }
                    }

                    function all_orders()
                    {
                        $id = $_SESSION['user_id'];
                        $query = "SELECT * FROM orders, item WHERE orders.item_id = item.item_id AND user_id = $id";
                        $data = query_($query);
                        return $data;
                    }
                    
                    function delete_order()
                    {
                        if (isset($_GET['delete'])) {
                            $order_id = $_GET['delete'];
                            $query = "DELETE FROM orders WHERE order_id ='$order_id'";
                            $run = single_query($query);
                            get_redirect("orders.php");
                        } elseif (isset($_GET['done'])) {
                            $order_id = $_GET['done'];
                            $query = "UPDATE orders SET order_status = 1 WHERE order_id='$order_id'";
                            single_query($query);
                            get_redirect("orders.php");
                        } elseif (isset($_GET['undo'])) {
                            $order_id = $_GET['undo'];
                            $query = "UPDATE orders SET order_status = 0 WHERE order_id='$order_id'";
                            single_query($query);
                            get_redirect("orders.php");
                        }
                    }

                    $data = all_orders();
                     delete_order();
                    if (isset($_GET['search_order'])) {
                        $query = search_order();
                        if (!empty($query)) {
                            $data = $query;
                        } else {
                            get_redirect("useroders.php");
                        }
                    }
                    // print($data);
                    $num = sizeof($data);
                    for ($i = 0; $i < $num; $i++) {

                    ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $data[$i]['order_id'] ?></td>
                            <td><?php echo $data[$i]['user_id'] ?></td>
                            <td><?php echo $data[$i]['item_title'] ?></td>
                            <td><?php echo $data[$i]['order_quantity'] ?></td>
                            <td><?php echo $data[$i]['order_date'] ?></td>
                            <?php if ($data[$i]['order_status'] == 1) {
                            ?>
                                <td style="color: green;">
                                    shipped
                                </td>
                            <?php
                            } else {
                            ?>
                                <td style="color: red;">
                                    pending
                                </td>
                            <?php
                            }
                            ?>
                            
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <br><br>
        
    </main>
    </div>
    </div>
    <?php
    include "includes/footer.php"
    ?>
</body>