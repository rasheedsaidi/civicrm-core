DROP TABLE IF EXISTS `civicrm_membershipterm`;

CREATE TABLE `civicrm_membershipterm` (


     `id` int unsigned NOT NULL AUTO_INCREMENT  COMMENT 'Unique MembershipTerm ID',
     `contact_id` int unsigned    COMMENT 'FK to Contact',
     `start_date` date    COMMENT 'Records the start date of a Contact\'s term/period',
     `end_date` date    COMMENT 'Records the end date of a Contact\'s term/period',
     `contribution_taken` int COMMENT 'Indicates whether contribution is taken for the Contact\'s membership or not',
     `comment` text COMMENT 'Records any comment that may arise',
        PRIMARY KEY (`id`)
 
 
,          CONSTRAINT FK_civicrm_membershipterm_contact_id FOREIGN KEY (`contact_id`) REFERENCES `civicrm_contact`(`id`) ON DELETE CASCADE  
)  ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci  ;