-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2018 at 01:30 AM
-- Server version: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `odetta`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `messId` varchar(10) NOT NULL,
  `message` varchar(500) NOT NULL,
  `sender` varchar(10) NOT NULL,
  `timeSent` datetime NOT NULL,
  `nextMess` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`messId`, `message`, `sender`, `timeSent`, `nextMess`) VALUES
('01flr603', 'Hello', 'Srkcg2', '2017-04-11 16:35:27', 'kc7vbxj4');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `school_id` char(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`school_id`, `name`) VALUES
('y2sxk', 'Boston College');

-- --------------------------------------------------------

--
-- Table structure for table `sentinels`
--

CREATE TABLE `sentinels` (
  `node` varchar(10) NOT NULL,
  `profId` varchar(10) NOT NULL,
  `name` varchar(40) NOT NULL,
  `timeBuilt` datetime NOT NULL,
  `open` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `nextMess` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sentinels`
--

INSERT INTO `sentinels` (`node`, `profId`, `name`, `timeBuilt`, `open`, `deleted`, `nextMess`) VALUES
('00qk8', 'gd8tj', '', '2016-10-26 22:30:18', 0, 0, 'hx1nz');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `ip`) VALUES
('Sk646v', 'Thomas', '::1'),

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(10) NOT NULL,
  `fname` varchar(35) NOT NULL,
  `lname` varchar(35) NOT NULL,
  `school_id` char(10) NOT NULL,
  `dept` varchar(50) NOT NULL,
  `lastSeen` datetime NOT NULL,
  `inChat` tinyint(1) NOT NULL,
  `avail` tinyint(1) NOT NULL,
  `register` datetime NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `cookieKey` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `school_id`, `dept`, `lastSeen`, `inChat`, `avail`, `register`, `email`, `password`, `cookieKey`) VALUES
('9lj4', 'Thomas', 'Jones', 'y2sxk', 'History', '0000-00-00 00:00:00', 0, 0, '2017-01-09 13:39:38', 'tom@jones.org', '$2y$10$wSyNqbiOHh6dT0TAAT/jEe6REAYzQ.hyNT4UdeIJFNxHojP3g9zb2', 'uasjb');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`messId`),
  ADD UNIQUE KEY `messKey` (`messId`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `sentinels`
--
ALTER TABLE `sentinels`
  ADD PRIMARY KEY (`node`),
  ADD UNIQUE KEY `node` (`node`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`);
