<?php include('includes/header.php'); 

if(isset($_SESSION['loggedIn'])){
    ?>
    <script>window.location.href='index.php';</script>
    <?php
}

?>

<div class="py-5 bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow rounded-4">
                    <?php alertMessage(); ?>

                    <div class="p-5">
                        <h4 class="text-dark mb-3">Sign In to POS System.</h4>
                        <form action="login-code.php" method="POST">
                            <div class="mb-3">
                                <label>Enter Email ID</label>
                                <input type="email" name="email" class="form-control" required/>
                            </div>
                            <div class="mb-3">
                                <label>Enter Password</label>
                                <input type="password" name="password" class="form-control" required/>
                            </div>
                            <div class="mb-3">
                                <button type="submit" name="loginBtn" class="btn btn-primary w-100 mt-2">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<?php include('includes/footer.php'); ?>