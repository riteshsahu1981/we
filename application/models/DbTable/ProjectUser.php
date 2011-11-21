<?php

class Application_Model_DbTable_ProjectUser extends Zend_Db_Table_Abstract
{
    protected $_name = 'project_user';
    protected $_referenceMap    = array(
        
        'User' => array(
            'columns'           => array('user_id'),
            'refTableClass'     => 'Application_Model_DbTable_User',
            'refColumns'        => array('id')
        ),
        'Project' => array(
            'columns'           => array('project_id'),
            'refTableClass'     => 'Application_Model_DbTable_Project',
            'refColumns'        => array('id')
        )
    );
}
