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





