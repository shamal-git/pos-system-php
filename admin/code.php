<?php
include('../config/function.php');

//Admin
if (isset($_POST['saveAdmin'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    if ($name != '' && $email != '' && $password != '') {
        $emailCheck = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('admins-create.php', 'Email Already used by another user.');
            }
        }

        $bcrptpassword = password_hash($password, PASSWORD_BCRYPT);
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrptpassword,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];
        $result = insert('admins', $data);
        if ($result) {
            redirect('admins.php', 'Admin Created Successfully!');
        } else {
            redirect('admins-create.php', 'Something Went Wrong!');
        }
    } else {
        redirect('admins-create.php', 'Please fill required fields!');
    }
}

if (isset($_POST['updateAdmin'])) {
    $adminId = validate($_POST['adminId']);

    $adminData = getById('admins', $adminId);
    if ($adminData['status'] != 200) {
        redirect('admins-edit.php?id=' . $adminId, 'Please fill required fields!');
    }

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $phone = validate($_POST['phone']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    $EmailCheckQuery = "SELECT * FROM admins WHERE email = '$email' AND id!='$adminId'";
    $checkResult = mysqli_query($conn, $EmailCheckQuery);
    if ($checkResult) {
        if (mysqli_num_rows($checkResult) > 0) {
            redirect('admins-edit.php?id=' . $adminId, 'Email Already used by another User!');
        }
    }

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];

    }

    if ($name != '' && $email != '') {
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $bcrptpassword,
            'phone' => $phone,
            'is_ban' => $is_ban
        ];
        $result = update('admins', $adminId, $data);
        if ($result) {
            redirect('admins-edit.php?id=' . $adminId, 'Admin Updated Successfully!');
        } else {
            redirect('admins-edit.php?id=' . $adminId, 'Something Went Wrong!');
        }
    } else {
        redirect('admins-create.php', 'Please fill required fields!');
    }
}

//categories
if (isset($_POST['saveCategory'])) {
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];
    $result = insert('categories', $data);
    if ($result) {
        redirect('categories.php', 'Category Created Successfully!');
    } else {
        redirect('categories-create.php', 'Something Went Wrong!');
    }
}

//update category
if (isset($_POST['updateCategory'])) {
    $categoryId = validate($_POST['categoryId']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];
    $result = update('categories', $categoryId, $data);
    if ($result) {
        redirect('categories-edit.php?id=' . $categoryId, 'Category Updated Successfully!');
    } else {
        redirect('categories-edit.php?id=' . $categoryId, 'Something Went Wrong!');
    }
}

//product 
if (isset($_POST['saveProduct'])) {
    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

        $filename = time() . "." . $image_ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename);
        $finalImage = "assets/uploads/products/" . $filename;

    } else {
        $finalImage = "";
    }

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status
    ];
    $result = insert('products', $data);
    if ($result) {
        redirect('products.php', 'Product Created Successfully!');
    } else {
        redirect('products-create.php', 'Something Went Wrong!');
    }
}

//update product
if (isset($_POST['updateProduct'])) {
    $product_id = validate($_POST['product_id']);
    $productData = getById('products',$product_id);
    if (!$productData) {
        redirect('products.php','No such product found!');
    }


    $category_id = validate($_POST['category_id']);
    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $price = validate($_POST['price']);
    $quantity = validate($_POST['quantity']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);

        $filename = time() . "." . $image_ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename);
        $finalImage = "assets/uploads/products/" . $filename;

        $deleteImage = "../".$productData['data']['image'];
        if(file_exists($deleteImage)) {
            unlink($deleteImage);
        }

    } else {
        $finalImage = $productData['data']['image'];
    }

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status
    ];
    $result = update('products', $product_id,$data);

    if ($result) {
        redirect('products-edit.php?id='.$product_id, 'Product Updated Successfully!');
    } else {
        redirect('products-edit.php?id='.$product_id, 'Something Went Wrong!');
    }
}

//customer create
if (isset($_POST['saveCustomer'])) {
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1:0;

    if($name != ''){
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email'");
        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0){
                redirect('customers.php', 'Email Already used by another user!');
            }
        }
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status 
        ];

        $result = insert('customers', $data);
        if ($result) {
            redirect('customers.php', 'Customer Created Successfully!');
        }
        else {
            redirect('customers.php', 'Somthing went wrong!');
        }
    } else{
        redirect('customers.php','Please fill required fields!');
    }

}

//update
if(isset($_POST['updateCustomer'])){
    $customerId = validate($_POST['customerId']);
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = isset($_POST['status']) ? 1:0;

    if($name != ''){
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email = '$email' AND id!='$customerId'");
        if($emailCheck){
            if(mysqli_num_rows($emailCheck) > 0){
                redirect('customers-edit.php?id='.$customerId, 'Email Already used by another user!');
            }
        }
        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'status' => $status 
        ];

        $result = update('customers', $customerId,$data);
        if ($result) {
            redirect('customers-edit.php?id='.$customerId, 'Customer Updated Successfully!');
        }
        else {
            redirect('customers-edit.php?id='.$customerId, 'Somthing went wrong!');
        }
    } else{
        redirect('customers-edit.php?id='.$customerId,'Please fill required fields!');
    }

}
?>