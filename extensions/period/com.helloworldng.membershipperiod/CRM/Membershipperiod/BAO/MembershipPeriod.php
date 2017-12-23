<?php
use CRM_Membershipperiod_ExtensionUtil as E;

class CRM_Membershipperiod_BAO_MembershipPeriod extends CRM_Membershipperiod_DAO_MembershipPeriod {

  /**
   * Create a new MembershipPeriod based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Membershipperiod_DAO_MembershipPeriod|NULL
   */
  protected function create($params) {
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
  public static function find($contact_id) {
    if(is_integer($contact_id)) {
      return self::findByContactID($contact_id);
    } else {
      return [];
    }
  }

  /**
  * Method findContactMembershipPeriods
  *
  * @param int $contact_id
  * @access protected
  * @return array
  */
  protected function findByContactID($contact_d) {           
    $result = civicrm_api3('MembershipPeriod', 'get', array(
    'sequential' => 1,
    'contact_id' => $id,
    'return' => array("start_date", "end_date", "contact_id", "contact_id.first_name", "contact_id.last_name"),
  ));

  return $result;
  }

  /**
  * Method to find Contact's list of recorded contributions
  *
  * @param $contact_id
  * return array
  */
  public static function findContactContributions($contact_id) {
    $result = civicrm_api3('Contribution', 'get', array(
      'sequential' => 1,
      'contact_id' => $id
    ));

    return $result;
  }

}
