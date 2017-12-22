<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// http://wiki.civicrm.org/confluence/display/CRMDOC42/Hook+Reference
return array (
  0 => 
  array (
    'name' => 'CRM_Membershipterm_Form_Report_MembershipReport',
    'entity' => 'ReportTemplate',
    'params' => 
    array (
      'version' => 3,
      'label' => 'MembershipReport',
      'description' => 'MembershipReport (com.helloworldng.membershipterm)',
      'class_name' => 'CRM_Membershipterm_Form_Report_MembershipReport',
      'report_url' => 'com.helloworldng.membershipterm/membershipreport',
      'component' => 'CiviMember',
    ),
  ),
);
