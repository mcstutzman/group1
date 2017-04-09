DROP TABLE IF EXISTS orderdetails;
DROP TABLE IF EXISTS productdetails;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS employees;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS grocers;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS prodcategories;



CREATE TABLE customers(
    id int unsigned not null auto_increment,
    email varchar(64) not null,
    passwordhash varchar (255) not null,
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
    orderdate date,
    deliverydate date,
    employeeid int unsigned,
    status int (1),
    primary key (id, grocerid)    
);

CREATE TABLE orderdetails(
    orderid int unsigned not null,
    grocerid int unsigned not null,
    productid int unsigned not null,
    quantity int unsigned not null,
    price decimal (6,2),
    primary key (orderid,grocerid,productid)
);

CREATE TABLE products(
    id int unsigned not null auto_increment,
    name varchar (64) not null,
    categoryid int unsigned not null,
    brand varchar (128),
    price decimal (6,2),
    description varchar (255),
    image varchar (128),
    thumbnail varchar (128),
    primary key (id)    
);

CREATE TABLE productdetails(
    productid int unsigned not null,
    grocerid int unsigned not null,
    msrp decimal (6,2) not null,
    saleprice decimal (6,2),
    stock int unsigned not null,
    primary key (productid, grocerid)    
);

CREATE TABLE grocers(
    id int unsigned not null auto_increment,
    name varchar (64) not null,
    email varchar(64) not null,
    phone int (10) not null,
    address varchar (128),
    logo varchar (128),
    url varchar (255),
    primary key (id)
);

CREATE TABLE employees(
    id int unsigned not null auto_increment,
    grocerid int unsigned not null,
    name varchar (64) not null,
    email varchar(64) not null,
    phone int (10) not null,
    administrator boolean not null,
    primary key (id, grocerid)

);

CREATE TABLE prodcategories(
    id int unsigned not null auto_increment,
    name varchar (64),
    description varchar (255),
    thumbnail varchar (128),
    primary key (id)
);

insert into prodcategories (name, description, thumbnail) values ('Dairy', 'Milk and milk derived products',"GroceryPics/milkTN.jpg");
insert into prodcategories (name, description, thumbnail) values ('Produce', 'Fruits and Vegetables', "GroceryPics/bananaTN.jpg");
insert into prodcategories (name, description, thumbnail) values ('Paper', 'Paper products', "GroceryPics/toiletpaperTN.jpg");
insert into prodcategories (name, description, thumbnail) values ('Meat', 'Meats and meat products',"GroceryPics/steakTN.png");
insert into prodcategories (name, description, thumbnail) values ('Candy', 'Sweets and treats', "GroceryPics/toiletpaperTN.jpg");

insert into products (name, categoryid, price, description, thumbnail) values ('Whole Milk', 1, 3.56, "A&E Whole White Milk", "GroceryPics/milkTN.jpg");
insert into products (name, categoryid, price, description, thumbnail) values ('Bananas', 2, 0.77, "For scale", "GroceryPics/bananaTN.jpg");
insert into products (name, categoryid, price, description, thumbnail) values ('Toilet Paper', 3, 1.99, "Scott Triple Ply", "GroceryPics/toiletpaperTN.jpg");
insert into products (name, categoryid, price, description, thumbnail) values ('Steak', 4, 5.15, "New York Strip", "GroceryPics/steakTN.png");