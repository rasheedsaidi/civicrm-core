<?php

class CRM_Membershipperiod_Hook {
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
	    $mode = $this->getMode($op);
	    if(in_array($op, $ops) && $objectName == 'Membership') {
	    	
	    	$params = self::getCreateMembershipPeriodParams($objectRef, $mode);

	    	$membershipperiod = CRM_Membershipperiod_BAO_MembershipPeriod::validateAndCreate($params);
	    	if($membershipperiod) {
	    		$session = CRM_Core_Session::singleton();
	    		$session->set('membershipperiod_id_session', $membershipperiod->id);
	    		$session->set('membership_id_session', ($objectId)? $objectId: $objectRef->id);
	    	}
	    } else if(in_array($op, $ops) && $objectName == 'Contribution') {
	    	$session = CRM_Core_Session::singleton();
	    	$id = $session->get('membershipperiod_id_session');
	    	$membership_id = $session->get('membership_id_session');
	    	$params = self::getEditMembershipPeriodParams($objectRef, $id, $objectId, $membership_id);
	    	$membershipperiod = CRM_Membershipperiod_BAO_MembershipPeriod::edit($params);
	    	$session->reset();
	    }
	    
	}

	public static function getCreateMembershipPeriodParams($obj, $mode=1) {
		 
		$params = [
    		'contact_id' => $obj->contact_id,
    		'start_date' => CRM_Membershipperiod_Utility::formatDate($obj->start_date),
    		'end_date' => CRM_Membershipperiod_Utility::formatDate($obj->end_date),
    		'membership_id' => $obj->id,
    		'contribution_state' => 0,
    		'comment' => '',
    	];
    	if($mode == 2) {
			$membershipperiod = CRM_Membershipperiod_BAO_MembershipPeriod::findByMembershipID($obj->id);
			if($membershipperiod && !empty($membershipperiod['id'])) {
				$params['id'] = $membershipperiod['id'];
			}
		}
		return $params;
	}

	public static function getEditMembershipPeriodParams($obj, $id, $contribution_id, $membership_id) {
		return [
			'id' => $id,
    		'contact_id' => $obj->contact_id,
    		'membership_id' => $membership_id,
    		'contribution_id' => $contribution_id,
    		'contribution_state' => 1,
    		'comment' => '',
    	];
	}

	private function getMode($op) {
		$mode = 1;
    	if($op == 'create') {
    		$mode = 1;
    	} else if($op == 'edit') {
    		$mode = 2;
    	}
    	return $mode;
	}
}