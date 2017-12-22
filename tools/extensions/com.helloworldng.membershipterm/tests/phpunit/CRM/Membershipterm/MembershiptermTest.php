<?php

use CRM_Membershipterm_ExtensionUtil as E;
use Civi\Test\HeadlessInterface;
use Civi\Test\HookInterface;
use Civi\Test\TransactionalInterface;

/**
 * FIXME - Add test description.
 *
 * Tips:
 *  - With HookInterface, you may implement CiviCRM hooks directly in the test class.
 *    Simply create corresponding functions (e.g. "hook_civicrm_post(...)" or similar).
 *  - With TransactionalInterface, any data changes made by setUp() or test****() functions will
 *    rollback automatically -- as long as you don't manipulate schema or truncate tables.
 *    If this test needs to manipulate schema or truncate tables, then either:
 *       a. Do all that using setupHeadless() and Civi\Test.
 *       b. Disable TransactionalInterface, and handle all setup/teardown yourself.
 *
 * @group headless
 */
class CRM_Membershipterm_MembershiptermTest extends \PHPUnit_Framework_TestCase implements HeadlessInterface, HookInterface, TransactionalInterface {

  public $contact_id;
  public $membership_id;
  public $membership_start_date;
  public $membership_end_date;
  public $membership_term_id;

  public function setUpHeadless() {
    // Civi\Test has many helpers, like install(), uninstall(), sql(), and sqlFile().
    // See: https://github.com/civicrm/org.civicrm.testapalooza/blob/master/civi-test.md
    return \Civi\Test::headless()
      ->installMe(__DIR__)
      ->apply();
  }

  public function setUp() {
    $contact = civicrm_api3("Contact","create",array(
      'contact_type' => 'Individual',
      'first_name' => 'Hadlows',
      'last_name'  => 'Sharon'
    ));

    $this->contact_id = $contact['id'];

    $membership = civicrm_api3('Membership', 'create', array(
      'membership_type_id' => "General",
      'contact_id' => $this->contact_id,
    ));

    $this->membership_id = $membership['id'];
    $this->membership_start_date = $membership['values'][$this->membership_id]['start_date'];
    $this->membership_end_date = $membership['values'][$this->membership_id]['end_date'];

    $membership_term = civicrm_api3('MembershipTerm', 'create', array(
      'contact_id' => $this->contact_id,
      'membership_id' => $this->membership_id,
      'start_date' => $this->membership_start_date,
      'end_date' => $this->membership_end_date
    ));
    $this->membership_term_id = $membership_term['id'];

    parent::setUp();
  }

  public function tearDown() {
    parent::tearDown();
  }

  /**
   * Example: Test that a version is returned.
   */
  public function testWellFormedVersion() {
    $this->assertRegExp('/^([0-9\.]|alpha|beta)*$/', \CRM_Utils_System::version());
  }

  /**
   * Example: Test that we're using a fake CMS.
   */
  public function testWellFormedUF() {
    $this->assertEquals('UnitTests', CIVICRM_UF);
  } 

  /**
  * Test that an entity MembershipTerm is created  *
  */
  public function hasMembershipTermCreated() {
    $membership_term_id = civicrm_api3('MembershipTerm', 'getvalue', array(
      'membership_id' => $this->membership_id,
      'return' => "id",
    ));

    $sql = "SELECT count(1) FROM `civicrm_membershipterm` WHERE membership_id=%1";
    $params[1]=array($ruleId,'Integer');
    
    return (CRM_Core_DAO::singleValueQuery($sql, $params))? true: false;
  }

  protected function testMembershipTermIsCreated(){
    self::assertTrue($this->hasMembershipTermCreated());
  }


}
