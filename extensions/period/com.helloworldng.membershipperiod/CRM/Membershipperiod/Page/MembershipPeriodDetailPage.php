<?php
use CRM_Membershipperiod_ExtensionUtil as E;

class CRM_Membershipperiod_Page_MembershipPeriodDetailPage extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('Membership period details page'));
    $this->_id = CRM_Utils_Request::retrieve('cid', 'Positive', $this, FALSE);
    $this->_mid = CRM_Utils_Request::retrieve('mid', 'Positive', $this, FALSE);
    $this->_ccid = CRM_Utils_Request::retrieve('coid', 'Positive', $this, FALSE);

    $membership = CRM_Membershipperiod_BAO_Membership::findSingle($this->_mid);

    $contributions = null;

    if(intval($this->_ccid) > 0) {
    	$contributions = CRM_Membershipperiod_BAO_Contribution::findOne($this->_ccid);
    }

    $this->assign('cid', $this->_id);
    $this->assign('mid', $this->_mid);
    $this->assign('ccid', $this->_ccid);
    $this->assign('membership', $membership);
    $this->assign('contribution', $contributions);

    parent::run();
  }

}
