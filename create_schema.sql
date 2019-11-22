/* The CUSTOMER table */

drop table customers;

create table customers (
	cellphone integer, 
	name varchar(40),
	address varchar(100),
	dlicense integer,
	primary key (dlicense),
	unique (cellphone) 
);

/* The VEHICLE table */

drop table vehicles;

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
	check (
		status = 'available' or
		status = 'rented' or 
		status = 'maintenance'
	)
);

/* The VEHICLE TYPE table */

drop table vehicle_types;

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

/* The RESERVATIONS table */

drop table reservations;

create table reservations (
	conf_no integer,
	vtname varchar(40),
	cellphone integer,
	from_datetime date,
	to_datetime date,
	primary key (conf_no)
);

/* The RENTALS table */

drop table rentals;

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
	primary key (rid)
);

/* The RETURNS table */

drop table returns;

create table returns (
	rid integer,
	return_date date,
	odometer integer,
	full_tank varchar(2),
	value integer,
	primary key (rid),
	check (
		full_tank = 'y' or
		full_tank = 'n'
	)
);





