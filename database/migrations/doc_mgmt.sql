CREATE TABLE `DOC_MGMT` (
	`DOC_ID`   INT          NOT NULL AUTO_INCREMENT COMMENT '문서ID', -- DOC_ID
	`TYPE_CD`  VARCHAR(20)  NULL     COMMENT '문서종류', -- TYPE_CD
	`DOC_NM`   VARCHAR(100) NULL     COMMENT '문서이름', -- DOC_NM
	`DOC_DESC` VARCHAR(150) NULL     COMMENT '문서내용', -- DOC_DESC
	`ATT_DTM`  VARCHAR(14)  NULL     COMMENT '첨부문서', -- ATT_DTM
	`REG_ID`   VARCHAR(15)  NULL     COMMENT '등록자ID', -- REG_ID 
	`REG_DTM`  VARCHAR(14)  NULL     COMMENT '등록일시', -- REG_DTM
	PRIMARY KEY(DOC_ID)
)
COMMENT 'Doc Management';