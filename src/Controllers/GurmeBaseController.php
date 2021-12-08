<?php
namespace GurmeFramework\Controllers;

use PhpRestfulApiResponse\Response;

class GurmeBaseController{

    public function output($data,$status="created",$code=200){
        $response=new Response();
        echo $response->withArray([
            'status' => $status,
            'data'=>$data
        ], $code);
    }
}