/* SCRIPT TO POPULATE THE DB */

/* ====== customers ===== * 

create table customers (
        cellphone integer,
        name varchar(40),
        address varchar(100),
        dlicense integer,
        primary key (dlicense),
        unique (cellphone)
);

Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 CELLPHONE					    NUMBER(38)
 NAME						    VARCHAR2(40)
 ADDRESS					    VARCHAR2(100)
 DLICENSE				   NOT NULL NUMBER(38)

*/

insert into customers values (111111, 'Ananye Agarwal', 'B109', 1);

insert into customers values (222222, 'Kabir Tomer', 'B108', 2);

insert into customers values (333333, 'Salman', 'B107', 3);

insert into customers values (444444, 'John Doe', 'B108', 4);

insert into customers values (915100, 'Jane Doe', 'W747', 5);

insert into customers values (257662, 'Junsoo Wayne', 'R623', 6);

insert into customers values (663378, 'Ryan Murtha', 'U338', 7);

insert into customers values (737751, 'Andy Berg', 'S724', 8);

insert into customers values (580903, 'Luca Payne', 'Q874', 9);

insert into customers values (648821, 'Bruce Kim', 'Z856', 10);

insert into customers values (422876, 'Adam James', 'C806', 11);

insert into customers values (382863, 'William Baker', 'D269', 12);

insert into customers values (648703, 'Clyde Wayne', 'Q237', 13);

insert into customers values (315247, 'David Parker', 'L451', 14);

insert into customers values (784503, 'Emily Howard', 'M625', 15);

insert into customers values (939946, 'Fred Gibbons', 'E126', 16);

insert into customers values (201922, 'Gregory Baker', 'Z503', 17);

insert into customers values (833052, 'Henry Icecap', 'L926', 18);

insert into customers values (380122, 'Ingrid Walker', 'Q550', 19);

insert into customers values (715972, 'Jason Thomas', 'E163', 20);

insert into customers values (494079, 'Kurt Barton', 'F148', 21);

/* ===== vehicle_types ========= 

create table vehicle_types (
        vtname varchar(40),
        features varchar(400),
        wrate integer,
        drate integer,
        hrate integer,
        wirate integer,
        dirate integer,
        hirate integer,
        krate integer,
        primary key (vtname)
);

Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 VTNAME 				   NOT NULL VARCHAR2(40)
 FEATURES					    VARCHAR2(400)
 WRATE						    NUMBER(38)
 DRATE						    NUMBER(38)
 HRATE						    NUMBER(38)
 WIRATE 					    NUMBER(38)
 DIRATE 					    NUMBER(38)
 HIRATE 					    NUMBER(38)
 KRATE						    NUMBER(38)

*/

insert into vehicle_types
values ( 'sedan',
	 'Sturdy family car with nice mileage',
	 123,
	 123,
	 23,
	 123,
	 123,
	 123,
	 123 );

 
insert into vehicle_types
values ( 'truck',
	 'Truck with large holding space',
	 1, 2, 3, 4, 5, 6, 7 );

insert into vehicle_types
values ( 'electric',
	 'Stylish electric car',
	 1, 2, 3, 4, 5, 6, 6 );	

insert into vehicle_types
values ( 'SUV',
	 'A large, durable car that can withstand any terrain',
	 4, 6, 7, 14, 8, 10, 7 );	

insert into vehicle_types
values ( 'hybrid',
	 'A car with a gasoline engine and an electric motor',
	 7, 8, 6, 8, 8, 9, 7 );	

insert into vehicle_types
values ( 'minivan',
	 'A minivan with many seats for trips',
	 8, 3, 6, 7, 7, 5, 2 );	

insert into vehicle_types
values ( 'wagon',
	 'A car with a large cargo area',
	 8, 7, 5, 9, 6, 9, 7 );	

/* ======= vehicle ======= 

create table vehicles (
        vlicense integer,
        make varchar(40),
        model varchar(40),
        year integer,
        color varchar(20),
        odometer integer,
        status varchar(20),
        vtname varchar(40),
        location varchar(40),
        city varchar(40),
        primary key (vlicense),
        foreign key (vtname) references vehicle_types(vtname),
        check (
                status = 'available' or
                status = 'rented' or
                status = 'maintenance'
        )
);

Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 VLICENSE				   NOT NULL NUMBER(38)
 MAKE						    VARCHAR2(40)
 MODEL						    VARCHAR2(40)
 YEAR						    NUMBER(38)
 COLOR						    VARCHAR2(20)
 ODOMETER					    NUMBER(38)
 STATUS 					    VARCHAR2(20)
 VTNAME 					    VARCHAR2(40)
 LOCATION					    VARCHAR2(40)
 CITY						    VARCHAR2(40)


*/

insert into vehicles values (1, 'alpha', 'one', 1999, 'red', 100, 'available', 'sedan', 'ubc', 'vancouver' );

insert into vehicles values (2, 'beta', 'two', 2000, 'blue', 200, 'rented', 'sedan', 'ubc', 'vancouver' );

insert into vehicles values (3, 'gamma', 'three', 2002, 'purple', 30, 'available', 'truck', 'downtown', 'vancouver' );

insert into vehicles values (4, 'delta', 'four', 2004, 'brown', 40, 'available', 'electric', 'downtown', 'richmond' );

insert into vehicles values (5, 'epsilon', 'five', 2005,'green', 40, 'available', 'electric', 'kits', 'vancouver' );

insert into vehicles values (6, 'Volkswagen', '7 Series', 2001, 'white,', 53, 'rented', 'hybrid', 'dunbar', 'vancouver');

insert into vehicles values (7, 'Mercedez-Benz', 'A3', 2014, 'yellow', 66, 'rented', 'sedan', 'point grey', 'vancouver');

insert into vehicles values (8, 'Mercedez-Benz', 'Bolt', 2007, 'yellow', 110, 'rented', 'SUV', 'kerrisdale', 'vancouver');

insert into vehicles values (9, 'Honda', 'Spark', 2005, 'green', 60, 'rented', 'minivan', 'downtown', 'vancouver');

insert into vehicles values (10, 'Jaguar', 'X7', 2002, 'green', 64, 'available', 'minivan', 'point grey', 'vancouver');

insert into vehicles values (11, 'Volkswagen', 'Durango', 1998, 'yellow', 49, 'maintenance', 'sedan', 'kerrisdale', 'vancouver');

insert into vehicles values (12, 'Volkswagen', 'X6', 2002, 'white,', 104, 'available', 'SUV', 'kerrisdale', 'vancouver');

insert into vehicles values (13, 'Mercedez-Benz', '4 Series', 1995, 'white,', 111, 'maintenance', 'SUV', 'ubc', 'vancouver');

insert into vehicles values (14, 'Honda', 'XT4', 2003, 'green', 51, 'maintenance', 'sedan', 'downtown', 'vancouver');

insert into vehicles values (15, 'Mitsubishi', '4 Series', 1998, 'yellow', 114, 'available', 'hybrid', 'dunbar', 'vancouver');

insert into vehicles values (16, 'Jaguar', 'XT4', 2002, 'white,', 61, 'maintenance', 'hybrid', 'ubc', 'vancouver');

insert into vehicles values (17, 'Nissan', 'A4', 2003, 'green', 103, 'available', 'electric', 'ubc', 'vancouver');

insert into vehicles values (18, 'Cadilac', 'Durango', 1999, 'blue', 83, 'maintenance', 'sedan', 'point grey', 'vancouver');

insert into vehicles values (19, 'Mitsubishi', 'Impala', 2014, 'blue', 89, 'rented', 'minivan', 'downtown', 'vancouver');

insert into vehicles values (20, 'BMW', 'XT4', 2003, 'black', 113, 'rented', 'truck', 'dunbar', 'vancouver');

insert into vehicles values (21, 'Mitsubishi', 'Spark', 2009, 'white,', 117, 'rented', 'minivan', 'downtown', 'vancouver');

insert into vehicles values (22, 'Honda', 'Spark', 2006, 'red', 115, 'available', 'minivan', 'dunbar', 'vancouver');

insert into vehicles values (23, 'Ford', 'X7', 1995, 'black', 57, 'available', 'wagon', 'downtown', 'vancouver');

insert into vehicles values (24, 'Honda', 'Durango', 2009, 'blue', 71, 'available', 'minivan', 'kits', 'vancouver');

insert into vehicles values (25, 'BMW', 'XT4', 1997, 'black', 96, 'rented', 'electric', 'kits', 'vancouver');

insert into vehicles values (26, 'Dodge', '4 Series', 1996, 'red', 104, 'rented', 'SUV', 'downtown', 'vancouver');

insert into vehicles values (27, 'Cadilac', 'XT4', 2008, 'green', 54, 'rented', 'sedan', 'dunbar', 'vancouver');

insert into vehicles values (28, 'Mercedez-Benz', 'A4', 2009, 'white,', 51, 'rented', 'hybrid', 'ubc', 'vancouver');

insert into vehicles values (29, 'Honda', 'A3', 1996, 'yellow', 105, 'rented', 'SUV', 'ubc', 'vancouver');

insert into vehicles values (30, 'Volkswagen', 'A3', 2010, 'black', 53, 'available', 'SUV', 'kits', 'vancouver');

insert into vehicles values (31, 'Audi', 'Spark', 2013, 'white,', 101, 'available', 'sedan', 'downtown', 'vancouver');

insert into vehicles values (32, 'Lexus', 'X7', 2006, 'green', 42, 'rented', 'truck', 'dunbar', 'vancouver');

insert into vehicles values (33, 'Dodge', 'A3', 2008, 'white,', 55, 'available', 'wagon', 'dunbar', 'vancouver');

insert into vehicles values (34, 'Volkswagen', 'Bolt', 2003, 'yellow', 47, 'rented', 'wagon', 'kits', 'vancouver');

insert into vehicles values (35, 'Mazda', '7 Series', 2014, 'white,', 90, 'rented', 'truck', 'point grey', 'vancouver');

/* ===== reservations ======== 

create table reservations (
        conf_no integer,
        vtname varchar(40),
        dlicense integer,
        from_datetime date,
        to_datetime date,
        primary key (conf_no),
        foreign key (vtname) references vehicle_types(vtname),
        foreign key (dlicense) references customers(dlicense)
);

Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 CONF_NO                                   NOT NULL VARCHAR2(40)
 VTNAME 					    VARCHAR2(40)
 DLICENSE					    NUMBER(38)
 FROM_DATETIME					    DATE
 TO_DATETIME					    DATE

*/

insert into reservations values ('1111', 'truck', 1, to_date('1998/05/31:12:00AM', 'yyyy/mm/dd:hh:miam'), to_date('1998/06/05:12:00AM', 'yyyy/mm/dd:hh:miam'), 'ubc');

insert into reservations values ('2222', 'sedan', 2, to_date('1998/06/01:12:00AM', 'yyyy/mm/dd:hh:miam'), to_date('1998/06/06:12:00AM', 'yyyy/mm/dd:hh:miam'), 'kitsilano');

insert into reservations values ('3333', 'electric', 3, to_date('1998/06/08:12:00AM', 'yyyy/mm/dd:hh:miam'), to_date('1998/06/15:12:00AM', 'yyyy/mm/dd:hh:miam'), 'downtown');

insert into reservations values ('4444', 'electric', 4, to_date('1998/06/17:12:00AM', 'yyyy/mm/dd:hh:miam'), to_date('1998/06/20:12:00AM', 'yyyy/mm/dd:hh:miam'), 'ubc');

insert into reservations values ('5000', 'electric', 7, to_date('1998/2/3:2:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1998/3/1:3:00PM', 'yyyy/mm/dd:hh:miam'), 'kerrisdale');

insert into reservations values ('5001', 'minivan', 17, to_date('2000/12/15:11:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2000/13/2:11:00AM', 'yyyy/mm/dd:hh:miam'), 'dunbar');

insert into reservations values ('5002', 'truck', 13, to_date('1998/5/15:10:00AM', 'yyyy/mm/dd:hh:miam'), to_date('1998/6/5:10:00AM', 'yyyy/mm/dd:hh:miam'), 'point grey');

insert into reservations values ('5003', 'electric', 14, to_date('2002/2/10:5:00PM', 'yyyy/mm/dd:hh:miam'), to_date('2002/3/7:5:00PM', 'yyyy/mm/dd:hh:miam'), 'ubc');

insert into reservations values ('5004', 'minivan', 11, to_date('2001/2/15:4:00PM', 'yyyy/mm/dd:hh:miam'), to_date('2001/3/11:5:00PM', 'yyyy/mm/dd:hh:miam'), 'dunbar');

insert into reservations values ('5005', 'SUV', 15, to_date('1995/4/6:2:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1995/4/6:2:00PM', 'yyyy/mm/dd:hh:miam'), 'kerrisdale');

insert into reservations values ('5006', 'wagon', 12, to_date('1996/2/27:8:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1996/3/8:9:00PM', 'yyyy/mm/dd:hh:miam'), 'kits');

insert into reservations values ('5007', 'hybrid', 16, to_date('2003/1/15:6:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2003/2/3:7:00AM', 'yyyy/mm/dd:hh:miam'), 'kits');

insert into reservations values ('5008', 'truck', 20, to_date('1999/7/1:9:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1999/7/20:9:00PM', 'yyyy/mm/dd:hh:miam'), 'kits');

insert into reservations values ('5009', 'electric', 3, to_date('1997/10/16:9:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1997/11/10:9:00PM', 'yyyy/mm/dd:hh:miam'), 'dunbar');

insert into reservations values ('5010', 'sedan', 13, to_date('2004/12/24:10:00PM', 'yyyy/mm/dd:hh:miam'), to_date('2004/13/9:10:00PM', 'yyyy/mm/dd:hh:miam'), 'kits');

insert into reservations values ('5011', 'minivan', 12, to_date('1995/12/22:11:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1995/13/5:11:00PM', 'yyyy/mm/dd:hh:miam'), 'ubc');

insert into reservations values ('5012', 'SUV', 18, to_date('2002/4/4:2:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2002/4/25:2:00AM', 'yyyy/mm/dd:hh:miam'), 'kits');

insert into reservations values ('5013', 'electric', 2, to_date('1997/5/13:7:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1997/5/13:7:00PM', 'yyyy/mm/dd:hh:miam'), 'ubc');

insert into reservations values ('5014', 'minivan', 10, to_date('2003/6/25:10:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2003/7/3:10:00AM', 'yyyy/mm/dd:hh:miam'), 'dunbar');

insert into reservations values ('5015', 'truck', 5, to_date('1997/3/24:8:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1997/4/17:8:00PM', 'yyyy/mm/dd:hh:miam'), 'kits');

insert into reservations values ('5016', 'minivan', 16, to_date('1998/11/24:7:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1998/12/15:7:00PM', 'yyyy/mm/dd:hh:miam'), 'downtown');

insert into reservations values ('5017', 'wagon', 5, to_date('1997/8/16:5:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1997/8/29:5:00PM', 'yyyy/mm/dd:hh:miam'), 'kerrisdale');

insert into reservations values ('5018', 'electric', 15, to_date('2000/1/16:7:00PM', 'yyyy/mm/dd:hh:miam'), to_date('2000/1/29:7:00PM', 'yyyy/mm/dd:hh:miam'), 'kits');

insert into reservations values ('5019', 'hybrid', 14, to_date('2003/6/26:4:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2003/7/18:5:00AM', 'yyyy/mm/dd:hh:miam'), 'dunbar');

insert into reservations values ('5020', 'SUV', 18, to_date('2001/3/26:5:00PM', 'yyyy/mm/dd:hh:miam'), to_date('2001/4/8:5:00PM', 'yyyy/mm/dd:hh:miam'), 'kerrisdale');

insert into reservations values ('5021', 'truck', 15, to_date('1997/2/4:6:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1997/2/19:6:00PM', 'yyyy/mm/dd:hh:miam'), 'kerrisdale');

insert into reservations values ('5022', 'wagon', 15, to_date('1999/8/26:8:00AM', 'yyyy/mm/dd:hh:miam'), to_date('1999/9/6:9:00AM', 'yyyy/mm/dd:hh:miam'), 'ubc');

insert into reservations values ('5023', 'sedan', 7, to_date('2003/10/6:10:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2003/10/8:10:00AM', 'yyyy/mm/dd:hh:miam'), 'ubc');

insert into reservations values ('5024', 'truck', 12, to_date('2000/6/22:10:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2000/7/4:10:00AM', 'yyyy/mm/dd:hh:miam'), 'dunbar');

insert into reservations values ('5025', 'SUV', 16, to_date('1997/1/10:3:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1997/1/10:3:00PM', 'yyyy/mm/dd:hh:miam'), 'point grey');

insert into reservations values ('5026', 'wagon', 3, to_date('2001/10/18:10:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2001/10/19:10:00AM', 'yyyy/mm/dd:hh:miam'), 'kerrisdale');

insert into reservations values ('5027', 'sedan', 3, to_date('2001/4/6:3:00PM', 'yyyy/mm/dd:hh:miam'), to_date('2001/4/6:3:00PM', 'yyyy/mm/dd:hh:miam'), 'downtown');

insert into reservations values ('5028', 'SUV', 11, to_date('1995/11/27:9:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1995/11/29:9:00PM', 'yyyy/mm/dd:hh:miam'), 'kerrisdale');

insert into reservations values ('5029', 'electric', 20, to_date('2001/8/4:7:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2001/8/27:7:00AM', 'yyyy/mm/dd:hh:miam'), 'point grey');

insert into reservations values ('5030', 'wagon', 14, to_date('2003/12/17:7:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2003/13/1:8:00AM', 'yyyy/mm/dd:hh:miam'), 'downtown');

insert into reservations values ('5031', 'SUV', 18, to_date('1997/6/17:12:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1997/7/7:12:00PM', 'yyyy/mm/dd:hh:miam'), 'downtown');

insert into reservations values ('5032', 'hybrid', 4, to_date('1999/4/29:1:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1999/5/22:2:00PM', 'yyyy/mm/dd:hh:miam'), 'dunbar');

insert into reservations values ('5033', 'hybrid', 16, to_date('2004/10/16:8:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2004/10/27:8:00AM', 'yyyy/mm/dd:hh:miam'), 'kerrisdale');

insert into reservations values ('5034', 'sedan', 17, to_date('1998/1/15:8:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1998/2/8:9:00PM', 'yyyy/mm/dd:hh:miam'), 'kits');

insert into reservations values ('5035', 'wagon', 1, to_date('2002/3/17:1:00PM', 'yyyy/mm/dd:hh:miam'), to_date('2002/4/8:2:00PM', 'yyyy/mm/dd:hh:miam'), 'dunbar');

insert into reservations values ('5036', 'electric', 18, to_date('2002/1/26:6:00PM', 'yyyy/mm/dd:hh:miam'), to_date('2002/2/19:6:00PM', 'yyyy/mm/dd:hh:miam'), 'downtown');

insert into reservations values ('5037', 'truck', 1, to_date('1999/3/29:6:00AM', 'yyyy/mm/dd:hh:miam'), to_date('1999/4/27:6:00AM', 'yyyy/mm/dd:hh:miam'), 'point grey');

insert into reservations values ('5038', 'wagon', 10, to_date('1995/1/28:8:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1995/2/25:8:00PM', 'yyyy/mm/dd:hh:miam'), 'kits');

insert into reservations values ('5039', 'SUV', 14, to_date('2002/9/4:9:00PM', 'yyyy/mm/dd:hh:miam'), to_date('2002/9/22:9:00PM', 'yyyy/mm/dd:hh:miam'), 'downtown');

insert into reservations values ('5040', 'sedan', 13, to_date('1995/8/3:2:00AM', 'yyyy/mm/dd:hh:miam'), to_date('1995/8/10:2:00AM', 'yyyy/mm/dd:hh:miam'), 'dunbar');

insert into reservations values ('5041', 'hybrid', 7, to_date('1999/11/2:3:00AM', 'yyyy/mm/dd:hh:miam'), to_date('1999/11/7:3:00AM', 'yyyy/mm/dd:hh:miam'), 'point grey');

insert into reservations values ('5042', 'sedan', 3, to_date('1999/5/26:4:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1999/6/18:5:00PM', 'yyyy/mm/dd:hh:miam'), 'ubc');

insert into reservations values ('5043', 'wagon', 20, to_date('1999/7/1:9:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1999/7/20:9:00PM', 'yyyy/mm/dd:hh:miam'), 'kerrisdale');

insert into reservations values ('5044', 'sedan', 20, to_date('1999/7/1:6:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1999/7/26:6:00PM', 'yyyy/mm/dd:hh:miam'), 'kerrisdale');

insert into reservations values ('5045', 'SUV', 14, to_date('2000/7/28:5:00AM', 'yyyy/mm/dd:hh:miam'), to_date('2000/8/17:6:00AM', 'yyyy/mm/dd:hh:miam'), 'downtown');

insert into reservations values ('5046', 'sedan', 5, to_date('1997/7/24:12:00AM', 'yyyy/mm/dd:hh:miam'), to_date('1997/8/3:12:00AM', 'yyyy/mm/dd:hh:miam'), 'downtown');

insert into reservations values ('5047', 'sedan', 18, to_date('2001/7/27:10:00PM', 'yyyy/mm/dd:hh:miam'), to_date('2001/8/9:10:00PM', 'yyyy/mm/dd:hh:miam'), 'point grey');

insert into reservations values ('5048', 'wagon', 7, to_date('1997/4/8:5:00PM', 'yyyy/mm/dd:hh:miam'), to_date('1997/5/2:6:00PM', 'yyyy/mm/dd:hh:miam'), 'dunbar');

insert into reservations values ('5049', 'wagon', 16, to_date('2002/5/22:3:00PM', 'yyyy/mm/dd:hh:miam'), to_date('2002/6/19:3:00PM', 'yyyy/mm/dd:hh:miam'), 'ubc');

/* ======= rentals ========= 

create table rentals (
        rid integer,
        vlicense integer,
        dlicense integer,
        from_datetime date,
        to_datetime date,
        odometer integer,
        card_name varchar(40),
        card_no integer,
        exp_date date,
        conf_no integer,
        primary key (rid),
        foreign key (conf_no) references reservations(conf_no),
        foreign key (vlicense) references vehicles(vlicense),
        foreign key (dlicense) references customers(dlicense)
);

Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 RID					   NOT NULL NUMBER(38)
 VLICENSE					    NUMBER(38)
 DLICENSE					    NUMBER(38)
 FROM_DATETIME					    DATE
 TO_DATETIME					    DATE
 ODOMETER					    NUMBER(38)
 CARD_NAME					    VARCHAR2(40)
 CARD_NO					    NUMBER(38)
 EXP_DATE					    DATE
 CONF_NO                                            VARCHAR2(40) 

*/

insert into rentals values ('1', 1, 1, 1000, 'Lorem Ipsum', 1234, to_date('2020/05/31', 'yyyy/mm/dd'), '1111');

insert into rentals values ('2', 2, 2, 1000, 'Lorem Ipsum 2', 1235, to_date('2021/05/31', 'yyyy/mm/dd'), '2222');

insert into rentals values ('3', 3, 3, 1000, 'Lorem Ipsum 3', 1236, to_date('2021/05/31', 'yyyy/mm/dd'), '3333');

insert into rentals values ('4', 4, 4, 1000, 'Lorem Ipsum 4', 1237, to_date('2021/05/31', 'yyyy/mm/dd'), '4444');

insert into rentals values ('5', 8, 21, 934, 'Lorem Ipsum6', 3640, to_date('2015/12/15', 'yyyy/mm/dd'), '5010');

insert into rentals values ('6', 16, 15, 992, 'Lorem Ipsum7', 4973, to_date('2013/10/16', 'yyyy/mm/dd'), '5006');

insert into rentals values ('7', 10, 12, 991, 'Lorem Ipsum8', 6927, to_date('2015/10/22', 'yyyy/mm/dd'), '5019');

insert into rentals values ('8', 20, 15, 1016, 'Lorem Ipsum9', 9823, to_date('2011/8/10', 'yyyy/mm/dd'), '5027');

insert into rentals values ('9', 13, 12, 1013, 'Lorem Ipsum10', 1199, to_date('2013/11/19', 'yyyy/mm/dd'), '5034');

insert into rentals values ('10', 26, 18, 995, 'Lorem Ipsum11', 9040, to_date('2019/10/25', 'yyyy/mm/dd'), '5005');

insert into rentals values ('11', 25, 15, 958, 'Lorem Ipsum12', 5186, to_date('2017/1/24', 'yyyy/mm/dd'), '5013');

insert into rentals values ('12', 33, 21, 958, 'Lorem Ipsum13', 8801, to_date('2018/8/24', 'yyyy/mm/dd'), '5020');

insert into rentals values ('13', 14, 18, 945, 'Lorem Ipsum14', 8547, to_date('2013/11/24', 'yyyy/mm/dd'), '5026');

insert into rentals values ('14', 6, 8, 1042, 'Lorem Ipsum15', 5356, to_date('2019/9/26', 'yyyy/mm/dd'), '5032');

insert into rentals values ('15', 8, 21, 1048, 'Lorem Ipsum16', 6736, to_date('2012/5/8', 'yyyy/mm/dd'), '5038');

insert into rentals values ('16', 25, 13, 1039, 'Lorem Ipsum17', 7203, to_date('2018/1/18', 'yyyy/mm/dd'), '5016');

insert into rentals values ('17', 7, 21, 966, 'Lorem Ipsum18', 1143, to_date('2019/1/15', 'yyyy/mm/dd'), '5025');

insert into rentals values ('18', 3, 1, 986, 'Lorem Ipsum19', 6553, to_date('2014/1/14', 'yyyy/mm/dd'), '5003');

insert into rentals values ('19', 18, 7, 1009, 'Lorem Ipsum20', 4828, to_date('2019/9/11', 'yyyy/mm/dd'), '5002');

insert into rentals values ('20', 16, 12, 885, 'Lorem Ipsum21', 4363, to_date('2010/3/22', 'yyyy/mm/dd'), '5008');

insert into rentals values ('21', 23, 3, 1014, 'Lorem Ipsum22', 9894, to_date('2014/10/29', 'yyyy/mm/dd'), '5000');

insert into rentals values ('22', 18, 11, 978, 'Lorem Ipsum23', 2738, to_date('2011/6/11', 'yyyy/mm/dd'), '5036');

insert into rentals values ('23', 34, 16, 925, 'Lorem Ipsum24', 7944, to_date('2011/11/22', 'yyyy/mm/dd'), '5035');

insert into rentals values ('24', 4, 16, 869, 'Lorem Ipsum25', 4039, to_date('2018/5/24', 'yyyy/mm/dd'), '5001');

insert into rentals values ('25', 24, 11, 1016, 'Lorem Ipsum26', 4970, to_date('2016/5/26', 'yyyy/mm/dd'), '5017');

insert into rentals values ('26', 10, 19, 960, 'Lorem Ipsum27', 2660, to_date('2012/11/29', 'yyyy/mm/dd'), '5011');

insert into rentals values ('27', 22, 10, 885, 'Lorem Ipsum28', 8154, to_date('2012/11/10', 'yyyy/mm/dd'), '5029');

insert into rentals values ('28', 10, 11, 1034, 'Lorem Ipsum29', 2453, to_date('2014/6/9', 'yyyy/mm/dd'), '5033');

insert into rentals values ('29', 7, 5, 972, 'Lorem Ipsum30', 9918, to_date('2018/8/10', 'yyyy/mm/dd'), '5022');

insert into rentals values ('30', 33, 6, 902, 'Lorem Ipsum31', 4482, to_date('2019/7/28', 'yyyy/mm/dd'), '5007');

/* ========= returns ============ 

create table returns (
        rid integer,
        return_date date,
        odometer integer,
        full_tank varchar(2),
        value integer,
        primary key (rid),
        foreign key (rid) references rentals(rid),
        check (
                full_tank = 'y' or
                full_tank = 'n'
        )
);

Name					   Null?    Type
 ----------------------------------------- -------- ----------------------------
 RID					   NOT NULL NUMBER(38)
 RETURN_DATE					    DATE
 ODOMETER					    NUMBER(38)
 FULL_TANK					    VARCHAR2(2)
 VALUE						    NUMBER(38)

*/

insert into returns values ('1', to_date('1998/06/05:12:00AM', 'yyyy/mm/dd:hh:miam'), 2000, 'y', 1123);

insert into returns values ('2', to_date('1998/06/06:12:00AM', 'yyyy/mm/dd:hh:miam'), 2000, 'y', 1234);

insert into returns values ('3', to_date('1998/06/15:12:00AM', 'yyyy/mm/dd:hh:miam'), 4000, 'n', 12345);

insert into returns values ('4', to_date('1998/06/20:12:00AM', 'yyyy/mm/dd:hh:miam'), 123124, 'n', 234);

insert into returns values ('14', to_date('2014/1/20:1:00AM', 'yyyy/mm/dd:hh:miam'), 881, 'n', 13087);

insert into returns values ('19', to_date('2016/8/23:1:00AM', 'yyyy/mm/dd:hh:miam'), 919, 'y', 14840);

insert into returns values ('17', to_date('2014/3/9:12:00PM', 'yyyy/mm/dd:hh:miam'), 885, 'n', 12684);

insert into returns values ('5', to_date('2016/5/9:4:00PM', 'yyyy/mm/dd:hh:miam'), 990, 'y', 16317);

insert into returns values ('21', to_date('2018/9/26:3:00AM', 'yyyy/mm/dd:hh:miam'), 996, 'y', 15553);

insert into returns values ('13', to_date('2015/4/14:11:00PM', 'yyyy/mm/dd:hh:miam'), 976, 'y', 12306);

insert into returns values ('14', to_date('2012/11/29:9:00AM', 'yyyy/mm/dd:hh:miam'), 918, 'y', 16174);

insert into returns values ('19', to_date('2018/12/7:9:00PM', 'yyyy/mm/dd:hh:miam'), 994, 'y', 15181);

insert into returns values ('3', to_date('2010/12/27:5:00PM', 'yyyy/mm/dd:hh:miam'), 916, 'n', 14472);

insert into returns values ('21', to_date('2017/9/21:7:00PM', 'yyyy/mm/dd:hh:miam'), 884, 'y', 15524);

insert into returns values ('12', to_date('2018/10/25:8:00AM', 'yyyy/mm/dd:hh:miam'), 963, 'n', 14817);

insert into returns values ('30', to_date('2019/10/27:4:00PM', 'yyyy/mm/dd:hh:miam'), 873, 'y', 13980);

insert into returns values ('12', to_date('2015/12/6:2:00PM', 'yyyy/mm/dd:hh:miam'), 994, 'n', 14749);

insert into returns values ('6', to_date('2011/1/3:5:00PM', 'yyyy/mm/dd:hh:miam'), 956, 'n', 16674);

insert into returns values ('1', to_date('2017/9/24:9:00AM', 'yyyy/mm/dd:hh:miam'), 920, 'n', 12008);

insert into returns values ('5', to_date('2011/5/16:4:00PM', 'yyyy/mm/dd:hh:miam'), 876, 'y', 15718);

insert into returns values ('7', to_date('2018/3/28:12:00AM', 'yyyy/mm/dd:hh:miam'), 955, 'y', 14055);

insert into returns values ('10', to_date('2014/2/13:3:00AM', 'yyyy/mm/dd:hh:miam'), 1028, 'y', 16441);

insert into returns values ('24', to_date('2018/11/13:10:00PM', 'yyyy/mm/dd:hh:miam'), 948, 'n', 14539);

insert into returns values ('19', to_date('2014/6/2:5:00AM', 'yyyy/mm/dd:hh:miam'), 952, 'n', 12022);

insert into returns values ('4', to_date('2012/2/4:11:00PM', 'yyyy/mm/dd:hh:miam'), 937, 'n', 15878);

insert into returns values ('15', to_date('2015/5/28:9:00PM', 'yyyy/mm/dd:hh:miam'), 915, 'y', 12981);

insert into returns values ('12', to_date('2013/11/3:9:00PM', 'yyyy/mm/dd:hh:miam'), 1045, 'y', 16649);

insert into returns values ('5', to_date('2018/7/29:2:00PM', 'yyyy/mm/dd:hh:miam'), 937, 'y', 15964);

insert into returns values ('4', to_date('2017/5/5:12:00PM', 'yyyy/mm/dd:hh:miam'), 862, 'y', 13104);

insert into returns values ('13', to_date('2012/4/20:2:00PM', 'yyyy/mm/dd:hh:miam'), 1026, 'n', 16523);

insert into returns values ('24', to_date('2012/2/9:12:00AM', 'yyyy/mm/dd:hh:miam'), 917, 'y', 15375);

insert into returns values ('11', to_date('2019/11/3:6:00PM', 'yyyy/mm/dd:hh:miam'), 937, 'y', 16407);




