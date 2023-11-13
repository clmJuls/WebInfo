CREATE DATABASE StudentRecord;

USE StudentRecord;

CREATE TABLE Student (
    StudentID int PRIMARY KEY,
    FirstName varchar(50),
    LastName varchar(50),
    DateOfBirth date,
    Email varchar(100),
    Phone int(11)
);


CREATE TABLE Course (
    CourseID int PRIMARY KEY,
    CourseName varchar(50),
    Credits int
);

CREATE TABLE Instructor (
    InstructorID int PRIMARY KEY,
    FirstName varchar(50),
    LastName varchar(50),
    Email varchar(100),
    Phone int
);

CREATE TABLE Enrollment (
    EnrollmentID int PRIMARY KEY,
    StudentID int,
    CourseID int,
    EnrollmentDate date,
    Grade varchar(2),
    FOREIGN KEY (StudentID) REFERENCES Student (StundetID),
    FOREIGN KEY (CourseID) REFERENCES Course (CourseID)
);
