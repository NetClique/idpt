-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 07, 2015 at 03:17 PM
-- Server version: 5.5.43
-- PHP Version: 5.3.10-1ubuntu3.19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS `convo_tbl` (
  `convo_id` bigint(11) NOT NULL AUTO_INCREMENT,
  `src_ip` varchar(50) NOT NULL,
  `dst_ip` varchar(50) NOT NULL,
  `duration` double NOT NULL,
  `total_payload` bigint(20) NOT NULL,
  `payload_sent` bigint(20) NOT NULL,
  `payload_recvd` bigint(20) NOT NULL,
  `total_packets` int(11) NOT NULL,
  `packets_sent` int(11) NOT NULL,
  `packets_recvd` int(11) NOT NULL,
  `compression_ratio` double NOT NULL,
  `primewave_payload` double NOT NULL,
  `ft_payload_1` double NOT NULL,
  `ft_payload_2` double NOT NULL,
  `ft_payload_3` double NOT NULL,
  `primewave_iat` double NOT NULL,
  `ft_iat_1` double NOT NULL,
  `ft_iat_2` double NOT NULL,
  `ft_iat_3` double NOT NULL,
  `class` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`convo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `flow_ensem`
--

CREATE TABLE IF NOT EXISTS `flow_ensem` (
  `flow_id` int(11) NOT NULL AUTO_INCREMENT,
  `src_ip` varchar(50) NOT NULL,
  `src_port` int(11) NOT NULL,
  `dst_ip` varchar(50) NOT NULL,
  `dst_port` int(11) NOT NULL,
  `proto` int(11) NOT NULL,
  `src_pkt_cnt` int(11) NOT NULL,
  `dst_pkt_cnt` int(11) NOT NULL,
  `src_pktlen_entro` double NOT NULL,
  `dst_pktlen_entro` double NOT NULL,
  `src_flow_duration` double NOT NULL,
  `dst_flow_duration` double NOT NULL,
  `src_total_bytes` int(11) NOT NULL,
  `dst_total_bytes` int(11) NOT NULL,
  `src_min_pkt_size` int(11) NOT NULL,
  `dst_min_pkt_size` int(11) NOT NULL,
  `src_max_pkt_size` int(11) NOT NULL,
  `dst_max_pkt_size` int(11) NOT NULL,
  `src_avg_pkt_size` int(11) NOT NULL,
  `dst_avg_pkt_size` int(11) NOT NULL,
  `class` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`flow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `flow_tbl`
--

CREATE TABLE IF NOT EXISTS `flow_tbl` (
  `flow_id` int(11) NOT NULL AUTO_INCREMENT,
  `src_ip` varchar(50) NOT NULL,
  `src_port` int(11) NOT NULL,
  `dst_ip` varchar(50) NOT NULL,
  `dst_port` int(11) NOT NULL,
  `proto` int(11) NOT NULL,
  `src_pkt_cnt` int(11) NOT NULL,
  `dst_pkt_cnt` int(11) NOT NULL,
  `src_pktlen_entro` double NOT NULL,
  `dst_pktlen_entro` double NOT NULL,
  `src_flow_duration` double NOT NULL,
  `dst_flow_duration` double NOT NULL,
  `src_total_bytes` int(11) NOT NULL,
  `dst_total_bytes` int(11) NOT NULL,
  `src_min_pkt_size` int(11) NOT NULL,
  `dst_min_pkt_size` int(11) NOT NULL,
  `src_max_pkt_size` int(11) NOT NULL,
  `dst_max_pkt_size` int(11) NOT NULL,
  `src_avg_pkt_size` int(11) NOT NULL,
  `dst_avg_pkt_size` int(11) NOT NULL,
  `class` varchar(10) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`flow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
