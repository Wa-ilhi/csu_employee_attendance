-- PostgreSQL version 14

CREATE OR REPLACE FUNCTION set_config(name text, value text, is_local boolean)
  RETURNS text AS $$
BEGIN
  EXECUTE 'SET ' || quote_ident(name) || ' TO ' || quote_literal(value) || ', ' || CASE WHEN is_local THEN 'LOCAL' ELSE 'SESSION' END;
  RETURN current_setting(name, is_local);
END;
$$ LANGUAGE plpgsql;

SELECT set_config('sql_mode', 'NO_AUTO_VALUE_ON_ZERO', false);
SELECT set_config('time_zone', '+00:00', false);

-- Database: eam_db

-- Table structure for table tbl_attendance

CREATE TABLE tbl_attendance (
  id serial PRIMARY KEY,
  employee_id varchar(255) NOT NULL,
  department varchar(255) NOT NULL,
  shift varchar(255) NOT NULL,
  location varchar(255) NOT NULL,
  message text NOT NULL,
  date date NOT NULL,
  check_in time NOT NULL,
  in_status varchar(255) NOT NULL,
  check_out time NOT NULL,
  out_status varchar(255) NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);

-- Dumping data for table tbl_attendance

INSERT INTO tbl_attendance (employee_id, department, shift, location, message, date, check_in, in_status, check_out, out_status, created_at)
VALUES
  ('EMP-2', 'Account', '09:00:00-18:00:00', 'Office', 'Hello', '2023-09-29', '11:23:05', 'Late', '11:23:39', 'Early', '2023-09-29 05:53:39');

-- Table structure for table tbl_department

CREATE TABLE tbl_department (
  id serial PRIMARY KEY,
  department_id varchar(255) NOT NULL,
  department_name varchar(250) NOT NULL,
  status smallint NOT NULL CHECK (status IN (1, 0)),
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE tbl_attendance
ADD COLUMN meet_topic VARCHAR(255);


-- Drop the primary key constraint on department_id
-- Drop the new primary key on department_id
ALTER TABLE tbl_department DROP CONSTRAINT tbl_department_pkey;

-- Add back the id column
ALTER TABLE tbl_department ADD COLUMN id serial PRIMARY KEY;

-- Drop the old primary key on department_id
ALTER TABLE tbl_department DROP COLUMN department_id;

-- Rename the temporary column back to id
ALTER TABLE tbl_department RENAME COLUMN id_tmp TO id;

-- Add back the primary key constraint on id
ALTER TABLE tbl_department ADD PRIMARY KEY (id);

ALTER TABLE tbl_department
ADD COLUMN department_id varchar(255) NULL;


-- Update existing rows to provide non-null values for department_id
UPDATE tbl_department
SET department_id = 'some_null_value'
WHERE department_id IS NOT NULL;

-- Add the NOT NULL constraint to the department_id column
ALTER TABLE tbl_department
ALTER COLUMN department_id SET NOT NULL;


-- Dumping data for table tbl_department

INSERT INTO tbl_department (department_id, department_name, status, created_at)
VALUES
  ('ACD', 'Account', 1, '2023-09-29 05:47:23'),
  ('ADM', 'Admin', 1, '2023-09-29 05:47:39'),
  ('HRD', 'HR', 1, '2023-09-29 05:47:51');

-- Table structure for table tbl_employee

CREATE TABLE tbl_employee (
  id serial PRIMARY KEY,
  first_name varchar(250) NOT NULL,
  last_name varchar(250) NOT NULL,
  username varchar(250) NOT NULL,
  emailid varchar(250) NOT NULL,
  password varchar(250) NOT NULL,
  dob varchar(50) NOT NULL,
  gender varchar(10) NOT NULL,
  employee_id varchar(250) NOT NULL,
  joining_date varchar(250) NOT NULL,
  phone varchar(10) NOT NULL,
  shift varchar(255) NOT NULL,
  department varchar(255) NOT NULL,
  role varchar(50) NOT NULL CHECK (role IN ('1', '0')),
  status smallint NOT NULL CHECK (status IN (1, 0)),
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);

-- Dumping data for table tbl_employee

INSERT INTO tbl_employee (first_name, last_name, username, emailid, password, dob, gender, employee_id, joining_date, phone, shift, department, role, status, created_at)
VALUES
  ('admin', '', 'admin', 'admin@eam.com', 'AdminEAM@123#$', '', '', '', '', '', '', '', '1', 1, '2023-09-29 05:05:43'),
  ('Jane', 'Smith', 'jane', 'jane@xyz.com', '123', '08/01/2008', 'Male', 'EMP-2', '01/09/2023', '987654321', '09:00:00-18:00:00', 'Account', '0', 1, '2023-09-29 05:50:57');

-- Table structure for table tbl_location

CREATE TABLE tbl_location (
  id serial PRIMARY KEY,
  location varchar(255) NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);

-- Dumping data for table tbl_location

INSERT INTO tbl_location (location, created_at)
VALUES
  ('Office', '2023-09-29 05:52:28'),
  ('Field', '2023-09-29 05:52:40'),
  ('Home', '2023-09-29 05:52:46');

-- Table structure for table tbl_shift

CREATE TABLE tbl_shift (
  id serial PRIMARY KEY,
  start_time varchar(255) NOT NULL,
  end_time varchar(255) NOT NULL,
  status smallint NOT NULL CHECK (status IN (1, 0)),
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);

-- Dumping data for table tbl_shift

INSERT INTO tbl_shift (start_time, end_time, status, created_at)
VALUES
  ('09:00:00', '18:00:00', 1, '2023-09-29 05:48:50'),
  ('13:00:00', '22:00:00', 1, '2023-09-29 05:49:14');
-- PostgreSQL version 14

CREATE OR REPLACE FUNCTION set_config(name text, value text, is_local boolean)
  RETURNS text AS $$
BEGIN
  EXECUTE 'SET ' || quote_ident(name) || ' TO ' || quote_literal(value) || ', ' || CASE WHEN is_local THEN 'LOCAL' ELSE 'SESSION' END;
  RETURN current_setting(name, is_local);
END;
$$ LANGUAGE plpgsql;
SELECT set_config('sql_mode', 'NO_AUTO_VALUE_ON_ZERO', false);
SELECT set_config('time_zone', '+00:00', false);
-- Database: eam_db

-- Table structure for table tbl_attendance

CREATE TABLE tbl_attendance (
  id serial PRIMARY KEY,
  employee_id varchar(255) NOT NULL,
  department varchar(255) NOT NULL,
  shift varchar(255) NOT NULL,
  location varchar(255) NOT NULL,
  message text NOT NULL,
  date date NOT NULL,
  check_in time NOT NULL,
  in_status varchar(255) NOT NULL,
  check_out time NOT NULL,
  out_status varchar(255) NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);
-- Dumping data for table tbl_attendance

INSERT INTO tbl_attendance (employee_id, department, shift, location, message, date, check_in, in_status, check_out, out_status, created_at)
VALUES
  ('EMP-2', 'Account', '09:00:00-18:00:00', 'Office', 'Hello', '2023-09-29', '11:23:05', 'Late', '11:23:39', 'Early', '2023-09-29 05:53:39');
-- Table structure for table tbl_department

CREATE TABLE tbl_department (
  id serial PRIMARY KEY,
  department_id varchar(255) NOT NULL,
  department_name varchar(250) NOT NULL,
  status smallint NOT NULL CHECK (status IN (1, 0)),
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);
-- Dumping data for table tbl_department

INSERT INTO tbl_department (department_id, department_name, status, created_at)
VALUES
  ('ACD', 'Account', 1, '2023-09-29 05:47:23'),
  ('ADM', 'Admin', 1, '2023-09-29 05:47:39'),
  ('HRD', 'HR', 1, '2023-09-29 05:47:51');
-- Table structure for table tbl_employee

CREATE TABLE tbl_employee (
  id serial PRIMARY KEY,
  first_name varchar(250) NOT NULL,
  last_name varchar(250) NOT NULL,
  username varchar(250) NOT NULL,
  emailid varchar(250) NOT NULL,
  password varchar(250) NOT NULL,
  dob varchar(50) NOT NULL,
  gender varchar(10) NOT NULL,
  employee_id varchar(250) NOT NULL,
  joining_date varchar(250) NOT NULL,
  phone varchar(10) NOT NULL,
  shift varchar(255) NOT NULL,
  department varchar(255) NOT NULL,
  role varchar(50) NOT NULL CHECK (role IN ('1', '0')),
  status smallint NOT NULL CHECK (status IN (1, 0)),
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);
-- Dumping data for table tbl_employee

INSERT INTO tbl_employee (first_name, last_name, username, emailid, password, dob, gender, employee_id, joining_date, phone, shift, department, role, status, created_at)
VALUES
  ('admin', '', 'admin', 'admin@eam.com', 'AdminEAM@123#$', '', '', '', '', '', '', '', '1', 1, '2023-09-29 05:05:43'),
  ('Jane', 'Smith', 'jane', 'jane@xyz.com', '123', '08/01/2008', 'Male', 'EMP-2', '01/09/2023', '987654321', '09:00:00-18:00:00', 'Account', '0', 1, '2023-09-29 05:50:57');
-- Table structure for table tbl_location

CREATE TABLE tbl_location (
  id serial PRIMARY KEY,
  location varchar(255) NOT NULL,
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);
-- Dumping data for table tbl_location

INSERT INTO tbl_location (location, created_at)
VALUES
  ('Office', '2023-09-29 05:52:28'),
  ('Field', '2023-09-29 05:52:40'),
  ('Home', '2023-09-29 05:52:46');
-- Table structure for table tbl_shift

CREATE TABLE tbl_shift (
  id serial PRIMARY KEY,
  start_time varchar(255) NOT NULL,
  end_time varchar(255) NOT NULL,
  status smallint NOT NULL CHECK (status IN (1, 0)),
  created_at timestamp DEFAULT CURRENT_TIMESTAMP
);
-- Dumping data for table tbl_shift

INSERT INTO tbl_shift (start_time, end_time, status, created_at)
VALUES
  ('09:00:00', '18:00:00', 1, '2023-09-29 05:48:50'),
  ('13:00:00', '22:00:00', 1, '2023-09-29 05:49:14');
  
  
  
CREATE TABLE tbl_meeting (
    meet_id SERIAL PRIMARY KEY,
    meet_topic VARCHAR(255),
    time TIME,
    meet_date DATE,
    status INTEGER,
    emp_id INTEGER REFERENCES tbl_employee(id)
);

 ALTER TABLE tbl_meeting
DROP COLUMN time;

ALTER TABLE tbl_meeting
ADD COLUMN start_time TIME,
ADD COLUMN end_time TIME;



--VIEWS

CREATE VIEW employee_attendance_view AS
SELECT
    a.id AS attendance_id,
    a.employee_id,
    a.department,
    a.shift,
    a.location,
    a.message,
    a.date,
    a.check_in,
    a.in_status,
    a.check_out,
    a.out_status,
    e.first_name || ' ' || e.last_name AS employee_name
FROM
    tbl_attendance a
JOIN
    tbl_employee e ON a.employee_id = e.employee_id;

CREATE OR REPLACE VIEW active_meetings AS
SELECT * FROM tbl_meeting WHERE status = 1;

--TRIGGERS

CREATE OR REPLACE FUNCTION public.before_insert_attendance()
 RETURNS trigger
 LANGUAGE plpgsql
AS $function$
BEGIN
    IF EXISTS (SELECT 1 FROM tbl_attendance WHERE employee_id = NEW.employee_id AND date = NEW.date) THEN
        -- Raise an exception if an existing record is found
        RAISE EXCEPTION 'Employee is already checked-in for the day.'
    END IF;

    -- If no existing record, proceed with the original insert
    RETURN NEW;
END;
$function$;

CREATE TRIGGER before_insert_attendance
BEFORE INSERT
ON tbl_attendance
FOR EACH ROW
EXECUTE FUNCTION public.before_insert_attendance();


--USER PRIVILEGES

-- Grant privileges for Admin or '1'
CREATE ROLE "1" LOGIN;

GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE tbl_employee,tbl_shift,tbl_department,tbl_meeting,tbl_location,tbl_attendance TO "1";




-- Grant privileges for Employee or '0'
CREATE ROLE "0" LOGIN;

GRANT UPDATE ON TABLE tbl_employee TO "0";




