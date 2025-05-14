1. Central Database (For Tenants Management Only)
┌─────────────────┐       ┌───────────────────┐
│     tenants     │       │    tenant_users   │
├─────────────────┤       ├───────────────────┤
│ PK id           │───────│ FK tenant_id      │
│   name          │       │   email           │
│   domain        │       │   password        │
│   database_name │       │   role            │
│   status        │       └───────────────────┘
└─────────────────┘

2. Tenant Database Structure (Each School Gets This Entire Structure)
┌─────────────────┐       ┌───────────────────┐       ┌─────────────────────┐
│     schools     │       │      users        │       │   teacher_profiles  │
├─────────────────┤       ├───────────────────┤       ├─────────────────────┤
│ PK id           │───────│ FK school_id      │◄──────│ FK teacher_id       │
└─────────────────┘       │   role            │       │ FK school_id        │
        │                 └───────────────────┘       └─────────────────────┘
        │                         │                              ▲
        │                         │                              │
        ▼                         ▼                              │
┌─────────────────┐       ┌───────────────────┐                │
│    classes      │       │  student_profiles │                │
├─────────────────┤       ├───────────────────┤                │
│ PK id           │◄──────│ FK class_id       │                │
│ FK teacher_id   │       │ FK section_id     │                │
└─────────────────┘       │ FK student_id     │                │
        ▲                 └───────────────────┘                │
        │                         ▲                           │
        │                         │                           │
┌─────────────────┐       ┌───────────────────┐       ┌─────────────────────┐
│    sections     │       │   parent_profiles │       │   teacher_subjects  │
├─────────────────┤       ├────────────────────┤       ├─────────────────────┤
│ PK id           │       │ FK parent_id      │       │ FK teacher_id       │
│ FK class_id     │       │ FK school_id      │       │ FK subject_id       │
└─────────────────┘       └───────────────────┘       └─────────────────────┘
        ▲                         ▲                              ▲
        │                         │                              │
        └─────────────────────────┼──────────────────────────────┘
                                  │
                                  ▼
                       ┌─────────────────────┐
                       │   student_parents   │
                       ├─────────────────────┤
                       │ FK student_id       │
                       │ FK parent_id        │
                       └─────────────────────┘

┌─────────────────┐       ┌───────────────────┐       ┌─────────────────────┐
│  fee_categories │       │  fee_structures   │       │        fees         │
├─────────────────┤       ├───────────────────┤       ├─────────────────────┤
│ PK id           │◄──────│ FK category_id    │◄──────│ FK structure_id     │
└─────────────────┘       │ FK class_id       │       │ FK student_id       │
                          └───────────────────┘       └─────────────────────┘
                                  │                              ▲
                                  │                              │
                                  ▼                              │
                       ┌─────────────────────┐                   │
                       │    fee_payments     │───────────────────┘
                       ├─────────────────────┤
                       │ FK fee_id           │
                       └─────────────────────┘

┌─────────────────┐       ┌───────────────────┐       ┌─────────────────────┐
│     exams       │       │  exam_schedules   │       │    exam_results     │
├─────────────────┤       ├───────────────────┤       ├─────────────────────┤
│ PK id           │◄──────│ FK exam_id        │◄──────│ FK exam_id          │
└─────────────────┘       │ FK subject_id     │       │ FK student_id       │
                          │ FK class_id       │       │ FK subject_id       │
                          └───────────────────┘       └─────────────────────┘

┌─────────────────┐       ┌───────────────────┐
│     books       │       │   book_issues     │
├─────────────────┤       ├───────────────────┤
│ PK id           │◄──────│ FK book_id        │
└─────────────────┘       │ FK user_id        │
                          └───────────────────┘

┌─────────────────┐       ┌───────────────────┐
│ inventory_items │       │inventory_transacts│
├─────────────────┤       ├───────────────────┤
│ PK id           │◄──────│ FK item_id        │
└─────────────────┘       └───────────────────┘

┌─────────────────┐       ┌───────────────────┐
│    notices      │       │     holidays      │
├─────────────────┤       ├───────────────────┤
│ PK id           │       │ PK id             │
└─────────────────┘       └───────────────────┘

┌─────────────────┐       ┌───────────────────┐
│  audit_logs     │       │ system_settings   │
├─────────────────┤       ├───────────────────┤
│ PK id           │       │ PK id             │
│ FK user_id      │       │ FK school_id      │
└─────────────────┘       └───────────────────┘



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
    │
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


{{-- 
    ┌───────────────────────┐
    │      Super Admin      │
    └──────────┬────────────┘
               │
               ▼
    1. School Banata Hai (Tenant)
       ├─ Database Automatically Create Hota Hai
       ├─ Admin User Assign Karta Hai
       └─ School Ko Activate Karta Hai
    
    ┌───────────────────────┐
    │     School Admin      │
    └──────────┬────────────┘
               │
               ▼
    2. School Setup Ka Kaam
       ├─ School Profile Complete Kare
       ├─ Academic Structure Banaye
       │   ├─ Classes Add Kare
       │   ├─ Sections Create Kare
       │   └─ Subjects Setup Kare
       ├─ Users Manage Kare
       │   ├─ Teachers Register Kare
       │   ├─ Students Add Kare
       │   └─ Parents Ko Link Kare
       └─ System Settings Configure Kare
    
    ┌───────────────────────┐
    │ Daily School Ka Kaam  │
    └──────────┬────────────┘
               │
               ▼
    3. Rozana Activities
       ├─ Teachers:
       │   ├─ Attendance Mark Kare
       │   ├─ Exams Conduct Kare
       │   └─ Results Upload Kare
       ├─ Admin:
       │   ├─ Fees Generate Kare
       │   ├─ Reports Banaye
       │   └─ Inventory Manage Kare
       ├─ Parents:
       │   ├─ Bacchon Ka Data Dekhe
       │   ├─ Fees Pay Kare
       │   └─ Progress Track Kare
       └─ System:
           ├─ Automatic Reminders Bhaje
           ├─ Reports Generate Kare
           └─ Audit Logs Maintain Kare
    
    ┌───────────────────────┐
    │   Reporting System    │
    └──────────┬────────────┘
               │
               ▼
    4. Reports Ka Flow
       ├─ User Report Type Select Kare
       ├─ Filters Apply Kare
       ├─ PDF/Excel Generate Hota Hai
       ├─ Database Mein Save Hota Hai
       └─ (Optional) Recurring Set Kar Sakte Hain
    
    ┌───────────────────────┐
    │  Inventory System     │
    └──────────┬────────────┘
               │
               ▼
    5. Inventory Ka Flow
       ├─ Admin New Item Add Kare
       ├─ Staff Item Checkout Kare
       ├─ System Track Karta Hai:
       │   ├─ Current Location
       │   ├─ Item Ki Condition
       │   └─ Availability Status
       └─ Due Items Ka Automatic Alert
    
    ┌───────────────────────┐
    │    Library System     │
    └──────────┬────────────┘
               │
               ▼
    6. Library Ka Flow
       ├─ Librarian Books Add Kare
       ├─ Students Books Issue Karen
       ├─ Due Dates Track Hoti Hain
       └─ Late Returns Par Fine Lage
    
    ┌───────────────────────┐
    │   Security Features   │
    └──────────┬────────────┘
               │
               ▼ 
    7. Har Action Ka Audit Hota Hai
       ├─ Timestamp Record Hota Hai
       ├─ User Ka Details Save Hota Hai
       ├─ IP Address Track Hota Hai
       └─ Action Ki Full Details Log Hoti Hai
      --}}
      
       5. Yeh App Schools Ko Kaise Help Karegi?
       ✔ Complete School Management
       
       Har School Ka Apna Alag Database
       
       Teachers, Students, Parents Ka Full Record
       
       ✔ Automated Systems
       
       Attendance Automatic Calculate Hota Hai
       
       Fees Automatic Generate Hota Hai
       
       Results Automatic Process Hote Hain
       
       ✔ Multi-Role Support
       
       Admin: Pure School Ko Control Kare
       
       Teacher: Apne Classes Manage Kare
       
       Parent: Sirf Apne Bacchon Ka Data Dekhe
       
       ✔ Advanced Features
       
       Library System (Books Tracking)
       
       Inventory Management (School Supplies)
       
       Automatic Reports Generation
       
       ✔ Security & Privacy
       
       Har School Ka Data Alag Alag Secure Hota Hai
       
       Har User Ki Activity Log Hoti Hai
       
       Final Notes:
       
       Laravel Multi-Tenancy: Har School Ka Alag Database
       
       Breeze Package: Secure Authentication Ke Liye
       
       Tailwind CSS: Professional School Dashboard
       
       Automated Jobs: Emails, Reports, Reminders






Mera Complete School Management System - Roman Urdu Mein Full Details

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