<?php

class SearchController extends Base_Controller_Action {

    protected $_sortPosition = true; // to sort with manual positions
    public function preDispatch() {
        parent::preDispatch();
        $this->_helper->layout->setLayout('dih_wide');
    }

    public function init() {
        $this->_helper->cache(array('index'), array('indexaction'));
    }

    public function indexAction() {
//		$this->_helper->layout->disableLayout();
        $this->view->topMenuFlag = true;

           /*$fields = array ('optimize'=> true, 'commit'=> true, 'clean'=> true);
        
//        $curl_request = curl_init('http://pbodev.info:8983/solr/mbartists/dataimport?command=fullimport');
//        $curl_request = curl_init('http://pbodev.info:8983/solr/dataimport?command=fullimport');
        $curl_request = curl_init('http://pbodev.info:8983/solr/select?qt=/dataimport&command=fullimpor&clean=true&commit=true&optimize=true');
        curl_setopt($curl_request, CURLOPT_HEADER, 0);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $fields);
        $curl_response = curl_exec($curl_request);
        curl_close($curl_request);

        prexit($curl_response);*/
        
        $catid = $this->_getParam('category');
        $insuranceid = $this->_getParam('insurance', '');
        $planid = $this->_getParam('plan', '');
        $reasonid = $this->_getParam('reason');
        $sobi2SearchText = addslashes(trim($this->_getParam('searchText')));
        $search1 = trim($this->_getParam('search1'));
        $state = trim($this->_getParam('st'));
        $start_date = $this->_getParam('start_date');
        $isAjax = $this->_getParam('isAjax', 0);

        $reasons = array();
        $linkArray = array();


        $this->view->catid = $catid;
        $this->view->insuranceid = $insuranceid;
        $this->view->planid = $planid;
        $this->view->reasonid = $reasonid;
        $this->view->searchText = stripslashes(stripslashes($sobi2SearchText));
        $this->view->search1 = stripslashes(stripslashes($search1));
        $this->view->start_date = $start_date;
        $this->view->isReasontoVisit = 1;


        // fetch category
        $Category = new Application_Model_Category();
        $categories = $Category->fetchAll("status=1", "name ASC");
        $this->view->categories = $categories;

        // fetch insurance companies
        if ($catid == 7) {
            $plan_type = 'd';
        } else {
            $plan_type = 'g';
        }
        $Plan = new Application_Model_InsurancePlan();
        $plans = $Plan->fetchAll("plan_type='{$plan_type}' AND status=1");
        $planArray = array();
        foreach ($plans as $p) {
            $planArray[] = $p->getInsuranceCompanyId();
        }
        $planArray = array_unique($planArray);
        $planStr = implode(',', $planArray);
        $Insurance = new Application_Model_InsuranceCompany();
        if ($insuranceid){
            $planStr = $planStr . "," . $insuranceid; // when some come from insurance company-plan sitemap directly
            $this->view->insuranceCompany = $Insurance->fetchRow("status=1 AND id ='{$insuranceid}'");
        }
        
        $insurances = $Insurance->fetchAll("status=1 AND id IN ($planStr)", "company ASC");
        $this->view->insurances = $insurances;

        // fetch insurance plans
        $insuranceplans = array();
        if ($insuranceid > 0) {
            $insuranceplans = $Plan->fetchAll("insurance_company_id='{$insuranceid}' AND status=1");
            $linkArray['insurance'] = $insuranceid;
        }
        $this->view->insuranceplans = $insuranceplans;
        //$this->view->insuranceCompany = $insuranceCompany;
        if ($planid > 0) {
            $linkArray['plan'] = $planid;
        }
        if ($reasonid > 0) {
            $linkArray['reason'] = $reasonid;
        }
        if ($search1 != '') {
            $linkArray['search1'] = $search1;
        }
        if ($state != '') {
            $linkArray['st'] = $state;
        }
        if ($sobi2SearchText != '') {
            $linkArray['searchText'] = $sobi2SearchText;
        }
        $isBronze = 0; // 0 - paid doctor, 1 - bronze doctors
        // fetch reason for visits
        if ($catid > 0) {
            $linkArray['category'] = $catid;
            $Reason = new Application_Model_ReasonForVisit();
            $reasons = $Reason->fetchAll("category_id='{$catid}' AND status=1", "reason ASC");
        }
        $this->view->reasons = $reasons;

        
        // ############################################### Search Results ######################################
        $this->view->page = $page = $this->_getParam('page', 1);
//        $Search = new Base_SearchLucene();
        $settings = new Admin_Model_GlobalSettings();
        $limit = $settings->settingValue('pagination_size');
        $searchResults = $this->searchDIH('paid', $limit);
        if(isset($searchResults['other']) && count($searchResults['other']) >0){
            $this->view->otherStates = $searchResults['other'];
        }
//        prexit($searchResults);
        if(isset($searchResults['total']) && $searchResults['total'] < 1){
            // search for bronze doctors
            $isBronze = 1;
            $searchResults = $this->searchDIH('free', $limit);
        }
        
        $this->view->total = $searchResults['total'];
        $this->view->allResultArray = $searchResults['allResultArray'];
        $Paginator = new Base_Paginator();
        $this->view->paginator = $paginator = $Paginator->solrPaginator($searchResults['allResultArray'], $searchResults['total'], $page, $limit);
        $this->view->isBronze = $isBronze;
//        prexit($paginator);
//        $this->view->sortPosition = $this->_sortPosition;
        
        // ############################################ Search Results ##########################################

        $ip = $_SERVER['REMOTE_ADDR'];



        $this->view->linkArray = $linkArray;


        #-----------------------------------Start set title and description as per search result--------------------------- #
        $title = "";
        $desc = "";
        $sobi2Search = "";
        if ($catid != '') {
            $catObj = $Category->find($catid);
            if (!empty($catObj)) {
                $sobi2Search = $catObj->getName();
            }
        }
        $search1 = trim(str_replace(",", " ", $this->_getParam('search1')));


        $insurance_name = "";
        $dentistCategory = array('Dentist', 'Endodontist', 'Periodontist', 'Prosthodontist', 'Oral and Maxillofacial Surgeon', 'Orthodontist');

        if ($insuranceid > 0) {
            $insuranceObj = $Insurance->fetchRow("id='{$insuranceid}'");
            $insurance_name = $insuranceObj->getCompany();
        }

        if ($insuranceid > 0 && (isset($sobi2Search) && in_array($sobi2Search, $dentistCategory) )) {
            $title = "$insurance_name, $insurance_name Dentist, $insurance_name Dental , $insurance_name Dental Insurance Plan";
            $desc = "$insurance_name Dental Insurance Plan: For $insurance_name, $insurance_name Dentist, $insurance_name Dental & Dentist's that Accept $insurance_name Visit Doctors Improving Healthcare";
        } else {
            //if (isset ( $sobi2Search ) && $sobi2Search != "all") { // Speciality serach
            if (isset($sobi2Search) && $sobi2Search != "") { // Speciality serach
                if ($search1 != "") {
                    $title = "$sobi2Search $search1, $sobi2Search $search1";
                    $desc = "$sobi2Search $search1: Find the best Dentist in $search1 with patients reviews. Choose a top rated $sobi2Search $search1 for your needs. Schedule an appointment now!";
                } else {
                    $title = "$sobi2Search San Francisco, New York, Los Angeles(LA), San Diego, CA";
                    $desc = "Find the best $sobi2Search in San Francisco, Los Angeles(LA), San Diego with patients reviews, Make an instant appointment Now!";
                }
            } else { // City, zipcode address serch
                $title = "$search1 Dentist, Doctor, Dermatologist, Plastic/Cosmetic Surgeon";

                if (is_numeric($search1)) { //############# Is zipcode
                    $desc = "Choose from hundreds of local $search1 Top Doctors & Dentists, Dermatologists, Plastic Surgeons, Cosmetic Surgeons & Cosmetic Dentist at Doctors Improving Healthcare.";
                } else {
                    $desc = "$search1 Dentist: Choose from hundreds of Top $search1 Doctors & $search1 Dentists, Dermatologists, Plastic Surgeons, Cosmetic Surgeons & Cosmetic Dentist at Doctors Improving Healthcare.";
                }
            }
        }
        
        
        $returnArray = array();
        if($isAjax){
            $this->_helper->layout->disableLayout();
//            $returnArray['middel_content'] = $this->view->render('search/middle_content.phtml');
            echo $this->view->render('search/middle_content.phtml');
//            echo Zend_Json::encode($returnArray);
            exit(); 
        }
        /* -----------------------------------End set title and description as per search result--------------------------- */
    }

// end function

    public function searchDIH($membershipLevel = "paid", $limit) {

        $result = array();
        $allResultArray = array();
        $page = $this->_getParam('page', 0);
        $catid = $this->_getParam('category');
        $st = $this->_getParam('st');
        $insuranceid = $this->_getParam('insurance');
        $planid = $this->_getParam('plan');
        $reasonid = $this->_getParam('reason');
        $sobi2SearchText = addslashes(trim($this->_getParam('searchText')));
        $search1 = trim($this->_getParam('search1'));

        $search2 = $search1; // just check for neighborhood
        $stateArray = array('st' => strtoupper($st), 'category' => $catid);

        $Search = new Base_SearchLucene($search1, $stateArray, $limit);

        if($membershipLevel=='free'){
			$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/' . APPLICATION_INI, APPLICATION_ENV);
			$Search->_solrPort = $config->dih->bronzeSolrPort;
		}
        $fullState = $Search->getFullStateName(soundex($search1));

        if ($fullState != '') {
            $search1 = $fullState;
        }

        $naborhood = $Search->getNaborhood(strtolower($search2));

        if ($naborhood != '')
            $search1 = $naborhood;


        $Search->_membershipLevel = $membershipLevel;

        if ($catid == '' || $catid < 1)
            $catid = 7; // hardcoded for Dentist

        $sobi2Search = '';
        $Category = new Application_Model_Category();
        $catObj = $Category->find($catid);
        if (!empty($catObj)) {
            $sobi2Search = $catObj->getName();
        }


        if ($sobi2SearchText != '') {
            // Advanced search for doctor name
            $searchResults = $Search->dih_search_by_name_company($sobi2SearchText, $page);
        }


        if (($catid > 0 || $search1 != '') && $sobi2SearchText == '') {
            $searchResults = $Search->partial_search($catid, $search1, $page, $Search->_stateArray);
        }

        $resutls = array();
        $results = $Search->_stateArray;
        
        if(empty($searchResults)){
            $results ['allResultArray'] = array();
            $results ['total'] = 0;
            $results ['start'] = 0;
            return $results;
        }

        

//            $AllResultArray=$Search->new_shuffle_members($AllResultArray); // added Jitu on 12 Jan
        if($this->_sortPosition===true){
            $tempArray = array();
            
            foreach($searchResults->response->docs as $doc){
                // this is zipcode condition for doctor if doctor does not
//                if($doc->id==40239)prexit($doc);
                if((isset($doc->zipcode) && $doc->zipcode==$search1 && $doc->use_zip==false) || (isset($doc->zipcode1) && $doc->zipcode1==$search1 && $doc->use_zip1==false)
                    || (isset($doc->zipcode2) && $doc->zipcode2==$search1 && $doc->use_zip2==false) || (isset($doc->zipcode3) && $doc->zipcode3==$search1 && $doc->use_zip3==false)
                    || (isset($doc->zipcode4) && $doc->zipcode4==$search1 && $doc->use_zip4==false) && (isset($doc->zipcode5) && $doc->zipcode5==$search1 && $doc->use_zip5==false))
                {
                    $tempArray[$doc->id] = $doc;
                }else{
                    $allResultArray[$doc->id] = $doc;
                }
            }
            if(!empty($tempArray)){
                foreach($tempArray as $tmpDoc){
                    $allResultArray[$tmpDoc->id] = $tmpDoc;
                }
            }
    //        prexit($searchResults->response);
            $Search->updatePosition(&$allResultArray, $catid, $search1);
            $results ['allResultArray'] = $allResultArray;
        }else{
            $results ['allResultArray'] = $searchResults->response->docs;
        }
//        echo "##########################################################################################################";
//        prexit($results);
        $results ['total'] = $searchResults->response->numFound;
        $results ['start'] = $searchResults->response->start;
        
//        $results ['solrResponseDocs'] = $searchResults->response->docs;


        return $results;
    }
    
    
    
    public function timeslotAction(){

        $post = array();
        $post['drid']       = $this->_getParam('drid');
        $post['start_date'] = $this->_getParam('start_date');
        $post['type'] = 0; // type '0' for doctor listing page.

        $Timeslot = new Base_Timeslot();
        $Timeslot->getAppointmentAvailability($post);
    }
    
    
    public function autoseggestAction(){
        
        $q       = strtolower($this->_getParam('q'));
        
        if (!$q) return;
        $db = Zend_Registry::get('db');
        $query = "SELECT `city` FROM `cache_cities` WHERE city LIKE '{$q}%'";
        $select = $db->query($query);
        $docObject = $select->fetchAll();
       foreach($docObject as $obj){
            echo $obj->city."\n";
            //echo $obj->getCity()."hello|hi\n";
       }
        
        exit();
    }
    
    public function seggessionPopupAction(){
       
        $this->_helper->layout->disableLayout();
        $catid = $this->_getParam('category');
        $category = "";
        $category_id = 0;
        if($catid > 0){
            $Category = new Application_Model_Category();
            $object = $Category->find($catid);
            if($object){
                $category = $object->getName();
                $category_id = $object->getId();
            }
        }
         $this->view->category = $category;
         $this->view->catid = $category_id;


        $this->view->search1 = ucwords($this->_getParam('search1'));

    }// end function
    
    public function insuranceAction() {
        
        $this->_helper->layout->disableLayout();
        $drids = trim($this->_getParam('drids'));
        $comp_id = $this->_getParam('comp_id');
        $DoctorInsurance = new Application_Model_DoctorInsurance();
        if($comp_id > 0){
            $Company = new Application_Model_InsuranceCompany();
            $insuranceCompany = $Company->find($comp_id);
        }
        $returnArray = array();
        $dridArray = explode(' ', $drids);
        if(count($dridArray)){
            foreach($dridArray as $drid){
                if($comp_id > 0){
                    $object = $DoctorInsurance->fetchRow("doctor_id={$drid} AND insurance_id={$comp_id}");
                    if(!empty($object)){
                        $returnArray[$drid] = "<div class=\"in-network\">In Network</div>
        <img width=\"125\" alt=\"{$insuranceCompany->getCompany()}\" src=\"/images/insurance/{$insuranceCompany->getLogo()}\">";
                    }else{
                        $returnArray[$drid] = "<strong>Out of network.</strong><br />Please contact the Doctor's office to see if they file paperwork.";
                    }
                }elseif($comp_id==-1){
                    $returnArray[$drid] = "<span class='na'>N/A</span>";
                }else{
                    $returnArray[$drid] = "Please enter your insurance at the top of the page.";
                }
            }
        }
        echo Zend_Json::encode($returnArray);
        exit();
    }
    
    function footerarticleAction(){
        $this->_helper->layout->disableLayout();
        $this->view->catid = $this->_getParam('category');
        $this->view->insuranceid = $this->_getParam('insurance', '');
        $this->view->planid = $this->_getParam('plan', '');
        $this->view->reasonid = $this->_getParam('reason');
        $this->view->searchText = addslashes(trim($this->_getParam('searchText')));
        $this->view->search1 = trim(stripslashes(stripslashes($this->_getParam('search1'))));
        echo $this->view->footerArticle(); // call Veiw Helper - Base_View_Helper_FooterArticle
        exit();
    }

}
