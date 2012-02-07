<?php
class Application_Model_HomeMidContent
{
    protected $_id;
    protected $_title;
    protected $_subTitle1;
    protected $_subTitle1Text;
	protected $_subTitle2;
	protected $_subTitle2Text;
	protected $_editorPic;
	protected $_editorPicTitle;
	protected $_editorPicText;
	protected $_editorPicUrlLabel;
    protected $_editorPicUrlLink;
    protected $_editorPicUrlTarget;
    protected $_status;
    protected $_userId;
	protected $_addedon;
    protected $_updatedon;
    protected $_mapper;
    
    public function __construct(array $options = null)
    {
        if (is_array($options))
		{
            $this->setOptions($options);
        }
    }

    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
		{
            throw new Exception('Setting invalid table property');
        }
        $this->$method($value);
    }
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method))
		{
            throw new Exception('Getting invalid table property'.$method);
        }
        return $this->$method();
    }
	
	public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }    
    public function getMapper()
    {
        if (null === $this->_mapper)
		{
            $this->setMapper(new Application_Model_HomeMidContentMapper());
        }
        return $this->_mapper;
    }

    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value)
		{
            $method = 'set' . ucfirst($key);
		    if (in_array($method, $methods))
			{
                $this->$method($value);
            }
        }
        return $this;
    }
	    
 	public function setId($id)
    {
        $this->_id = (int) $id;
        return $this;
    }
    public function getId()
    {
        return $this->_id;
    }
    
    public function setTitle($title)
    {
        $this->_title = (string) $title;
        return $this;
    }
	public function getTitle()
    {
        return $this->_title;
    }
	
	public function setSubTitle1($subTitle1)
    {
        $this->_subTitle1 = (string) $subTitle1;
        return $this;
    }
    public function getSubTitle1()
    {
        return $this->_subTitle1;
    }
    
    public function setSubTitle1Text($subTitle1Text)
    {
        $this->_subTitle1Text = (string) $subTitle1Text;
        return $this;
    }
    public function getSubTitle1Text()
    {
        return $this->_subTitle1Text;
    }
	
	public function setSubTitle2($subTitle2)
    {
        $this->_subTitle2 = (string) $subTitle2;
        return $this;
    }
    public function getSubTitle2()
    {
        return $this->_subTitle2;
    }
    
    public function setSubTitle2Text($subTitle2Text)
    {
        $this->_subTitle2Text = (string) $subTitle2Text;
        return $this;
    }
    public function getSubTitle2Text()
    {
        return $this->_subTitle2Text;
    }
	
	public function setEditorPic($editorPic)
    {
        $this->_editorPic = (string) $editorPic;
        return $this;
    }
    public function getEditorPic()
    {
        return $this->_editorPic;
    }
    
    public function setEditorPicTitle($editorPicTitle)
    {
        $this->_editorPicTitle = (string) $editorPicTitle;
        return $this;
    }
    public function getEditorPicTitle()
    {
        return $this->_editorPicTitle;
    }
    
    public function setEditorPicText($editorPicText)
    {
        $this->_editorPicText = (string) $editorPicText;
        return $this;
    }
    public function getEditorPicText()
    {
        return $this->_editorPicText;
    }
    
  	public function setEditorPicUrlLabel($editorPicUrlLabel)
    {
        $this->_editorPicUrlLabel = (string) $editorPicUrlLabel;
        return $this;
    }
    public function getEditorPicUrlLabel()
    {
        return $this->_editorPicUrlLabel;
    }
    
	public function setEditorPicUrlLink($editorPicUrlLink)
    {
        $this->_editorPicUrlLink = (string) $editorPicUrlLink;
        return $this;
    }
    public function getEditorPicUrlLink()
    {
        return $this->_editorPicUrlLink;
    }

    public function setEditorPicUrlTarget($editorPicUrlTarget)
    {
        $this->_editorPicUrlTarget= (string) $editorPicUrlTarget;
        return $this;
    }
    public function getEditorPicUrlTarget()
    {
        return $this->_editorPicUrlTarget;
    }

    public function setStatus($status)
    {
        $this->_status= (int) $status;
        return $this;
    }
    public function getStatus()
    {
        return $this->_status;
    }    
    
	public function setUserId($userId)
    {
        $this->_userId= (int) $userId;
        return $this;
    }
    public function getUserId()
    {
        return $this->_userId;
    }	
    
	public function setAddedon($addedon)
    {
        $this->_addedon = (int) $addedon;
        return $this;
    }
    public function getAddedon()
    {
        return $this->_addedon;
    }
    
	public function setUpdatedon($updatedon)
    {
        $this->_updatedon = (int) $updatedon;
        return $this;
    }
    public function getUpdatedon()
    {
        return $this->_updatedon;
    }
	
    /*----Data Manupulation functions ----*/
    private function setModel($row)
    {
    	$model = new Application_Model_HomeMidContent();
        $model->setId($row->id)
              ->setTitle($row->title)
              ->setSubTitle1($row->sub_title1)
              ->setSubTitle1Text($row->sub_title1_text)
              ->setSubTitle2($row->sub_title2)
              ->setSubTitle2Text($row->sub_title2_text)
              ->setEditorPic($row->editor_pic)
              ->setEditorPicTitle($row->editor_pic_title)
			  ->setEditorPicText($row->editor_pic_text)
			  ->setEditorPicUrlLabel($row->editor_pic_url_label)
			  ->setEditorPicUrlLink($row->editor_pic_url_link)
			  ->setEditorPicUrlTarget($row->editor_pic_url_target)
              ->setStatus($row->status)
              ->setUserId($row->user_id)
			  ->setAddedon($row->addedon)              
              ->setUpdatedon($row->updatedon)              
              ;
             return $model;
    }
    
    public function save()
    {
      	$data = array(
            'title'					=> $this->getTitle(),
	  	  	'sub_title1'   			=> $this->getSubTitle1(),
		    'sub_title1_text'	  	=> $this->getSubTitle1Text(),
  	  		'sub_title2'   			=> $this->getSubTitle2(),
  	  	    'sub_title2_text' 		=> $this->getSubTitle2Text(),
  	  		'editor_pic'   			=> $this->getEditorPic(),
  	  		'editor_pic_title'		=> $this->getEditorPicTitle(),
  	  		'editor_pic_text'   	=> $this->getEditorPicText(),
			'editor_pic_url_label'	=> $this->getEditorPicUrlLabel(),
			'editor_pic_url_link'   => $this->getEditorPicUrlLink(),
			'editor_pic_url_target' => $this->getEditorPicUrlTarget(),
  	  		'status'   				=> $this->getStatus(),		
        	'user_id' 				=> $this->getUserId(),
        );
		//print_r($data);exit;		        
        if (null === ($id = $this->getId()))
		{
			unset($data['id']);
			$data['addedon'] = time();
			return $this->getMapper()->getDbTable()->insert($data);
        }
		else
		{
			$data['updatedon'] = time();
			return $this->getMapper()->getDbTable()->update($data, array('id = ?' => $id));
        }        
    }//end function


    public function find($id)
    {
        $result = $this->getMapper()->getDbTable()->find($id);
        if (0 == count($result))
		{
            return false;
        }
        $row = $result->current();
        $res=$this->setModel($row);
        return $res;
    }
	

    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
        $resultSet = $this->getMapper()->getDbTable()->fetchAll($where, $order , $count , $offset);
        $entries   = array();
        foreach ($resultSet as $row) 
        {
            $res=$this->setModel($row);
            $entries[] = $res;
        }
        return $entries;        
    }
    
    public function fetchRow($where)
    {
    	$row = $this->getMapper()->getDbTable()->fetchRow($where);

       	if(!empty($row))
       	{
 			$res=$this->setModel($row);
 			return $res;
       	}
       	else 
       	{
       		return false;
       	}        
    }   
    
    public function delete($where)
    {
    	return $this->getMapper()->getDbTable()->delete($where);
    }    
}
