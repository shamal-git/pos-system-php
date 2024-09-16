<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Edit Admin
                <a href="admins.php" class="btn btn-danger float-end"><i class="fa-solid fa-arrow-left"></i> Back</a>
            </h4>
        </div>

        <div class="card-body">
            <?php alertMessage(); ?>

            <?php 
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $adminId = $_GET['id'];

                $adminData = getById('admins', $adminId);
                if ($adminData && $adminData['status'] == 200) {
            ?>
                    <!-- Form starts here -->
                    <form action="code.php" method="POST">
                        <!-- Hidden field for admin ID -->
                        <input type="hidden" name="adminId" value="<?= $adminData['data']['id']; ?>">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="">Name *</label>
                                <input type="text" name="name" required value="<?= $adminData['data']['name']; ?>" class="form-control"/>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Email *</label>
                                <input type="email" name="email" required value="<?= $adminData['data']['email']; ?>" class="form-control"/>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Password (Leave blank to keep current password)</label>
                                <input type="password" name="password" class="form-control"/>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">Phone *</label>
                                <input type="number" name="phone" required value="<?= $adminData['data']['phone']; ?>" class="form-control"/>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="">Is Ban</label>
                </br>
                                <input type="checkbox" name="is_ban" <?= $adminData['data']['is_ban'] == 1 ? 'checked' : ''; ?> style="width: 20px; height: 20px;"/>
                            </div>

                            <div class="col-md-12 mb-3 text-end">
                                <button type="submit" name="updateAdmin" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                    <!-- Form ends here -->
            <?php 
                } else {
                    echo '<h5>' . $adminData['message'] . '</h5>';
                }
            } else {
                echo '<h5>No ID found.</h5>';
            }
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
