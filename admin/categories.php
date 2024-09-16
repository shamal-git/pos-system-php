<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Categories
                <a href="categories-create.php" class="btn btn-primary float-end"><i class="fa-solid fa-plus"></i> Add Category</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $categories = getAll('categories');
            if (!$categories) {
                echo '<h4>Somthing Went Wrong!</h4>';
                return false;
            }
            if (mysqli_num_rows($categories) > 0) {

                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($categories as $Item): ?>
                                <tr>
                                    <td><?= $Item['id'] ?></td>
                                    <td><?= $Item['name'] ?></td>
                                    <td>
                                        <?php if ($Item['status'] == 1): ?>
                                        <span class="badge rounded-pill text-bg-danger">Hidden</span>
                                        <?php else: ?>
                                        <span class="badge rounded-pill text-bg-primary">Visible</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="categories-edit.php?id=<?= $Item['id']; ?>" class="btn btn-success btn-sm"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                        <a href="categories-delete.php?id=<?= $Item['id']; ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</a>
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