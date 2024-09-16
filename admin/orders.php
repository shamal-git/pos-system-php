<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="mb-0">Orders</h4>
                </div>
                <div class="col-md-8">
                    <form action="" method="GET">
                        <div class="row g-1">
                            <div class="col-md-4">
                                <input type="date" name="date" class="form-control"
                                    value="<?= isset($_GET['date']) == true ? $_GET['date'] : ''; ?>" />
                            </div>
                            <div class="col-md-4">
                                <select name="payment_status" class="form-select">
                                    <option value="">Select Payment Status</option>
                                    <option value="cash payment" <?= isset($_GET['payment_status']) == true ? ($_GET['payment_status'] == 'cash_payment' ? 'selected' : '') : ''; ?>>Cash
                                        Payment
                                    </option>
                                    <option value="card payment" <?= isset($_GET['payment_status']) == true ? ($_GET['payment_status'] == 'card_payment' ? 'selected' : '') : ''; ?>>Card
                                        Payment
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i>
                                    Filter</button>
                                <a href="orders.php" class="btn btn-danger">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <?php

            if (isset($_GET['date']) || isset($_GET['payment_status'])) {
                $orderData = validate($_GET['date']);
                $paymentStatus = validate($_GET['payment_status']);

                if ($orderData != '' && $paymentStatus == '') {
                    $query = "SELECT O.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id AND o.order_date='$orderData' ORDER BY o.id DESC";
                } elseif ($orderData == '' && $paymentStatus != '') {
                    $query = "SELECT O.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id AND o.payment_mode='$paymentStatus' ORDER BY o.id DESC";
                } elseif ($orderData != '' && $paymentStatus != '') {
                    $query = "SELECT O.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id AND o.order_date='$orderData' AND o.payment_mode='$paymentStatus' ORDER BY o.id DESC";
                } else {
                    $query = "SELECT O.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id ORDER BY o.id DESC";
                }
            } else {
                $query = "SELECT O.*, c.* FROM orders o, customers c WHERE c.id = o.customer_id ORDER BY o.id DESC";
            }
            $orders = mysqli_query($conn, $query);
            if ($orders) {
                if (mysqli_num_rows($orders) > 0) {
                    ?>
                    <table class="table table-striped table-bordered align-items-center justify-content-center">
                        <thead>
                            <tr>
                                <th>Tracking No</th>
                                <th>Customer Name</th>
                                <th>Custome Phone No</th>
                                <th>Order Date</th>
                                <th>Order Status</th>
                                <th>Payment Mode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $orderItem): ?>
                                <tr>
                                    <td class="fw-bold"><?= $orderItem['tracking_no']; ?></td>
                                    <td><?= $orderItem['name']; ?></td>
                                    <td><?= $orderItem['phone']; ?></td>
                                    <td><?= date('d M, Y', strtotime($orderItem['order_date'])); ?></td>
                                    <td><?= $orderItem['order_status']; ?></td>
                                    <td><?= $orderItem['payment_mode']; ?></td>
                                    <td>
                                        <a href="orders-view.php?track=<?= $orderItem['tracking_no']; ?>"
                                            class="btn btn-success mb-0 px-2 btn-sm">View</a>
                                        <a href="orders-view-print.php?track=<?= $orderItem['tracking_no']; ?>"
                                            class="btn btn-danger mb-0 px-2 btn-sm"><i class="fa-solid fa-print"></i>
                                            Print</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
                } else {
                    echo '<h5>No Record Found!</h5>';
                }
            } else {
                echo '<h5>Somthing Went Wrong!</h5>';
            }
            ?>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>