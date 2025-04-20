🧾 Core PHP Role-Based Management System (RBMS)
This project is a lightweight and modular Role-Based Management System built using Core PHP. It implements secure user authentication, admin validation workflows, and dynamic role-based dashboards using the AdminLTE UI framework.

RBMS supports two main roles:

Admin – Validates new users and manages the system.

User – Can register, log in, and access a personal dashboard after admin approval.

🔑 Key Features
Role-based login and dashboards (Admin & User)

User registration with form validation

Admin gets email notification on new registration (SMTP using PHPMailer)

Admin approves/rejects users

Email confirmation sent to users upon approval

Secure login with session management

Profile photo upload and update

Responsive UI with AdminLTE and Bootstrap

Modular code with separation of logic (DB, mail, templates)

CSRF token support and input sanitization

📂 Tech Stack
PHP (Core, no framework)

MySQL (for user and role data)

PHPMailer (for email notifications)

AdminLTE 3 (for dashboard UI)

Bootstrap 4, jQuery

📦 Project Structure
includes/ – DB connection, auth, email, utilities

views/ – Login, register, and dashboard pages

templates/ – Reusable UI blocks (header, footer, sidebar)

uploads/ – User profile images

adminlte/ – AdminLTE assets (or use CDN)

vendor/ – Composer-managed PHPMailer

🔧 Setup Instructions
Clone the repository.

Run composer install to get PHPMailer.

Import the SQL database (included).

Configure your DB and SMTP settings in db.php and mailer.php.

Run locally with php -S localhost:8000.
