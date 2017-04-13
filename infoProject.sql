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
insert into prodcategories (name, description, thumbnail) values ('Candy', 'Sweets and treats', "GroceryPics/herseybarTN.jpg");

insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Whole Milk', 1, 3.56, "A&E Whole White Milk", "GroceryPics/milkTN.jpg", "GroceryPics/milk.jpeg", "AE");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Bananas', 2, 0.77, "For scale", "GroceryPics/bananaTN.jpg", "GroceryPics/banana.jpg", "Chiquita");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Toilet Paper', 3, 5.99, "Scott Triple Ply", "GroceryPics/toiletpaperTN.jpg", "GroceryPics/toiletpaper.jpg", 'Scott');
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Steak', 4, 5.15, "New York Strip", "GroceryPics/steakTN.png", "GroceryPics/steak.jpg",'Econo-meat');
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Chocolate Bar', 5, 1.99, "Hershey Bar", "GroceryPics/herseybarTN.jpg", "GroceryPics/herseybar.jpg",'Hershey');

insert into productdetails (productid, grocerid, saleprice, stock) values (1, 1, 3.99, 12);
insert into productdetails (productid, grocerid, saleprice, stock) values (2, 1, .99, 30);
insert into productdetails (productid, grocerid, saleprice, stock) values (3, 1, 7.99, 24);
insert into productdetails (productid, grocerid, saleprice, stock) values (4, 1, 8.99, 20);
insert into productdetails (productid, grocerid, saleprice, stock) values (5, 1, 2.99, 64);
insert into productdetails (productid, grocerid, saleprice, stock) values (1, 2, 4.99, 6);
insert into productdetails (productid, grocerid, saleprice, stock) values (2, 2, 1.15, 12);
insert into productdetails (productid, grocerid, saleprice, stock) values (3, 2, 6.49, 46);

insert into grocers (name, email, phone) values ('food.biz', 'boss@food.biz', '(555)555-5555');
insert into grocers (name, email, phone) values ('scam.food', 'thief@scam.food', '(545)545-5445');