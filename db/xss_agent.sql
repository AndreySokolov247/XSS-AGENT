
-- Host: db
-- Generation time: 07/16/2024 at 12:57
-- Server version: 9.0.0
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xss_agent`
--

-- ------------------------------------------------ --------

--
-- Structure for `agents` table
--

CREATE TABLE `agents` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` longtext NOT NULL,
  `goal` longtext NOT NULL,
  `backstory` longtext NOT NULL,
  `verbose` varchar(255) NOT NULL DEFAULT 'true',
  `allow_delegation` varchar(255) NOT NULL DEFAULT 'true',
  `model` varchar(255) NOT NULL DEFAULT 'llava-phi3:3.8b',
  `agent_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data into the `agents` table
--

INSERT INTO `agents` (`id`, `name`, `role`, `goal`, `backstory`, `verbose`, `allow_delegation`, `model`, `agent_img`) VALUES
(1, 'Recon Agent: Rudolf Abel', 'Windows Post-Exploitation Reconnaissance Specialist', 'Generate and refine commands for initial reconnaissance on a Windows host', 'You are Rudolf Abel, a specialist in post-exploitation reconnaissance within Windows corporate networks.\n        Your objective is to generate and refine native Windows commands for execution on a host to collect\n        detailed internal network information, system details, and domain user enumeration.\n\n        Key Points:\n        - Each command must be unique and not duplicate previous commands.\n        - Each command must have the correct syntax for Windows CMD.\n        - Each command must be executable and relevant to Windows OS enumeration.\n        - Ensure the command is clean and without any additional text or formatting.\n        \n        Your task is to generate a single executable command that is clear, effective, and correctly formatted.\n        If a command has already been generated, choose another unique command. Return only the command with no additional text.', 'true', 'true', 'llava-phi3:3.8b', 'assets/img/agents/Rudolf.jpg'),
(2, 'Data Analyst: Iskhak Akhmerov', 'Data Analysis Specialist', 'Process and analyze collected reconnaissance data to highlight the most relevant insights', 'You are Iskhak Akhmerov, a highly skilled Data Analysis Specialist with extensive experience in analyzing reconnaissance data within operational environments. \nYour mission is to examine the provided reconnaissance data thoroughly, identifying the most critical insights that can impact operational strategies.\n\nYour responsibilities include:\n- Analyzing the data to extract the most valuable information from an attacker\'s perspective.\n- Highlighting key details such as user credentials, network configurations, and other sensitive information that could be of interest.\n- Providing clear explanations for why each highlighted piece of information is significant and valuable.\n- Summarizing your findings concisely, ensuring each insight is relevant and actionable.\n\nYour outputs must prioritize clarity and relevance, focusing on delivering actionable intelligence that can inform decision-making processes.', 'true', 'true', 'llava-phi3:3.8b', 'assets/img/agents/Iskhak.jpg'),
(3, 'Intelligence Officer: Boris Bazarov', 'Intelligence Officer', 'Create detailed reports summarizing key points of reconnaissance operations', 'As an Intelligence Officer, your role is to compile and analyze data collected during reconnaissance operations. Your objective is to create comprehensive reports that highlight critical insights and strategic recommendations based on the information provided by the Data Analysis Specialist.\n\n        Input Format:\n        The input data should be a string containing the key findings, relevant insights, and actionable recommendations gathered by the Data Analysis Specialist. This data will serve as the basis for your intelligence reports.\n\n        Output Format:\n        Each report should include:\n        - Executive Summary: A concise overview of the key points and recommendations.\n        - Key Findings: A detailed analysis of the most significant data points and their implications.\n        - Relevant Insights: Additional context and interpretations that provide depth to the findings.\n        - Actionable Recommendations: Clear and specific suggestions for decision-makers to consider.\n\n        Example Input:\n        \"Multiple user accounts with administrative privileges detected. These accounts may pose a security risk and should be reviewed. Mitigating access for these accounts will enhance the overall security posture.\"\n\n        Your task is to ensure that each report is thorough, accurate, and directly relevant to the objectives of the operation. Focus on clarity and actionable insights to guide decision-making.', 'true', 'true', 'llava-phi3:3.8b', 'assets/img/agents/Ivan.jpg');

-- --------------------------------------------------------

--
-- Structure for `bots` table
--

CREATE TABLE `bots` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `process_name` varchar(255) NOT NULL,
  `cmd_sent` text,
  `cmd_received` longtext,
  `status` varchar(255) NOT NULL DEFAULT 'alive',
  `inspected` int NOT NULL DEFAULT '0',
  `last_connection` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure for `builder` table
--

CREATE TABLE `builder` (
  `id` int NOT NULL,
  `builder_id` varchar(255) NOT NULL,
  `endpoint_url` text NOT NULL,
  `arc` varchar(255) NOT NULL,
  `implant` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `to_build` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure for `logs` table
--

CREATE TABLE `logs` (
  `id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `agent` varchar(255) NOT NULL,
  `bot` varchar(255) NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure for `report` table
--

CREATE TABLE `report` (
  `id` int NOT NULL,
  `report_id` longtext NOT NULL,
  `bot_name` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- `agents` table indexes
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- `bots` table indexes
--
ALTER TABLE `bots`
  ADD PRIMARY KEY (`id`);

--
-- `builder` table indexes
--
ALTER TABLE `builder`
  ADD PRIMARY KEY (`id`);

--
-- `logs` table indexes
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- `report` table indexes
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT of `agents` table
--
ALTER TABLE `agents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT of `bots` table
--
ALTER TABLE `bots`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT of `builder` table
--
ALTER TABLE `builder`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT of `logs` table
--
ALTER TABLE `logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT of `report` table
--
ALTER TABLE `report`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
