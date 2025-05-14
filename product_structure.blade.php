Project Database structure



-- SCHOOL CORE
CREATE TABLE schools (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  address TEXT,
  phone VARCHAR(20),
  email VARCHAR(255) UNIQUE,
  logo VARCHAR(255),
  session_year VARCHAR(20),
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- USERS
CREATE TABLE users (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  email_verified_at TIMESTAMP NULL,
  password VARCHAR(255) NOT NULL,
  phone VARCHAR(20),
  address TEXT,
  gender ENUM('male','female','other'),
  dob DATE,
  remember_token VARCHAR(100),
  role ENUM('admin','teacher','parent','student','accountant','librarian') NOT NULL,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id)
);

-- ACADEMIC STRUCTURE
CREATE TABLE classes (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  name VARCHAR(50) NOT NULL,
  numeric_value INT,
  teacher_id BIGINT,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id),
  FOREIGN KEY (teacher_id) REFERENCES users(id)
);

CREATE TABLE sections (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  class_id BIGINT NOT NULL,
  name VARCHAR(10) NOT NULL,
  capacity INT,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id),
  FOREIGN KEY (class_id) REFERENCES classes(id),
  UNIQUE KEY (class_id, name)
);

CREATE TABLE subjects (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  name VARCHAR(100) NOT NULL,
  code VARCHAR(20),
  class_id BIGINT,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id),
  FOREIGN KEY (class_id) REFERENCES classes(id)
);

-- PEOPLE MANAGEMENT
CREATE TABLE teacher_profiles (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  teacher_id BIGINT NOT NULL,
  school_id BIGINT NOT NULL,
  employee_id VARCHAR(50) UNIQUE,
  qualification TEXT,
  specialization VARCHAR(100),
  experience_years INT,
  joining_date DATE,
  salary_grade VARCHAR(20),
  base_salary DECIMAL(12,2) NOT NULL,
  current_salary DECIMAL(12,2) NOT NULL,
  last_increment_date DATE NUL,
  bank_details JSON,
  emergency_contact JSON,
  documents JSON,
  signature VARCHAR(255),
  bio TEXT,
  social_links JSON,
  is_class_teacher BOOLEAN DEFAULT false,
  class_teacher_of BIGINT,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (teacher_id) REFERENCES users(id),
  FOREIGN KEY (school_id) REFERENCES schools(id),
  FOREIGN KEY (class_teacher_of) REFERENCES classes(id)
);

CREATE TABLE student_profiles (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  student_id BIGINT NOT NULL,
  school_id BIGINT NOT NULL,
  admission_no VARCHAR(50) UNIQUE,
  admission_date DATE,
  class_id BIGINT,
  section_id BIGINT,
  previous_school TEXT,
  medical_history JSON,
  transport_details JSON,
  hobbies JSON,
  awards JSON,
  documents JSON,
  student_photo VARCHAR(255),
  id_card_issued BOOLEAN DEFAULT false,
  id_card_number VARCHAR(20),
  blood_group VARCHAR(5),
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (student_id) REFERENCES users(id),
  FOREIGN KEY (school_id) REFERENCES schools(id),
  FOREIGN KEY (class_id) REFERENCES classes(id),
  FOREIGN KEY (section_id) REFERENCES sections(id)
);

CREATE TABLE parent_profiles (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  parent_id BIGINT NOT NULL,
  school_id BIGINT NOT NULL,
  occupation VARCHAR(100),
  employer VARCHAR(100),
  income_range VARCHAR(50),
  education_level VARCHAR(100),
  relation_type ENUM('father','mother','guardian'),
  is_primary BOOLEAN DEFAULT false,
  address_proof VARCHAR(255),
  id_proof VARCHAR(255),
  emergency_contact BOOLEAN DEFAULT false,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (parent_id) REFERENCES users(id),
  FOREIGN KEY (school_id) REFERENCES schools(id)
);

-- STUDENT-PARENT RELATIONSHIPS
CREATE TABLE student_parents (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  student_id BIGINT NOT NULL,
  parent_id BIGINT NOT NULL,
  relationship ENUM('father','mother','guardian') NOT NULL,
  is_primary BOOLEAN DEFAULT false,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at TIMESTAMP NULL,
  FOREIGN KEY (student_id) REFERENCES users(id),
  FOREIGN KEY (parent_id) REFERENCES users(id),
  UNIQUE KEY (student_id, parent_id)
);

-- TEACHER-SUBJECT ASSIGNMENT
CREATE TABLE teacher_subjects (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  teacher_id BIGINT NOT NULL,
  subject_id BIGINT NOT NULL,
  class_id BIGINT,
  is_class_teacher BOOLEAN DEFAULT false,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (teacher_id) REFERENCES users(id),
  FOREIGN KEY (subject_id) REFERENCES subjects(id),
  FOREIGN KEY (class_id) REFERENCES classes(id),
  UNIQUE KEY (teacher_id, subject_id, class_id)
);

-- ATTENDANCE
CREATE TABLE attendances (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  student_id BIGINT NOT NULL,
  date DATE NOT NULL,
  status ENUM('present','absent','late','half_day') NOT NULL,
  remarks TEXT,
  recorded_by BIGINT,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id),
  FOREIGN KEY (student_id) REFERENCES users(id),
  FOREIGN KEY (recorded_by) REFERENCES users(id),
  UNIQUE KEY (student_id, date)
);

-- FEES MANAGEMENT
CREATE TABLE fee_categories (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id)
);

CREATE TABLE fee_structures (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  category_id BIGINT NOT NULL,
  class_id BIGINT,
  name VARCHAR(100) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  frequency ENUM('one_time','monthly','quarterly','yearly'),
  due_date DATE,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id),
  FOREIGN KEY (category_id) REFERENCES fee_categories(id),
  FOREIGN KEY (class_id) REFERENCES classes(id)
);

CREATE TABLE fees (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  student_id BIGINT NOT NULL,
  structure_id BIGINT NOT NULL,
  invoice_number VARCHAR(50) UNIQUE,
  amount DECIMAL(10,2) NOT NULL,
  discount DECIMAL(10,2) DEFAULT 0,
  due_date DATE NOT NULL,
  status ENUM('pending','paid','partial','cancelled') DEFAULT 'pending',
  payment_date DATE,
  payment_method ENUM('cash','cheque','card','bank_transfer','online'),
  transaction_reference VARCHAR(100),
  notes TEXT,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id),
  FOREIGN KEY (student_id) REFERENCES users(id),
  FOREIGN KEY (structure_id) REFERENCES fee_structures(id)
);

CREATE TABLE fee_payments (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  fee_id BIGINT NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  payment_date DATE NOT NULL,
  payment_method ENUM('cash','cheque','card','bank_transfer','online'),
  transaction_reference VARCHAR(100),
  received_by BIGINT,
  notes TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (fee_id) REFERENCES fees(id),
  FOREIGN KEY (received_by) REFERENCES users(id)
);

-- EXAM MANAGEMENT
CREATE TABLE exams (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  start_date DATE,
  end_date DATE,
  is_published BOOLEAN DEFAULT false,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id)
);

CREATE TABLE exam_schedules (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  exam_id BIGINT NOT NULL,
  subject_id BIGINT NOT NULL,
  class_id BIGINT NOT NULL,
  exam_date DATE NOT NULL,
  start_time TIME,
  end_time TIME,
  room_number VARCHAR(20),
  max_marks INT,
  passing_marks INT,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (exam_id) REFERENCES exams(id),
  FOREIGN KEY (subject_id) REFERENCES subjects(id),
  FOREIGN KEY (class_id) REFERENCES classes(id)
);

CREATE TABLE exam_results (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  exam_id BIGINT NOT NULL,
  student_id BIGINT NOT NULL,
  subject_id BIGINT NOT NULL,
  marks_obtained DECIMAL(5,2),
  grade VARCHAR(5),
  remarks TEXT,
  published_at TIMESTAMP NULL,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id),
  FOREIGN KEY (exam_id) REFERENCES exams(id),
  FOREIGN KEY (student_id) REFERENCES users(id),
  FOREIGN KEY (subject_id) REFERENCES subjects(id),
  UNIQUE KEY (exam_id, student_id, subject_id)
);

-- LIBRARY MANAGEMENT
CREATE TABLE books (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(100),
  isbn VARCHAR(20),
  publisher VARCHAR(100),
  edition VARCHAR(20),
  category VARCHAR(50),
  price DECIMAL(10,2),
  quantity INT NOT NULL,
  available INT NOT NULL,
  shelf_number VARCHAR(20),
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id)
);

CREATE TABLE book_issues (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  book_id BIGINT NOT NULL,
  user_id BIGINT NOT NULL,
  issue_date DATE NOT NULL,
  return_date DATE,
  due_date DATE NOT NULL,
  status ENUM('issued','returned','lost','damaged') DEFAULT 'issued',
  fine_amount DECIMAL(10,2) DEFAULT 0,
  notes TEXT,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id),
  FOREIGN KEY (book_id) REFERENCES books(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- INVENTORY MANAGEMENT
CREATE TABLE inventory_items (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  name VARCHAR(100) NOT NULL,
  category VARCHAR(50),
  quantity INT NOT NULL,
  min_quantity INT,
  unit VARCHAR(20),
  location VARCHAR(100),
  description TEXT,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id)
);

CREATE TABLE inventory_transactions (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  item_id BIGINT NOT NULL,
  user_id BIGINT,
  quantity INT NOT NULL,
  transaction_type ENUM('purchase','issue','return','adjustment','damage'),
  reference_number VARCHAR(50),
  notes TEXT,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id),
  FOREIGN KEY (item_id) REFERENCES inventory_items(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- NOTICEBOARD
CREATE TABLE notices (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  target_roles JSON,
  target_classes JSON,
  start_date DATE,
  end_date DATE,
  is_published BOOLEAN DEFAULT false,
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id)
);

-- HOLIDAYS
CREATE TABLE holidays (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  title VARCHAR(100) NOT NULL,
  description TEXT,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  is_recurring BOOLEAN DEFAULT false,
  recurring_pattern ENUM('yearly','monthly','weekly'),
  deleted_at TIMESTAMP NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id)
);

-- AUDIT SYSTEM
CREATE TABLE audit_logs (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  user_id BIGINT NOT NULL,
  action VARCHAR(50) NOT NULL,
  table_affected VARCHAR(50) NOT NULL,
  record_id BIGINT NOT NULL,
  old_values JSON,
  new_values JSON,
  ip_address VARCHAR(45),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- SYSTEM SETTINGS
CREATE TABLE system_settings (
  id BIGINT PRIMARY KEY AUTO_INCREMENT,
  school_id BIGINT NOT NULL,
  setting_key VARCHAR(100) NOT NULL,
  setting_value TEXT,
  is_encrypted BOOLEAN DEFAULT false,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (school_id) REFERENCES schools(id),
  UNIQUE KEY (school_id, setting_key)
);

-- Create salary payments table (similar to fee_payments)
CREATE TABLE salary_payments (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    teacher_id BIGINT UNSIGNED NOT NULL,
    school_id BIGINT UNSIGNED NOT NULL,
    payment_date DATE NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    bonus DECIMAL(12,2) DEFAULT 0.00,
    deductions DECIMAL(12,2) DEFAULT 0.00,
    tax_amount DECIMAL(12,2) DEFAULT 0.00,
    payment_method VARCHAR(20),
    transaction_reference VARCHAR(100),
    status VARCHAR(20) DEFAULT 'pending',
    notes TEXT,
    recorded_by BIGINT UNSIGNED NULL,
    deleted_at TIMESTAMP NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT fk_salary_teacher FOREIGN KEY (teacher_id) 
        REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_salary_school FOREIGN KEY (school_id) 
        REFERENCES schools(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_salary_recorded_by FOREIGN KEY (recorded_by) 
        REFERENCES users(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

Here's the concise format for all tables as requested:

1. schools  => `id | name | address | phone | email | logo | session_year | deleted_at | created_at | updated_at`
2. users  => `id | school_id | name | email | email_verified_at | password | phone | address | gender | dob | remember_token | role | deleted_at | created_at | updated_at`
3. classes  => `id | school_id | name | numeric_value | teacher_id | deleted_at | created_at | updated_at`
4. sections  => `id | school_id | class_id | name | capacity | deleted_at | created_at | updated_at`
5. subjects  => `id | school_id | name | code | class_id | deleted_at | created_at | updated_at`
6. teacher_profiles  => `id | teacher_id | school_id | employee_id | qualification | specialization | experience_years | joining_date | salary_grade |base_salary | current_salary | last_increment_date | bank_details | emergency_contact | documents | signature | bio | social_links | is_class_teacher | class_teacher_of | deleted_at | created_at | updated_at`
7. student_profiles  => `id | student_id | school_id | admission_no | admission_date | class_id | section_id | previous_school | medical_history | transport_details | hobbies | awards | documents | student_photo | id_card_issued | id_card_number | blood_group | deleted_at | created_at | updated_at`
8. parent_profiles  => `id | parent_id | school_id | occupation | employer | income_range | education_level | relation_type | is_primary | address_proof | id_proof | emergency_contact | deleted_at | created_at | updated_at`
9. student_parents  => `id | student_id | parent_id | relationship | is_primary | created_at | updated_at | deleted_at`
10. teacher_subjects  => `id | teacher_id | subject_id | class_id | is_class_teacher | created_at | updated_at`
11. time_tables  => `id | school_id | class_id | section_id | subject_id | teacher_id | day_of_week | start_time | end_time | room_number | is_recurring | effective_from | effective_to | deleted_at | created_at | updated_at`
12. attendance_sessions  => `id | school_id | time_table_id | date | recorded_by | notes | created_at | updated_at`
13. attendances  => `id | session_id | user_id | status | remarks | deleted_at | created_at | updated_at`
14. fee_categories  => `id | school_id | name | description | deleted_at | created_at | updated_at`
15. fee_structures  => `id | school_id | category_id | class_id | name | amount | frequency | due_date | deleted_at | created_at | updated_at`
16. fees  => `id | school_id | student_id | structure_id | invoice_number | amount | discount | due_date | status | payment_date | payment_method | transaction_reference | notes | deleted_at | created_at | updated_at`
17. fee_payments  => `id | fee_id | amount | payment_date | payment_method | transaction_reference | received_by | notes | created_at | updated_at`
18. exams  => `id | school_id | name | description | start_date | end_date | is_published | deleted_at | created_at | updated_at`
19. exam_schedules  => `id | exam_id | subject_id | class_id | exam_date | start_time | end_time | room_number | max_marks | passing_marks | deleted_at | created_at | updated_at`
20. exam_results  => `id | school_id | exam_id | student_id | subject_id | marks_obtained | grade | remarks | published_at | deleted_at | created_at | updated_at`
21. books  => `id | school_id | title | author | isbn | publisher | edition | category | price | quantity | available | shelf_number | deleted_at | created_at | updated_at`
22. book_issues  => `id | school_id | book_id | user_id | issue_date | return_date | due_date | status | fine_amount | notes | deleted_at | created_at | updated_at`
23. inventory_items  => `id | school_id | name | category | quantity | min_quantity | unit | location | description | deleted_at | created_at | updated_at`
24. inventory_transactions  => `id | school_id | item_id | user_id | quantity | transaction_type | reference_number | notes | deleted_at | created_at | updated_at`
25. notices  => `id | school_id | title | content | target_roles | target_classes | start_date | end_date | is_published | deleted_at | created_at | updated_at`
26. holidays  => `id | school_id | title | description | start_date | end_date | is_recurring | recurring_pattern | deleted_at | created_at | updated_at`
27. audit_logs  => `id | user_id | action | table_affected | record_id | old_values | new_values | ip_address | created_at`
28. system_settings  => `id | school_id | setting_key | setting_value | is_encrypted | created_at | updated_at`
29. salary_payments => id | teacher_id | school_id | payment_date | amount | bonus | deductions | tax_amount | payment_method | transaction_reference | status | notes | recorded_by | deleted_at | created_at | updated_at | PRIMARY |

Here's the concise relationship summary for all existing models:

1. **School**:
   - users() → hasMany(User::class)
   - classes() → hasMany(Classes::class)
   - notices() → hasMany(Notice::class)
   =>2. **User**:
   - school() → belongsTo(School::class)
   - teacherProfile() → hasOne(TeacherProfile::class)
   - studentProfile() → hasOne(StudentProfile::class)
   - parents() → belongsToMany(User::class, 'student_parents', 'student_id', 'parent_id')->withPivot('relationship', 'is_primary')
   - children() → belongsToMany(User::class, 'student_parents', 'parent_id', 'student_id')->withPivot('relationship', 'is_primary')->withTimestamps();
   - studentParentRelationships() → hasMany(StudentParent::class, 'parent_id');
   - childParentRelationships() → hasMany(StudentParent::class, 'student_id');
   =>3. **Classes**:
   - school() → belongsTo(School::class)
   - classTeacher() → belongsTo(User::class)
   - sections() → hasMany(Section::class)
   - class() → $this->belongsToMany(Subject::class, 'subject_classes');
   =>4. **Section**:
   - school() → belongsTo(School::class)
   - class() → belongsTo(Classes::class)
   - students() → hasMany(StudentProfile::class)
   =>5. **Subject**:
   - school() → belongsTo(School::class)
   - class() → belongsTo(Classes::class)
   - teachers() → belongsToMany(User::class, 'teacher_subjects', 'subject_id', 'teacher_id')->withPivot('class_id', 'is_class_teacher')
   - classes() return $this->belongsToMany(Classes::class, 'subject_classes');
   - teacherSubjects() return $this->hasMany(TeacherSubject::class);

   =>6. **TeacherProfile**:
   - teacher() → belongsTo(User::class)
   - school() → belongsTo(School::class)
   - classTeacherOf() → belongsTo(Classes::class)
   =>7. **StudentProfile**:
   - student() → belongsTo(User::class)
   - school() → belongsTo(School::class)
   - class() → belongsTo(Classes::class)
   - section() → belongsTo(Section::class)
   - parents() → belongsToMany(User::class)
   - parentRelationships() → hasMany(StudentParent::class, 'student_id', 'student_id')
   =>8. **ParentProfile**:
   - parent() → belongsTo(User::class)
   - school() → belongsTo(School::class)
   - children() → belongsToMany(User::class)
   - studentRelationships() → hasMany(StudentParent::class, 'parent_id', 'parent_id')
   =>9. **TimeTable**:
   - school() → belongsTo(School::class)
   - class() → belongsTo(Classes::class)
   - section() → belongsTo(Section::class)
   - subject() → belongsTo(Subject::class)
   - teacher() → belongsTo(User::class)
   - attendanceSessions() → hasMany(AttendanceSession::class)
   =>10. **AttendanceSession**:
    - school() → belongsTo(School::class)
    - timeTable() → belongsTo(TimeTable::class)
    - recordedBy() → belongsTo(User::class)
    - attendances() → hasMany(Attendance::class)
    =>11. **Attendance**:
    - session() → belongsTo(AttendanceSession::class)
    - student() → belongsTo(User::class)
    =>12. **FeeCategory**:
    - school() → belongsTo(School::class)
    - structures() → hasMany(FeeStructure::class)
    =>13. **FeeStructure**:
    - school() → belongsTo(School::class)
    - category() → belongsTo(FeeCategory::class)
    - class() → belongsTo(Classes::class)
    - fees() → hasMany(Fee::class)
    =>14. **Fee**:
    - school() → belongsTo(School::class)
    - student() → belongsTo(User::class)
    - structure() → belongsTo(FeeStructure::class)
    - payments() → hasMany(FeePayment::class)
    =>15. **FeePayment**:
    - fee() → belongsTo(Fee::class)
    - receivedBy() → belongsTo(User::class)
    =>16. **Exam**:
    - school() → belongsTo(School::class)
    - schedules() → hasMany(ExamSchedule::class)
    - results() → hasMany(ExamResult::class)
    =>17. **ExamSchedule**:
    - exam() → belongsTo(Exam::class)
    - subject() → belongsTo(Subject::class)
    - class() → belongsTo(Classes::class)
    =>18. **ExamResult**:
    - school() → belongsTo(School::class)
    - exam() → belongsTo(Exam::class)
    - student() → belongsTo(User::class)
    - subject() → belongsTo(Subject::class)
    =>19. **Book**:
    - school() → belongsTo(School::class)
    - issues() → hasMany(BookIssue::class)
    =>20. **BookIssue**:
    - school() → belongsTo(School::class)
    - book() → belongsTo(Book::class)
    - user() → belongsTo(User::class)
    =>21. **InventoryItem**:
    - school() → belongsTo(School::class)
    - transactions() → hasMany(InventoryTransaction::class)
    =>22. **InventoryTransaction**:
    - school() → belongsTo(School::class)
    - item() → belongsTo(InventoryItem::class)
    - user() → belongsTo(User::class)
    =>23. **Notice**:
    - school() → belongsTo(School::class)
    =>24. **Holiday**:
    - school() → belongsTo(School::class)
    =>25. **AuditLog**:
    - user() → belongsTo(User::class)
    =>26. **SystemSetting**:
    - school() → belongsTo(School::class)
    =>
    =>27 ,**Salary Payment** 
  school() => $this->belongsTo(School::class) 
  teacher() => $this->belongsTo(User::class, 'teacher_id') 
  recordedBy() => $this->belongsTo(User::class, 'recorded_by') 
  getNetSalaryAttribute() => $this->amount + $this->bonus - $this->deductions - $this->tax_amount 
  scopeForMonth($query, $monthYear) => $query->where('month_year', $monthYear) 
  scopeForTeacher($query, $teacherId) => $query->where('teacher_id', $teacherId) 

=>// For parents
public function children()
{
    return $this->belongsToMany(User::class, 'student_parents', 'parent_id', 'student_id')->withPivot('relationship', 'is_primary')->withTimestamps();
}
=>public function studentParentRelationships()
{
    return $this->hasMany(StudentParent::class, 'parent_id');
}
=>public function childParentRelationships()
{
    return $this->hasMany(StudentParent::class, 'student_id');
}

TeacherSubject => 
  subject()return $this->belongsTo(Subject::class);
  class()return $this->belongsTo(Classes::class);


=>Application Core Modules
Super Admin Panel >
🏠 Dashboard
🏫 Schools Management
  ├─ Create New School
  ├─ All Schools List
  └─ School Activation
👥 User Management
⚙️ System Configuration
📊 Master Reports

School Admin Panel >
🏠 Dashboard
🏫 School Profile
📚 Academic Setup
  ├─ Classes
  ├─ Sections
  └─ Subjects
👥 People Management
  ├─ Teachers
  ├─ Students
  └─ Parents
📅 Attendance
💰 Fees Management
  ├─ Categories
  ├─ Structures
  └─ Payments
📝 Exams
  ├─ Schedule
  └─ Results
📚 Library
  ├─ Books
  └─ Issues
📦 Inventory
📢 Notices
🎉 Holidays
📊 Reports
⚙️ Settings

Teacher Panel >
🏠 Dashboard
👨🏫 My Profile
👥 My Students
📅 Mark Attendance
📝 Exams
  ├─ Create Tests
  └─ Enter Marks
📚 Subjects
📊 My Reports

Parent Panel >
🏠 Dashboard
🧒 My Children
  ├─ Profile
  ├─ Attendance
  └─ Results
💰 Fee Payments
📚 Library Books
📢 Notices

Student Panel >
🏠 Dashboard
📚 My Profile
📅 My Attendance
📝 My Results
💰 Fee Status
📚 Book Issues

Common Features >
🔔 Notifications
📝 Quick Actions
🔍 Search
⚙️ My Account
🚪 Logout


file/directory structure

📁 app/
├── Console/
│   └── Commands/
│       ├── CreateTenantDatabase.php
│       └── InstallSchoolData.php
│
├── Events/
│   ├── TenantCreated.php
│   ├── StudentRegistered.php
│   ├── FeePaymentReceived.php
│   ├── AttendanceMarked.php
│   ├── ExamScheduled.php
│   ├── BookIssued.php
│   └── InventoryLowStock.php
│
├── Exceptions/
│   ├── TenantNotActiveException.php
│   ├── SchoolNotFoundException.php
│   └── ExamConflictException.php
│
├── Helpers/
│   ├── TenantHelper.php
│   ├── SchoolHelper.php
│   ├── FeeCalculator.php
│   ├── AttendanceHelper.php
│   ├── ExamHelper.php
│   └── InventoryHelper.php
│
├── Http/
│   ├── Controllers/
│   │   ├── Tenant/
│   │   │   ├── DashboardController.php
│   │   │   ├── SchoolController.php
│   │   │   ├── ProfileController.php
│   │   │   └── SettingsController.php
│   │   │
│   │   ├── Admin/
│   │   │   ├── StudentController.php
│   │   │   ├── TeacherController.php
│   │   │   ├── ParentController.php
│   │   │   ├── ClassController.php
│   │   │   ├── SectionController.php
│   │   │   ├── SubjectController.php
│   │   │   ├── AttendanceController.php
│   │   │   ├── ExamController.php
│   │   │   ├── FeeController.php
│   │   │   ├── LibraryController.php
│   │   │   ├── InventoryController.php
│   │   │   └── ReportController.php
│   │   │
│   │   ├── Teacher/
│   │   │   ├── DashboardController.php
│   │   │   ├── AttendanceController.php
│   │   │   ├── ExamController.php
│   │   │   └── StudentController.php
│   │   │
│   │   ├── Parent/
│   │   │   ├── DashboardController.php
│   │   │   ├── StudentController.php
│   │   │   └── FeeController.php
│   │   │
│   │   ├── Auth/
│   │   │   ├── LoginController.php
│   │   │   ├── RegisterController.php
│   │   │   └── ForgotPasswordController.php
│   │   │
│   │   ├── Api/
│   │   │   ├── V1/
│   │   │   │   ├── StudentApiController.php
│   │   │   │   ├── AttendanceApiController.php
│   │   │   │   ├── FeeApiController.php
│   │   │   │   ├── ExamApiController.php
│   │   │   │   └── LibraryApiController.php
│   │   │
│   │   └── BackendController.php -> Super Admin access
│   │
│   ├── Middleware/
│   │   ├── TenantActive.php
│   │   ├── SchoolSelected.php
│   │   └── RoleMiddleware.php
│   │
│   ├── Requests/
│   │   ├── Tenant/
│   │   │   ├── CreateSchoolRequest.php
│   │   │   └── UpdateSchoolRequest.php
│   │   │
│   │   ├── Admin/
│   │   │   ├── Student/
│   │   │   │   ├── StoreStudentRequest.php
│   │   │   │   └── UpdateStudentRequest.php
│   │   │   ├── Teacher/
│   │   │   │   ├── StoreTeacherRequest.php
│   │   │   │   └── UpdateTeacherRequest.php
│   │   │   ├── Exam/
│   │   │   │   ├── StoreExamRequest.php
│   │   │   │   └── ScheduleExamRequest.php
│   │   │   └── Fee/
│   │   │       ├── StoreFeeRequest.php
│   │   │       └── ProcessPaymentRequest.php
│   │   │
│   │   └── Teacher/
│   │       ├── MarkAttendanceRequest.php
│   │       └── SubmitResultRequest.php
│   │
│   └── Resources/
│       ├── StudentResource.php
│       ├── TeacherResource.php
│       ├── ExamResource.php
│       ├── FeeResource.php
│       └── BookResource.php
│
├── Jobs/
│   ├── SendWelcomeEmail.php
│   ├── ProcessFeePayment.php
│   ├── GenerateReport.php
│   ├── ProcessExamResults.php
│   └── SendInventoryAlert.php
│
├── Mail/
│   ├── TenantWelcomeMail.php
│   ├── FeePaymentReceipt.php
│   ├── AttendanceReport.php
│   ├── ExamScheduleMail.php
│   └── BookDueReminder.php
│
├── Models/
│   ├── Tenant.php
│   ├── School.php
│   ├── User.php
│   ├── Student.php
│   ├── Teacher.php
│   ├── ParentModel.php
│   ├── ClassModel.php
│   ├── Section.php
│   ├── Subject.php
│   ├── Attendance.php
│   ├── Exam.php
│   ├── ExamSchedule.php
│   ├── ExamResult.php
│   ├── FeeCategory.php
│   ├── FeeStructure.php
│   ├── Fee.php
│   ├── FeePayment.php
│   ├── Book.php
│   ├── BookIssue.php
│   ├── InventoryItem.php
│   ├── InventoryTransaction.php
│   ├── Notice.php
│   ├── Holiday.php
│   └── AuditLog.php
│
├── Notifications/
│   ├── StudentAttendanceNotification.php
│   ├── FeeDueNotification.php
│   ├── HolidayNotification.php
│   ├── ExamScheduleNotification.php
│   ├── BookDueNotification.php
│   └── InventoryAlertNotification.php
│
├── Observers/
│   ├── SchoolObserver.php
│   ├── UserObserver.php
│   ├── StudentObserver.php
│   ├── TeacherObserver.php
│   ├── AttendanceObserver.php
│   ├── ExamObserver.php
│   ├── FeeObserver.php
│   └── BookObserver.php
│
├── Policies/
│   ├── SchoolPolicy.php
│   ├── StudentPolicy.php
│   ├── TeacherPolicy.php
│   ├── ClassPolicy.php
│   ├── ExamPolicy.php
│   ├── FeePolicy.php
│   └── LibraryPolicy.php
│
├── Providers/
│   ├── TenantServiceProvider.php
│   ├── SchoolServiceProvider.php
│   ├── AuthServiceProvider.php
│   └── ObserverServiceProvider.php
│
├── Services/
│   ├── TenantService.php
│   ├── SchoolService.php
│   ├── FeeService.php
│   ├── ExamService.php
│   ├── LibraryService.php
│   ├── InventoryService.php
│   ├── AuditLogger.php
│   └── ReportGenerator.php
│
└── Traits/
    ├── TenantScoped.php
    ├── SchoolFilter.php
    ├── SoftDeletesWithUser.php
    └── HasEncryptedAttributes.php

📁 resources/
├── css/
│   └── app.css
│
├── js/
│   ├── app.js
│   └── tenant.js
│
├── lang/
│   └── en/
│       ├── auth.php
│       ├── pagination.php
│       ├── validation.php
│       ├── tenant.php
│       └── roles.php
│
└── views/
    ├── components/
    │   ├── tenant/
    │   │   ├── sidebar.blade.php
    │   │   ├── nav.blade.php
    │   │   └── school-selector.blade.php
    │   ├── ui/
    │   │   ├── button.blade.php
    │   │   └── input.blade.php
    │   └── auth/
    │       ├── input.blade.php
    │       └── validation-errors.blade.php
    │
    ├── layouts/
    │   ├── app.blade.php          # Main layout
    │   ├── tenant.blade.php       # Tenant dashboard layout
    │   ├── admin.blade.php        # Admin-specific layout
    │   ├── teacher.blade.php      # Teacher layout
    │   ├── parent.blade.php       # Parent layout
    │   └── guest.blade.php        # Auth pages layout
    │
    ├── tenant/
    │   ├── dashboard.blade.php
    │   ├── profile/
    │   │   ├── edit.blade.php
    │   │   └── show.blade.php
    │   └── settings/
    │       ├── general.blade.php
    │       ├── security.blade.php
    │       └── appearance.blade.php
    └── app 
        ├── admin/
        │   ├── students/
        │   │   ├── index.blade.php
        │   │   ├── create.blade.php
        │   │   ├── edit.blade.php
        │   │   └── show.blade.php
        │   │
        │   ├── teachers/
        │   │   ├── index.blade.php
        │   │   ├── create.blade.php
        │   │   └── edit.blade.php
        │   │
        │   ├── attendance/
        │   │   ├── index.blade.php
        │   │   └── mark.blade.php
        │   │
        │   ├── exams/
        │   │   ├── index.blade.php
        │   │   ├── create.blade.php
        │   │   └── results.blade.php
        │   │
        │   ├── fees/
        │   │   ├── index.blade.php
        │   │   ├── create.blade.php
        │   │   └── report.blade.php
        │   │
        │   └── library/
        │       ├── books.blade.php
        │       └── issues.blade.php
        │
        ├── teacher/
        │   ├── dashboard.blade.php
        │   ├── attendance/
        │   │   ├── index.blade.php
        │   │   └── mark.blade.php
        │   ├── exams/
        │   │   ├── index.blade.php
        │   │   └── create.blade.php
        │   └── students/
        │       └── list.blade.php
        │
        ├── parent/
        │   ├── dashboard.blade.php
        │   ├── students/
        │   │   └── show.blade.php
        │   └── fees/
        │       └── index.blade.php
        │
        └── auth/
            ├── login.blade.php
            ├── register.blade.php
            ├── forgot-password.blade.php
            ├── verify-email.blade.php
            └── confirm-password.blade.php
        
📁 routes/
├── api.php
├── web.php
├── channels.php
└── console.php

📁 routes/tenant/
├── admin.php       # Admin-specific routes
├── teacher.php     # Teacher routes  
├── parent.php      # Parent routes
├── student.php     # Student routes
└── auth.php        # Tenant authentication routes

📁 routes/api/
├── v1/
│   ├── admin.php   # Admin API routes
│   ├── teacher.php # Teacher API routes
│   └── shared.php  # Shared API routes

📁 storage/
├── app/
│   ├── public/
│   │   ├── tenants/
│   │   │   ├── {tenant_id}/
│   │   │   │   ├── school/
│   │   │   │   │   ├── logo/
│   │   │   │   │   └── documents/
│   │   │   │   ├── users/
│   │   │   │   │   ├── profile/
│   │   │   │   │   ├── signatures/
│   │   │   │   │   └── documents/
│   │   │   │   ├── students/
│   │   │   │   │   ├── profile/
│   │   │   │   │   ├── documents/
│   │   │   │   │   └── id_cards/
│   │   │   │   ├── teachers/
│   │   │   │   │   ├── profile/
│   │   │   │   │   ├── qualifications/
│   │   │   │   │   └── documents/
│   │   │   │   ├── exams/
│   │   │   │   │   ├── question_papers/
│   │   │   │   │   └── results/
│   │   │   │   ├── library/
│   │   │   │   │   ├── book_covers/
│   │   │   │   │   └── digital_books/
│   │   │   │   ├── fees/
│   │   │   │   │   └── receipts/
│   │   │   │   ├── notices/
│   │   │   │   └── reports/
│   │   │   └── shared/
│   │   │       ├── templates/
│   │   │       └── system/
│   │   └── temp/
│   └── private/
│       ├── exports/
│       ├── imports/
│       ├── backups/
│       └── secure_documents/
│           ├── bank_details/
│           └── id_proofs/
├── framework/
│   ├── cache/
│   ├── sessions/
│   ├── testing/
│   └── views/
│
└── logs/
    ├── tenant/
    │   ├── {tenant_id}/
    │   │   ├── audit.log
    │   │   └── system.log
    └── central.log



    📁 resources/views/admin/
    └─── academic/
                ├──── classes/
                │      ├── index.blade.php
                │      ├── create.blade.php
                │      ├── edit.blade.php
                │      ├── show.blade.php
                │      └── _form.blade.php (partial)
                │   
                ├─── sections/
                │      ├── index.blade.php
                │      ├── create.blade.php
                │      ├── edit.blade.php
                │      ├── show.blade.php
                │      └── _form.blade.php (partial)
                │   
                └──── subjects/
                       ├── index.blade.php
                       ├── create.blade.php
                       ├── edit.blade.php
                       ├── show.blade.php
                       ├── assign.blade.php (for teacher assignment)
                       └── _form.blade.php (partial)  


Mera Complete School Management System - Roman Urdu Mein Full Details
    5. Yeh App Schools Ko Kaise Help Karegi?
    ✔ Complete School Management
    -> Har School Ka Apna Alag Database
    -> Teachers, Students, Parents Ka Full Record
    -> ✔ Automated Systems
    -> Attendance Automatic Calculate Hota Hai
    -> Fees Automatic Generate Hota Hai
    -> Results Automatic Process Hote Hain
    -> ✔ Multi-Role Support
    -> Admin: Pure School Ko Control Kare
    -> Teacher: Apne Classes Manage Kare
    -> Parent: Sirf Apne Bacchon Ka Data Dekhe
    -> ✔ Advanced Features
    -> Library System (Books Tracking)
    -> Inventory Management (School Supplies)
    -> Automatic Reports Generation
    -> ✔ Security & Privacy
    -> Har School Ka Data Alag Alag Secure Hota Hai
    -> Har User Ki Activity Log Hoti Hai
    -> Final Notes:
    -> Laravel Multi-Tenancy: Har School Ka Alag Database
    -> Breeze Package: Secure Authentication Ke Liye
    -> Tailwind CSS: Professional School Dashboard
    -> Automated Jobs: Emails, Reports, Reminders

Ye ek professional-grade school management software hai jo Laravel aur MySQL pe based hai. System ko maine multi-tenant architecture mein design kiya hai jahan:

🌟 Special Features:
Multi-School Support

Har school ka apna alag database (100% data isolation)

Central admin sab schools ko manage kar sakta hai

Complete Academic Management

Classes, sections, subjects ka full tracking

Teacher-subject assignments

Student promotion system

Smart Attendance System

Daily attendance (present/absent/late/half-day)

Automatic monthly reports

SMS alerts parents ko

Advanced Fee Management

Different fee categories (tuition, transport, etc.)

Online/offline payment tracking

Automatic late fee calculations

Exam Management

Exam schedules with room allocation

Marks entry system

Automatic grade calculation

Library Management

Book inventory tracking

Issue/return system

Automatic fine calculation for late returns

Inventory Control

School supplies tracking

Low stock alerts

Purchase/issue records

👥 User Roles:
Super Admin (sab schools ko control kare)

School Admin (apni school manage kare)

Teachers (attendance, exams handle kare)

Parents (apne bachhon ka data dekhe)

Students (apna profile aur results dekhe)

🔒 Security Features:
Har user ki activity log hoti hai

IP address tracking for security

Sensitive data encryption

🚀 Technical Advantages:
Clean code structure (MVC pattern)

API ready (mobile app banane ke liye)

Automated jobs (emails, reports, reminders)

🏫 Schools Ke Liye Benefits:
✔ Paperless system
✔ Time-saving automation
✔ 24/7 access from anywhere
✔ Error-free calculations
✔ Professional reports generation

Ye system small schools se lekar large chains tak ke liye perfect hai. Mainne isme scalability ka khayal rakha hai takay future mein easily expand ho sake.

Final Opinion:
Ek modern, secure aur feature-rich solution hai jo schools ko completely digital bana dega! 



Here's a step-by-step development roadmap for your school management system in Roman Urdu:

Phase 1: Core Setup (1-2 Weeks)
Database Creation

Pehle schools table banao (central database)

Phir users table with roles (admin/teacher/parent/student)

classes, sections, subjects tables setup karo

Basic Authentication

Login/Register system banao

Password reset feature add karo

Role-based access control (RBAC) implement karo

Phase 2: Academic Module (2 Weeks)
People Management

teacher_profiles, student_profiles, parent_profiles tables

Student-parent linking (student_parents table)

Teacher-subject assignment system

Attendance System

Daily attendance entry form

Monthly reports generator

SMS/email alerts for absences

Phase 3: Financial Module (1 Week)
Fee Management

Fee categories setup

Automatic fee generation

Payment tracking with receipts

Phase 4: Exam System (1 Week)
Exam Module

Exam schedules with rooms

Marks entry interface

Result cards generator

Phase 5: Additional Modules (1 Week)
Library System

Book inventory management

Issue/return tracking

Fine calculation

Inventory System

School supplies tracking

Low stock alerts

Phase 6: Final Touches (1 Week)
Notification System

SMS/email alerts

Push notifications

Reporting Dashboard

Graphical reports

Export to PDF/Excel

Audit Logs

Track all system activities

User action history

Deployment Phase
Testing & Launch

Beta testing with sample data

Feedback collection

Final deployment

Pro Tip: Har phase complete hone pe testing zaroor karna! Pehle core modules (attendance, fees) complete karo, phir advanced features add karna.

    -- Insert data into schools table
    INSERT INTO schools (NAME, address, phone, email, logo, session_year) VALUES
    ('Greenwood High School', '123 Education Blvd, Springfield', '+1 (555) 123-4567', 'info@greenwood.edu', 'schools/greenwood_logo.png', '2023-2024'),
    ('Sunshine Academy', '456 Learning Lane, Rivertown', '+1 (555) 234-5678', 'admin@sunshine.edu', 'schools/sunshine_logo.png', '2023-2024'),
    ('Pinecrest Preparatory', '789 Knowledge St, Mountainview', '+1 (555) 345-6789', 'contact@pinecrest.edu', 'schools/pinecrest_logo.png', '2023-2024');

    -- Insert admin users for each school
    INSERT INTO users (school_id, NAME, email, PASSWORD, phone, role) VALUES
    (1, 'Admin Greenwood', 'admin@greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 123-4567', 'admin'),
    (2, 'Admin Sunshine', 'admin@sunshine.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 234-5678', 'admin'),
    (3, 'Admin Pinecrest', 'admin@pinecrest.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 345-6789', 'admin');

    -- Insert classes for Greenwood High School
    INSERT INTO classes (school_id, NAME, numeric_value) VALUES
    (1, 'Nursery', 0), (1, 'KG', 0), (1, 'Class 1', 1), (1, 'Class 2', 2), (1, 'Class 3', 3),
    (1, 'Class 4', 4), (1, 'Class 5', 5), (1, 'Class 6', 6), (1, 'Class 7', 7), (1, 'Class 8', 8),
    (1, 'Class 9', 9), (1, 'Class 10', 10);

    -- Insert sections for Greenwood High School
    INSERT INTO sections (school_id, class_id, NAME, capacity) VALUES
    (1, 3, 'A', 30), (1, 3, 'B', 30), (1, 4, 'A', 30), (1, 4, 'B', 30),
    (1, 5, 'A', 30), (1, 6, 'A', 30), (1, 7, 'A', 30), (1, 7, 'B', 30),
    (1, 8, 'A', 30), (1, 9, 'A', 30), (1, 10, 'A', 30), (1, 11, 'A', 30),
    (1, 12, 'A', 30), (1, 12, 'B', 30);

    -- Insert subjects for Greenwood High School
    INSERT INTO subjects (school_id, NAME, CODE, class_id) VALUES
    (1, 'English', 'ENG', NULL), (1, 'Mathematics', 'MATH', NULL), (1, 'Science', 'SCI', NULL),
    (1, 'Social Studies', 'SOC', NULL), (1, 'Computer Science', 'COMP', NULL), (1, 'Physical Education', 'PE', NULL),
    (1, 'Art', 'ART', NULL), (1, 'Music', 'MUS', NULL), (1, 'Hindi', 'HIN', NULL), (1, 'French', 'FRE', NULL);

    -- Insert teachers for Greenwood High School
    INSERT INTO users (school_id, NAME, email, PASSWORD, phone, gender, dob, role) VALUES
    (1, 'Sarah Johnson', 's.johnson@greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 111-2222', 'female', '1980-05-15', 'teacher'),
    (1, 'Michael Brown', 'm.brown@greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 222-3333', 'male', '1975-08-22', 'teacher'),
    (1, 'Emily Davis', 'e.davis@greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 333-4444', 'female', '1982-03-10', 'teacher'),
    (1, 'Robert Wilson', 'r.wilson@greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 444-5555', 'male', '1978-11-30', 'teacher'),
    (1, 'Jennifer Lee', 'j.lee@greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 555-6666', 'female', '1985-07-18', 'teacher');

    -- Insert teacher profiles
    INSERT INTO teacher_profiles (teacher_id, school_id, employee_id, qualification, specialization, experience_years, joining_date, salary_grade, is_class_teacher, class_teacher_of) VALUES
    (4, 1, 'T001', 'M.Ed, B.Sc', 'Mathematics', 12, '2015-08-01', 'SG-5', TRUE, 3),
    (5, 1, 'T002', 'M.A, B.Ed', 'English Literature', 8, '2018-06-15', 'SG-4', TRUE, 4),
    (6, 1, 'T003', 'Ph.D, M.Sc', 'Physics', 15, '2012-03-10', 'SG-6', FALSE, NULL),
    (7, 1, 'T004', 'M.A, B.Ed', 'History', 10, '2016-01-20', 'SG-5', TRUE, 7),
    (8, 1, 'T005', 'B.Sc, B.Ed', 'Computer Science', 5, '2020-09-05', 'SG-3', FALSE, NULL);

    -- Insert students for Greenwood High School
    INSERT INTO users (school_id, NAME, email, PASSWORD, phone, gender, dob, role) VALUES
    (1, 'John Smith', 'john.smith@student.greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 666-7777', 'male', '2015-03-22', 'student'),
    (1, 'Emma Johnson', 'emma.johnson@student.greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 777-8888', 'female', '2015-07-15', 'student'),
    (1, 'Daniel Williams', 'daniel.williams@student.greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 888-9999', 'male', '2014-11-30', 'student'),
    (1, 'Sophia Brown', 'sophia.brown@student.greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 999-0000', 'female', '2014-09-18', 'student'),
    (1, 'James Davis', 'james.davis@student.greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 000-1111', 'male', '2013-05-10', 'student');

    -- Insert student profiles
    INSERT INTO student_profiles (student_id, school_id, admission_no, admission_date, class_id, section_id, previous_school, blood_group, id_card_issued, id_card_number) VALUES
    (9, 1, 'GHS2023001', '2023-04-01', 3, 1, 'Little Angels Preschool', 'A+', TRUE, 'GHS001'),
    (10, 1, 'GHS2023002', '2023-04-01', 3, 1, 'Sunshine Kindergarten', 'B+', TRUE, 'GHS002'),
    (11, 1, 'GHS2023003', '2023-04-01', 4, 3, 'Little Stars Preschool', 'O+', TRUE, 'GHS003'),
    (12, 1, 'GHS2023004', '2023-04-01', 4, 3, NULL, 'AB+', TRUE, 'GHS004'),
    (13, 1, 'GHS2023005', '2023-04-01', 5, 5, 'Rainbow Elementary', 'A-', TRUE, 'GHS005');

    -- Insert parents
    INSERT INTO users (school_id, NAME, email, PASSWORD, phone, gender, dob, role) VALUES
    (1, 'David Smith', 'david.smith@parent.greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 123-9999', 'male', '1980-02-15', 'parent'),
    (1, 'Lisa Smith', 'lisa.smith@parent.greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 123-8888', 'female', '1982-07-20', 'parent'),
    (1, 'Richard Johnson', 'richard.johnson@parent.greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 234-7777', 'male', '1978-11-05', 'parent'),
    (1, 'Karen Williams', 'karen.williams@parent.greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 345-6666', 'female', '1979-04-30', 'parent'),
    (1, 'Thomas Brown', 'thomas.brown@parent.greenwood.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '+1 (555) 456-5555', 'male', '1975-09-12', 'parent');

    -- Insert parent profiles
    INSERT INTO parent_profiles (parent_id, school_id, occupation, employer, income_range, education_level, relation_type, is_primary) VALUES
    (14, 1, 'Software Engineer', 'Tech Solutions Inc.', '$80,000-$100,000', 'Master''s Degree', 'father', TRUE),
    (15, 1, 'Homemaker', NULL, NULL, 'Bachelor''s Degree', 'mother', FALSE),
    (16, 1, 'Doctor', 'City Hospital', '$120,000-$150,000', 'MD', 'father', TRUE),
    (17, 1, 'Teacher', 'Maplewood School', '$60,000-$80,000', 'Master''s Degree', 'mother', TRUE),
    (18, 1, 'Business Owner', 'Brown Enterprises', '$100,000-$120,000', 'Bachelor''s Degree', 'father', TRUE);

    -- Insert student-parent relationships
    INSERT INTO student_parents (student_id, parent_id, relationship, is_primary) VALUES
    (9, 14, 'father', TRUE), (9, 15, 'mother', FALSE),
    (10, 16, 'father', TRUE), (10, 17, 'mother', TRUE),
    (11, 18, 'father', TRUE),
    (12, 14, 'father', TRUE), -- Demonstrating one parent with multiple children
    (13, 16, 'father', TRUE); -- Another parent with multiple children

    -- Assign teachers to subjects
    INSERT INTO teacher_subjects (teacher_id, subject_id, class_id, is_class_teacher) VALUES
    (4, 2, 3, TRUE), -- Michael Brown teaching Math to Class 1
    (5, 1, 4, TRUE), -- Emily Davis teaching English to Class 2
    (4, 2, 4, FALSE), -- Michael Brown also teaching Math to Class 2
    (6, 3, 5, FALSE), -- Robert Wilson teaching Science to Class 3
    (7, 4, 7, TRUE), -- Jennifer Lee teaching Social Studies to Class 5
    (8, 5, 6, FALSE); -- Sarah Johnson teaching Computer Science to Class 4

    -- Insert attendance records
    INSERT INTO attendances (school_id, student_id, DATE, STATUS, recorded_by) VALUES
    (1, 9, '2023-09-01', 'present', 4),
    (1, 10, '2023-09-01', 'present', 4),
    (1, 11, '2023-09-01', 'present', 5),
    (1, 12, '2023-09-01', 'absent', 5),
    (1, 13, '2023-09-01', 'present', 5),
    (1, 9, '2023-09-02', 'present', 4),
    (1, 10, '2023-09-02', 'late', 4),
    (1, 11, '2023-09-02', 'present', 5),
    (1, 12, '2023-09-02', 'present', 5),
    (1, 13, '2023-09-02', 'half_day', 5);

    -- Insert fee categories
    INSERT INTO fee_categories (school_id, NAME, description) VALUES
    (1, 'Tuition Fee', 'Regular tuition fees for academic sessions'),
    (1, 'Transportation Fee', 'Fees for school bus transportation'),
    (1, 'Library Fee', 'Annual library maintenance fee'),
    (1, 'Sports Fee', 'Fee for sports equipment and activities'),
    (1, 'Examination Fee', 'Fee for term examinations');

    -- Insert fee structures
    INSERT INTO fee_structures (school_id, category_id, class_id, NAME, amount, frequency, due_date) VALUES
    (1, 1, 3, 'Class 1 Tuition Fee', 500.00, 'monthly', '2023-09-05'),
    (1, 1, 4, 'Class 2 Tuition Fee', 550.00, 'monthly', '2023-09-05'),
    (1, 1, 5, 'Class 3 Tuition Fee', 600.00, 'monthly', '2023-09-05'),
    (1, 2, NULL, 'Transport Fee Zone A', 200.00, 'monthly', '2023-09-10'),
    (1, 3, NULL, 'Annual Library Fee', 100.00, 'one_time', '2023-09-15'),
    (1, 4, NULL, 'Sports Fee', 50.00, 'yearly', '2023-09-20'),
    (1, 5, NULL, 'Term 1 Exam Fee', 75.00, 'one_time', '2023-10-01');

    -- Insert fees for students
    INSERT INTO fees (school_id, student_id, structure_id, invoice_number, amount, due_date, STATUS) VALUES
    (1, 9, 1, 'INV20230001', 500.00, '2023-09-05', 'paid'),
    (1, 9, 4, 'INV20230002', 200.00, '2023-09-10', 'paid'),
    (1, 9, 5, 'INV20230003', 100.00, '2023-09-15', 'pending'),
    (1, 10, 1, 'INV20230004', 500.00, '2023-09-05', 'paid'),
    (1, 10, 4, 'INV20230005', 200.00, '2023-09-10', 'partial'),
    (1, 11, 2, 'INV20230006', 550.00, '2023-09-05', 'pending'),
    (1, 12, 2, 'INV20230007', 550.00, '2023-09-05', 'pending'),
    (1, 13, 3, 'INV20230008', 600.00, '2023-09-05', 'paid');

    -- Insert fee payments
    INSERT INTO fee_payments (fee_id, amount, payment_date, payment_method, received_by) VALUES
    (1, 500.00, '2023-09-01', 'online', 3),
    (2, 200.00, '2023-09-08', 'bank_transfer', 3),
    (4, 500.00, '2023-09-02', 'card', 3),
    (5, 100.00, '2023-09-09', 'cash', 3),
    (8, 600.00, '2023-09-03', 'online', 3);

    -- Insert exams
    INSERT INTO exams (school_id, NAME, description, start_date, end_date, is_published) VALUES
    (1, 'Term 1 Examination', 'First term examination for all classes', '2023-10-10', '2023-10-20', TRUE),
    (1, 'Half Yearly Examination', 'Mid-term comprehensive examination', '2024-01-15', '2024-01-25', FALSE),
    (1, 'Final Examination', 'Annual final examination', '2024-04-01', '2024-04-15', FALSE);

    -- Insert exam schedules
    INSERT INTO exam_schedules (exam_id, subject_id, class_id, exam_date, start_time, end_time, max_marks, passing_marks) VALUES
    (1, 1, 3, '2023-10-10', '09:00:00', '11:00:00', 100, 40),
    (1, 2, 3, '2023-10-11', '09:00:00', '11:00:00', 100, 40),
    (1, 3, 3, '2023-10-12', '09:00:00', '11:00:00', 100, 40),
    (1, 1, 4, '2023-10-10', '12:00:00', '14:00:00', 100, 40),
    (1, 2, 4, '2023-10-11', '12:00:00', '14:00:00', 100, 40);

    -- Insert exam results
    INSERT INTO exam_results (school_id, exam_id, student_id, subject_id, marks_obtained, grade, remarks) VALUES
    (1, 1, 9, 1, 85.5, 'A', 'Excellent performance'),
    (1, 1, 9, 2, 78.0, 'B+', 'Good effort'),
    (1, 1, 10, 1, 92.0, 'A+', 'Outstanding work'),
    (1, 1, 10, 2, 65.5, 'C+', 'Can improve'),
    (1, 1, 11, 1, 72.0, 'B', 'Satisfactory');

    -- Insert library books
    INSERT INTO books (school_id, title, author, isbn, publisher, edition, category, price, quantity, available, shelf_number) VALUES
    (1, 'Mathematics for Class 1', 'R.D. Sharma', '9788121923534', 'Dhanpat Rai', '2023', 'Textbook', 250.00, 30, 28, 'MATH-1A'),
    (1, 'English Grammar Basics', 'Wren & Martin', '9788121923534', 'S. Chand', '2022', 'Textbook', 180.00, 25, 23, 'ENG-2B'),
    (1, 'Science Wonders', 'N.K. Gupta', '9788121923534', 'Arihant', '2021', 'Reference', 320.00, 15, 15, 'SCI-3C'),
    (1, 'History of the World', 'H.G. Wells', '9788121923534', 'Penguin', '2019', 'General', 450.00, 10, 9, 'GEN-4D'),
    (1, 'Computer Fundamentals', 'P.K. Sinha', '9788121923534', 'BPB', '2023', 'Textbook', 280.00, 20, 18, 'COMP-5E');

    -- Insert book issues
    INSERT INTO book_issues (school_id, book_id, user_id, issue_date, due_date, STATUS) VALUES
    (1, 1, 9, '2023-09-01', '2023-09-15', 'returned'),
    (1, 1, 10, '2023-09-05', '2023-09-19', 'issued'),
    (1, 2, 11, '2023-09-10', '2023-09-24', 'issued'),
    (1, 4, 13, '2023-09-15', '2023-09-29', 'issued');

    -- Insert inventory items
    INSERT INTO inventory_items (school_id, NAME, category, quantity, min_quantity, unit, location) VALUES
    (1, 'Whiteboard Markers', 'Stationery', 50, 10, 'pieces', 'Store Room A'),
    (1, 'A4 Paper', 'Stationery', 5000, 1000, 'sheets', 'Store Room B'),
    (1, 'Science Lab Beakers', 'Lab Equipment', 30, 5, 'pieces', 'Science Lab'),
    (1, 'Basketballs', 'Sports Equipment', 15, 3, 'pieces', 'Sports Room'),
    (1, 'Printer Ink', 'Office Supplies', 10, 2, 'cartridges', 'Admin Office');

    -- Insert inventory transactions
    INSERT INTO inventory_transactions (school_id, item_id, user_id, quantity, transaction_type, reference_number) VALUES
    (1, 1, 3, -5, 'issue', 'REQ20230001'),
    (1, 2, 3, -500, 'issue', 'REQ20230002'),
    (1, 3, 6, -2, 'issue', 'REQ20230003'),
    (1, 1, 3, 20, 'purchase', 'PO20230001'),
    (1, 4, 3, 5, 'purchase', 'PO20230002');

    -- Insert notices
    INSERT INTO notices (school_id, title, content, target_roles, target_classes, start_date, end_date, is_published) VALUES
    (1, 'Parent-Teacher Meeting', 'Monthly parent-teacher meeting scheduled for September 15th at 2 PM.', '["parent"]', NULL, '2023-09-01', '2023-09-15', TRUE),
    (1, 'Sports Day Announcement', 'Annual sports day will be held on October 5th. All students must participate.', '["student","parent"]', NULL, '2023-09-10', '2023-10-05', TRUE),
    (1, 'Class 1 Field Trip', 'Field trip to Science Museum for Class 1 on September 20th.', NULL, '[3]', '2023-09-05', '2023-09-20', TRUE);

    -- Insert holidays
    INSERT INTO holidays (school_id, title, description, start_date, end_date, is_recurring, recurring_pattern) VALUES
    (1, 'Labor Day', 'National holiday', '2023-09-04', '2023-09-04', TRUE, 'yearly'),
    (1, 'Thanksgiving Break', 'Thanksgiving holiday break', '2023-11-23', '2023-11-24', TRUE, 'yearly'),
    (1, 'Winter Break', 'Christmas and New Year holidays', '2023-12-22', '2024-01-02', TRUE, 'yearly'),
    (1, 'Teacher Training Day', 'Staff development day - school closed for students', '2023-10-10', '2023-10-10', FALSE, NULL);

    -- Insert audit logs
    INSERT INTO audit_logs (user_id, ACTION, table_affected, record_id, ip_address) VALUES
    (3, 'create', 'users', 9, '192.168.1.1'),
    (3, 'update', 'users', 9, '192.168.1.1'),
    (4, 'create', 'attendances', 1, '192.168.1.2'),
    (5, 'create', 'attendances', 3, '192.168.1.3'),
    (3, 'create', 'fees', 1, '192.168.1.1');

    -- Insert system settings
    INSERT INTO system_settings (school_id, setting_key, setting_value, is_encrypted) VALUES
    (1, 'school_name', 'Greenwood High School', FALSE),
    (1, 'attendance_start_time', '08:30:00', FALSE),
    (1, 'attendance_late_time', '08:45:00', FALSE),
    (1, 'default_password_expiry_days', '90', FALSE),
    (1, 'smtp_password', 'encrypted_password_here', TRUE);



-------------------------------------------
    Add This latter
    FileStorageService



    