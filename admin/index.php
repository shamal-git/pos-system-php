<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt-4">Dashboard</h1>
            <?php alertMessage(); ?>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-captalize">Total Category</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('categories'); ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-captalize">Total Products</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('products'); ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-captalize">Admins</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('admins'); ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-captalize">Total Customers</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('customers'); ?>
                </h5>
            </div>
        </div>

        <div class="col-md-12">
            <hr>
            <h5>Orders</h5>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-captalize">Today Order Count</p>
                <h5 class="fw-bold mb-0">
                    <?php 
                        $todayDate = date('Y-m-d');
                        $todayOrders = mysqli_query($conn,"SELECT * FROM orders WHERE order_date= '$todayDate' ");
                        if ($todayOrders) {
                            if(mysqli_num_rows($todayOrders) > 0) {
                                $totalCountOrders = mysqli_num_rows($todayOrders);
                                echo $totalCountOrders;
                            }
                            else{
                                echo "0";
                            }
                        }
                        else {
                            echo 'Something Went Wrong!';
                        }
                    ?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-captalize">Total Orders</p>
                <h5 class="fw-bold mb-0">
                    <?= getCount('orders'); ?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-captalize">Total Amount</p>
                <h5 class="fw-bold mb-0">
                    <?= number_format(getTotalAmount('orders'), 2); ?>
                </h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-captalize">Today's Total Amount</p>
                <h5 class="fw-bold mb-0">
                    <?= number_format(getTodaysTotalAmount('orders'), 2); ?>
                </h5>
            </div>
        </div>

        <div class="col-md-12">
            <hr>
            <h5>Products</h5>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-captalize">Total Amount Of Product</p>
                <h5 class="fw-bold mb-0">
                    <?= number_format(getTotalAmountOfProducts('products'), 2); ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-captalize">Active Products</p>
                <h5 class="fw-bold mb-0">
                <?= getActiveProductCount('products'); ?>
                </h5>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card card-body p-3">
                <p class="text-sm mb-0 text-captalize">Hidden products</p>
                <h5 class="fw-bold mb-0">
                <?= getHiddenProductCount('products'); ?>
                </h5>
            </div>
        </div>
        
    </div>

</div>

<?php include('includes/footer.php'); ?>