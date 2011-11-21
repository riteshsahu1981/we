<?php
class test{
    public function process($c,$d=25){
        global $e;
        $retval = $c + $d - $_GET['c']-$e;
        return "res : ".$retval;
    }
}
$e = 10;
$obj=new test();
echo $obj->process(5);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
