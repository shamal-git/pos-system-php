<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Admins/Staff
                <a href="admins-create.php" class="btn btn-primary float-end"><i class="fa-solid fa-plus"></i> Add Admin</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $admins = getAll('admins');
            if (!$admins) {
                echo '<h4>Somthing Went Wrong!</h4>';
                return false;
            }
            if (mysqli_num_rows($admins) > 0) {

                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($admins as $adminItem): ?>
                                <tr>
                                    <td><?= $adminItem['id'] ?></td>
                                    <td><?= $adminItem['name'] ?></td>
                                    <td><?= $adminItem['email'] ?></td>
                                    <td>
                                        <?php if ($adminItem['is_ban'] == 1): ?>
                                        <span class="badge rounded-pill text-bg-danger">Banned</span>
                                        <?php else: ?>
                                        <span class="badge rounded-pill text-bg-primary">Active</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="admins-edit.php?id=<?= $adminItem['id']; ?>" class="btn btn-success btn-sm"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                        <a href="admins-delete.php?id=<?= $adminItem['id']; ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</a>
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