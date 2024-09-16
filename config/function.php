<?php 

session_start();

require 'dbcon.php';

//input validation function
function validate($inputData){
    global $conn;

    $validatedData = mysqli_real_escape_string($conn, $inputData);
    return trim($validatedData);
}

//redirect from one page to another page 
function redirect($url, $status){
    $_SESSION['status'] = $status;
    header('Location: '. $url);
    exit(0);
}

//Display messages 
function alertMessage() {
    if(isset($_SESSION['status'])){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h6>'.$_SESSION['status'].'</h6>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        unset($_SESSION['status']);
    }
}

//Insert Record Function
function insert($tableName, $data) {
    global $conn;

    $table = validate($tableName);
    $columns = array_keys($data);
    $values = array_values($data);

    $finalColumn = implode(',', $columns);
    $finalValues = "'".implode("', '", $values)."'";

    $query = "INSERT INTO $table ($finalColumn) VALUES ($finalValues)";
    $result = mysqli_query($conn, $query);
    return $result;

}

//Update Record Function
function update($tableName, $id, $data) {
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $updateDataString = "";

    foreach($data as $column => $value) {
        $updateDataString .= $column.'='."'$value',";
    }
    $finalUpdateData = substr(trim($updateDataString),0,-1);

    $query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    return $result;
}

//Get All the Data 
function getAll($tableName, $status = NULL) {
    global $conn;
    $table = validate($tableName);
    $status = validate($status);

    if($status == 'status') {
        $query = "SELECT * FROM $table WHERE $status= '0'";
    }
    else {
        $query = "SELECT * FROM $table";
    }
    return mysqli_query($conn, $query);
}

//Get each data
function getById($tableName, $id){
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result) {
        if(mysqli_num_rows($result) == 1 ) {
            $row = mysqli_fetch_array($result);
            $response = [
                'status' => 200,
                'data' => $row,
                'message'=> 'Record Found.'
            ];
            return $response;
        }
        else{
            $response = [
                'status' => 404,
                'message'=> 'No Data Found.'
            ];
            return $response;
        }
    }
    else {
        $response = [
            "status"=> 500,
            'message' => 'Something Went Wrong'        
        ];
        return $response;
    }

}

//Delete Data 
function delete($tableName, $id) {
    global $conn;
    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;

}

//check paramID
function checkParamId($type){
    if(isset($_GET[$type])){
        if($_GET[$type] != ''){
            return $_GET[$type];
        }
        else{
            return '<h5>No Id Found.</h5>';
        }
    }
    else{
        return '<h5>No Id Given.</h5>';
    }
}

//logout
function logoutSession(){
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}

function jsonResponse($status, $status_type, $message){
    $response = [
        'status'=> $status,
        'status_type' => $status_type,
        'message'=> $message
    ];
    echo json_encode($response);
    return;
}

//category count for dashbord card
function getCount($tableName){
    global $conn;
    $table = validate($tableName);
    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($conn, $query);
    if($query_run){
        $totalCount = mysqli_num_rows($query_run);
        return $totalCount;
    }
    else{
        return 'Somthing Went Wrong!';
    }
}

//display total amount
function getTotalAmount($tableName){
    global $conn;
    $table = validate($tableName);
    $query = "SELECT SUM(total_amount) AS total FROM orders";
    $query_run = mysqli_query($conn, $query);
    if($query_run){
        $row = mysqli_fetch_assoc($query_run);
        return $row['total'] ? $row['total'] : 0;
    }
    else{
        return 'Something Went Wrong!';
    }
}

//display today's total orders amount
function getTodaysTotalAmount($tableName) {
    global $conn;  
    $table = validate($tableName);
    $todayDate = date('Y-m-d');
    $query = "SELECT SUM(total_amount) AS total FROM orders WHERE order_date = '$todayDate'";
    $query_run = mysqli_query($conn, $query);
    if($query_run){
        $row = mysqli_fetch_assoc($query_run);
        return $row['total'] ? $row['total'] : 0;
    }
    else{
        return 'Something Went Wrong!';
    }
}

//total amount of product
function getTotalAmountOfProducts($tableName) {
    global $conn;
    $table = validate($tableName);
    $query = "SELECT SUM(price) AS total FROM products";
    $query_run = mysqli_query($conn, $query);
    if($query_run){
        $row = mysqli_fetch_assoc($query_run);
        return $row['total'] ? $row['total'] : 0;
    }
    else{
        return 'Something Went Wrong!';
    }
}
//active product count
function getActiveProductCount($tableName) {
    global $conn;
    $table = validate($tableName);
    $query = "SELECT COUNT(status) AS total FROM products WHERE status=0";
    $query_run = mysqli_query($conn, $query);
    if($query_run){
        $result = mysqli_fetch_assoc($query_run);
        return $result['total'];
    }
    else{
        return 'Something Went Wrong!';
    }
}
//Deactive product count
function getHiddenProductCount($tableName) {
    global $conn;
    $table = validate($tableName);
    $query = "SELECT COUNT(status) AS total FROM products WHERE status=1";
    $query_run = mysqli_query($conn, $query);
    if($query_run){
        $result = mysqli_fetch_assoc($query_run);
        return $result['total'];
    }
    else{
        return 'Something Went Wrong!';
    }
}
?>