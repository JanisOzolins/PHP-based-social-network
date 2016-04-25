drop table if exists comments;

create table comments(
  comment_id integer primary key autoincrement,
  author varchar(40) not null,
  post_id int not null,
  message text,
  FOREIGN KEY(post_id) REFERENCES posts(id)
);

/* Column names changed to avoid MySQL reserved words. */

insert into comments(author, post_id, message) values ('John', 1, "My message 1");
insert into comments(author, post_id, message) values ('John', 2, "My message 2");
insert into comments(author, post_id, message) values ('John', 2, "My message 3");
insert into comments(author, post_id, message) values ('John', 3, "My message 4");

