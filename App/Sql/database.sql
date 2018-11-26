CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

create table category
(
  id   int auto_increment
    primary key,
  name varchar(255) null
)
  engine = InnoDB;

create table newsletter
(
  id    int auto_increment,
  email varchar(255) not null,
  constraint newsletter_email_uindex
    unique (email),
  constraint newsletter_id_uindex
    unique (id)
);

alter table newsletter
  add primary key (id);

create table user
(
  id             int auto_increment
    primary key,
  username       varchar(255)                null,
  password       varchar(255)                null,
  email          varchar(255)                not null,
  quality        varchar(255) default 'user' not null,
  status         tinyint(1)   default 0      not null,
  validation_key varchar(255)                null
)
  engine = InnoDB;

create table post
(
  id           int auto_increment
    primary key,
  title        varchar(100)                  not null,
  chapo        varchar(255)                  not null,
  content      text                          not null,
  date_added   datetime                      not null,
  date_amended datetime                      null,
  category_id  int                           null,
  publish      varchar(20) default 'waiting' null,
  user_id      int                           not null,
  constraint posts___fk
    foreign key (user_id) references user (id)
)
  engine = InnoDB;

create table comment
(
  id         int auto_increment
    primary key,
  content    text                          not null,
  date_added datetime                      not null,
  publish    varchar(10) default 'waiting' null,
  post_id    int                           null,
  username   varchar(255)                  not null,
  constraint comment___f
    foreign key (post_id) references post (id)
      on delete cascade
)
  engine = InnoDB;

