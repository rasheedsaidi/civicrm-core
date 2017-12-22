<?php

class CRM_Services_Period {
	/**
   	* Data set in pre and used for compare which field is changed
   	*
   	* @var array $preData
   	*/
  	protected static $preData = array();
	
	public static function pre($op, $objectName, $objectId, $params) {	


	}
	/**
	   * Method post
	   *
	   * @param string $op
	   * @param string $objectName
	   * @param int $objectId
	   * @param object $objectRef
	   * @access public
	   * @static
	   */
	  public static function post( $op, $objectName, $objectId, &$objectRef ) {
	    	    
	    $ops = ['create', 'edit'];
	    $objs = ['Membership', 'Contribution'];
	    if(in_array($op, $ops) && in_array($objectName, $objs)) {
	    	// insert into 
	    	$params = [
	    		'contact_id' => $objectRef->contact_id,
	    		'start_date' => date('Y-m-d'),
	    		'end_date' => date("Y-m-d", strtotime(date("Y-m-d", strtotime(date('Y-m-d'))) . " + 1 year")),
	    		'comment' => json_encode($objectRef),
	    	];

	    	$m = new CRM_Membershipterm_BAO_MembershipTerm();
	    	$m->create($params);
	    }
	  }

	/**
	   * Method post
	   *
	   * @param string $op
	   * @param string $objectName
	   * @param int $objectId
	   * @param object $objectRef
	   * @access public
	   * @static
	   */
	  public static function get($id) {	    	    
	        $result = civicrm_api3('MembershipTerm', 'get', array(
		      'sequential' => 1,
		      'contact_id' => $id,
		      'return' => array("start_date", "end_date", "contact_id", "contact_id.first_name", "contact_id.last_name"),
		    ));

		    return $result;
	  }

	  public static function get_contribution($id) {	    	    
	        $result = civicrm_api3('Contribution', 'get', array(
		      'sequential' => 1,
		      'contact_id' => $id
		    ));

		    return $result;
	  }
}