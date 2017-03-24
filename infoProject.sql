DROP TABLE IF EXISTS orderdetails;
DROP TABLE IF EXISTS productdetails;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS employee;
DROP TABLE IF EXISTS customer;
DROP TABLE IF EXISTS grocer;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS productcategory;



CREATE TABLE customer(
    id int unsigned not null auto_increment,
    email varchar(64) not null,
    name varchar(64) not null,
    address varchar (128) not null,
    phone varchar (10) not null,
    grocerid int unsigned,
    primary key (id)
);

CREATE TABLE orders(
    id int unsigned not null auto_increment,
    grocerid int unsigned not null,
    customerid int unsigned not null,
    total decimal (6,2),
    orderdate date not null,
    deliverydate date,
    employeeid int unsigned,
    status int (1),
    primary key (id, grocerid),
    foreign key (grocerid) references grocer(id)
);

CREATE TABLE orderdetails(
    orderid int unsigned not null,
    
    productid int unsigned not null,
    quantity int unsigned not null,
    price decimal (6,2),
    primary key (orderid,grocerid,productid),
    foreign key (orderid) references orders(id),
    
    foreign key (productid) references product(id)
);

CREATE TABLE product(
    id int unsigned not null auto_increment,
    name varchar (64) not null,
    categoryid int unsigned not null,
    unitprice decimal (6,2) not null,
    description varchar (255),
    image varchar (128),
    primary key (id)    
);

CREATE TABLE productdetails(
    productid int unsigned not null,
    grocerid int unsigned not null,
    msrp decimal (6,2) not null,
    saleprice decimal (6,2),
    stock int unsigned not null,
    primary key (productid, grocerid),
    foreign key (productid) references product(id),
    foreign key (grocerid) references grocer(id)
);

CREATE TABLE grocer(
    id int unsigned not null auto_increment,
    name varchar (64) not null,
    email varchar(64) not null,
    phone int (10) not null,
    address varchar (128) not null,
    logo varchar (128),
    primary key (id)
);

CREATE TABLE employee(
    id int unsigned not null auto_increment,
    grocerid int unsigned not null,
    name varchar (64) not null,
    email varchar(64) not null,
    phone int (10) not null,
    administrator boolean not null
    primary key (id, grocerid),
    foreign key (grocerid) references grocer(id)
);

CREATE TABLE prodcategory(
    id int unsigned not null auto_increment,
    name varchar (64) not null,
    description varchar (255),
    primary key (id)
);
CREATE TABLE administrator(
	id
	email
	name
);