<?php

use CRM_Membershipperiod_ExtensionUtil as E;
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
class CRM_MembershipPeriod_MembershipPeriodTest extends \PHPUnit_Framework_TestCase implements HeadlessInterface, HookInterface, TransactionalInterface {

  public $contact_id;
  public $membership_id;
  public $membership_start_date;
  public $membership_end_date;
  public $membership_period_id;
  public $membership_type_id;
  public $b;

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

    $membership_type = civicrm_api3('MembershipType', 'create', array(
      'domain_id' => "Default Domain Name",
      'member_of_contact_id' => 1,
      'financial_type_id' => "Member Dues",
      'duration_unit' => "day",
      'duration_interval' => 30,
      'period_type' => "fixed",
      'name' => "Test Plan",
    ));

    $this->membership_type_id = $membership_type['id'];

    $membership = civicrm_api3('Membership', 'create', array(
      'membership_type_id' => $this->membership_type_id,
      'contact_id' => $this->contact_id,
      'start_date' => date('Y-m-d')
    ));

    $this->membership_id = $membership['id'];
    $this->membership_start_date = $membership['values'][$this->membership_id]['start_date'];
    $this->membership_end_date = $membership['values'][$this->membership_id]['end_date'];

    $membership_params = array(
      'contact_id' => $this->contact_id,
      'membership_id' => $this->membership_id,
      'start_date' => CRM_Membershipperiod_Utility::formatDate($this->membership_start_date), //$this->membership_start_date,
      'end_date' => CRM_Membershipperiod_Utility::formatDate($this->membership_end_date), //date("Y-m-d", strtotime(date("Y-m-d", strtotime(date('Y-m-d'))) . " + 1 year")), //$this->membership_end_date
      'contribution_state' => 0,
      'comment' => 'comment'
    );
    $membership_period = CRM_Membershipperiod_BAO_MembershipPeriod::validateAndCreate($membership_params);    //civicrm_api3('MembershipPeriod', 'create', $membership_params);
    $this->membership_period_id = $membership_period->id;
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
  * Test that an entity MembershipPeriod is created  *
  */
  protected function hasMembershipPeriodCreated() {
    $membership_period_id = civicrm_api3('MembershipPeriod', 'getvalue', array(
      'membership_id' => $this->membership_id,
      'return' => "id",
    ));

    $sql = "SELECT count(1) FROM `civicrm_membershipperiod` WHERE contact_id=".$this->contact_id;
    $params[1]=array($membership_period_id,'Integer');
    
    return (CRM_Core_DAO::singleValueQuery($sql, $params))? true: false;
  }

  public function testMembershipIsInteger() {
    self::assertTrue(is_integer($this->membership_id));
  }

  public function testMembershipPeriodStartDateIsValid() {
    self::assertEquals(date('Y-m-d', strtotime($this->membership_start_date)), date('Y-m-d'));
  }

  public function testMembershipPeriodEndDateHasValidFormat() {
    self::assertTrue(CRM_Membershipperiod_Validator::validateDateFormat(date('Y-m-d', strtotime($this->membership_end_date))));
  }

  public function testFindAllContactMembershipPeriods() {
    $membership_periods = CRM_Membershipperiod_BAO_MembershipPeriod::findAll($this->contact_id);
    $this->assertTrue(is_integer($membership_periods['count']));
  }

  public function testMembershipPeriodIsCreated(){
    self::assertTrue($this->hasMembershipPeriodCreated());
  }

  public function testCreateMembershipPriosValidates() {
    $params = $this->getTestParam();
    self::assertTrue(CRM_Membershipperiod_Validator::validateCreateParams($params));
  }

  private function getTestParam() {
    return array(
      'membership_id' => 1,
      'contact_id' => 1,
      'start_date' => date('Y-m-d'),
      'return' => "id",
    );
  }

  public function testFindContactMemberships() {
    $memberships = CRM_Membershipperiod_BAO_Membership::findAll($this->contact_id);
    $this->assertTrue(is_integer($memberships['count']));
    $this->assertTrue(intval($memberships['count']) > 0);
  }

  public function testFindContactSingleMembershipRecord() {
    $memberships = CRM_Membershipperiod_BAO_Membership::findOne($this->membership_id);
    $this->assertEquals($memberships['id'], $this->membership_id);
  }

}
