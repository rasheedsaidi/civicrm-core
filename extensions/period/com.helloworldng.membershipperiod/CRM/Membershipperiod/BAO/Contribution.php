<?php

class CRM_Membershipperiod_BAO_Contribution {

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
    $result = civicrm_api3('Contribution', 'get', array(
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
    $result = civicrm_api3('Contribution', 'getsingle', array(
      'sequential' => 1,
      'id' => $id,
    ));

    return self::extractRecord($result);
  }

  /**
  * Method to extract record items from findOne call
  *
  * @param array $record
  * @return array
  */
  public static function extractRecord($result) {
    if(empty($result)) {
      return [];
    }

    $record = $result;
    $params = array(
      'amount' => $record['total_amount'],
      'type' => $record['financial_type'],
      'source' => $record['contribution_source'],
      'payment_method' => $record['payment_instrument'],
      'status' => $record['contribution_status'],
      'receive_date' => $record['receive_date']
    );

    return $params;
  }


}
