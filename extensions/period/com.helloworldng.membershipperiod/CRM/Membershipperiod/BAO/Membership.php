<?php
use CRM_Membershipperiod_ExtensionUtil as E;

class CRM_Membershipperiod_BAO_Membership {

  /**
  * Validate the $params before calling findByContactID
  *
  * @param array $params key-value pairs
  * @return array
  */
  public static function findAll($contact_id) {
    if(is_integer($contact_id)) {
      return self::findByContactID($contact_id);
    } else {
      return [];
    }
  }

  /**
  * Method findByContactID
  *
  * @param int $contact_id
  * @access public
  * @return array
  */
  public static function findByContactID($contact_id) {           
    $result = civicrm_api3('Membership', 'get', array(
      'sequential' => 1,
      'contact_id' => $contact_id,
    ));

    return $result;
  }

  /**
  * Method findOne
  *
  * @param int $id
  * @access public
  * @return array
  */
  public static function findOne($id) {           
    $result = civicrm_api3('Membership', 'getsingle', array(
      'sequential' => 1,
      'id' => $id,
    ));

    return $result;
  }


}
