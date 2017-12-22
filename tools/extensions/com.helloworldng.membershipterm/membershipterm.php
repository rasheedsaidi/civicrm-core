<?php

require_once 'membershipterm.civix.php';
use CRM_Membershipterm_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config(). 
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function membershipterm_civicrm_config(&$config) {
  _membershipterm_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function membershipterm_civicrm_xmlMenu(&$files) {
  _membershipterm_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function membershipterm_civicrm_install() {
  _membershipterm_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function membershipterm_civicrm_postInstall() {
  _membershipterm_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function membershipterm_civicrm_uninstall() {
  _membershipterm_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function membershipterm_civicrm_enable() {
  _membershipterm_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function membershipterm_civicrm_disable() {
  _membershipterm_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function membershipterm_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _membershipterm_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function membershipterm_civicrm_managed(&$entities) {
  _membershipterm_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function membershipterm_civicrm_caseTypes(&$caseTypes) {
  _membershipterm_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function membershipterm_civicrm_angularModules(&$angularModules) {
  _membershipterm_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function membershipterm_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _membershipterm_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function membershipterm_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function membershipterm_civicrm_navigationMenu(&$menu) {
  _membershipterm_civix_insert_navigation_menu($menu, NULL, array(
    'label' => E::ts('The Page'),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _membershipterm_civix_navigationMenu($menu);
} // */

function membershipterm_civicrm_pre($op, $objectName, $objectId, &$params) {
  CRM_Services_Period::pre($op, $objectName, $objectId, $params);
}

function membershipterm_civicrm_post( $op, $objectName, $objectId, &$objectRef ) {
  CRM_Services_Period::post($op, $objectName, $objectId, $objectRef);
}

function membershipterm_civicrm_tabset($tabsetName, &$tabs, $context) {
  if ($tabsetName == 'civicrm/contact/view') {
    // unset the contribition tab, i.e. remove it from the page
    unset( $tabs[1] );
    $contactID = $context['contact_id'];
    // let's add a new "contribution" tab with a different name and put it last
    // this is just a demo, in the real world, you would create a url which would
    // return an html snippet etc.
    $url1 = CRM_Utils_System::url( 'civicrm/contact/view/contribution',
                                  "reset=1&snippet=1&force=1&cid=$contactID" );
    $url = CRM_Utils_System::url( 'civicrm/membershipterm',
                                  "reset=1&snippet=1&force=1&cid=$contactID" );
    // $url should return in 4.4 and prior an HTML snippet e.g. '<div><p>....';
    // in 4.5 and higher this needs to be encoded in json. E.g. json_encode(array('content' => <html form snippet as previously provided>));
    // or CRM_Core_Page_AJAX::returnJsonResponse($content) where $content is the html code
    // in the first cases you need to echo the return and then exit, if you use CRM_Core_Page method you do not need to worry about this.
    $tabs[] = array( 'id'    => 'membershipterm',
      'url'   => $url,
      'title' => 'Membership Periods',
      'weight' => 100,
    );
  }
}

function membershipterm_civicrm_pageRun(&$page) {
  $f = '_' . __FUNCTION__ . '_' . get_class($page);
  if (function_exists($f)) {
    $f($page);
  }
}
