

CREATE DATABASE if not exists groupCollab;


use groupCollab;



create table if not exists user(
	id int auto_increment primary key,
    googleID nvarchar(255) unique, /*very large number that can't be even a UNSIGNED BIGINT*/
    fname nvarchar(50), /* no included*/
    lname nvarchar(50), /* no included*/
    born date, /* no included*/
    email nvarchar(100) unique,
    contactEmail varchar(100),
    password nvarchar(255),
    username varchar(100) unique,
    phone varchar(15),
    about text,
    image MEDIUMBLOB,
    status BOOLEAN, /* no included*/
    link1 varchar(255),
    link2 varchar(255),
    link3 varchar(255),
    link4 varchar(255)
);


select * from user;



create table if not exists msg(
	id int auto_increment primary key,
    body mediumtext
);

select * from msg;



create table if not exists grp(
	id int auto_increment primary key,
    title varchar(100) UNIQUE,
    image mediumblob,
    description text,
    creation datetime default current_timestamp,
    isPublic boolean
);


select * from grp;



create table if not exists send(
	user int, 
    msg int,
    grp int,
    date datetime default CURRENT_TIMESTAMP,
    primary key(user, msg, grp),
    foreign key (user) references user(id),
	foreign key (msg) references msg(id),
	foreign key (grp) references grp(id)
);

use groupCollab;
select * from send;



create table if not exists joinGroup(
	grp int,
    user int,
	date datetime default CURRENT_TIMESTAMP,
    method varchar(255),
    primary key(grp, user),
    foreign key (grp) references grp(id),
    foreign key (user) references user(id)
);


select * from joinGroup;



create table if not exists created(
    user int,
    grp int,
    date DATETIME default CURRENT_TIMESTAMP,
    primary key (user, grp),
    foreign key (user) references user(id),
    foreign key (grp) references grp(id)
);


select * from created;




use groupCollab;




-- prevent_multiple_group_creators
CREATE TRIGGER prevent_multiple_group_creators
BEFORE INSERT ON created
FOR EACH ROW
BEGIN
    DECLARE group_exists INT;

    -- Check if the group already exists for any user
    SELECT COUNT(*) INTO group_exists
    FROM created
    WHERE grp = NEW.grp;

    -- If the group already exists, raise an error
    IF group_exists > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'This group is already created by another user.';
    END IF;
END;












