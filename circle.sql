create table users
(
    id       int auto_increment
        primary key,
    login    varchar(150) not null,
    password varchar(255) not null,
    constraint users_login_uindex
        unique (login)
);

create table circles
(
    id      int auto_increment
        primary key,
    centerX int         not null,
    centerY int         not null,
    radius  int         not null,
    hex     varchar(10) null,
    user_id int         not null,
    constraint circles_users_id_fk
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
);


INSERT INTO circle.users (id, login, password) VALUES (1, 'test', '2ec44c9ac0851bfc900bc27327258bea');
INSERT INTO circle.users (id, login, password) VALUES (2, 'test2', '2ec44c9ac0851bfc900bc27327258bea');