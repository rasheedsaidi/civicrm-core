<?php
use CRM_Membershipperiod_ExtensionUtil as E;

class CRM_Membershipperiod_BAO_MembershipPeriod extends CRM_Membershipperiod_DAO_MembershipPeriod {

  /**
   * Create a new MembershipPeriod based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Membershipperiod_DAO_MembershipPeriod|NULL
   */
  public static function create($params) {
    $className = 'CRM_Membershipperiod_DAO_MembershipPeriod';
    $entityName = 'MembershipPeriod';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } 

  /**
  * Validate the $params before creating a new MemberhsipPeriod
  *
  * @param array $params key-value pairs
  * @return CRM_Membershipperiod_DAO_MembershipPeriod|NULL
  */
  public static function validateAndCreate($params) {    
    if(CRM_Membershipperiod_Validator::validateCreateParams($params)) {
      return self::create($params);
    } else {
      return NULL;
    }
  }

  /**
  * Validate the $params before creating a new MemberhsipPeriod
  *
  * @param array $params key-value pairs
  * @return CRM_Membershipperiod_DAO_MembershipPeriod|NULL
  */
  public static function findAll($contact_id) {
    $cid = intval($contact_id);
    if(is_integer($cid)) {
      return self::findByContactID($cid);
    } else {
      return [];
    }
  }

  /**
  * Method findByContactID
  *
  * @param int $contact_id
  * @access protected
  * @return array
  */
  public static function findByContactID($contact_id) {           
    $result = civicrm_api3('MembershipPeriod', 'get', array(
      'sequential' => 1,
      'contact_id' => $contact_id,
      'return' => array("start_date", "end_date", "contact_id", "contact_id.first_name", "contact_id.last_name", "membership_id", "contribution_id"),
    ));

    return $result;
  }

  /**
  * Method findByMembershipID
  *
  * @param int $contact_id
  * @access protected
  * @return array
  */
  public static function findByMembershipID($membership_id) {           
    $result = civicrm_api3('MembershipPeriod', 'getsingle', array(
      'sequential' => 1,
      'membership_id' => $membership_id
    ));

    return $result;
  }

  /**
  * Method to modify MembershipPeriods
  *
  * @param int $contact_id
  * @access protected
  * @return array
  */
  public static function edit($params) {           
    $result = civicrm_api3('MembershipPeriod', 'create', $params);
    return $result;
  }

}
