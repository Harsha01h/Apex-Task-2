# BlogApp - PHP CRUD Application with User Authentication

A complete PHP web application for blogging with user authentication and CRUD operations.

## Features

- **User Authentication**: Secure signup, login, and logout with password hashing
- **CRUD Operations**: Create, read, update, and delete blog posts
- **Session Management**: Secure session handling for user state
- **Responsive Design**: Modern, clean UI that works on all devices
- **Security**: Prepared statements, input validation, and XSS protection

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP built-in server

## Installation

1. **Clone or download the project** to your web server directory

2. **Database Setup**:
   - Create a MySQL database named `blogapp`
   - Update database credentials in `config/database.php` if needed
   - Run the database setup script:
     ```bash
     cd database
     php init.php
     ```
   - Or manually import `database/setup.sql` into your MySQL database

3. **Configure Database** (if needed):
   - Edit `config/database.php` to match your database settings:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'blogapp');
     ```

4. **Start the Application**:
   - Using PHP built-in server:
     ```bash
     php -S localhost:8000
     ```
   - Or configure your web server to point to the project directory

5. **Access the Application**:
   - Open your browser and go to `http://localhost:8000` (or your configured URL)

## Usage

1. **Sign Up**: Create a new account with username, email, and password
2. **Login**: Access your account using email and password
3. **Create Posts**: Write and publish blog posts
4. **Manage Posts**: Edit or delete your own posts
5. **Browse Posts**: View all posts from all users

## File Structure

```
BlogApp/
├── config/
│   ├── database.php     # Database configuration
│   └── session.php      # Session management functions
├── css/
│   └── style.css        # Application styling
├── database/
│   ├── setup.sql        # Database schema
│   └── init.php         # Database initialization script
├── includes/
│   └── header.php       # Navigation header
├── index.php            # Home page
├── signup.php           # User registration
├── login.php            # User login
├── logout.php           # User logout
├── posts.php            # View all posts
├── create_post.php      # Create new post
├── edit_post.php        # Edit existing post
├── delete_post.php      # Delete post
└── README.md            # This file
```

## Security Features

- Password hashing using PHP's `password_hash()` and `password_verify()`
- Prepared statements for all database queries
- Input validation and sanitization
- XSS protection with `htmlspecialchars()`
- Session-based authentication
- CSRF protection through proper form handling

## Testing

1. **Sign up** with a new account
2. **Login** with your credentials
3. **Create a post** and verify it appears in the posts list
4. **Edit your post** and confirm changes are saved
5. **Delete a post** and verify it's removed
6. **Logout** and confirm you can't access protected pages

## Troubleshooting

- **Database connection errors**: Check your database credentials in `config/database.php`
- **Permission errors**: Ensure your web server has read/write permissions to the project directory
- **Session issues**: Make sure your PHP installation has session support enabled

## License

This project is open source and available under the MIT License.
