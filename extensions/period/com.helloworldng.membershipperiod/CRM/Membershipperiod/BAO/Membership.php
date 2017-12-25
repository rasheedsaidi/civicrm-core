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

  /**
  * Method findSingle. Gets a composite by joining four entity tables: Contact, Membership, MembershipType and MembershipStatus
  *
  * @param in $id
  * @return array
  */
  public static function findSingle($id) {
    $result = civicrm_api3('Membership', 'get', array(
      'sequential' => 1,
      'return' => array("contact_id.first_name", "contact_id.last_name", "membership_type_id.name", "status_id.name", "start_date", "end_date", "membership_type_id.auto_renew"),
      'id' => $id,
    ));
    return self::extractRecord($result);
  }

  /**
  * Method to extract record items from findSingle call
  *
  * @param array $record
  * @return array
  */
  public static function extractRecord($result) {
    if(empty($result) || $result['count'] < 1) {
      return [];
    }

    $record = $result['values'][0];
    $params = array(
      'first_name' => $record['contact_id.first_name'],
      'last_name' => $record['contact_id.last_name'],
      'name' => $record['contact_id.first_name'] . " " . $record['contact_id.last_name'],
      'membership_type_name' => $record['membership_type_id.name'],
      'status' => $record['status_id.name'],
      'start_date' => $record['start_date'],
      'end_date' => $record['end_date']
    );

    return $params;
  }


}
