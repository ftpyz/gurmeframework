<?php
namespace GurmeFramework\Controllers;
use GurmeFramework\Base\BaseController;

class SettingsController extends BaseController{

    public function getSMSProviders(){
        $data=array(
            array("name"=>"verimor")
        );
        return $this->output($data);
    }
}