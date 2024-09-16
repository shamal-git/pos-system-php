<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Add Customer
                <a href="customers.php" class="btn btn-danger float-end"><i class="fa-solid fa-arrow-left"></i> Back</a>
            </h4>
        </div>

        <div class="card-body">
        <?php  alertMessage(); ?>
            <form action="code.php" method="POST">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="">Name *</label>
                        <input type="text" name="name" required class="form-control">
                        
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Email </label>
                        <input type="email" name="email" class="form-control">
                        
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Phone </label>
                        <input type="number" name="phone" class="form-control">
                        
                    </div>
                    <div class="col-md-6">
                        <label>Status (UnChecked = Visible, Checked = Hidden)</label>
                        <br/>
                        <input type="checkbox" name="status" style="width: 20px;height: 20px";>
                    </div>
                    <div class="col-md-6 mb-3 text-end">
                        <br/>
                        <button type="submit" name="saveCustomer" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>