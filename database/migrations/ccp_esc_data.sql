-- CCP Escape Data
CREATE TABLE `CCP_ESC_DATA` (
`DEVICE_ID` VARCHAR(20)  NOT NULL COMMENT '장비코드', -- DEVICE_ID
`SRT_DTM`   VARCHAR(14)  NOT NULL COMMENT '시작시간', -- SRT_DTM
`END_DTM`   VARCHAR(14)  NULL     COMMENT '종료시간', -- END_DTM
`ESC_DATA`  DECIMAL(10.3)  NULL  COMMENT '이탈시 값', -- ESC DATA
`REASON`    VARCHAR(300) NULL     COMMENT '이탈사유', -- REASON
PRIMARY KEY(DEVICE_ID, SRT_DTM)
)
COMMENT 'CCP Escape Data';
