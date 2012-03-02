<?php

class Base_Search {

    protected $_positionArray;
    public $_distanceArray;
    public $_membershipLevel = PAID_SEARCH;
//    public $_membershipLevel = NO_SILVER; // commented by jitu
    public $_stateArray;

    public function __construct($search1=null, $stateArray=array()) {
       
        $this->_stateArray = $this->getSelectedState($search1, $stateArray);

        
    }
    public function insuranceavailble($listingid,$insuranceid)
    {
        $Insurance = new Application_Model_DoctorInsurance();
        $insuranceObj = $Insurance->fetchAll("doctor_id='{$listingid}' AND insurance_id='{$insuranceid}'");
	//$query	=	"SELECT * FROM doctor_insurances "." WHERE doctor_id='{$listingid}' AND insurance_id='{$insuranceid}'";
	return count($insuranceObj);
    }// end function

   public function dih_search_categories($value, $CatResultArray, $searchtypeR="") {

        $db = Zend_Registry::get('db');
        $Doctor = new Application_Model_Doctor();

        $ChildCatMatchAr = array();
        $ExactCatMatchAr = $this->dih_search_get_catid_byname($value, "Exact");
        
        $PartialCatMatchAr = $this->dih_search_get_catid_byname($value, "Partial");
        $PartialLangCatMatchAr = $this->dih_search_get_catid_byname($value, "PartialLang");

        if ((isset($_GET['searchphrase']) && $_GET['searchphrase'] == "fromcat") OR $searchtypeR == "Exact") {
            $PartialCatMatchAr = array();
            $PartialLangCatMatchAr = array();
        }

        // commented by Jitu
        /* if (count($ExactCatMatchAr)) {
          $ChildCatMatchAr = dih_get_childCatIds($ExactCatMatchAr['0']);
          } */


        foreach ($ExactCatMatchAr as $ExactMatchValue) {

            $catid = $ExactMatchValue->getId();
            
            $query = "SELECT DISTINCT (d.id) AS did FROM doctor_categories dc, doctors d
                        WHERE d.id=dc.doctor_id AND d.status='1' AND dc.category_id={$catid} AND d.membership_level IN ({$this->_membershipLevel}) ";
            /*$query = "SELECT DISTINCT (d.id) AS did FROM doctor_categories dc, doctors d
                        WHERE d.id=dc.doctor_id AND d.status='1' AND dc.category_id={$catid} AND d.membership_level IN ('Platinum','Gold','Silver','Bronze Premium') ";*/
           
                        $select = $db->query($query);
            $docObject = $select->fetchAll();

            
            //$docObject = $Doctor->fetchAll("category_id = {$catid} AND membership_level IN ('Platinum','Gold','Silver','Bronze Premium') AND status=1 ");
            /* $query = "SELECT DISTINCT(ir.itemid) FROM #__sobi2_cat_items_relations ir, #__profile p
              WHERE p.itemid=ir.itemid AND p.published='1' AND  ir.catid=$catid AND p.field_membership_level IN ('Platinum','Gold','Silver','Bronze Premium')";
             */
            if (!empty($docObject)) {
                foreach ($docObject as $value) {
                    if (!isset($CatResultArray [$value->did])) {
                        $CatResultArray [$value->did] = 0;
                    }
//                    $CatResultArray [$value->did] += 10; // commented by jitu 12 Feb
                    $CatResultArray [$value->did] += 3;
                }
            }
        }


        // commented by jitu
        /* foreach ($ChildCatMatchAr as $ExactMatchValue) {
          $catid = $ExactMatchValue->catid;
          $query = "select DISTINCT(ir.itemid) from #__sobi2_cat_items_relations ir, #__profile p where p.itemid=ir.itemid AND p.published='1' AND  ir.catid=$catid AND p.field_membership_level IN ('Platinum','Gold','Silver','Bronze Premium') ";

          $database->setQuery($query);
          $rs_E_cat = $database->loadObjectList();
          print mysql_error();
          foreach ($rs_E_cat as $value) {
          if (!isset($CatResultArray [$value->itemid])) {
          $CatResultArray [$value->itemid] = 0;
          }
          $CatResultArray [$value->itemid] += 7;
          }
          } */
        foreach ($PartialCatMatchAr as $ExactMatchValue) {
            $catid = $ExactMatchValue->getId();
            
            $query = "SELECT DISTINCT (d.id) AS did FROM doctor_categories dc, doctors d
                        WHERE d.id=dc.doctor_id AND d.status='1' AND dc.category_id={$catid} AND d.membership_level IN ({$this->_membershipLevel}) ";
            /*$query = "SELECT DISTINCT (d.id) AS did FROM doctor_categories dc, doctors d
                        WHERE d.id=dc.doctor_id AND d.status='1' AND dc.category_id={$catid} AND d.membership_level IN ('Platinum','Gold','Silver','Bronze Premium') ";*/
            $select = $db->query($query);
            $docObject = $select->fetchAll();

            //$docObject = $Doctor->fetchAll("category_id = {$catid} AND membership_level IN ('Platinum','Gold','Silver','Bronze Premium') AND status=1 ");
            if (!empty($docObject)) {
                foreach ($docObject as $value) {
                    if (!isset($CatResultArray [$value->did])) {
                        $CatResultArray [$value->did] = 0;
                    }
//                    $CatResultArray [$value->did] += 5; // commented by jitu 12 Feb
                    $CatResultArray [$value->did] += 1;
                }
            }
        }


        foreach ($PartialLangCatMatchAr as $ExactMatchValue) {
            $catid = $ExactMatchValue->getId();
            $query = "SELECT DISTINCT (d.id) AS did FROM doctor_categories dc, doctors d
                        WHERE d.id=dc.doctor_id AND d.status='1' AND dc.category_id={$catid} AND d.membership_level IN ({$this->_membershipLevel}) ";

             /*$query = "SELECT DISTINCT (d.id) AS did FROM doctor_categories dc, doctors d
                        WHERE d.id=dc.doctor_id AND d.status='1' AND dc.category_id={$catid} AND d.membership_level IN ('Platinum','Gold','Silver','Bronze Premium') ";*/
            $select = $db->query($query);
            $docObject = $select->fetchAll();
           // $docObject = $Doctor->fetchAll("category_id = {$catid} AND membership_level IN ('Platinum','Gold','Silver','Bronze Premium') AND status=1 ");
            if (!empty($docObject)) {
                foreach ($docObject as $value) {
                    if (!isset($CatResultArray [$value->did])) {
                        $CatResultArray [$value->did] = 0;
                    }
//                    $CatResultArray [$value->did] += 7; // commented by jitu 12 Feb
                    $CatResultArray [$value->did] += 2;
                }
            }
        }
    }

    public function dih_search_get_catid_byname($value, $searchtype) {

        if ($searchtype == "PartialLang") {
            $key = "left(soundex( name ),4)";
            $value = "left(soundex( '$value' ),4)";
            $conditionoperator = " = ";
        }

        if ($searchtype == "Partial") {

            $key = "name";
            $value = "'%$value%'";
            $conditionoperator = " like ";
        }

        if ($searchtype == "Exact") {

            $key = "name";
            $value = "'$value'";
            $conditionoperator = " = ";
        }

        $Category = new Application_Model_Category();
        //echo "$key $conditionoperator $value";
        $catObj = $Category->fetchAll("$key $conditionoperator $value");
        //$query = "SELECT catid FROM #__sobi2_categories WHERE $key $conditionoperator $value";
        /* if(!empty($catObj)){

          } */
//echo "<pre>";print_r($catObj);exit;
        return $catObj;
    }

    /* public function dih_get_childCatIds($catid)
      {
      global $arrayCatIds;
      $arrayCatIds[]=$catid;
      $SQL="SELECT catid FROM dih_sobi2_cats_relations WHERE parentid='".$catid."'";
      $RES=mysql_query($SQL);
      if(mysql_num_rows($RES)>0)
      {
      while($ROW=mysql_fetch_array($RES))
      {
      getAllRelatedId($ROW['catid']);
      }
      }
      return $arrayCatIds;
      } */

    public function dih_search_query($fieldswithvalues, $searchtype, $resultArray, $matchPoint = false, $operator = "OR", $searchArea='paid') {

        $searchwhereAr = array();

        foreach ($fieldswithvalues as $key => $value) {
//                $value = mysql_real_escape_string($value);
                $value = addslashes($value);
            if ($searchtype == "PartialLang") {
//                $POINT = $matchPoint == false ? 7 : $matchPoint; // commented by Jitu on 12 Feb
                $POINT = $matchPoint == false ? 2 : $matchPoint;
                $key = "soundex($key)";
                $value = "soundex('$value')";
                $conditionoperator = " = ";
            }

            if ($searchtype == "Partial") {

//                $POINT = $matchPoint == false ? 5 : $matchPoint; // commented by Jitu on 12 Feb
                $POINT = $matchPoint == false ? 1 : $matchPoint;
                $key = "`$key`";
                $value = "'%$value%'";
                $conditionoperator = " like ";
            }

            if ($searchtype == "Exact") {

//                $POINT = $matchPoint == false ? 10 : $matchPoint; // commented by Jitu on 12 Feb
                $POINT = $matchPoint == false ? 3 : $matchPoint;
                if ($value == "Bronze" && $key == "membership_level" && $searchArea=='paid') {
                    $key = "`$key`";
                    $value = "'$value'";
                    $conditionoperator = " != ";
                } else {
                    $key = "`$key`";
                    $value = "'$value'";
                    $conditionoperator = " = ";
                }
            }

            $searchwhereAr [] = "$key $conditionoperator $value";
			
        }
        $zipWhere ='';
        if(isset($fieldswithvalues['city']) && is_int($fieldswithvalues['city'])){
//        if(isset($fieldswithvalues['city'])){

            $zipWhere = " AND ((zipcode='{$fieldswithvalues['city']}' AND use_zip=1) OR (zipcode1='{$fieldswithvalues['city']}' AND use_zip1=1)
                            OR (zipcode2='{$fieldswithvalues['city']}' AND use_zip2=1))";
                            //die($zipWhere);
        }
        $whr = "";
        if(isset($this->_stateArray['selected']) && $this->_stateArray['selected']!='')$whr = " AND state='{$this->_stateArray['selected']}'";

        $searchwhereStr = implode($operator, $searchwhereAr);
        $where = " AND membership_level IN ({$this->_membershipLevel}) {$whr} {$zipWhere}"; // added by jitu, not fetch the record from bronze and bronze premium
		
        $Doctor = new Application_Model_Doctor();
        $docObject = $Doctor->fetchAll("$searchwhereStr AND status='1' $where");
        if(isset($fieldswithvalues['city'])){
            //die("$searchwhereStr AND status='1' $where");
        }

        foreach ($docObject as $obj) {
            $doc_id = trim($obj->getId());
			
            if (!isset($resultArray [$doc_id])) {
                $resultArray [$doc_id] = 0;
            }
            $resultArray [$doc_id] += $POINT;
        }
//		echo "<br><br>search were str=".$searchwhereStr ." AND where=".$where;
		
        return $resultArray;
    }

    public function getSelectedState($cityname, $stateArray=array(), $category= null){
//        $cityname = mysql_real_escape_string($cityname);
        $cityname = addslashes($cityname);
        $db = Zend_Registry::get('db');
        if(isset($stateArray['category']) && $stateArray['category']!=''){
            $queryState = "SELECT d.`state` FROM `doctors` d, `doctor_categories` dc
                        WHERE d.id=dc.doctor_id AND d.membership_level IN ({$this->_membershipLevel})
                        AND d.`city` = '$cityname' AND d.`status`=1 AND dc.category_id='{$stateArray['category']}'";
        }else{
            $queryState = "SELECT `state` FROM `doctors`
                            WHERE membership_level IN ({$this->_membershipLevel})
                            AND `city` = '$cityname' AND `status`=1";
        }
			//die($queryState);
        $selectState = $db->query($queryState);
        $resultState = $selectState->fetchAll();
		
        if(count($resultState)> 1){
            foreach($resultState as $states)$stateArray['other'][$states->state] = $states->state;
            if(isset($stateArray['st']) && $stateArray['st']!=''){
                unset($stateArray['other'][$stateArray['st']]);
                $stateArray['selected'] = $stateArray['st'];
            }else{
                 $stateArray['selected'] = array_pop($stateArray['other']);
		 $stateArray['st'] = $stateArray['selected'];
            }
        }elseif(count($resultState)== 1){
			 $stateArray['st'] = $resultState[0]->state;
		}
                
		//echo "<pre>";print_r($stateArray);exit;
        return $stateArray;
    }
    //MatchPoint increase by 20 shekhar on 21 January 2011 for in network should come once
    public function dih_search_insurance($insurance, $AllResultArray, $matchpoint = 170) {
            $matchpoint = count($AllResultArray)*2; // added by jitu on 12 Feb
        //echo "<pre>";print_r($AllResultArray);
        
            if(!empty($AllResultArray)){
                $DoctorInsurance = new Application_Model_DoctorInsurance();
                
                $where = "doctor_id IN (".implode(',',array_keys($AllResultArray)).") AND insurance_id='{$insurance}'";
                //echo "whereclause =".$where;
                $insObject = $DoctorInsurance->fetchAll($where);
                if(!empty($insObject)){
                    foreach($insObject as $ins){
                        if(isset($AllResultArray[$ins->getDoctorId()]) && $AllResultArray[$ins->getDoctorId()] > 0){
                           
                            $AllResultArray[$ins->getDoctorId()] = $AllResultArray[$ins->getDoctorId()]+$matchpoint;
                        }
                    }
                }
                //$where = array_keys($AllResultArray);
            }
            //echo "<pre>";print_r($AllResultArray);exit;
        
    }


        public function dih_search_zip($zipcode, $AllResultArray, $search_type="zipcode", $distance = 10, $matchpoint = 100, $stateArray=array()) {
//        $zipcode = mysql_real_escape_string($zipcode);
        $zipcode = addslashes($zipcode);
        $db = Zend_Registry::get('db');
        //$where ="";
        if ($search_type == "city") {
            $whr_state ="";
            if(isset($stateArray['st']) && $stateArray['st']!=''){
                $whr_state = " AND `statename`='{$stateArray['st']}'";
                //$where  = "AND z.statename='{$stateArray['st']}'";
            }else{
                $whr_state =" AND `prefered_state`='1'";
            }

            $query = "SELECT * FROM zipcodesusa WHERE cityname = '$zipcode' AND `deleted`='0' AND `used_geocode`='1' {$whr_state} ";
          
            /*$queryState = "SELECT `statename` FROM `zipcodesusa`
                            WHERE `cityname` = '$zipcode' AND deleted='0'  AND used_geocode='1' GROUP BY `statename`  ";
            $selectState = $db->query($queryState);
            $resultState = $selectState->fetchAll();
            if(count($resultState)> 1){
                foreach($resultState as $states)$stateArray['other'][$states->statename] = $states->statename;
            }*/
            
            //$query = "SELECT * FROM zipcodesusa WHERE cityname = '$zipcode' ORDER BY latitude DESC ";
            $distance = 150;
            $matchpoint = 150;
        } else {
            $query = "SELECT * FROM zipcodesusa WHERE zipcode = '$zipcode'";
            $distance = 150;
            //$matchpoint = 150;// added by jitu on 05 Jan 2011
        }
        
        $select = $db->query($query);
        $result = $select->fetch();

        
        if ($result) { //################### Is a valid ZIP code
//           prexit($result);
            $varLatitude = $result->latitude;
            $varLongitude = $result->longitude;
            $zip1State = $result->statename;
            $zip1City = $result->cityname;
            $varZip = $zipcode;
            $varMiles = $distance; //Max distance

            // unset the current state name from the array
            /*if(!empty($stateArray) && isset($stateArray['other'][$zip1State])){
                unset($stateArray['other'][$zip1State]);
                $stateArray['selected'] = $zip1State;
            }*/
            //echo "<pre>";print_r($stateArray);exit;

           //$query = "SELECT DISTINCT z.zipcode, z.cityname, // changed by jitu on 08 Feb 2011
           $query = "SELECT DISTINCT z.zipcode, z.cityname,
                                    sqrt(power(69.1*(z.latitude - ($varLatitude)),2)+ power(69.1*(z.longitude-($varLongitude))*cos(z.latitude/57.3),2)) as dist,
                                    d.id as dr_id,d.membership_level
                    FROM
                            zipcodesusa z, doctors d
                    WHERE 
                            z.deleted='0' AND d.status='1' AND d.membership_level IN ({$this->_membershipLevel}) AND
                            ((d.zipcode=z.zipcode) OR (d.zipcode1=z.zipcode) OR (d.zipcode2=z.zipcode) OR (d.zipcode3=z.zipcode) OR (d.zipcode4=z.zipcode) OR (d.zipcode5=z.zipcode))
                            AND
                            sqrt(power(69.1*(z.latitude - ($varLatitude)),2)+ power(69.1*(z.longitude-($varLongitude))*cos(z.latitude/57.3),2)) <  $varMiles
                    ORDER by dist, membership_level ASC";
            
           /*$query = "SELECT DISTINCT z.zipcode, z.cityname,
                                    sqrt(power(69.1*(z.latitude - ($varLatitude)),2)+ power(69.1*(z.longitude-($varLongitude))*cos(z.latitude/57.3),2)) as dist,
                                    d.id as dr_id,d.membership_level
                    FROM
                            zipcodesusa z, doctors d
                    WHERE
                            z.deleted='0' AND d.status='1' AND d.membership_level IN ({$this->_membershipLevel}) AND
                            ((d.zipcode=z.zipcode AND d.use_zip=1) OR (d.zipcode1=z.zipcode AND d.use_zip1=1) OR (d.zipcode2=z.zipcode AND d.use_zip2=1))
                            AND
                            sqrt(power(69.1*(z.latitude - ($varLatitude)),2)+ power(69.1*(z.longitude-($varLongitude))*cos(z.latitude/57.3),2)) <  $varMiles
                    ORDER by dist";*/


               

            $select = $db->query($query);
            $result1 = $select->fetchAll();

            /*$chArray = array();
            
           // if(is_int($zipcode)){
                //die($zipcode);
                $Doctor = new Application_Model_Doctor();
                $zipWhere = " ((zipcode='{$zipcode}' AND use_zip=0) OR (zipcode1='{$zipcode}' AND use_zip1=0)
                            OR (zipcode2='{$zipcode}' AND use_zip2=0) OR (zipcode3='{$zipcode}' AND use_zip3=0)
                            OR (zipcode4='{$zipcode}' AND use_zip4=0)OR (zipcode5='{$zipcode}' AND use_zip5=0))
                            AND membership_level IN ({$this->_membershipLevel})";
                //$whr = " AND zipcode='{$zipcode}' AND use_zip=0 AND membership_level IN ({$this->_membershipLevel})  ";
                $docObject = $Doctor->fetchAll($zipWhere);
                if($docObject){
                    foreach($docObject as $dobj){
                        $chArray[] = $dobj->getId();
                    }
                }*/
           // }
           $chArray = array();

           // if(is_int($zipcode)){
                //die($zipcode);
               
            if ($result1) {
//                prexit($result1);
                $totalresults = count($result1);
                $singleweight = round($matchpoint / $totalresults, 1);

                $checkArray = array();

               $Doctor = new Application_Model_Doctor();
               $maxNumber = $totalresults*2;
               $distance = 0;
               $membership = 'Platinum';
               $SilverResultArray = array();
               $PaidResultArray = array();
               $loop = 0;
                foreach ($result1 as $k1 => $v_zip) {
                $cityBonus = 0;
                /*********************Start Jitu Search*********************/
                $item_id = trim($v_zip->dr_id);
                if($item_id<1 || $item_id=='')continue;


                $zipWhere = " ((zipcode='{$zipcode}' AND use_zip=0) OR (zipcode1='{$zipcode}' AND use_zip1=0)
                            OR (zipcode2='{$zipcode}' AND use_zip2=0) OR (zipcode3='{$zipcode}' AND use_zip3=0)
                            OR (zipcode4='{$zipcode}' AND use_zip4=0)OR (zipcode5='{$zipcode}' AND use_zip5=0))
                            AND id = {$v_zip->dr_id}";
                $docObject = $Doctor->fetchRow($zipWhere);
                if(!empty($docObject)){
                    $reduce = 0.5;
                }else{
                    $reduce = 0;
                }

                    if(in_array($v_zip->dr_id, $checkArray)){
                        continue;
                    }else{
                        $checkArray[] = $v_zip->dr_id;
                    }
                    
                    if($loop==0){
                        $distance = $v_zip->dist;
                        $membership = $v_zip->membership_level;
                    }else{
                        if($distance!=$v_zip->dist){
                            $distance = $v_zip->dist;
                            $maxNumber = $maxNumber-1-$reduce;
                        }
                        if($membership!=$v_zip->membership_level){
                            $membership = $v_zip->membership_level;
                            $maxNumber = $maxNumber-1-$reduce;
                        }
                    }

                    $this->_distanceArray[$item_id] = number_format($v_zip->dist, 2, '.', '');;
                    if($v_zip->membership_level=='Silver'){
                        $numbers = $maxNumber-$totalresults-$reduce;
                        if(isset($AllResultArray[$item_id]))$AllResultArray[$item_id] += $numbers;
                        else $AllResultArray[$item_id] = $numbers;
                        continue;
                        // just remove the sivler doctors and store in other variable to display below in search result
                    }
                    /*if ($v_zip->zipcode == $zipcode OR strtolower($v_zip->cityname) == strtolower($zipcode)) {
                        $cityBonus = 4;
                    }*/
//                    $AllResultArray[$item_id] += $maxNumber+$cityBonus-$reduce;
                    $numbers = $maxNumber+$cityBonus-$reduce;;
                    if(isset($AllResultArray[$item_id]))$AllResultArray[$item_id] += $numbers;
                    else $AllResultArray[$item_id] = $numbers;
                    $loop++;
                    /*********************End Jitu Search*********************/

                    continue;// prohibit from below code


                    /*if(in_array($v_zip->dr_id,$chArray)){
                        unset($chArray[$v_zip->dr_id]);
                        continue;
                    }*/
                    $delMatchpoint = 0;
                    $bonus = 20;
                    // added by jitu rand down those doctor who's zipcode is checked
                    if(in_array($v_zip->dr_id,$chArray)){
                        $delMatchpoint = $matchpoint + $bonus-(intval($singleweight * $totalresults)-1);//50;
                    }

                    if(in_array($v_zip->dr_id, $checkArray)){
                        continue;
                    }else{
                        $checkArray[] = $v_zip->dr_id;
                    }
                    $item_id = trim($v_zip->dr_id);
                    
                    if (!isset($AllResultArray [$item_id])) {
                        $AllResultArray [$item_id] = 0;
                    }
                   // echo "<br>itemid=".$item_id." ANd points=".$AllResultArray [$item_id];
                    if ($v_zip->zipcode == $zipcode OR strtolower($v_zip->cityname) == strtolower($zipcode)) {
                   //echo "<br>increasing from itemid=".$item_id." from 0 to".$matchpoint + 20 - $delMatchpoint;
                        //echo "first-$item_id";
                        
//                        $AllResultArray [$item_id] += $matchpoint + 30 - $delMatchpoint; // $delMatchpoint added by jitu
                        $AllResultArray [$item_id] += $matchpoint + $bonus - $delMatchpoint; // $delMatchpoint added by jitu
                        //pre($AllResultArray [$item_id]);
                        /*if($item_id==565446 || $item_id==565450){
                            pre(array(strtolower($v_zip->cityname),strtolower($zipcode)));
                            pre(array($item_id=>$matchpoint + $bonus - $delMatchpoint));
                        }*/
                    } elseif ($v_zip->membership_level != "Bronze Premium") { //### No point for distance matching for Bronze Premium #####//
                        //echo "<br>increasing1 from itemid=".$item_id." from 0 to".$singleweight * $totalresults." singleweight=".$singleweight." And totalresu=".$totalresults;
                        //echo "second-$item_id";
                        $AllResultArray [$item_id] += intval($singleweight * $totalresults);
                        //pre($AllResultArray [$item_id]);
                        /*if($item_id==565446 || $item_id==565450){
                            pre(array($item_id=>intval($singleweight * $totalresults)));
                        }*/
                    }
                     //echo "<br>itemid=".$item_id." ANd points=".$AllResultArray [$item_id];
                    $totalresults--;
                    
                }
            }
            //$AllResultArray = $this->merge_associative_array($PaidResultArray, $SilverResultArray, $AllResultArray);
            //pre($SilverResultArray);
            //prexit($AllResultArray);
        }
    }

    protected function merge_associative_array($array1, $array2){
        
        foreach($array2 as $key=>$value){
            $array1 [$key] = $value;
        }
        return $array1;
    }
    public function is_valid_categories($value)
    {

        $key = "left(soundex( name ),4)";
        $value = "left(soundex( '$value' ),4)";
        $conditionoperator = " = ";
        
        $Category = new Application_Model_Category();
        $object = $Category->fetchRow("$key $conditionoperator $value");
        //$query = "SELECT catid FROM #__sobi2_categories WHERE $key $conditionoperator $value";
        if(!empty($object)) return true;
        else return false;
    }
    
    public function dih_is_valid_zipcode($zipcode) {
        $db = Zend_Registry::get('db');
        $rs_zip = array();
        //################ Search nearby zipcode ##################//
        if (is_numeric($zipcode) && strlen($zipcode) >= 3) {
            $query = "SELECT * FROM zipcodesusa WHERE zipcode = '$zipcode'";
            $select = $db->query($query);
            $rs_zip = $select->fetchAll();
        }
        return (count($rs_zip));
    }

    public function dih_is_valid_city($city) {
	$db = Zend_Registry::get('db');
	$rs_city = array ();
	//################ Search nearby city ##################//
//	$query = "SELECT DISTINCT z.cityname FROM zipcodesusa z, doctors d WHERE d.city=z.cityname AND  z.cityname = '$city'";
	$query = "SELECT city FROM doctors WHERE city = '$city' AND status=1";
	$select = $db->query($query);
        $rs_city = $select->fetchAll();
	return (count ( $rs_city ));
    }

    public function dih_is_valid_state($state) {
	$db = Zend_Registry::get('db');
	$rs_state = array ();
	//################ Search nearby city ##################//
	$query = "SELECT state FROM doctors WHERE state = '{$state}' AND status=1";
	$select = $db->query($query);
        $rs_state = $select->fetchAll();
	return (count ( $rs_state ));
    }

    public function get_zip_code_resutls($city, $AllResultArray, $matchpoint = 20) {
	$db = Zend_Registry::get('db');

	/*$query = "SELECT DISTINCT d.id FROM zipcodesusa z, doctors d WHERE d.status='1' AND LEFT(d.zipcode, 5) = z.zipcode
                    AND cityname = '$city' AND d.membership_level IN ('Platinum','Gold','Silver','Bronze Premium')";*/
	$query = "SELECT DISTINCT d.id FROM zipcodesusa z, doctors d WHERE d.status='1' AND LEFT(d.zipcode, 5) = z.zipcode
                    AND cityname = '$city' AND d.membership_level IN ({$this->_membershipLevel})";
	$select = $db->query($query);
        $rs_zip = $select->fetchAll();

	$totalresults = count ( $rs_zip );
	$singleweight = $matchpoint / $totalresults;

	if (count ( $rs_zip )) {
	$i=1;
		foreach($rs_zip as $k_zip => $v_zip) {
			$AllResultArray[$v_zip->id] = $singleweight * $totalresults;
		}
	}
    }

    public function dih_search_membership($item_id, $resultArray) {
        return true; // jitu return 
	$db = Zend_Registry::get('db');
        $Doctor = new Application_Model_Doctor();
        //$query = "SELECT field_membership_level FROM dih_profile WHERE  published='1'  AND `itemid`= '$item_id'";
        $rs = $Doctor->fetchRow("status='1' AND `id`= '$item_id'");

	switch ($rs->membershipLevel)
            {
                case "Platinum":
                //$POINT=250; //jitu 8 Feb 2011
                $POINT=390; // need 150+240 it means total max points in zip search+gold membership level
                break;
                case "Gold":
                $POINT=240;
                break;
                case "Silver":
                $POINT=180;
                break;
                case "Bronze Premium":
                $POINT=5;
                break;
                case "Bronze":
                $POINT=0;
                break;
            }// end switch
            if (! isset ( $resultArray [$item_id] )) {
                    $resultArray [$item_id] = 0;
            }
            //print $POINT;
            $resultArray [$item_id] += $POINT;

    }// end function

    public function new_shuffle_members($AllResultArray)
    {
        $shuffledArray = array();
        $temArray = array();
        $holdNumber = 1;
        $loop=0;
        foreach($AllResultArray as $item_id=>$number){
            if($loop==0){
                $holdNumber = $number;
            }
            if($holdNumber != $number){
                $holdNumber = $number;
                if(!empty($temArray)){
                    shuffle($temArray);
                    foreach($temArray as $id){
                        $shuffledArray[$id] = $AllResultArray[$id];
                    }
                    $temArray = array();
                }else{
                    $temArray[] = $item_id;
                }
            }else{
                $temArray[] = $item_id;
            }
        }
        if(!empty($temArray)){
            shuffle($temArray);
            foreach($temArray as $id){
                $shuffledArray[$id] = $AllResultArray[$id];
            }
            $temArray = array();
        }
        $loop++;
        
        return $shuffledArray;
    }
   
    public function shuffle_members($AllResultArray)
    {

	if(isset($_GET['SobiSearchPage']) && $_GET['SobiSearchPage']>0)
	{
		$seedvalue=date("h");
	}else{
		$seedvalue=time();
	}
//$seedvalue=1;
	//print "<pre>"; print_r($AllResultArray); print "</pre>";

	$n = array_count_values($AllResultArray);
	//print "<pre>"; print_r($n); print "</pre>";
	krsort($n);
	//print "<pre>"; print_r($n); print "</pre>";
	$m=array_values($n);
	//print "<pre>"; print_r($m); print "</pre>";

	$OnlyPlatinum=isset($m[0])?array_slice($AllResultArray,0,$m[0],true):array();
	$OnlyGold=isset($m[1]) ?array_slice($AllResultArray,$m[0],$m[1],true):array();
	$Others=isset($m[2]) ?array_slice($AllResultArray,$m[1],10000,true):array();

	//print_r($m);
	//print_r($OnlyPlatinum);
	//print_r($OnlyGold);
	//print_r($Others);
	//print_r($OnlyPlatinum);
	//print_r($OnlyGold);
	//print_r($Others);

	srand($seedvalue);
	count($OnlyPlatinum)?$this->shuffle_assoc($OnlyPlatinum):"";
	srand($seedvalue);
	count($OnlyGold)?$this->shuffle_assoc($OnlyGold):"";
	srand($seedvalue);
	count($Others)?$this->shuffle_assoc($Others):"";

	$ReturnAllResultArray=$OnlyPlatinum+$OnlyGold+$Others;
	if(count($ReturnAllResultArray)==0)
	{
		$ReturnAllResultArray=$AllResultArray;
	}
	//shuffle_assoc($AllResultArray);
	//print_r($AllResultArray);
	//print "</pre>";

	return $ReturnAllResultArray;
    }// end function

    public function shuffle_assoc(&$array) {
        $keys = array_keys($array);

        shuffle($keys);

        foreach($keys as $key) {
            $new[$key] = $array[$key];
        }

        $array = $new;

        return true;
    }

    public function get_matched_words($word){
        $word=soundex($word);
        $Doctor = new Application_Model_Doctor();
        //$docObject = $Doctor->fetchAll("status='1' AND citysoundex='$word'");
        $docObject = $Doctor->fetchAll("status='1' AND citysoundex='$word' AND membership_level IN ({$this->_membershipLevel})");
        //echo "<pre>";print_r($docObject);exit;
        //$query = "SELECT distinct(field_city) FROM dih_profile WHERE  published='1' AND soundex('$word')=soundex(field_city)";

        $returnval=array();
        if(count($docObject > 0)){
            foreach($docObject as $obj){
                $returnval[]=$obj->getCity();
            }
        }
        $returnval = array_unique($returnval);
        return $returnval;
    }

    public function setsearchcachedata($data)
    {
	//Store data in APC 
	return false;
	/*
	$uniquehash=md5(implode(",",$_GET));
	if (apc_fetch($uniquehash)) {
		
	} else {
		apc_add($uniquehash,$data);
	}
	*/
	
	
	/*//Store data in database.
	global $database;
	$uniquehash=md5(implode(",",$_GET));	
	
	//$query = "INSERT INTO #__search_cache (search_hash, search_data) ('".$uniquehash."','".addslashes(serialize($data))."')";

	//$data = str_replace('"','&quot;',serialize($data));

	$query = "INSERT INTO #__search_cache (search_hash, search_data) VALUES ('".$uniquehash."','".serialize($data)."')";


	$database->setQuery($query);
    //echo "<br />".$database->getQuery();
	if($database->query()) {
		//echo "<br />Inserted..."; 
		return true;
	}
	else {
		//echo "<br />Insert Issue..."; 
		return false;
	}*/
    }// end function

    public function getserachcachedata()
    {
	return false;
	//Get the value from APC


	/*$uniquehash=md5(implode(",",$_GET));
	if (apc_fetch($uniquehash)) {
		return apc_fetch($uniquehash);
	} else {
		return false;
	}*/


	/*
	//Get the values from database and return if no data found then just return false;
	global $database;
	$uniquehash=md5(implode(",",$_GET));
	$query = "SELECT search_data FROM #__search_cache WHERE search_hash='{$uniquehash}'";
	$database->setQuery($query);
//echo "<br />". $database->getQuery();
	$result = $database->loadObjectList();

	if(count($result))
		return unserialize(stripslashes($result[0]->search_data));
	else
		return false;
		*/
    }// end function

    public function getNaborhood($key){
        $key = stripslashes(stripslashes($key));
        $naborhood = array(
                        'queens'=>'11354',
                        'norridge'=>'60706',
                        'newport beach'=>'92663',
                        'orange county'=>'92612',
                        'manhattan'=>'10002',
                        'brooklyn'=>'11223',
                        // boston
                        'allston'=>'02134',
                        'brighton'=>'02135',
                        'arlington center'=>'02474',
                        //'arlington heights'=>'02475',
                        'arlington heights'=>'60004',
                        'back bay'=>'02116',
                        'beacon hill'=>'02116',
                        'brookline village'=>'02445',
                        'central square'=>'02139',
                        'charlestown'=>'02129',
                        'chinatown'=>'02111',
                        'coolidge corner'=>'02446',
                        'davis square'=>'02144',
                        'dorchester'=>'02124',
                        'downtown'=>'02101',
                        'dudley square'=>'02119',
                        'east arlington'=>'02474',
                        'east boston'=>'02128',
                        'east cambridge'=>'02141',
                        'egleston square'=>'02119',
                        'fenway'=>'02115',
                        'fields corner'=>'02122',
                        'financial district'=>'02108',
                        'harvard square'=>'02138',
                        'huron village'=>'02138',
                        'hyde park'=>'02136',
                        'inman square'=>'02139',
                        'jamaica plain'=>'02130',
                        'kendall square/mit'=>'02142',
                        'leather district'=>'02111',
                        'mattapan'=>'02126',
                        'mattapan square'=>'02126',
                        'mission hill'=>'02120',
                        'north cambridge'=>'02140',
                        'north end'=>'02114',
                        'porter square'=>'02140',
                        'roslindale'=>'02131',
                        'roslindale village'=>'02131',
                        'south boston'=>'02127',
                        'south end'=>'02118',
                        'teele square'=>'02144',
                        'uphams corner'=>'02125',
                        'waterfront'=>'02210',
                        'west roxbury'=>'02132',
                        'west roxbury center'=>'02132',
                        'winthrop'=>'02152',
                        // chicago
                        'albany park'=>'60625',
                        'andersonville'=>'60640',
                        'archer heights'=>'60632',
                        'ashburn'=>'60652',
                        'auburn gresham'=>'60620',
                        'austin'=>'60707',
                        'avalon park'=>'60617',
                        'avondale'=>'60618',
                        'back of the yards'=>'60609',
                        'belmont central'=>'60641',
                        'beverly'=>'60643',
                        'brainerd'=>'60620',
                        'bridgeport'=>'60608',
                        'brighton park'=>'60632',
                        'bronzeville'=>'60653',
                        'bucktown'=>'60622',
                        'burnside'=>'60619',
                        'cabrini-green'=>'60611',
                        'calumet heights'=>'60617',
                        'canaryville'=>'60609',
                        'chatham'=>'60620',
                        'chicago lawn'=>'60629',
                        'chinatown'=>'60608',
                        'clearing'=>'60638',
                        'cragin'=>'60635',
                        'depaul'=>'60614',
                        'douglas'=>'60653',
                        'dunning'=>'60634',
                        'east garfield park'=>'60624',
                        'east side'=>'60617',
                        'edgewater'=>'60640',
                        'edison park'=>'60630',
                        'englewood'=>'60636',
                        'forest glen'=>'60630',
                        'fulton market'=>'60607',
                        'gage park'=>'60609',
                        'galewood'=>'60639',
                        'garfield ridge'=>'60632',
                        'gold coast'=>'60610',
                        'goose island'=>'60610',
                        'grand boulevard'=>'60609',
                        'greater grand crossing'=>'60619',
                        'greektown'=>'60607',
                        'hegewisch'=>'60633',
                        'hermosa'=>'60639',
                        'humboldt park'=>'60624',
                        'hyde park'=>'60637',
                        'irving park'=>'60641',
                        'jefferson park'=>'60646',
                        'jeffery manor'=>'60617',
                        'kenwood'=>'60653',
                        'lakeview'=>'60613',
                        'lawndale'=>'60608',
                        'lincoln park'=>'60614',
                        'lincoln square'=>'60659',
                        'little village'=>'60616',
                        'logan square'=>'60639',
                        'magnificent mile'=>'60610',
                        'marquette park'=>'60629',
                        'mckinley park'=>'60608',
                        'montclare'=>'60634',
                        'morgan park'=>'60643',
                        'mount greenwood'=>'60655',
                        'near north side'=>'60606',
                        'near southside'=>'60607',
                        'near west side'=>'60616',
                        'new city'=>'60609',
                        'noble square'=>'60610',
                        'north center'=>'60657',
                        'north park'=>'60625',
                        'norwood park'=>'60631',
                        //'oakland'=>'60653',
                        "o'hare"=>'60656', // single quotes
                        'old town'=>'60614',
                        'pilsen'=>'60608',
                        'portage park'=>'60641',
                        "printer's row"=>'60605',  // single quotes
                        'pullman'=>'60628',
                        'ravenswood'=>'60640',
                        'river east'=>'60611',
                        'river north'=>'60611',
                        'river west'=>'60661',
                        'riverdale'=>'60627',
                        'rogers park'=>'60626',
                        'roscoe village'=>'60657',
                        'roseland'=>'60628',
                        'sauganash'=>'60646',
                        'scottsdale'=>'60652',
                        'south chicago'=>'60617',
                        'south deering'=>'60617',
                        'south loop'=>'60605',
                        'south shore'=>'60637',
                        'streeterville'=>'60611',
                        'the loop'=>'60601',
                        'tri-taylor'=>'60607',
                        'ukrainian village'=>'60612',
                        'university village'=>'60607',
                        'uptown'=>'60640',
                        'washington heights'=>'60620',
                        'washington park'=>'60615',
                        'west elsdon'=>'60629',
                        'west englewood'=>'60636',
                        'west garfield park'=>'60624',
                        'west lawn'=>'60629',
                        'west loop'=>'60606',
                        'west pullman'=>'60628',
                        'wicker park'=>'60622',
                        'woodlawn'=>'60637',
                        'wrigleyville'=>'60613',
                        // los angelses
                        'alhambra'=>'91801',
                        'atwater village'=>'90039',
                        'bel air'=>'90049',
                        'beverly crest'=>'90210',
                        'beverly hills'=>'90210',
                        'brentwood'=>'90049',
                        'burbank'=>'91501',
                        'canoga park'=>'91304',
                        'chatsworth'=>'91311',
                        'chinatown'=>'90012',
                        'crenshaw'=>'90008',
                        'culver city'=>'90232',
                        'cypress park'=>'90065',
                        'downtown'=>'90013',
                        'eagle rock'=>'90041',
                        'echo park'=>'90026',
                        'el segundo'=>'90245',
                        'elysian park'=>'90090',
                        'encino'=>'91316',
                        'glassell park'=>'90065',
                        'glendale'=>'91201',
                        'granada hills'=>'91344',
                        'griffith park'=>'90027',
                        'los feliz'=>'90027',
                        'harbor city'=>'90710',
                        'harbor gateway'=>'90248',
                        'hermosa beach'=>'90254',
                        'highland park'=>'90042',
                        'hollywood'=>'90028',
                        'jefferson park'=>'90018',
                        'koreatown'=>'90005',
                        'lake balboa'=>'91406',
                        'lake view terrace'=>'91342',
                        'leimert park'=>'90008',
                        'lincoln heights'=>'90031',
                        'little tokyo'=>'90058',
                        'manhattan beach'=>'90266',
                        'marina del rey'=>'90292',
                        'mid-city'=>'90019',
                        'mid-city west'=>'90019',
                        'mid wilshire'=>'90004',
                        'mount washington'=>'90065',
                        'north hills'=>'91343',
                        'north hollywood'=>'91601',
                        'northridge'=>'91324',
                        'pacific palisades'=>'90272',
                        'pacoima'=>'91331',
                        'palms'=>'90034',
                        'pasadena'=>'91101',
                        'pico union'=>'90006',
                        'playa del rey'=>'90293',
                        'porter ranch'=>'91326',
                        'redondo beach'=>'90277',
                        'reseda'=>'91335',
                        'san pedro'=>'90731',
                        'santa monica'=>'90401',
                        'shadow hills'=>'91040',
                        'sherman oaks'=>'91403',
                        'silver lake'=>'90026',
                        'south east la'=>'90003',
                        'south los angeles'=>'90003',
                        'studio city'=>'91604',
                        'sun valley'=>'91352',
                        'sunland'=>'91040',
                        'sylmar'=>'91342',
                        'tarzana'=>'91356',
                        'terminal island'=>'90731',
                        'toluca lake'=>'91602',
                        'torrance'=>'90501',
                        'tujunga'=>'91042',
                        'universal city'=>'91608',
                        'valley village'=>'91607',
                        'van nuys'=>'91401',
                        'venice'=>'90291',
                        'watts'=>'90002',
                        'west adams'=>'90016',
                        'west hills'=>'91307',
                        'west hollywood'=>'90069',
                        'west los angeles'=>'90025',
                        'westchester'=>'90045',
                        'westlax'=>'90045',
                        'westlake'=>'90057',
                        'westwood'=>'90024',
                        'wilmington'=>'90744',
                        'wilshire center'=>'90004',
                        'winnetka'=>'91306',
                        'woodland hills'=>'91364',
                        //san francisco
                        'bayview'=>'94124',
                        'hunters point'=>'94124',
                        'bernal heights'=>'94110',
                        'castro'=>'94114',
                        'chinatown'=>'94108',
                        'civic center'=>'94109',
                        'tenderloin'=>'94109',
                        'cole valley'=>'94117',
                        'crocker amazon'=>'94112',
                        'diamond heights'=>'94131',
                        'dogpatch'=>'94107',
                        'embarcadero'=>'94107',
                        'excelsior'=>'94112',
                        'financial district'=>'94104',
                        "fisherman's wharf"=>'94133',
                        'glen park'=>'94131',
                        'haight ashbury'=>'94117',
                        'hayes valley'=>'94102',
                        'ingleside'=>'94112',
                        'inner richmond'=>'94118',
                        'inner sunset'=>'94116',
                        'japantown'=>'94115',
                        'lakeside'=>'94132',
                        'laurel heights'=>'94118',
                        'lower haight'=>'94102',
                        'lower pac heights'=>'94115',
                        'marina'=>'94123',
                        'cow hollow'=>'94123',
                        'miraloma'=>'94127',
                        'mission'=>'94112',
                        'mission terrace'=>'94112',
                        'nob hill'=>'94109',
                        'noe valley'=>'94114',
                        'north beach'=>'94133',
                        'telegraph hill'=>'94133',
                        'outer richmond'=>'94121',
                        'outer sunset'=>'94122',
                        'pacific heights'=>'94115',
                        'parkside'=>'94116',
                        'portola'=>'94134',
                        'potrero hill'=>'94107',
                        'russian hill'=>'94109',
                        'soma'=>'94127',
                        'twin peaks'=>'94131',
                        'union square'=>'94108',
                        'visitacion valley'=>'94134',
                        'west portal'=>'94127',
                        'nopa'=>'94115',
                        'western addition'=>'94115',
                        'dimond district'=>'94602',
                        'downtown oakland'=>'94612',
                        'east oakland'=>'94602',
                        'fruitvale'=>'94601',
                        'glenview'=>'94602',
                        'grand lake'=>'94610',
                        'jack london square'=>'94607',
                        'lake merritt'=>'94610',
                        'lakeshore'=>'94610',
                        'laurel district'=>'94619',
                        'lower hills'=>'94602',
                        'montclair village'=>'94611',
                        'north oakland'=>'94618',
                        'oakland chinatown'=>'94607',
                        'oakland hills'=>'94621',
                        'old oakland'=>'94621',
                        'piedmont'=>'94611',
                        'piedmont ave'=>'94611',
                        'rockridge'=>'94618',
                        'temescal'=>'94709',
                        'uptown'=>'94612',
                        'west oakland'=>'94607',
                        'claremont'=>'94705',
                        'downtown berkeley'=>'94703',
                        'east solano ave'=>'94707',
                        'elmwood'=>'94704',
                        'fourth street'=>'94710',
                        'gourmet ghetto'=>'94709',
                        'north berkeley'=>'94709',
                        'north berkeley hills'=>'94704',
                        'south berkeley'=>'94609',
                        'telegraph ave'=>'94704',
                        'uc campus area'=>'94709',
                        //san diego
                        'allied gardens'=>'92120',
                        'alpine'=>'91901',
                        'alpine heights'=>'91901',
                        'alta vista'=>'92114',
                        'balboa park'=>'92102',
                        "banker's hill"=>'92101',
                        'barrio logan'=>'92113',
                        'blossom valley'=>'92021',
                        'bostonia'=>'92021',
                        'carlsbad'=>'92008',
                        'carmel valley'=>'92130',
                        'chollas creek'=>'92102',
                        'chollas view'=>'91910',
                        'chula vista'=>'91902',
                        'city heights'=>'92154',
                        'clairemont'=>'92124',
                        'coronado'=>'92135',
                        'crest'=>'92021',
                        'del cerro'=>'92021',
                        'del mar'=>'92130',
                        'downtown'=>'91910',
                        'east village'=>'92101',
                        'el cajon'=>'92019',
                        'emerald hills'=>'92037',
                        'encinitas'=>'92023',
//                        'escondido'=>'92029',
                        'escondido'=>'92025',
                        'eucalyptus hills'=>'92040',
                        'fleetridge'=>'92106',
                        'fletcher hills'=>'92021',
                        'gaslamp'=>'92101',
                        'golden hill'=>'91910',
                        'granite hills'=>'92019',
                        'grant hill'=>'92113',
                        'grantville'=>'92108',
                        'harbison canyon'=>'92019',
                        'hillcrest'=>'92028',
                        'imperial beach'=>'91932',
                        'jamacha'=>'92019',
                        'kearny mesa'=>'92123',
                        'kensington'=>'92116',
                        'la jolla'=>'92037',
                        'la jolla shores'=>'92037',
                        'la mesa'=>'91941',
                        'la playa'=>'92106',
                        'la presa'=>'91977',
                        'lakeside'=>'92040',
                        'lemon grove'=>'91945',
                        'liberty station'=>'92106',
                        'lincoln park'=>'92102',
                        'linda vista'=>'92111',
                        'little italy'=>'92101',
                        'logan heights'=>'92113',
                        'loma portal'=>'92110',
                        'lomita'=>'90717',
                        'memorial'=>'92102',
                        'middletown'=>'95461',
                        'midway'=>'92110',
                        'mira mesa'=>'92026',
                        'miramar'=>'92131',
                        'mission hills'=>'92056',
                        'mission valley'=>'92123',
                        'mount helix'=>'91977',
                        'mount hope'=>'92102',
                        /*'mountain view'=>'92113',*/
                        'mountain view'=>'94040',
                        'national city'=>'91950',
                        'navajo'=>'92120',
                        'nestor'=>'92154',
                        'normal heights'=>'91911',
                        'north bay terraces'=>'92114',
                        'north encanto'=>'92114',
                        'north park'=>'92014',
                        'oak park'=>'92105',
                        'ocean beach'=>'92154',
                        'oceanside'=>'92049',
                        'old town'=>'92110',
                        'otay'=>'91913',
                        'otay mesa'=>'91913',
                        'pacific beach'=>'92019',
                        'palm city'=>'92154',
                        'palo verde'=>'92115',
                        'paradise hills'=>'92139',
                        'point loma'=>'92064',
                        'poway'=>'92064',
                        'rancho bernardo'=>'92128',
                        'rancho palo verde'=>'90275',
                        'rancho penasquitos'=>'92129',
                        'rancho san diego'=>'92019',
                        'rolando'=>'92115',
                        'roseville'=>'95747',
                        'san carlos'=>'94070',
                        'san ysidro'=>'92070',
                        'santee'=>'92071',
                        'scripps ranch'=>'92131',
                        'serra mesa'=>'92123',
                        'shelter island'=>'92106',
                        'sherman heights'=>'92113',
                        'skyline'=>'92114',
                        'sorrento valley'=>'92121',
                        'south bay terraces'=>'91932',
                        'south encanto'=>'92114',
                        'south park'=>'92113',
                        'southcrest'=>'92113',
                        'spring valley'=>'91976',
                        'stockton'=>'92102',
                        'talmadge'=>'92115',
                        'tierrasanta'=>'92008',
                        'torrey highlands'=>'92129',
                        'torrey hills'=>'92129',
                        'torrey pines'=>'92129',
                        'university city'=>'92123',
                        'university heights'=>'91911',
                        'valencia park'=>'92114',
                        'victoria'=>'92101',
                        'vista'=>'92083',
                        'winter gardens'=>'92040',
                        //new york
                        'alphabet city'=>'10009',
                        'battery park'=>'10280',
                        'chelsea'=>'10011',
                        'chinatown'=>'10013',
                        'civic center'=>'10007',
                        'east harlem'=>'10035',
                        'east village'=>'10009',
                        'financial district'=>'10280',
                        'flatiron'=>'10461',
                        'gramercy'=>'10022',
                        'greenwich village'=>'10461',
                        'harlem'=>'10040',
                        "hell's kitchen"=>'10036',
                        'inwood'=>'10040',
                        'kips bay'=>'10016',
                        'koreatown'=>'10001',
                        'little italy'=>'10458',
                        'lower east side'=>'10038',
                        'manhattan valley'=>'10026',
                        'marble hill'=>'10463',
                        'meatpacking district'=>'10014',
                        'midtown east'=>'10022',
                        'midtown west'=>'10036',
                        'morningside heights'=>'10025',
                        'murray hill'=>'10016',
                        'noho'=>'10012',
                        'nolita'=>'10009',
                        'roosevelt island'=>'10044',
                        'soho'=>'10014',
                        'south street seaport'=>'10038',
                        'south village'=>'10013',
                        'stuyvesant town'=>'12173',
                        'theater district'=>'10036',
                        'tribeca'=>'11103',
                        'two bridges'=>'10002',
                        'union square'=>'10016',
                        'upper east side'=>'10128',
                        'upper west side'=>'11204',
                        'washington heights'=>'10040',
                        'west village'=>'10034',
                        'yorkville'=>'13495',
                        'bath beach'=>'11229',
                        'bay ridge'=>'11234',
                        'bedford stuyvesant'=>'11237',
                        'bensonhurst'=>'11232',
                        'boerum hill'=>'11231',
                        'borough park'=>'11233',
                        'brighton beach'=>'11235',
                        'brooklyn heights'=>'11223',
                        'brownsville'=>'11236',
                        'bushwick'=>'11238',
                        'canarsie'=>'11236',
                        'carroll gardens'=>'11231',
                        'city line'=>'10464',
                        'clinton hill'=>'11238',
                        'cobble hill'=>'11231',
                        'columbia street waterfront district'=>'11231',
                        'coney island'=>'11224',
                        'crown heights'=>'11238',
                        'cypress hills'=>'11237',
                        'ditmas park'=>'11233',
                        'downtown brooklyn'=>'11213',
                        'dumbo'=>'11205',
                        'dyker heights'=>'11230',
                        'east flatbush'=>'11236',
                        'east new york'=>'11234',
                        'east williamsburg'=>'11211',
                        'flatbush'=>'11236',
                        'flatlands'=>'11234',
                        'fort greene'=>'11221',
                        'fort hamilton'=>'11228',
                        'georgetown'=>'11237',
                        'gerritson beach'=>'11229',
                        'gowanus'=>'11231',
                        'gravesend'=>'11235',
                        'greenpoint'=>'11222',
                        'highland park'=>'11208',
                        'kensington'=>'11230',
                        'manhattan beach'=>'11235',
                        'marine park'=>'11234',
                        'midwood'=>'11235',
                        'mill basin'=>'11234',
                        'mill island'=>'11234',
                        'new lots'=>'11236',
                        'ocean hill'=>'11238',
                        'ocean parkway'=>'11218',
                        'paedergat basin'=>'11236',
                        'park slope'=>'11238',
                        'prospect heights'=>'11238',
                        'prospect lefferts gardens'=>'11226',
                        'prospect park south'=>'11226',
                        'red hook'=>'11231',
                        'remsen village'=>'11231',
                        'sea gate'=>'11224',
                        'sheepshead bay'=>'11236',
                        'south williamsburg'=>'11206',
                        'spring creek'=>'11239',
                        'starret city'=>'11235',
                        'sunset park'=>'11238',
                        'vinegar hill'=>'11201',
                        'weeksville'=>'11233',
                        'williamsburg north side'=>'11206',
                        'williamsburg south side'=>'11206',
                        'windsor terrace'=>'11228',
                        'wingate'=>'11203',
                        'baychester'=>'10475',
                        'bedford park'=>'10468',
                        'belmont'=>'10458',
                        'castle hill'=>'10462',
                        'city island'=>'10465',
                        'claremont village'=>'10460',
                        'clason point'=>'10473',
                        'co-op city'=>'10475',
                        'concourse'=>'10451',
                        'concourse village'=>'10456',
                        'country club'=>'10465',
                        'east tremont'=>'10469',
                        'eastchester'=>'10475',
                        'edenwald'=>'10466',
                        'edgewater park'=>'10465',
                        'fieldston'=>'10471',
                        'fordham'=>'10468',
                        'high bridge'=>'10472',
                        'hunts point'=>'10474',
                        'kingsbridge'=>'10469',
                        'longwood'=>'10474',
                        'melrose'=>'10457',
                        'morris heights'=>'10458',
                        'morris park'=>'10473',
                        'morrisania'=>'10462',
                        'mott haven'=>'10459',
                        'mount eden'=>'10456',
                        'mount hope'=>'10457',
                        'north riverdale'=>'10471',
                        'norwood'=>'10475',
                        'olinville'=>'10467',
                        'parkchester'=>'10473',
                        'pelham bay'=>'10475',
                        'pelham gardens'=>'10469',
                        'port morris'=>'10456',
                        'riverdale'=>'10475',
                        'schuylerville'=>'12871',
                        'soundview'=>'10475',
                        'spuyten duyvil'=>'10463',
                        'throgs neck'=>'10473',
                        'unionport'=>'10472',
                        'university heights'=>'10468',
                        'van nest'=>'10460',
                        'wakefield'=>'10470',
                        'west farms'=>'10472',
                        'westchester square'=>'10472',
                        'williamsbridge'=>'10475',
                        'woodlawn'=>'10473',
                        'annadale'=>'10314',
                        'arden heights'=>'10312',
                        'arlington'=>'10303',
                        'arrochar'=>'10305',
                        'bay terrace'=>'11360',
                        'bloomfield'=>'10301',
                        'bullshead'=>'10314',
                        'castleton corners'=>'10314',
                        'charleston'=>'10309',
                        'chelsea'=>'10001',
                        'clifton'=>'11427',
                        //'concord'=>'10314',
                        'dongan hills'=>'10314',
                        'elm park'=>'10314',
                        'eltingville'=>'10314',
                        'emerson hill'=>'10304',
                        'graniteville'=>'10314',
                        'grant city'=>'10306',
                        'grasmere'=>'10305',
                        'great kills'=>'10314',
                        'grymes hill'=>'10314',
                        'heartland village'=>'10314',
                        'howland hook'=>'10314',
                        'huguenot'=>'10314',
                        'lighthouse hill'=>'10306',
                        'mariner'=>'10314',
                        'midland beach'=>'10306',
                        'new brighton'=>'10314',
                        'new dorp'=>'10306',
                        'new dorp beach'=>'10306',
                        'new springville'=>'10314',
                        'oakwood'=>'10314',
                        'old town'=>'10304',
                        'park hill'=>'10701',
                        'pleasant plains'=>'10310',
                        'port richmond'=>'10314',
                        'princes bay'=>'10309',
                        'randall manor'=>'10304',
                        'richmond town'=>'10306',
                        'richmond valley'=>'10309',
                        'rosebank'=>'10305',
                        'rossville'=>'10312',
                        'shore acres'=>'10305',
                        'silver lake'=>'10310',
                        'st. george'=>'10310',
                        'stapleton'=>'11420',
                        'sunnyside'=>'10310',
                        'todt hill'=>'10314',
                        'tompkinsville'=>'10304',
                        'tottenville'=>'10312',
                        'west brighton'=>'10310',
                        'westerleigh'=>'10014',
                        'woodrow'=>'10314',
                        'vernon hills'=>'60061'
                        );
        
        if(isset($naborhood[$key]))return $naborhood[$key];
        return '';
    }
    public function getFullStateName($key){
        $fullName = array(
                        soundex('Alaska')=>'AK',
                        soundex('Alabama')=>'AL',
                        soundex('Massachusetts')=>'MA',
                        soundex('Arkansas')=>'AR',
                        soundex('Arizona')=>'AZ',
                        soundex('California')=>'CA',
                        soundex('Colorado')=>'CO',
                        soundex('Connecticut')=>'CT',
                        soundex('Dist Of Col')=>'DC',
                        soundex('Delaware')=>'DE',
                        soundex('Florida')=>'FL',
                        soundex('Georgia')=>'GA',
                        soundex('Hawaii')=>'HI',
                        soundex('Iowa')=>'IA',
                        soundex('Idaho')=>'ID',
                        soundex('Illinois')=>'IL',
                        soundex('Indiana')=>'IN',
                        soundex('Kansas')=>'KS',
                        soundex('Kentucky')=>'KY',
                        soundex('Louisiana')=>'LA',
                        soundex('Massachusetts')=>'MA',
                        soundex('Maryland')=>'MD',
                        soundex('Maine')=>'ME',
                        soundex('Michigan')=>'MI',
                        soundex('Minnesota')=>'MN',
                        soundex('Missouri')=>'MO',
                        soundex('Mississippi')=>'MS',
                        soundex('Montana')=>'MT',
                        //soundex('North Carolina')=>'NC',
                        soundex('North Dakota')=>'ND',
                        soundex('Nebraska')=>'NE',
                        soundex('New Hampshire')=>'NH',
                        soundex('New Jersey')=>'NJ',
                        soundex('New Mexico')=>'NM',
                        soundex('Nevada')=>'NV',
                        //soundex('New York')=>'NY',
                        soundex('Ohio')=>'OH',
                        //soundex('Oklahoma')=>'OK',
                        soundex('Oregon')=>'OR',
                        soundex('Pennsylvania')=>'PA',
                        soundex('Rhode Island')=>'RI',
                        soundex('South Carolina')=>'SC',
                        soundex('South Dakota')=>'SD',
                        soundex('Tennessee')=>'TN',
                        soundex('Texas')=>'TX',
                        soundex('Utah')=>'UT',
                        soundex('Virginia')=>'VA',
                        soundex('Vermont')=>'VT',
                        soundex('Washington')=>'WA',
                        soundex('Wisconsin')=>'WI',
                        soundex('West Virginia')=>'WV',
                        soundex('Wyoming')=>'WY'
                        );
        if(isset($fullName[$key]))return $fullName[$key];
        return '';
    }
    
	
	
	public function get_manual_points($AllResultArray)
	{
            return true;
            /*
             * Commented by jitu
         if(isset($AllResultArray['565227']) && !empty($_GET['search1']) && ($_GET['search1']=="91710" )){

         
             $AllResultArray['565227'] =$AllResultArray['565227'] +55.5;
        }

        if(isset($AllResultArray['565227']) && !empty($_GET['search1']) && (strtolower($_GET['search1'])=="chino hills" )){

          
             $AllResultArray['565227'] =$AllResultArray['565227'] +8;
        }

        
        if(isset($AllResultArray['565306']) && !empty($_GET['search1']) && (strtolower($_GET['search1'])=="hacienda heights" )){


             $AllResultArray['565306'] =$AllResultArray['565306'] +8;
        }

        if(isset($AllResultArray['565199']) && !empty($_GET['search1']) && (strtolower($_GET['search1'])=="91436" )){


             $AllResultArray['565199'] =$AllResultArray['565199'] +7;
        }

        if(isset($AllResultArray['843987']) && !empty($_GET['search1']) && (strtolower($_GET['search1'])=="06840" )){


             $AllResultArray['843987'] =$AllResultArray['843987'] +1;
        }


        if(isset($AllResultArray['843987']) && !empty($_GET['search1']) && (strtolower($_GET['search1'])=="11756" )){


             $AllResultArray['843987'] =$AllResultArray['843987'] +49;
        }

        if(isset($AllResultArray['843987']) && !empty($_GET['search1']) && (strtolower($_GET['search1'])=="11756" )){


             $AllResultArray['843987'] =$AllResultArray['843987'] +49;
        }

        
        
        //Force condition made by shekhar for RE: Diana Racean http://www.topdocamerica.com/diana-c-racean-dds-3 (not fixed) Diana Racean is located in Skokie, IL. When you search for Chicago dentist, Des Plains shows up before Skokie. Skokie is closer than Des Plains. Can you look into this?
        if(isset($AllResultArray['756606']) && !empty($_GET['search1']) && (strtolower($_GET['search1'])=="chicago" ) && $_GET['category']=='7'){


             $AllResultArray['756606'] =$AllResultArray['756606'] +75;
        }

        if(isset($AllResultArray['725923']) && !empty($_GET['search1']) && ($_GET['search1']=="92130" )){

           
             $AllResultArray['725923'] =$AllResultArray['725923'] +14.5;
        }

        if(isset($AllResultArray['565353']) && !empty($_GET['search1']) && ($_GET['search1']=="92130" )){


             $AllResultArray['565353'] =$AllResultArray['565353'] +5;
        }
        */

        /*if(isset($AllResultArray['565639']) && !empty($_GET['search1']) && ($_GET['search1']=="10023" )){


             $AllResultArray['565639'] =$AllResultArray['565639'] +49;
        }

        if(isset($AllResultArray['565624']) && !empty($_GET['search1']) && ($_GET['search1']=="10023" )){


             $AllResultArray['565624'] =$AllResultArray['565624'] +48;
        }

        if(isset($AllResultArray['565620']) && !empty($_GET['search1']) && ($_GET['search1']=="10023" )){


             $AllResultArray['565620'] =$AllResultArray['565620'] +47;
        }

        if(isset($AllResultArray['565617']) && !empty($_GET['search1']) && ($_GET['search1']=="10001" )){


             $AllResultArray['565617'] =$AllResultArray['565617'] +45;
        }

        if(isset($AllResultArray['565608']) && !empty($_GET['search1']) && ($_GET['search1']=="11510" )){


             $AllResultArray['565608'] =$AllResultArray['565608'] +44;
        }
        
        if(isset($AllResultArray['565582']) && !empty($_GET['search1']) && ($_GET['search1']=="10013" )){


             $AllResultArray['565582'] =$AllResultArray['565582'] +42;
        }

         if(isset($AllResultArray['565577']) && !empty($_GET['search1']) && ($_GET['search1']=="10038" )){


             $AllResultArray['565577'] =$AllResultArray['565577'] +38;
        }*/
        /*
             * Commented by jitu
        if(isset($AllResultArray['565194']) && !empty($_GET['search1']) && (strtolower($_GET['search1'])=="newport beach" )){

              $AllResultArray['565267'] =$AllResultArray['565267'] + 5;
              $AllResultArray['565194'] =$AllResultArray['565194'] + 2;
        }

        if(isset($AllResultArray['565302']) && !empty($_GET['search1']) && ($_GET['search1']=="92506" )){

             $AllResultArray['565248'] =$AllResultArray['565248'] +5;
             $AllResultArray['565302'] =$AllResultArray['565302'] +16;
        }
        if(isset($AllResultArray['843120']) && !empty($_GET['search1']) && ($_GET['search1']=="92692" )){

           
             $AllResultArray['843120'] =$AllResultArray['843120'] +10;
        }

        if(isset($AllResultArray['565306']) && !empty($_GET['search1']) && ($_GET['search1']=="91745" )){


             $AllResultArray['565306'] =$AllResultArray['565306'] +10;
        }

        if(isset($AllResultArray['565306']) && !empty($_GET['search1']) && ($_GET['search1']=="91744" )){


             $AllResultArray['565306'] =$AllResultArray['565306'] +55;
        }

        if(isset($AllResultArray['565467']) && !empty($_GET['search1']) && ($_GET['search1']=="60042" )){


             $AllResultArray['565467'] =$AllResultArray['565467'] +40;
        }

        if(isset($AllResultArray['565374']) && !empty($_GET['search1']) && ($_GET['search1']=="92014" )){


             $AllResultArray['565374'] =$AllResultArray['565374'] +10;
        }

        if(isset($AllResultArray['565374']) && !empty($_GET['search1']) && ($_GET['search1']=="92130" )){


             $AllResultArray['565374'] =$AllResultArray['565374'] +53.5;
        }

        if(isset($AllResultArray['842229']) && !empty($_GET['search1']) && ($_GET['search1']=="91007" )){


             $AllResultArray['842229'] =$AllResultArray['842229'] +20;
        }

        if(isset($AllResultArray['842229']) && !empty($_GET['search1']) && ($_GET['search1']=="91006" )){


             $AllResultArray['842229'] =$AllResultArray['842229'] +10;
        }

        if(isset($AllResultArray['565319']) && !empty($_GET['search1']) && ($_GET['search1']=="91745" )){


             $AllResultArray['565319'] =$AllResultArray['565319'] +17;
        }


        if(isset($AllResultArray['565285']) && !empty($_GET['search1']) && ($_GET['search1']=="90293" )){


             $AllResultArray['565285'] =$AllResultArray['565285'] +10;
        }

        if(isset($AllResultArray['565235']) && !empty($_GET['search1']) && ($_GET['search1']=="90245" )){


             $AllResultArray['565235'] =$AllResultArray['565235'] +7;
        }

        if(isset($AllResultArray['565194']) && !empty($_GET['search1']) && ($_GET['search1']=="92660" )){


             $AllResultArray['565194'] =$AllResultArray['565194'] +4;
        }

        if(isset($AllResultArray['725550']) && !empty($_GET['search1']) && ($_GET['search1']=="92008" )){


             $AllResultArray['725550'] =$AllResultArray['725550'] +16;
        }

        if(isset($AllResultArray['565298']) && !empty($_GET['search1']) && ($_GET['search1']=="92505" )){


             $AllResultArray['565298'] =$AllResultArray['565298'] +17;
        }

        if(isset($AllResultArray['757322']) && !empty($_GET['search1']) && ($_GET['search1']=="60156" )){

            $AllResultArray['565664'] =$AllResultArray['565664'] + 2;
             $AllResultArray['757322'] =$AllResultArray['757322'] + 45;
        }

        if(isset($AllResultArray['565192']) && !empty($_GET['search1']) && ($_GET['search1']=="91202" )){

            
             $AllResultArray['565192'] =$AllResultArray['565192'] + 8;
        }

        if(isset($AllResultArray['565324']) && !empty($_GET['search1']) && ($_GET['search1']=="91202" )){


             $AllResultArray['565324'] =$AllResultArray['565324'] + 17.5;
        }

         if(isset($AllResultArray['565275']) && !empty($_GET['search1']) && ($_GET['search1']=="90293" )){


             $AllResultArray['565275'] =$AllResultArray['565275'] + 18;
        }

        if(isset($AllResultArray['565260']) && !empty($_GET['search1']) && ($_GET['search1']=="92507" )){


             $AllResultArray['565260'] =$AllResultArray['565260'] + 8;
        }

        if(isset($AllResultArray['565341']) && !empty($_GET['search1']) && ($_GET['search1']=="92507" )){


             $AllResultArray['565341'] =$AllResultArray['565341'] + 116;
        }

        if(isset($AllResultArray['565235']) && !empty($_GET['search1']) && ($_GET['search1']=="90245" )){


             $AllResultArray['565235'] =$AllResultArray['565235'] + 1;
        }

       

        

       

	 if(isset($AllResultArray['565227']) && !empty($_GET['search1']) && ($_GET['search1']=="91709" || $_GET['search1']=="91786")){

           //$AllResultArray['565227'] =$AllResultArray['565227'] +$Point;
             $AllResultArray['565227'] =$AllResultArray['565227'] +50;
        }
         
	
	return $AllResultArray;
        
         */
	}

        public function updatePosition($AllResultArray, $catid=null, $search1=null){
            
            if($catid!='' && $search1!=''){
                // category and zipcode/city search
                $this->setCatSearch1Array();
                
                if(isset($this->_positionArray[$catid][strtolower($search1)])){
                    foreach($this->_positionArray[$catid][strtolower($search1)] as $drid=>$pos){
                        $AllResultArray = $this->setposition($AllResultArray, $drid, $pos);
                    }
                }
            }elseif($catid!='' && $search1==''){
                // category search
                $this->setCatArray();
            }elseif($catid=='' && $search1!=''){
                // zipcode/city search
                $this->setSearch1Array();
            }
            
        }

        protected function setposition($array, $key, $position)
        {
            $position=$position-1;// array position starts from zero (0)
            $arraykey=array_keys($array);
            if($arraykey[array_search($key,$arraykey)]==$key){
                unset($arraykey[array_search($key,$arraykey)]);
                array_splice($arraykey,$position,0,$key);
            }
            $newarray=array();
            foreach($arraykey as $key=>$value)
            {
                if(isset($array[$value])){
                    $newarray[$value]=$array[$value];
                }

            }
            return $newarray;
        }
        
        protected function setSearch1Array(){
            $this->_positionArray['91710']['565227'] = 2;
        }

        protected function setCatSearch1Array(){
            $this->_positionArray['7']['91710']['565227'] = 2;
            $this->_positionArray['7']['chino hills']['565227'] = 1;
            $this->_positionArray['7']['60156']['757322'] = 1;
            $this->_positionArray['7']['92075']['565341'] = 1;
            $this->_positionArray['7']['92660']['565194'] = 1;
            $this->_positionArray['7']['92612']['565194'] = 3;
            $this->_positionArray['7']['92662']['565296'] = 1;
            $this->_positionArray['7']['92657']['565296'] = 1;
            $this->_positionArray['7']['92625']['565296'] = 1;
            $this->_positionArray['7']['90265']['565257'] = 1;
            $this->_positionArray['7']['10801']['565519'] = 1;
            $this->_positionArray['7']['92507']['565519'] = 2;
            $this->_positionArray['7']['92014']['565374'] = 1;
            $this->_positionArray['7']['92130']['565374'] = 3;
            $this->_positionArray['7']['91745']['565306'] = 1;
            $this->_positionArray['7']['91744']['565306'] = 2;
            $this->_positionArray['7']['hacienda heights']['565306'] = 2;
            $this->_positionArray['7']['07626']['565542'] = 3;
            $this->_positionArray['7']['92692']['843120'] = 1;
            $this->_positionArray['7']['60042']['565467'] = 4;
            $this->_positionArray['7']['90245']['565235'] = 1;
            $this->_positionArray['7']['91007']['842229'] = 1;
            $this->_positionArray['7']['91006']['842229'] = 3;
            $this->_positionArray['7']['91745']['565319'] = 2;
            $this->_positionArray['7']['90293']['565285'] = 1;
            $this->_positionArray['7']['92008']['725550'] = 1;
            $this->_positionArray['7']['92505']['565298'] = 1;
            $this->_positionArray['7']['91436']['565199'] = 1;
            $this->_positionArray['7']['06840']['843987'] = 2;
            $this->_positionArray['7']['11756']['843987'] = 1;
            $this->_positionArray['7']['92130']['725923'] = 3;
            $this->_positionArray['7']['92130']['565353'] = 1;
            $this->_positionArray['7']['92663']['565194'] = 2; // for newport beach
            $this->_positionArray['7']['92506']['565302'] = 2;
            $this->_positionArray['7']['91202']['565324'] = 2;
            $this->_positionArray['7']['90293']['565275'] = 2;
            $this->_positionArray['7']['92507']['565260'] = 1;
            $this->_positionArray['7']['90049']['565310'] = 1;
            $this->_positionArray['7']['91701']['565317'] = 1;
            $this->_positionArray['7']['91730']['565317'] = 3;
            $this->_positionArray['7']['hacienda heights']['565306'] = 1;
            $this->_positionArray['7']['06824']['742217'] = 1;
            $this->_positionArray['7']['06840']['742315'] = 1;
            $this->_positionArray['7']['06605']['742220'] = 1;
            $this->_positionArray['7']['06824']['742220'] = 4;
            $this->_positionArray['7']['06880']['742224'] = 1;
            $this->_positionArray['7']['06890']['742224'] = 1;
            $this->_positionArray['7']['11021']['565597'] = 1;
            $this->_positionArray['7']['07662']['565571'] = 2;
            $this->_positionArray['66']['02451']['844046'] = 1;
            $this->_positionArray['66']['02451']['844047'] = 2;
            $this->_positionArray['66']['02451']['565417'] = 3;
            $this->_positionArray['66']['02116']['844047'] = 1;
            $this->_positionArray['66']['02116']['844046'] = 2;
            


            //Plastic Surgeon
            $this->_positionArray['35']['92121']['565387'] = 1;
        }
        protected function setCatArray(){
            $this->_positionArray['7']['565227'] = 2;
        }
}// end class
