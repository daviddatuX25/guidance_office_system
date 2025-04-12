INSERT INTO strands (name) VALUES
('ABM'),
('STEM'),
('HUMSS'),
('GAS'),
('TVL-ICT'),
('TVL-HE'),
('TVL-AFA'),
('TVL-IA'),
('Arts and Design'),
('Sports'),
('Old Curriculum'),
('Others'),
('Transferee');

-- Populate the courses table
INSERT INTO courses (name, nickname) VALUES
('Bachelor of Arts in Psychology', 'BAP'),
('Bachelor of Science in Mathematics', 'BSM'),
('Bachelor of Arts in English Language', 'BAEL'),
('Bachelor of Arts in Social Sciences', 'BASS'),
('Bachelor of Public Administration', 'BPA'),
('Bachelor of Science in Information and Technology', 'BSIT'),
('Bachelor of Science in Entrepreneurship', 'BSE'),
('Bachelor of Science in Business Administration - Human Resources Management', 'BSBA-HR'),
('Bachelor of Science in Business Administration - Marketing Management', 'BSBA-MM'),
('Bachelor of Science in Business Administration - Financial Management', 'BSBA-FM'),
('Bachelor of Elementary Education', 'BEE'),
('Bachelor of Physical Education', 'BPE'),
('Bachelor of Secondary Education - Science', 'BSED-Sci'),
('Bachelor of Secondary Education - English', 'BSED-Eng'),
('Bachelor of Secondary Education - Mathematics', 'BSED-Math'),
('Bachelor of Secondary Education - Filipino', 'BSED-Fil'),
('Bachelor of Secondary Education - Social Studies', 'BSED-SS');

-- Populate the application_term table
INSERT INTO application_term (academic_year, semester) VALUES
('2024-2025', '1st semester'),
('2024-2025', '2nd semester');

-- Populate the applicants table
INSERT INTO applicants (applicant_no, application_term_id, lastname, firstname, middlename, suffix, sex, strand_id, course_1_id, course_2_id, course_3_id) VALUES
('0001', 1, 'Santos', 'Juan', 'Reyes', NULL, 'Male', 1, 8, 9, NULL),
('0002', 1, 'Cruz', 'Maria', 'Lopez', NULL, 'Female', 2, 2, 6, 13),
('0003', 1, 'Reyes', 'Pedro', 'Gomez', 'Jr', 'Male', 5, 6, 2, NULL),
('0004', 1, 'Garcia', 'Anna', 'Mendoza', NULL, 'Female', 6, 11, 14, NULL),
('0005', 2, 'Lim', 'Jose', 'Tan', NULL, 'Male', 3, 1, 4, NULL),
('0006', 2, 'Dela Cruz', 'Sofia', 'Villanueva', NULL, 'Female', 9, 3, 14, NULL),
('0007', 2, 'Fernandez', 'Mark', 'Santiago', NULL, 'Male', 7, 7, 8, NULL),
('0008', 2, 'Aquino', 'Clara', 'Perez', NULL, 'Female', 4, 5, 11, 1),
('0009', 1, 'Tan', 'Liza', 'Cruz', NULL, 'Female', 11, 11, 14, NULL),
('0010', 1, 'Gomez', 'Raul', 'Santos', NULL, 'Male', 12, 7, 8, 10),
('0011', 2, 'Perez', 'Mika', 'Reyes', NULL, 'Female', 13, 1, 4, 5);

-- Populate the test_results table
INSERT INTO test_results (applicant_id, general_ability, verbal_aptitude, numerical_aptitude, spatial_aptitude, perceptual_aptitude, manual_dexterity, date_taken) VALUES
(1, 85, 90, 80, 75, 70, 65, '2024-08-15'),
(2, 92, 88, 95, 90, 85, 80, '2024-08-16'),
(3, 78, 82, 75, 80, 85, 90, '2024-08-16'),
(4, 80, 85, 70, 65, 75, 88, '2024-08-17'),
(5, 88, 90, 85, 80, 78, 70, '2025-01-10'),
(6, 90, 92, 80, 85, 88, 82, '2025-01-11'),
(7, 75, 78, 82, 80, 85, 90, '2025-01-11'),
(8, 82, 85, 88, 78, 80, 75, '2025-01-12'),
(9, 79, 83, 77, 70, 82, 85, '2024-08-18'),
(10, 81, 80, 84, 78, 76, 88, '2024-08-18'),
(11, 87, 89, 82, 84, 80, 79, '2025-01-13');