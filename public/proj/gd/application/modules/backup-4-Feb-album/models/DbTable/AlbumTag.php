<?php
class Album_Model_DbTable_AlbumTag extends Zend_Db_Table_Abstract
{
    protected $_name = 'album_tag';
    protected $_referenceMap = array (
    'tags'=> array (
    'columns'=>'tag_id',
    'refTableClass'=>'Application_Model_Tags',
    'refColumns'=>'id'
    )
    );
    
}
