create table Movie(
	id int not null,
	title varchar(100) not null,
	year int,
	rating varchar(10),
	company varchar(50),
	primary key(id),
	check (id > 0 and year > 0),
	check (rating in ('G', 'PG', 'PG-13', 'R', 'NC-17'))
);


create table Actor(
	id int not null,
	last varchar(20) not null,
	first varchar(20) not null,
	sex varchar(6),
	dob date,
	dod date,
	primary key(id),
	check(sex in ('Male', 'Female'))
);

create table Director(
	id int,
	last varchar(20),
	first varchar(20),
	dob date,
	dod date,
	primary key(id),
	check(
		not exists(
			select Director.id
			from Director join Actor
			where Director.id != Actor.id and Director.last = Actor.last and Director.first = Actor.first and Director.dob = Actor.dob
		)
	)
);

create table MovieGenre(
	mid int,
	genre varchar(20),
	foreign key(mid) references Movie(id) on delete cascade
);

create table MovieDirector(
	mid int,
	did int,
	primary key(mid),
	foreign key(mid) references Movie(id) on delete cascade,
	foreign key(did) references Director(id) on delete cascade
);

create table MovieActor(
	mid int,
	aid int,
	role varchar(50),
	primary key(mid, aid, role),
	foreign key(mid) references Movie(id) on delete cascade,
	foreign key(aid) references Actor(id) on delete cascade
);

create table Review(
	name varchar(20),
	time timestamp,
	mid int,
	rating int,
	comment varchar(500),
	foreign key (mid) references Movie(id) on delete cascade,
	check (rating > 0)
);

create table MaxPersonID(
	id int,
	check(id > 0)
);

create table MaxMovieID(
	id int,
	check(id > 0)
);