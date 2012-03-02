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
        
        $this->addRole(new Zend_Acl_Role('administrator'), 'guest');
    }
    
    public function setResources()
    {   
        /** Default module */
        $this->add(new Zend_Acl_Resource('default'))
        ->add(new Zend_Acl_Resource('default:error','default'))
        ->add(new Zend_Acl_Resource('default:image','default'))
        ->add(new Zend_Acl_Resource('default:seo-url','default'))
        ->add(new Zend_Acl_Resource('default:user-privilege','default'))
       ->add(new Zend_Acl_Resource('default:db-config','default'))
        ->add(new Zend_Acl_Resource('default:log','default'))
        ->add(new Zend_Acl_Resource('default:index','default'))
          ->add(new Zend_Acl_Resource('default:user','default'));
        
        
        
        /// demomodle module
       // $this->add(new Zend_Acl_Resource('demomodule'))
             //   ->add(new Zend_Acl_Resource('demomodule:index', 'index'));
        // admin module
        $this->add(new Zend_Acl_Resource('admin'))
                ->add(new Zend_Acl_Resource('admin:index', 'admin'))
                
                ->add(new Zend_Acl_Resource('admin:dashboard', 'admin'))
                 ->add(new Zend_Acl_Resource('admin:log', 'admin'))
                ->add(new Zend_Acl_Resource('admin:user-privilege', 'admin'))
                ->add(new Zend_Acl_Resource('admin:db-config', 'admin'))
               
            ;
                      
        
        // security module
        
        $this->add(new Zend_Acl_Resource('security'))
                ->add(new Zend_Acl_Resource('security:user', 'security'))
                ->add(new Zend_Acl_Resource('security:privilege', 'security'))
                ->add(new Zend_Acl_Resource('security:legend', 'security'))
                ->add(new Zend_Acl_Resource('security:menu', 'security'))
            ;
    }

    public function setPrivilages()
    {
        /* guest */
	$this->allow('guest',array('default:index', 'default:error', 'default:image', 'admin:index'));
        
        
        /* administrator*/
	$this->allow('administrator');
    }
}
