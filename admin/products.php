<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Products
                <a href="products-create.php" class="btn btn-primary float-end"><i class="fa-solid fa-plus"></i> Add Product</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $products = getAll('products');
            if (!$products) {
                echo '<h4>Somthing Went Wrong!</h4>';
                return false;
            }
            if (mysqli_num_rows($products) > 0) {

                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                               
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($products as $Item): ?>
                                <tr>
                                    <td><?= $Item['id'] ?></td>
                                    <td>
                                        <img src="../<?= $Item['image']; ?>" style="wisth: 50px;height:50px;" alt="img">
                                    </td>
                                    <td><?= $Item['name'] ?></td>

                                    <td>
                                        <?php if ($Item['status'] == 1): ?>
                                        <span class="badge rounded-pill text-bg-danger">Hidden</span>
                                        <?php else: ?>
                                        <span class="badge rounded-pill text-bg-primary">Visible</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="products-edit.php?id=<?= $Item['id']; ?>" class="btn btn-success btn-sm"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                        <a href="products-delete.php?id=<?= $Item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this image.')" ><i class="fa-solid fa-trash-can"></i> Delete</a>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php
            } else {
                ?>
                    <tr>
                        <h4 class="mb-0">No Record Found</h4>
                    </tr>
                    <?php
            }
            ?>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>