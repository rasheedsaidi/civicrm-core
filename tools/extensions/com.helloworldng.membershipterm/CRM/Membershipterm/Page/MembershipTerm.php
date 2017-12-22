<?php
use CRM_Membershipterm_ExtensionUtil as E;

class CRM_Membershipterm_Page_MembershipTerm extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('MembershipTerm'));

    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));


  	$this->_id = CRM_Utils_Request::retrieve('cid', 'Positive', $this, FALSE);

  	require_once 'CRM/Utils/Rule.php';
    if (!CRM_Utils_Rule::positiveInteger($this->_id)) {
      CRM_Core_Error::fatal(ts('We need a valid discount ID for view'));
    }

    $this->assign('id', $this->_id);
    $result = CRM_Services_Period::get($this->_id);

    $this->assign('total', $result['count']);
    $this->assign('s', ($result['count'] > 1)? 's': '');

	  $this->assign('result', $result);

    parent::run();
  }

}
