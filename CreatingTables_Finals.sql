cd C:\xampp\mysql\bin
./mysql -u root

CREATE DATABASE studentrecord;
USE DATABASES studentrecord;

CREATE TABLE student (
    StudentID MEDIUMINT NOT NULL AUTO_INCREMENT,
    FirstName varchar(50) NOT NULL,
    LastName varchar(50),
    DateOfBirth date,
    Email varchar(50),
    Phone INT(20),
    PRIMARY KEY(StudentID)
);

CREATE TABLE course (
    CourseID MEDIUMINT NOT NULL AUTO_INCREMENT,
    CourseName varchar(100),
    Credits INT(255),
    PRIMARY KEY(CourseID)
);

CREATE TABLE instructor (
    InstructorID MEDIUMINT NOT NULL AUTO_INCREMENT,
    FirstName varchar(50),
    LastName varchar(50),
    Email varchar(50),
    Phone INT(20),
    PRIMARY KEY(InstructorID)
);

CREATE TABLE enrollment (
    EnrollmentID MEDIUMINT NOT NULL AUTO_INCREMENT,
    StudentID MEDIUMINT,
    FOREIGN KEY (StudentID) REFERENCES student(StudentID),
    CourseID MEDIUMINT,
    FOREIGN KEY (CourseID) REFERENCES course(CourseID),
    EnrollmentDate date,
    Grade INT,
    PRIMARY KEY(EnrollmentID)
);



INSERT INTO student VALUES(NULL,'Dexter','Capillan','2000-11-11','dexter@gmail.com',091234567890);
INSERT INTO student VALUES(NULL,'Jay','Jicx','2000-12-12','jay@gmail.com',091234567890);
INSERT INTO student VALUES(NULL,'John','Guzman','2000-10-10','jhon@gmail.com',091234567890);