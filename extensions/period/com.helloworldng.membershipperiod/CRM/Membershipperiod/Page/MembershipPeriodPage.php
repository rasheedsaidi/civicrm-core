<?php
use CRM_Membershipperiod_ExtensionUtil as E;

class CRM_Membershipperiod_Page_MembershipPeriodPage extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('MembershipPeriodPage'));

    $this->_id = CRM_Utils_Request::retrieve('cid', 'Positive', $this, FALSE);

    require_once 'CRM/Utils/Rule.php';
    if (!CRM_Utils_Rule::positiveInteger($this->_id)) {
      CRM_Core_Error::fatal(ts('We need a valid contact ID for this view'));
    }

    $this->assign('id', $this->_id);
    $total = 0;
    $s = '';

    $membershipperiods = CRM_Membershipperiod_BAO_MembershipPeriod::findAll($this->_id);

	if(!empty($membershipperiods)) {
		$total = $membershipperiods['count'];
		$s = ($membershipperiods['count'] > 1)? 's': '';
	}

    $this->assign('total', $total);
    $this->assign('s', $s);

	$this->assign('result', $membershipperiods);

    parent::run();
  }

}
