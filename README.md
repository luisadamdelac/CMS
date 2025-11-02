# Platia Restaurant Management System

A comprehensive web-based restaurant management system built with PHP, MySQL, and Bootstrap. The system provides complete restaurant management capabilities including menu management, reservations, order processing, and administrative controls.

## Features Implemented

### User Authentication & Role-Based Access Control
- Multi-level user roles (Admin, Staff, Customer)
- Secure login and registration with password hashing (bcrypt)
- Session management and security
- Profile management for all users
- Role-based navigation and dashboard access

### Menu Management
- Dynamic menu categories and items
- Add, edit, and disable menu items
- Category-based organization
- Price management and availability control

### Reservation System
- Online table reservations
- Reservation management for staff
- Status tracking (Pending, Confirmed, Completed, Cancelled)
- Table availability checking
- Customer reservation history

### Order Management
- Place orders online through cart system
- Order status tracking (Pending, Confirmed, Preparing, Ready, Completed, Cancelled)
- Payment processing with multiple methods (Cash, Card, GCash, Maya)
- Order history and receipts

### Shopping Cart System
- Add/remove items to cart
- Quantity management
- Cart persistence during session
- Real-time cart updates

### Admin Dashboard
- Real-time sales and reservation reports
- User management (view, edit, delete users)
- System configuration and settings
- Analytics with charts (sales, reservations, user stats)

### Staff Dashboard
- Today's orders and reservations management
- Order status updates
- Table occupancy tracking
- Revenue tracking

### Customer Dashboard
- Personal reservation and order history
- Account management
- Spending analytics

### REST-like API Endpoints
- CRUD operations for users
- Cart management endpoints
- Order processing endpoints
- Reservation management endpoints
- JSON responses with proper error handling

## Technology Stack

- **Backend**: PHP 8.0+
- **Database**: MySQL 8.0+
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Architecture**: MVC (Model-View-Controller)
- **Security**: Password hashing with bcrypt, input validation, CSRF protection
- **Libraries**: jQuery 3.6.0, Chart.js, Font Awesome 6.0.0

## Requirements

- PHP 8.0 or higher
- MySQL 8.0 or higher
- Apache/XAMPP web server
- mod_rewrite enabled
- PDO PHP Extension
- GD PHP Extension (for image processing)

## Setup Instructions (How to Run Locally)

### 1. Prerequisites
- Install XAMPP (or similar Apache/MySQL/PHP stack)
- Ensure Apache and MySQL services are running
- PHP 8.0+ with PDO extension enabled

### 2. Clone and Setup Project
```bash
# Clone the repository
git clone [repository-url]
cd RMS

# Place the project in XAMPP htdocs directory
# Copy the entire RMS folder to C:\xampp\htdocs\
```

### 3. Database Setup
```bash
# Start XAMPP Control Panel and start MySQL
# Open phpMyAdmin (http://localhost/phpmyadmin)

# Create database
CREATE DATABASE platia_db;

# Import schema
# In phpMyAdmin, select platia_db database
# Go to Import tab and upload platia_db.sql
# Or use command line:
mysql -u root platia_db < platia_db.sql

# Optional: Import sample data
mysql -u root platia_db < sample_data.sql
```

### 4. Configuration
- Update `config/database.php` if using different credentials:
```php
private $host = "localhost";
private $db_name = "platia_db";
private $username = "root";  // Change if different
private $password = "";      // Add password if set
```

### 5. Access the Application
- Open browser and go to: `http://localhost/RMS/public/`
- Default admin credentials:
  - Username: admin
  - Password: password
- Default staff credentials:
  - Username: staff
  - Password: password

## Database Structure

### Tables and Columns

#### users
- `user_id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `username` (VARCHAR(50), UNIQUE)
- `email` (VARCHAR(100), UNIQUE)
- `password` (VARCHAR(255))
- `first_name` (VARCHAR(50))
- `last_name` (VARCHAR(50))
- `phone` (VARCHAR(20))
- `role` (ENUM: 'customer', 'staff', 'admin')
- `is_active` (TINYINT(1))
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

#### menu_categories
- `category_id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `category_name` (VARCHAR(100))
- `description` (TEXT)
- `display_order` (INT)
- `is_active` (TINYINT(1))
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

#### menu_items
- `item_id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `category_id` (INT, FOREIGN KEY)
- `item_name` (VARCHAR(100))
- `description` (TEXT)
- `price` (DECIMAL(10,2))
- `is_available` (TINYINT(1))
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

#### restaurant_tables
- `table_id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `table_number` (VARCHAR(10), UNIQUE)
- `capacity` (INT)
- `is_available` (TINYINT(1))
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

#### reservations
- `reservation_id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `customer_id` (INT, FOREIGN KEY)
- `table_id` (INT, FOREIGN KEY)
- `reservation_date` (DATE)
- `reservation_time` (TIME)
- `party_size` (INT)
- `special_requests` (TEXT)
- `status` (ENUM: 'pending', 'confirmed', 'completed', 'cancelled')
- `created_at` (TIMESTAMP)

#### orders
- `order_id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `customer_id` (INT, FOREIGN KEY)
- `table_id` (INT, FOREIGN KEY, NULL)
- `order_number` (VARCHAR(20), UNIQUE)
- `total_amount` (DECIMAL(10,2))
- `status` (ENUM: 'pending', 'confirmed', 'preparing', 'ready', 'completed', 'cancelled')
- `order_type` (ENUM: 'dine-in', 'takeout', 'delivery')
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

#### order_items
- `order_item_id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `order_id` (INT, FOREIGN KEY)
- `item_id` (INT, FOREIGN KEY)
- `quantity` (INT)
- `unit_price` (DECIMAL(10,2))

#### payments
- `payment_id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `order_id` (INT, FOREIGN KEY)
- `staff_id` (INT, FOREIGN KEY, NULL)
- `payment_method` (ENUM: 'cash', 'card', 'gcash', 'maya')
- `amount` (DECIMAL(10,2))
- `payment_date` (TIMESTAMP)

## PHP Functions and Their Purposes

### Authentication & Security Functions (`helpers/functions.php`)
- `sanitizeInput($data)` - Sanitizes user input to prevent XSS attacks
- `redirect($url)` - Redirects user to specified URL
- `isLoggedIn()` - Checks if user is currently logged in
- `isAdmin()` - Checks if current user has admin role
- `isStaff()` - Checks if current user has staff role
- `generateCSRFToken()` - Generates CSRF protection token
- `validateCSRFToken($token)` - Validates CSRF token
- `getUserRole()` - Returns current user's role
- `getCurrentUser()` - Returns current user data from session
- `requireLogin()` - Redirects to login if user not authenticated
- `requireRole($role)` - Redirects to login if user doesn't have required role
- `hashPassword($password)` - Hashes password using bcrypt
- `verifyPassword($password, $hash)` - Verifies password against hash
- `getStaffEmails()` - Returns array of staff email addresses

### Utility Functions
- `formatPrice($price)` - Formats price with Philippine Peso symbol
- `generateOrderNumber()` - Generates unique order number
- `sendJsonResponse($data)` - Sends JSON response and exits

## API Endpoints and Their Descriptions

### User Management
- `GET /api/read.php` - Retrieve all users (Admin only)
- `POST /api/create.php` - Create new user account
- `PUT /api/update.php` - Update existing user information
- `DELETE /api/delete.php` - Delete user account (Admin only)

### Cart Management
- `GET /api/get_cart.php` - Retrieve current user's cart items
- `POST /api/add_to_cart.php` - Add item to cart
- `PUT /api/update_cart.php` - Update cart item quantity
- `DELETE /api/remove_from_cart.php` - Remove item from cart

### Order Management
- `GET /api/orders.php` - Retrieve orders (filtered by user role)
- `POST /api/checkout.php` - Process order checkout

### Reservation Management
- `GET /api/reservations.php` - Retrieve reservations (filtered by user role)
- `POST /api/reservations.php` - Create new reservation
- `PUT /api/reservations.php` - Update reservation status
- `DELETE /api/reservations.php` - Cancel reservation

### Notifications
- `GET /api/check_cart_notifications.php` - Check for cart-related notifications

## Step-by-Step Procedure for Uploading to GitHub

### Prerequisites
1. Create a GitHub account at https://github.com
2. Install Git on your system
3. Have your project ready locally

### Step 1: Initialize Git Repository
```bash
# Navigate to your project directory
cd C:\xampp\htdocs\RMS

# Initialize Git repository
git init

# Add all files to staging
git add .

# Make initial commit
git commit -m "Initial commit: Platia Restaurant Management System"
```

### Step 2: Create GitHub Repository
1. Go to https://github.com and sign in
2. Click the "+" icon in the top right corner
3. Select "New repository"
4. Repository name: `platia-rms` or `restaurant-management-system`
5. Description: "A comprehensive restaurant management system built with PHP and MySQL"
6. Choose "Public" or "Private" (Private requires paid plan)
7. **DO NOT** initialize with README, .gitignore, or license (we already have these)
8. Click "Create repository"

### Step 3: Connect Local Repository to GitHub
```bash
# Copy the repository URL from GitHub (HTTPS or SSH)
# Example: https://github.com/yourusername/platia-rms.git

# Add remote origin
git remote add origin https://github.com/yourusername/platia-rms.git

# Push to GitHub
git push -u origin master
```

### Step 4: Verify Upload
1. Refresh your GitHub repository page
2. All files should now be visible
3. Check that the README.md renders properly

### Step 5: Future Updates (Optional)
```bash
# Make changes to files
# Stage changes
git add .

# Commit changes
git commit -m "Description of changes"

# Push to GitHub
git push origin master
```

### Troubleshooting
- If push fails due to large files, consider using `.gitignore` to exclude unnecessary files
- If authentication fails, ensure you're using the correct GitHub credentials
- For HTTPS push, you may need to use a Personal Access Token instead of password

## Project Structure

```
RMS/
├── api/                    # REST API endpoints
├── config/                 # Database configuration
├── controllers/            # Business logic controllers
├── css/                    # Stylesheets
├── helpers/                # Utility functions
├── js/                     # JavaScript files
├── models/                 # Database models
├── public/                 # Public web files
├── tools/                  # Database tools and utilities
├── views/                  # HTML templates
├── platia_db.sql          # Database schema
├── sample_data.sql        # Sample data for testing
├── README.md              # This documentation
└── import_db.php          # Database import script
```

## Security Features

- Password hashing with bcrypt
- Input sanitization and validation
- SQL injection prevention with prepared statements
- XSS protection through htmlspecialchars
- CSRF protection with tokens
- Role-based access control
- Session management with secure settings

## Development Guidelines

### Coding Standards
- Follow PSR-12 coding standards
- Use meaningful variable and function names
- Include proper error handling and logging
- Add comments for complex logic
- Validate all user inputs

### Testing Checklist
- [ ] Test all CRUD operations for users
- [ ] Verify role-based access restrictions
- [ ] Check form validations and error messages
- [ ] Test API endpoints with different HTTP methods
- [ ] Verify cart functionality and persistence
- [ ] Test reservation system and table availability
- [ ] Check order processing and payment flows
- [ ] Validate dashboard data accuracy
- [ ] Test responsive design on different devices

## License

This project is developed for educational purposes as part of the Website Development 1 final examination.

## Contributors

- Dela Cruz, Luis Adam D.
- Bulalo Balite, Calapan City Oriental Mindoro

## Contact

For questions or support regarding this project, please contact the development team.
