<?php
require '../config/function.php';

$paraResultsId = checkParamId('id');
if(is_numeric($paraResultsId)) {
    $customerId = validate($paraResultsId);
    
    $customer = getById('customers',$customerId);
    if($customer['status'] == 200) {
        $response = delete('customers', $customerId);

        if($response){
            redirect('customers.php','Customer Deleted Successfully!');
        }
        else{
             redirect('customers.php','Somthing Went Wrong!');
        }
    }
    else{
        redirect('customers.php',$customer['message']);
    }
}
else {
    redirect('customers.php','Somthing Went Wrong!');
}



?>