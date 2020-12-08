CREATE TABLE `WORKER` (
	`WORKER_ID`     INT          NOT NULL AUTO_INCREMENT COMMENT '작업자 ID', -- WORKER_ID
	`WORKER_NM`     VARCHAR(60)  NULL     COMMENT '작업자이름', -- WORKER_NM 
	`TEL_NO`        VARCHAR(20)  NULL     COMMENT '전화번호', -- TEL_NO
	`WORK_CD`       VARCHAR(10)  NULL     COMMENT '작업코드', -- WORK_CD
	`HEALTH_CHK_DT` VARCHAR(8)   NULL     COMMENT '보건증갱신일', -- HEALTH_CHK_DT
	`ROLE_CD`       VARCHAR(10)  NULL     COMMENT '역할코드', -- ROLE_CD 
	`REMARK`        VARCHAR(100) NULL     COMMENT '참고사항', -- REMARK
	`REG_ID`        VARCHAR(15)  NULL     COMMENT '등록자ID', -- REG_ID 
	`REG_DTM`       VARCHAR(14)  NULL     COMMENT '등록일시', -- REG_DTM
	PRIMARY KEY(WORKER_ID)
)
COMMENT 'Worker';