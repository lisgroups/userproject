SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ecs_user
-- ----------------------------
DROP TABLE IF EXISTS `ecs_user`;
CREATE TABLE `ecs_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `phone` bigint(11) NOT NULL DEFAULT '0' COMMENT '手机号',
  `token` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱验证激活码',
  `email_token_exptime` int(10) NOT NULL DEFAULT '0' COMMENT '邮箱激活码有效期',
  `phone_token_exptime` int(10) NOT NULL DEFAULT '0' COMMENT '手机号激活码有效期',
  `email_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态,0未激活,1已激活',
  `phone_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态,0未激活,1已激活',
  `salt` char(8) NOT NULL DEFAULT '' COMMENT '密码加密密钥',
  `regtime` int(10) NOT NULL DEFAULT '0' COMMENT '注册时间',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ecs_user
-- ----------------------------

