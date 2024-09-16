<?php
require '../config/function.php';

$paraResultsId = checkParamId('id');
if(is_numeric($paraResultsId)) {
    $product_id = validate($paraResultsId);
    
    $product = getById('products',$product_id);
    if($product['status'] == 200) {
        $response = delete('products', $product_id);

        if($response){
            $deleteImage = "../".$product['data']['image'];
            if(file_exists($deleteImage)){
                unlink($deleteImage);
            }

            redirect('products.php','Product Deleted Successfully!');
        }
        else{
             redirect('products.php','Somthing Went Wrong!');
        }
    }
    else{
        redirect('products.php',$product['message']);
    }
}
else {
    redirect('products.php','Somthing Went Wrong!');
}



?>