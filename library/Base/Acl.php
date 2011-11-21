<?php
class Base_Acl  extends Zend_Acl{
	
    public function __construct()
    {
     	$this->setRoles();
        $this->setResources();
        $this->setPrivilages();
    }
	
    public function setRoles()
    {
        $this->addRole(new Zend_Acl_Role('guest'));
        $this->addRole(new Zend_Acl_Role('employee'), 'guest');
        $this->addRole(new Zend_Acl_Role('team_leader'), 'employee');
        $this->addRole(new Zend_Acl_Role('project_manager'), 'team_leader');
        $this->addRole(new Zend_Acl_Role('human_resource'), 'employee');
        $this->addRole(new Zend_Acl_Role('administrator'), 'human_resource');
    }
    
    public function setResources()
    {   
        /** Default module */
        $this->add(new Zend_Acl_Resource('default'))
              ->add(new Zend_Acl_Resource('default:error','default'))
              ->add(new Zend_Acl_Resource('default:employee','default'))
              ->add(new Zend_Acl_Resource('default:hr','default'))
              ->add(new Zend_Acl_Resource('default:image','default'))
              ->add(new Zend_Acl_Resource('default:cms','default'))
              ->add(new Zend_Acl_Resource('default:pm','default'))
                ->add(new Zend_Acl_Resource('default:gallery','default'))
              ->add(new Zend_Acl_Resource('default:index','default'));
                      
    }

    public function setPrivilages()
    {
        /* guest */
	$this->allow('guest',array('default:index', 'default:error', 'default:image'));
        
        /* employee */
	$this->allow('employee',array('default:employee'));
        //$this->deny('employee',array('default:employee'), array('create-request'));
      //$this->allow('employee',array('default:hr'));
        /* human_resource */
        $this->allow('human_resource',array('default:hr','default:cms','default:gallery'));
        
        /* project manager */
        $this->allow('project_manager',array('default:pm'));
        
        /* administrator*/
	$this->allow('administrator');
    }
}
