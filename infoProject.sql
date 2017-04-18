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
insert into prodcategories (name, description, thumbnail) values ('Other', 'Other', "GroceryPics/catfoodTN.jpg");

insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Whole Milk', 1, 3.56, "A&E Whole White Milk", "GroceryPics/milkTN.jpg", "GroceryPics/milk.jpeg", "AE");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Bananas', 2, 0.77, "For scale", "GroceryPics/bananaTN.jpg", "GroceryPics/banana.jpg", "Chiquita");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Toilet Paper', 3, 5.99, "Scott Triple Ply", "GroceryPics/toiletpaperTN.jpg", "GroceryPics/toiletpaper.jpg", 'Scott');
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Steak', 4, 5.15, "New York Strip", "GroceryPics/steakTN.png", "GroceryPics/steak.jpg",'Econo-meat');
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Chocolate Bar', 5, 1.99, "Hershey Bar", "GroceryPics/herseybarTN.jpg", "GroceryPics/herseybar.jpg",'Hershey');
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Apple', 2, 0.88, "Granny Smith Apple", "GroceryPics/appleTN.jpg", "GroceryPics/apple.jpeg", "Kanzi");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Ice Cream', 1, 4.50, "White Chocolae Macadamia Nut Cookie Ice Cream", "GroceryPics/bluebunnyTN.jpg", "GroceryPics/blue bunny.jpg", "Blue Bunny");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Paper Towel', 3, 1.50, "Single Roll Bounty Paper Towel", "GroceryPics/bountyTN.jpg", "GroceryPics/bounty.jpg", "Bounty");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Broccoli', 2, 0.80, "Bundle of Broccoli", "GroceryPics/broccoliTN.jpg", "GroceryPics/Broccoli.jpg", "Green Isle");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Cat Food', 6, 3.59, "Meow Mix Original Choice Cat Food", "GroceryPics/catfoodTN.jpg", "GroceryPics/catfood.jpg", "Meow Mix");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Coffee', 6, 8.50, "Folgers Coffee House Style Coffee", "GroceryPics/coffeeTN.jpg", "GroceryPics/coffee.jpg", "Folgers");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Pizza', 6, 3.99, "Digiorno Rising Crust Pepperoini Pizza", "GroceryPics/digiornoTN.jpg", "GroceryPics/digiorno.jpg", "Digiorno");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Paper Plates', 3, 1.99, "Dixie Ultra Paper Plates", "GroceryPics/dixieplatesTN.jpg", "GroceryPics/dixieplates.jpeg", "Dixie");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Cheese', 1, 2.49, "Kraft Singles American Cheese", "GroceryPics/kraftcheeseTN.jpg", "GroceryPics/kraftcheese.jpg", "Kraft");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Chips', 6, 2.49, "Lays Original Potato Chips", "GroceryPics/laysTN.jpg", "GroceryPics/lays.jpeg", "Lays");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Lunchable', 6, 1.49, "Ham and Cheddar Lunchable", "GroceryPics/lunchableTN.png", "GroceryPics/lunchable.jpg", "Lunchable");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Toilet Cleaner', 6, 1.99, "Lysol Toilet Cleaner", "GroceryPics/toilet cleanerTN.jpg", "GroceryPics/toilet cleaner.jpg", "Lysol");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Baby Carrots', 2, 0.99, "Bolthouse Farms Baby Cut Carrots", "GroceryPics/babycarrotsTN.jpg", "GroceryPics/babycarrots.jpeg", "Bolthouse Farms");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Baby Spinach', 2, 1.39, "Bloom Fresh Baby Spinach", "GroceryPics/babyspinachTN.jpg", "GroceryPics/babyspinach.jpg", "Bloom Fresh");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Ice Cream', 1, 3.49, "Ben and Jerry's Cherry Garcia Ice Cream", "GroceryPics/benjerryscherryTN.jpg", "GroceryPics/benjerryscherry.jpg", "Ben and Jerry's");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Ice Cream', 1, 3.49, "Ben and Jerry's Half Baked Ice Cream", "GroceryPics/benjerryshalfbakedTN.jpg", "GroceryPics/benjerryshalfbaked.jpg", "Ben and Jerry's");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Beverage', 6, 2.99, "Bolthouse Tropical Goodness Drink", "GroceryPics/bolthousedrinkTN.jpg", "GroceryPics/bolthousedrink.jpeg", "Bolthouse Farms");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Toilet Paper', 3, 5.49, "Charmin Ultra Strong Toilet Paper", "GroceryPics/charminTN.jpg", "GroceryPics/charmin.jpg", "Charmin");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Toilet Paper', 3, 5.29, "Charmin Basic Toilet Paper", "GroceryPics/charminbasicTN.jpg", "GroceryPics/charminbasic.jpg", "Charmin");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Toilet Paper', 3, 5.49, "Charmin Ultra Soft Toilet Paper", "GroceryPics/charminsoftTN.jpg", "GroceryPics/charminsoft.jpg", "Charmin");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Chicken Breast', 4, 1.99, "Boneless Skinless Chicken Breast", "GroceryPics/chickenbreastTN.jpg", "GroceryPics/chickenbreast.jpg", "Tyson");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Corn', 2, 0.99, "Price Per Dozen Ears", "GroceryPics/cornTN.png", "GroceryPics/corn.jpg", "Green Giant");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Candy Bar', 5, 5.49, "Crunch Bar", "GroceryPics/crunchTN.jpg", "GroceryPics/crunch.jpg", "Nestle");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Chips', 6, 1.49, "Doritos Nacho Cheese", "GroceryPics/doritoscheeseTN.jpg", "GroceryPics/doritoscheese.jpg", "Doritos");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Chips', 6, 1.59, "Doritos Dinamita Chile Limon", "GroceryPics/doritoschile.jpg", "GroceryPics/doritoschile.jpeg", "Doritos");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Ice Cream', 1, 2.49, "Breyers Reese's Peanut Butter Cup Ice Cream", "GroceryPics/hagenTN.jpg", "GroceryPics/hagen.jpeg", "Breyes");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Lunchable', 6, 1.49, "Lunchables Pizza", "GroceryPics/lunchablespizzaTN.jpg", "GroceryPics/lunchablespizza.jpg", "Lunchables");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Pork Chop', 4, 2.49, "Center Cut Pork Chop", "GroceryPics/porkchopTN.jpg", "GroceryPics/porkchop.jpg", "Swift Premium");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Pizza', 6, 2.49, "Red Baron Brick Oven Cheese Trio Pizza", "GroceryPics/redbaronTN.jpg", "GroceryPics/redbaron.jpg", "Red Baron");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Pizza', 6, 2.49, "Red Baron Rising Crust Pepperoni ", "GroceryPics/redbaronpepperoniTN.jpg", "GroceryPics/redbaronpepperoni.jpg", "Red Baron");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Toilet Paper', 3, 4.99, "Scott 12 Pack Single Ply", "GroceryPics/scotttoiletpaperTN.jpg", "GroceryPics/scotttoiletpaper.jpeg", "Scott");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Steak', 4, 8.99, "T-Bone Steak", "GroceryPics/tboneTN.jpg", "GroceryPics/tbone.jpg", "Econo-meat");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Cheese', 1, 3.99, "Original Shells and Cheese", "GroceryPics/velveetaTN.jpg", "GroceryPics/velveeta.jpg", "Velveeta");
insert into products (name, categoryid, price, description, thumbnail, image, brand) values ('Cheese', 1, 0.99, "Velveeta Shells and Cheese Snack Cup", "GroceryPics/velveetacupTN.jpg", "GroceryPics/velveetacup.jpg", "Velveeta");





insert into productdetails (productid, grocerid, saleprice, stock) values (1, 1, 3.99, 12);
insert into productdetails (productid, grocerid, saleprice, stock) values (2, 1, .99, 30);
insert into productdetails (productid, grocerid, saleprice, stock) values (3, 1, 7.99, 24);
insert into productdetails (productid, grocerid, saleprice, stock) values (4, 1, 8.99, 20);
insert into productdetails (productid, grocerid, saleprice, stock) values (5, 1, 2.99, 64);
insert into productdetails (productid, grocerid, saleprice, stock) values (1, 2, 4.99, 6);
insert into productdetails (productid, grocerid, saleprice, stock) values (2, 2, 1.15, 12);
insert into productdetails (productid, grocerid, saleprice, stock) values (3, 2, 6.49, 46);
insert into productdetails (productid, grocerid, saleprice, stock) values (6, 1, 1.49, 55);
insert into productdetails (productid, grocerid, saleprice, stock) values (7, 1, 6.00, 13);
insert into productdetails (productid, grocerid, saleprice, stock) values (8, 1, 2.29, 16);
insert into productdetails (productid, grocerid, saleprice, stock) values (9, 1, .99, 42);
insert into productdetails (productid, grocerid, saleprice, stock) values (10, 1, 11.99, 12);
insert into productdetails (productid, grocerid, saleprice, stock) values (11, 1, 9.99, 9);
insert into productdetails (productid, grocerid, saleprice, stock) values (12, 1, 5.99, 15);
insert into productdetails (productid, grocerid, saleprice, stock) values (13, 1, 3.99, 22);
insert into productdetails (productid, grocerid, saleprice, stock) values (14, 1, 4.29, 14);
insert into productdetails (productid, grocerid, saleprice, stock) values (15, 1, 3.99, 15);
insert into productdetails (productid, grocerid, saleprice, stock) values (16, 1, 2.49, 7);








insert into grocers (name, email, phone) values ('food.biz', 'boss@food.biz', '(555)555-5555');
insert into grocers (name, email, phone) values ('scam.food', 'thief@scam.food', '(545)545-5445');