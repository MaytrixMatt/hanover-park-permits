-- FACILITY TABLE
insert into location(loc_name) value('Briggs Field');
insert into location(loc_name) value('Ceurvels Field');
insert into location(loc_name) value('Calvin J. Ellis Field');
insert into location(loc_name) value('Forge Pond Park');
insert into location(loc_name) value('Amos Gallant Field');
insert into location(loc_name) value('B. Everett Hall');

-- FIELDS TABLE
insert into fields(fld_loc_id, fld_name) value(1, 'T-Ball');
insert into fields(fld_loc_id, fld_name) value(1, 'Other');

insert into fields(fld_loc_id, fld_name) value(2, 'Full-size Baseball');
insert into fields(fld_loc_id, fld_name) value(2, 'Little League');
insert into fields(fld_loc_id, fld_name) value(2, 'Softball');
insert into fields(fld_loc_id, fld_name) value(2, 'Lacrosse');
insert into fields(fld_loc_id, fld_name) value(2, 'Soccer');
insert into fields(fld_loc_id, fld_name) value(2, 'Basketball');
insert into fields(fld_loc_id, fld_name) value(2, 'Other');

insert into fields(fld_loc_id, fld_name) value(3, 'Little League #1');
insert into fields(fld_loc_id, fld_name) value(3, 'Little League #2');
insert into fields(fld_loc_id, fld_name) value(3, 'Little League #3');
insert into fields(fld_loc_id, fld_name) value(3, 'Field #4');
insert into fields(fld_loc_id, fld_name) value(3, 'Soccer');
insert into fields(fld_loc_id, fld_name) value(3, 'Other');

insert into fields(fld_loc_id, fld_name) value(4, 'Little League #1');
insert into fields(fld_loc_id, fld_name) value(4, 'Little League #2');
insert into fields(fld_loc_id, fld_name) value(4, 'Little League #3');
insert into fields(fld_loc_id, fld_name) value(4, 'Softball #4');
insert into fields(fld_loc_id, fld_name) value(4, 'Softball #5');
insert into fields(fld_loc_id, fld_name) value(4, 'Softball #6');
insert into fields(fld_loc_id, fld_name) value(4, 'Multi-Use Soccer');
insert into fields(fld_loc_id, fld_name) value(4, 'Multi-Use Lacrosse');
insert into fields(fld_loc_id, fld_name) value(4, 'Multi-Use Other');
insert into fields(fld_loc_id, fld_name) value(4, 'Pavilion');
insert into fields(fld_loc_id, fld_name) value(4, 'Kitchen & Pavilion');
insert into fields(fld_loc_id, fld_name) value(4, 'Other');

insert into fields(fld_loc_id, fld_name) value(5, 'Other');

insert into fields(fld_loc_id, fld_name) value(6, 'Full-Size Basketball');
insert into fields(fld_loc_id, fld_name) value(6, 'Little League [Front Field Only]');
insert into fields(fld_loc_id, fld_name) value(6, 'Basketball 1');
insert into fields(fld_loc_id, fld_name) value(6, 'Basket Ball 2');
insert into fields(fld_loc_id, fld_name) value(6, 'Football');
insert into fields(fld_loc_id, fld_name) value(6, 'Street Hockey Rink');
insert into fields(fld_loc_id, fld_name) value(6, 'Other');


-- for populating application_fields
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(1, '109', '1');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(2, '110', '1');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(3, '111', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(4, '112', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(5, '113', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(6, '114', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(7, '115', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(8, '116', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(9, '117', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(10, '118', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(11, '119', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(12, '120', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(13, '121', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(14, '122', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(15, '123', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(16, '124', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(17, '125', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(18, '126', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(19, '127', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(20, '128', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(21, '129', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(22, '130', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(23, '131', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(24, '132', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(25, '133', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(26, '134', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(27, '135', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(28, '136', '5');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(29, '137', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(30, '138', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(31, '139', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(32, '140', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(33, '141', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(34, '142', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(35, '143', '6');