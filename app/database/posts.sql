/* Prime Ministers database in MySQL. */
drop table if exists posts;

create table posts (
  id integer primary key autoincrement,
  author varchar(40) not null,
  created date not null,
  title varchar(140),
  message text, 
  comments int default 0
);

/* Column names changed to avoid MySQL reserved words. */

insert into posts(author, created, title, message, comments) values ('John', '2016-01-01', "My title", "My message", 99);

