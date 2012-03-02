<?php
class Base_Filter_AddSlashes implements Zend_Filter_Interface
{
    public function filter($value)
    {
        return get_magic_quotes_gpc() ?   $value : $this->_clean($value);
    }
 
    protected function _clean($value)
    {
        return is_array($value) ? array_map(array($this, '_clean'), $value) : addslashes($value);
    }
    
}