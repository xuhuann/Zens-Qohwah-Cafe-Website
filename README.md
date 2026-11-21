# Zens Qohwah Café Website

University Web Engineering project built with PHP, MySQL, HTML and CSS.

## Features
- User registration and login
- Product menu and shopping cart
- Checkout and order management
- Staff dashboard and product management
- Customer feedback

## Local setup
1. Install XAMPP with Apache and MySQL.
2. Place the `zens_qohwah` folder in `htdocs`.
3. Create a MySQL database named `zens_qohwah`.
4. Import `zens_qohwah/zens_qohwah.sql` using phpMyAdmin.
5. Visit `http://localhost/zens_qohwah/`.

The SQL file contains the database structure and product sample data, but excludes user accounts, orders and feedback records. Create your own test account using the registration page. Staff access requires local setup.

## AI assistance
ChatGPT was used to assist with understanding requirements, drafting code and troubleshooting.

## Important security note
This is a **learning project**, not production-ready. In particular, the authentication code stores and checks passwords in plain text, and some database queries require stronger validation and parameterization. Do not deploy publicly or use real personal information or passwords without fixing these issues.
