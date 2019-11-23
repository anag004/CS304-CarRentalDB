/* The CUSTOMER table */

drop table returns;
drop table rentals;
drop table reservations;
drop table customers;
drop table vehicles;
drop table vehicle_types;

create table customers (
	cellphone integer, 
	name varchar(40),
	address varchar(100),
	dlicense integer,
	primary key (dlicense),
	unique (cellphone) 
);

/* The VEHICLE TYPE table */


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

/* The VEHICLE table */


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

/* The RESERVATIONS table */


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

/* The RENTALS table */


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

/* The RETURNS table */


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





