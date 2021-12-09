<?php
namespace GurmeFramework\Base;

use PhpRestfulApiResponse\Response;

class BaseController{

    public function output($data,$status="created",$code=200){
        $response=new Response();
        echo $response->withArray([
            'status' => $status,
            'data'=>$data
        ], $code);
    }
}