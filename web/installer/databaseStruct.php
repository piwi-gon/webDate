<?php
/*
CREATE TABLE IF NOT EXISTS r_schedule_recipient(
    schedule_recipient_id           INT auto_increment primary key,
    fk_schedule_id                  INT,
    fk_recipient_id                 INT
);

CREATE TABLE IF NOT EXISTS t_schedule(
    schedule_id                     INT auto_increment primary key,
    message                         TEXT,
    day                             INT,
    month                           INT,
    year                            INT,
    single_message                  TINYINT,
    is_used                         TINYINT,
    used_date                       TIMESTAMP
);

CREATE TABLE IF NOT EXISTS t_recipient(
    recipient_id                    INT auto_increment primary key,
    recipient_name                  VARCHAR(255)    DEFAULT ''      NOT NULL,
    recipient_address               VARCHAR(200)    DEFAULT ''      NOT NULL
);

--
-- added: 2017-08-27
--

CREATE TABLE IF NOT EXISTS t_login (
    login_id                        INT auto_increment primary key,
    fk_recipient_id                 INT,
    login_name                      VARCHAR(40)     DEFAULT ''      NOT NULL,
    login_pass                      VARCHAR(255)    DEFAULT ''      NOT NULL,
    full_name                       VARCHAR(255)    DEFAULT ''      NOT NULL,
    salt                            VARCHAR(255)    DEFAULT''       NOT NULL
);

--
-- added 2018-04-27
--
CREATE TABLE IF NOT EXISTS t_configuration_option (
    configuration_option_id         INT auto_increment primary key,
    option_name                     VARCHAR(20)     DEFAULT ''      NOT NULL,
    option_value                    VARCHAR(255)    DEFAULT ''      NOT NULL,
    option_type                     ENUM('string', 'bool')   DEFAULT 'string'    NOT NULL
);

INSERT INTO t_configuration_option (option_name, option_value) VALUES('sender_name',            'WebDate V2.0');
INSERT INTO t_configuration_option (option_name, option_value) VALUES('sender_address',         'webdate@wondernet24.de');
INSERT INTO t_configuration_option (option_name, option_value, option_type) VALUES('logging',   'true', 'bool');
INSERT INTO t_configuration_option (option_name, option_value) VALUES('logilfe',                'mail.log');

--
-- added 2018-05-01
--
INSERT INTO t_configuration_option (option_name, option_value) VALUES('autoremove',             '21');
*/
?>