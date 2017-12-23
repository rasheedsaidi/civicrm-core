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
	    $objs = ['Membership'];
	    if(in_array($op, $ops) && in_array($objectName, $objs)) {
	    	// insert into 
	    	$params = [
	    		'contact_id' => $objectRef->contact_id,
	    		'start_date' => $objectRef->start_date,	//date('Y-m-d'),
	    		'end_date' => $objectRef->end_date,	//date("Y-m-d", strtotime(date("Y-m-d", strtotime(date('Y-m-d'))) . " + 1 year")),
	    		'comment' => json_encode($objectRef) . ":" . $objectId,
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
		    $session = CRM_Core_Session::singleton();

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
/*
{"id":48,"contact_id":137,"membership_type_id":1,"join_date":"20171221","start_date":"20171221","end_date":"20191220","source":null,"status_id":"1","is_override":null,"owner_membership_id":"47","max_related":null,"is_test":0,"is_pay_later":null,"contribution_recur_id":null,"campaign_id":null,"_DB_DataObject_version":"1.8.12","__table":"civicrm_membership","N":0,"_database_dsn":"","_database_dsn_md5":"fdea3be1e8f30d6021d71555b30a3633","_database":"mydrupalci_nppln","_query":{"condition":"","group_by":"","order_by":"","having":"","limit_start":"","limit_count":"","data_select":"*"},"_DB_resultid":null,"_resultFields":false,"_link_loaded":false,"_join":"","_lastError":false}

{"_relatedObjects":[],"_component":null,"trxn_result_code":null,"id":105,"contact_id":"212","financial_type_id":"2","contribution_page_id":null,"payment_instrument_id":"4","receive_date":"20171221095200","non_deductible_amount":"null","total_amount":"2.00","fee_amount":0,"net_amount":2,"trxn_id":"null","invoice_id":"5a7c4ab1f6550152be2569a313e22349","invoice_number":null,"currency":"USD","cancel_date":null,"cancel_reason":null,"receipt_date":"null","thankyou_date":null,"source":"Monthly Sub Membership: Offline membership renewal (by admin@example.com)","amount_level":null,"contribution_recur_id":null,"is_test":null,"is_pay_later":false,"contribution_status_id":"1","address_id":null,"check_number":"null","campaign_id":null,"creditnote_id":null,"tax_amount":null,"revenue_recognition_date":null,"_DB_DataObject_version":"1.8.12","__table":"civicrm_contribution","N":0,"_database_dsn":"","_database_dsn_md5":"fdea3be1e8f30d6021d71555b30a3633","_database":"mydrupalci_nppln","_query":{"condition":"","group_by":"","order_by":"","having":"","limit_start":"","limit_count":"","data_select":"*"},"_DB_resultid":null,"_resultFields":false,"_link_loaded":false,"_join":"","_lastError":false,"payment_processor":null} */