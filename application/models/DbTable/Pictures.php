<?php

class Application_Model_DbTable_Pictures extends Zend_Db_Table_Abstract
{
    protected $_name = 'pictures';
    
    protected $_referenceMap = array (
            'Album'=> array (
            'columns'=>'album_id',
            'refTableClass'=>'Application_Model_DbTable_Album',
            'refColumns'=>'id'
            )
           
            );
}
