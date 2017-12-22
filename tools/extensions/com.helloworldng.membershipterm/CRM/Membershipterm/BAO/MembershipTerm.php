<?php
use CRM_Membershipterm_ExtensionUtil as E;

class CRM_Membershipterm_BAO_MembershipTerm extends CRM_Membershipterm_DAO_MembershipTerm {

  /**
   * Create a new MembershipTerm based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Membershipterm_DAO_MembershipTerm|NULL
   */
  public static function create($params) {
    $className = 'CRM_Membershipterm_DAO_MembershipTerm';
    $entityName = 'MembershipTerm';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  }


}
