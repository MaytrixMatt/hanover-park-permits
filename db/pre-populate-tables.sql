-- LOCATION TABLE
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
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(1, '1', '1');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(2, '2', '1');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(3, '3', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(4, '4', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(5, '5', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(6, '6', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(7, '7', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(8, '8', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(9, '9', '2');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(10, '10', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(11, '11', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(12, '12', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(13, '13', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(14, '14', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(15, '15', '3');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(16, '16', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(17, '17', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(18, '18', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(19, '19', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(20, '20', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(21, '21', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(22, '22', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(23, '23', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(24, '24', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(25, '25', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(26, '26', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(27, '27', '4');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(28, '28', '5');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(29, '29', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(30, '30', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(31, '31', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(32, '32', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(33, '33', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(34, '34', '6');
insert into application_fields(afl_id, afl_fld_id, afl_loc_id) value(35, '35', '6');