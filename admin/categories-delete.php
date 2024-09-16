<?php
require '../config/function.php';

$paraResultsId = checkParamId('id');
if(is_numeric($paraResultsId)) {
    $categoryId = validate($paraResultsId);
    
    $category = getById('categories',$categoryId);
    if($category['status'] == 200) {
        $response = delete('categories', $categoryId);

        if($response){
            redirect('categories.php','Category Deleted Successfully!');
        }
        else{
             redirect('categories.php','Somthing Went Wrong!');
        }
    }
    else{
        redirect('categories.php',$category['message']);
    }
}
else {
    redirect('categories.php','Somthing Went Wrong!');
}



?>