DROP TABLE IF EXISTS `civicrm_membershipperiod`;

-- /*******************************************************
-- *
-- * civicrm_membershipperiod
-- *
-- * Record Contact's Membership periods/terms
-- *
-- *******************************************************/
CREATE TABLE `civicrm_membershipperiod` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique MembershipPeriod ID',
     `contact_id` int unsigned    COMMENT 'FK to Contact',
     `membership_id` int unsigned NOT NULL   COMMENT 'FK to Membership',
     `contribution_id` int unsigned NULL   COMMENT 'FK to Contribution',
     `start_date` date NOT NULL   COMMENT 'Records the Membership start date',
     `end_date` date    COMMENT 'Records the Membership end date',
     `contribution_state` int unsigned NOT NULL   COMMENT 'Records the contribution state of each Membership',
     `comment` text NULL   COMMENT 'Records any comments for the term' 
,
        PRIMARY KEY (`id`)
 
 
,          CONSTRAINT FK_civicrm_membershipperiod_contact_id FOREIGN KEY (`contact_id`) REFERENCES `civicrm_contact`(`id`) ON DELETE CASCADE  
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;