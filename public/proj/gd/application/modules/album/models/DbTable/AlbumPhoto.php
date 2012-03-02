<?php
class Album_Model_DbTable_AlbumPhoto extends Zend_Db_Table_Abstract
{
    protected $_name = 'album_photo';
    protected $_referenceMap = array (
    'album'=> array (
    'columns'=>'album_id',
    'refTableClass'=>'Album_Model_DbTable_Album',
    'refColumns'=>'id'
    )
    );
    
}
