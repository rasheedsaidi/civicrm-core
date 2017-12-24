<?php

class CRM_Membershipperiod_Validator {
	public static function validateMembershipId($params) {
		return array_key_exists('membership_id', $params) && is_numeric($params['membership_id']);
	}

	public static function validateContactId($params) {
		return array_key_exists('contact_id', $params) && is_numeric($params['contact_id']);
	}

	public static function validateStartDate($params) {
		return array_key_exists('start_date', $params) && self::validateDateFormat($params['start_date']);
	}

	public static function validateDateFormat($date) {
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
			return true;
		} else {
			return false;
		}
	}

	public static function validateCreateParams($params) {
		return self::validateMembershipId($params) && self::validateContactId($params) && self::validateStartDate($params);
	}

	public static function isContributionRecorded($membership_id) {
		
	}
}