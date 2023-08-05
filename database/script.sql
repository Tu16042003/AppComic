-- tạo database
create database if not exists MD17306;
use MD17306;
-- tạo bảng

create table if not exists users (
	id INT PRIMARY KEY AUTO_INCREMENT,
	password VARCHAR(150) NOT NULL,
	name VARCHAR(50) NOT NULL,  
	email VARCHAR(50) NOT NULL UNIQUE,
    verify BIT DEFAULT 0
);
insert into users (id, password, name, email,verify) values (1, '123', 'Brim', 'tupqtu@gmail.com',1);
insert into users (id, password, name, email,verify) values (2, '123', 'Brim', 'qtuvip@gmail.com',1);


create table reset_password (
	id INT PRIMARY KEY AUTO_INCREMENT,
	token VARCHAR(50) NOT NULL,
	createdAt DATETIME NOT NULL DEFAULT NOW(),
	email VARCHAR(50) NOT NULL,
    -- token dc sd hay chua
	avaiable BIT DEFAULT 1
);

create table if not exists categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
);
insert into categories (id, name) values (1, 'Điện thoại');
insert into categories (id, name) values (2, 'Laptop');
insert into categories (id, name) values (3, 'Phụ kiện');


create table if not exists products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    price INT NOT NULL,
    image VARCHAR(150) NOT NULL,
    description VARCHAR(50) NOT NULL,
    quantity INT NOT NULL,
    categoryId INT NOT NULL,
    FOREIGN KEY (categoryId) REFERENCES categories(id)
);