<?php
require '../config/function.php';

$paraResultsId = checkParamId('id');
if(is_numeric($paraResultsId)) {
    $adminId = validate($paraResultsId);
    
    $admin = getById('admins',$adminId);
    if($admin['status'] == 200) {
        $adminDeleteRes = delete('admins', $adminId);

        if($adminDeleteRes){
            redirect('admins.php','Admin Deleted Successfully!');
        }
        else{
             redirect('admins.php','Somthing Went Wrong!');
        }
    }
    else{
        redirect('admins.php',$admin['message']);
    }
}
else {
    redirect('admins.php','Somthing Went Wrong!');
}



?>