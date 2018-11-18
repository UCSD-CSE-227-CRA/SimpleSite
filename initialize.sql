-- Simple Site database structure

-- Table structure for table `user`

CREATE TABLE IF NOT EXISTS `user` (
  `userid` INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(32) NOT NULL,
  `password` VARCHAR(32) NOT NULL,
  `salt` VARCHAR(8) NOT NULL,
  `sex` VARCHAR(16) NOT NULL,
  `email` VARCHAR(128) NOT NULL,
  `register_time` TIMESTAMP NOT NULL DEFAULT NOW(),
  `latest_time` TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW()
);

-- Table structure for table `session`

CREATE TABLE IF NOT EXISTS `session` (
  `sid` CHAR(32) NOT NULL PRIMARY KEY,
  `secret` CHAR(32) NOT NULL,
  `token` CHAR(32) NOT NULL,
  `userid` INTEGER NOT NULL,
  `latest_time` TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
  FOREIGN KEY (`userid`) REFERENCES user(`userid`)
);

-- Timer task to delete inactive sessions

CREATE EVENT `delete_sessions`
ON SCHEDULE EVERY 1 DAY
STARTS CONCAT(DATE(NOW() + INTERVAL 1 DAY ), ' 00:00:00')
ON COMPLETION PRESERVE ENABLE
DO
DELETE FROM `session` WHERE `latest_time` < NOW() - 3600 * 24 * 7;