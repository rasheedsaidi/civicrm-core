<?php

class CRM_Membershipperiod_Utility {
	public static function formatDate($date) {
		return date('Y-m-d', strtotime($date));
	}
}