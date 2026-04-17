# Newachen Catering Management System

A comprehensive catering event booking and management platform built with Laravel. This system enables customers to browse catering packages, place orders for events, and allows administrators to manage bookings, track payments, and send email notifications.

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [Project Structure](#project-structure)
- [Core Features](#core-features)
- [Database Schema](#database-schema)
- [API Routes](#api-routes)
- [Admin Features](#admin-features)
- [Configuration](#configuration)

## Features

### Customer Features
- **Browse Catering Packages**: View multiple curated catering packages with detailed menus and pricing
- **Package Selection**: Choose from standard packages (Package 01, 02, 03, 04) with varying menu options and price points
- **Addon Items**: Add supplementary menu items to customize packages (Newa Mains Menu, Newari Specials, Indian Specials, etc.)
- **Event Booking**: Reserve packages for specific dates, times, venues, and guest counts
- **Kids Packages**: Special menu options for children with separate pricing
- **Delivery Options**: Add delivery charges for events outside standard service areas
- **Flexible Pricing**: Support for both per-person (price_per_pax) and total package pricing
- **Payment Flexibility**: Option to pay in advance with remaining balance payable later
- **Reservation Management**: Book specific event dates and times through the reservation system

### Admin Features
- **Admin Dashboard**: Comprehensive view of all bookings with color-coded customer cards
- **Booking Management**: View detailed booking information including customer details, menu selections, and event specifics
- **Status Tracking**: Update booking status (Pending, Confirmed, Cancelled, Payment Done)
- **Email Notifications**:
  - Booking Confirmed emails to customers
  - Booking Cancelled emails with cancellation details
- **Payment Management**: Track advance payments and remaining balances for each booking
- **Order Details**: View complete order breakdown including:
  - Main package items with customer selections
  - Addon items (if applicable)
  - Kids menu selections and pricing
  - Delivery charges
- **Customer Management**: View and manage customer contact information and preferences
- **Admin Authentication**: Secure login system for admin users

### System Features
- **Order Management**: Complete order lifecycle from creation to completion
- **Package Item Groups**: Organize menu items into logical groups for better selection
- **Package-Item Associations**: Connect items to packages with many-to-many relationships
- **Addon Item Management**: Flexible addon system for customizing orders
- **Kids Order Items**: Special handling for children's menu selections
- **Database Migrations**: Comprehensive migration system for database schema updates

## Tech Stack

- **Backend**: Laravel 11.x
- **Database**: MySQL/MariaDB
- **PHP**: 8.x
- **Frontend**: Blade templating engine with Vite
- **Authentication**: Laravel's built-in authentication system
- **Email**: Laravel Mail system for notifications

## Installation

### Prerequisites
- PHP 8.0 or higher
- Composer
- MySQL/MariaDB
- Node.js & npm

### Setup Steps

1. **Clone or Download the Repository**
   ```bash
   cd c:\xampp8\htdocs\Newachenrepo
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   - Update `.env` with your database credentials
   - Set `DB_DATABASE=newachen_db` (or your preferred name)
   - Set `DB_USERNAME` and `DB_PASSWORD`

5. **Run Migrations**
   ```bash
   php artisan migrate
   ```

6. **Build Frontend Assets**
   ```bash
   npm run build
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```

8. **In another terminal, build frontend assets (watch mode)**
   ```bash
   npm run dev
   ```

## Project Structure

```
app/
  ├── Http/
  │   ├── Controllers/
  │   │   ├── Admin/
  │   │   │   └── BookingController.php      # Admin booking management
  │   │   ├── Web/
  │   │   │   └── HomeController.php         # Customer home/booking pages
  │   │   ├── OrderController.php             # Order creation and management
  │   │   └── Controller.php                  # Base controller
  │   └── Middleware/
  │       └── AuthenticateAdmin.php           # Admin authentication middleware
  ├── Models/
  │   ├── User.php                           # User model
  │   ├── Package.php                        # Catering packages
  │   ├── Item.php                           # Menu items
  │   ├── Order.php                          # Customer orders
  │   ├── OrderAddonItem.php                 # Addon items in orders
  │   ├── OrderPackageSelection.php          # Customer's item selections from package
  │   ├── KidsOrderItem.php                  # Kids menu items in orders
  │   └── Package.php                        # Package management
  ├── Mail/
  │   ├── BookingConfirmedMail.php           # Booking confirmation emails
  │   └── BookingCancelledMail.php           # Booking cancellation emails
  └── Providers/
      └── AppServiceProvider.php             # Service provider configuration

database/
  ├── migrations/                            # All database schema migrations
  ├── factories/                             # Model factories for testing
  └── seeders/                               # Database seeders

routes/
  ├── web.php                                # Web routes for customers
  └── admin.php                              # Admin panel routes

resources/
  ├── views/                                 # Blade templates
  │   ├── admin/                             # Admin views
  │   └── web/                               # Customer-facing views
  ├── css/                                   # Stylesheets
  └── js/                                    # JavaScript files

config/
  ├── app.php                                # Application configuration
  ├── database.php                           # Database connection settings
  ├── mail.php                               # Email configuration
  ├── auth.php                               # Authentication configuration
  └── ...                                    # Other configurations
```

## Core Features

### 1. Package Management
- Multiple catering packages with predefined menus
- Dynamic pricing based on guest count (price_per_pax)
- Active/Inactive status for packages
- Support for main packages and kids packages

**Available Packages:**
- **Package 01** (₹24/pax): Essential menu with basic items
- **Package 02** (₹28/pax): Enhanced menu with additional sides
- **Package 03** (₹30/pax): Premium menu with noodles and special items
- **Package 04** (₹35/pax): Deluxe menu with full variety

### 2. Menu Items & Addons
**Main Package Items:**
- Starters (Furandana, Bhuteko Chiura, Chicken Choila, Chicken Chilli)
- Sides (Piro Aalu, Aalu Aachar, Soyabean Sadheko)
- Proteins (Chicken Curry, Goat Curry, Fried Fish, Chicken Roast)
- Vegetables (Aalutama, Raajma, Aalu Cauli)
- Condiments (Tomato Achar, Lalmon)
- Rice Preparations (Pulau, Jeera Rice)

**Addon Menus:**
- Newa Mains Menu (₹20)
- Newari Specials
- Indian Specials
- Chinese Specials
- And more customizable addons

### 3. Order System
- Complete order creation and tracking
- Customer information capture (name, email, phone, address)
- Event details (date, time, guest count, venue)
- Package selection with item customization
- Addon item selection
- Kids menu selection and pricing
- Delivery charge calculation
- Order status tracking (Pending, Confirmed, Cancelled, Payment Done)
- Price breakdown (package total, addon total, delivery charge, grand total)

### 4. Payment Management
- Advance payment tracking
- Remaining balance calculation
- Payment status updates
- Support for partial and full payments

### 5. Email Notifications
- **Booking Confirmed**: Sent when admin confirms a booking
- **Booking Cancelled**: Sent when a booking is cancelled with reason
- Configurable email templates
- Automated mail queue system

### 6. Admin Dashboard
- Real-time booking overview
- Color-coded customer cards for easy identification
- Comprehensive booking details including:
  - Customer information (name, email, phone)
  - Event details (date, time, venue, guest count)
  - Menu selections and customizations
  - Payment information (advance, remaining, total)
  - Booking status and notes
- Quick status updates
- Booking search and filtering capabilities

## Database Schema

### Tables
- **users**: Registered customers and admin users
- **packages**: Catering package definitions
- **items**: Menu items available
- **package_items**: Many-to-many relationship between packages and items
- **package_item_groups**: Grouping of items within packages
- **orders**: Customer orders and event bookings
- **order_addon_items**: Addon items selected for specific orders
- **order_package_selections**: Customer's menu selections from main package
- **kids_order_items**: Special kids menu selections for orders
- **admins**: Admin user accounts

### Key Relationships
- Package → has many Items (through package_items)
- Package → has many Orders
- Order → belongs to Package
- Order → has many OrderAddonItems
- Order → has many OrderPackageSelections
- Order → has many KidsOrderItems
- Item → belongs to many Packages

## API Routes

### Customer Routes
- `GET /` - Home page with package listings
- `GET /reservation` - Reservation booking page
- `POST /orders` - Create new order/booking

### Admin Routes
- `GET /admin/login` - Admin login page
- `POST /admin/login` - Process admin login
- `GET /admin/dashboard` - Admin booking dashboard (Authenticated)
- `POST /admin/update-status` - Update booking status
- `GET /admin/logout` - Admin logout

## Admin Features

### Booking Dashboard
The admin dashboard provides a comprehensive view of all bookings with the following information:

**Booking Card Details:**
- Booking ID (BK-0001 format)
- Customer initials with color coding
- Customer name and email
- Event date and time
- Guest count
- Venue/Delivery address
- Total amount with formatting
- Current booking status
- Contact phone number
- Booking date
- Special notes

**Menu Information:**
- Main package items selected by customer
- Addon items added
- Kids menu selections
- Delivery charge applied

**Payment Information:**
- Advance amount paid
- Remaining amount due
- Grand total

### Status Management
Update booking status with options:
- **Pending**: New booking received
- **Confirmed**: Booking confirmed and accepted
- **Cancelled**: Booking cancelled by admin
- **Payment Done**: Full payment received

## Configuration

### Environment Variables (.env)
```env
APP_NAME="Newachen"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=newachen_db
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@newachen.com
MAIL_FROM_NAME="Newachen Catering"
```

### Mail Configuration
Update `config/mail.php` for email settings:
- Configure SMTP or local mail driver
- Set sender email and name
- Configure email templates in `resources/views/emails/`

### Database Configuration
Update `config/database.php` with your MySQL connection details.

## Running Migrations

Several database migrations have been added for features:
- Payment fields (advance and remaining amounts)
- Package item groups
- Package selections
- Kids order items
- Delivery charges

Run all migrations:
```bash
php artisan migrate
```

## Development

### Local Development
1. Ensure PHP, MySQL, and Node.js are installed
2. Follow the Installation steps above
3. Use `php artisan serve` for backend
4. Use `npm run dev` for frontend asset compilation

### Testing
```bash
php artisan test
```

### Building for Production
```bash
npm run build
php artisan optimize
```

## Support & Maintenance

For issues or feature requests, contact the development team or check the project documentation.

---

**Version**: 1.0.0  
**Last Updated**: April 2026  
**License**: All rights reserved
