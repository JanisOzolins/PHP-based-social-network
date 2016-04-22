/* Prime Ministers database in MySQL. */
drop table if exists comments;

create table comments (
  comment_id integer primary key autoincrement,
  author varchar(40) not null,
  post_id int not null,
  message text
);

/* Column names changed to avoid MySQL reserved words. */

insert into comments(author, post_id, message) values ('John', 33, "You look great today!");

