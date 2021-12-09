<?php
namespace GurmeFramework\Base;

use PhpRestfulApiResponse\Response;

class BaseController{

    public function output($data,$status="created",$code=200){
        http_response_code($code);
        echo json_encode($data);
        exit();
    }
}