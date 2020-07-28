CREATE TABLE tx_comments_domain_model_comment (
  uid int(11) NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,

  user int(11) DEFAULT '0' NOT NULL,
  comment text,
  editorial_comment text,
  disabled tinyint(4) unsigned DEFAULT '0' NOT NULL,
  mail_notification tinyint(4) unsigned DEFAULT '0' NOT NULL,
  page_uid int(11) DEFAULT '0' NOT NULL,
  reported tinyint(4) unsigned DEFAULT '0' NOT NULL,
  acknowledged tinyint(4) unsigned DEFAULT '0' NOT NULL,

  l10n_parent int(11) DEFAULT '0' NOT NULL,
  l10n_diffsource mediumblob,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY page_uid (page_uid)
);
