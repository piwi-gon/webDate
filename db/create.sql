CREATE TABLE r_schedule_recipient(
    schedule_recipient_id           INT auto_increment primary key,
    fk_schedule_id                  INT,
    fk_recipient_id                 INT
);

CREATE TABLE t_schedule(
    schedule_id                     INT auto_increment primary key,
    message                         TEXT,
    day                             INT,
    month                           INT,
    year                            INT,
    single_message                  TINYINT,
    is_used                         TINYINT,
    used_date                       TIMESTAMP);

CREATE TABLE t_recipient(
    recipient_id                    INT auto_increment primary key,
    recipient_name                  VARCHAR(255)    DEFAULT ''      NOT NULL,
    recipient_address               VARCHAR(200)    DEFAULT ''      NOT NULL
);

--
-- added: 2017-08-27
--

CREATE TABLE t_login (
    login_id                        INT auto_increment primary key,
    fk_recipient_id                 INT
    login_name                      VARCHAR(40)     DEFAULT ''      NOT NULL,
    login_pass                      VARCHAR(255)    DEFAULT ''      NOT NULL,
    full_name                       VARCHAR(255)    DEFAULT ''      NOT NULL
);
