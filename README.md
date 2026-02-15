# Assignment -03 [BookStock - Book Management System]

A modern web application for managing books, authors, and categories built with **Laravel 11** and **Tailwind CSS**.

**GitHub Repository**: [https://github.com/sagarkhan04/BookStock](https://github.com/sagarkhan04/BookStock)

### Name : Sagar

### Email: sagar.cmt1920@gmail.com

## 📋 Project Overview

BookStock is a comprehensive book inventory management system that allows users to:

- **Manage Books**: Create, read, update, and delete books with detailed information (title, ISBN, description, cover image, publication date)
- **Manage Authors**: Create, read, update, delete authors with biographies
- **Manage Categories**: Create, read, update, delete book categories with descriptions
- **User Authentication**: Secure login and registration system
- **User Profiles**: Edit profile information and change passwords
- **Status Management**: Toggle active/inactive status for categories and authors
- **Book Relationships**: Associate books with authors and categories with book count tracking

## 🛠 Tech Stack

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Blade Templates + Tailwind CSS
- **Authentication**: Laravel Built-in Auth
- **Routing**: RESTful Resource Routes

## 📁 Project Structure

```
BookStock/
├── app/Http/Controllers/
│   ├── AuthController.php          # Authentication (login/signup)
│   ├── BookController.php          # Book CRUD operations
│   ├── CategoryController.php       # Category CRUD + toggleStatus
│   ├── AuthorController.php         # Author CRUD + toggleStatus
│   └── ProfileController.php        # User profile & password management
├── database/
│   ├── migrations/                 # Database schema
│   └── seeders/                    # Database seeders
├── resources/views/
│   ├── backend/                    # Admin dashboard views
│   └── components/                 # Reusable components (sidebar)
├── routes/
│   └── web.php                     # Application routes
└── public/                         # Public assets
```

## 🚀 How to Run the Project

### Prerequisites
- PHP 8.2+
- Composer
- MySQL 8.0+
- Node.js & npm (optional, for asset compilation)

### Installation Steps

1. **Clone/Setup the project**
   ```bash
   cd e:\Interactivecares\assignment\BookStock
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Create environment file**
   ```bash
   cp .env.example .env
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Configure database in `.env`**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bookstock
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Create database**
   ```bash
   mysql -u root -p -e "CREATE DATABASE bookstock;"
   ```

7. **Run migrations**
   ```bash
   php artisan migrate
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

9. **Access the application**
   - Open browser: `http://127.0.0.1:8000`
   - Default route redirects to login page

## 📝 Default User Credentials

After seeding (if seeders are run):
```
Email: test@example.com
Password: password
```

## 🔑 Key Features

| Feature | Status | Details |
|---------|--------|---------|
| Book Management | ✅ Complete | Full CRUD with author & category relations |
| Author Management | ✅ Complete | CRUD + Active/Inactive toggle |
| Category Management | ✅ Complete | CRUD + Description field + Active/Inactive toggle |
| User Authentication | ✅ Complete | Login, Signup, Logout |
| User Profile | ✅ Complete | Edit profile, Change password |
| Book Count Tracking | ✅ Complete | Shows count of books per author/category |
| Status Management | ✅ Complete | Toggle author/category status |
| Dynamic Sidebar | ✅ Complete | Shared component with active route highlighting |
| Responsive Design | ✅ Complete | Tailwind CSS with mobile support |
| Form Validation | ✅ Complete | Server-side validation with error display |
| Flash Messages | ✅ Complete | Success/error notifications |

## 📊 Database Schema

### Users Table
- id, name, email, password, timestamps

### Authors Table
- id, name, bio, is_active, timestamps

### Categories Table
- id, name, description, is_active, timestamps

### Books Table
- id, title, isbn, description, published_at, cover_image, category_id, author_id, timestamps

## 🔗 API Routes

### Authentication
- `GET /login` - Login form
- `POST /login` - Process login
- `GET /signup` - Registration form
- `POST /signup` - Process registration

### Dashboard
- `GET /` - Dashboard home

### Books
- `GET /books` - List all books
- `GET /books/create` - Create form
- `POST /books` - Store book
- `GET /books/{id}` - Show book details
- `GET /books/{id}/edit` - Edit form
- `PUT /books/{id}` - Update book
- `DELETE /books/{id}` - Delete book

### Categories
- `GET /categories` - List all categories
- `GET /categories/create` - Create form
- `POST /categories` - Store category
- `GET /categories/{id}` - Show category
- `GET /categories/{id}/edit` - Edit form
- `PUT /categories/{id}` - Update category
- `DELETE /categories/{id}` - Delete category
- `POST /categories/{id}/toggle-status` - Toggle active/inactive

### Authors
- `GET /authors` - List all authors
- `GET /authors/create` - Create form
- `POST /authors` - Store author
- `GET /authors/{id}` - Show author
- `GET /authors/{id}/edit` - Edit form
- `PUT /authors/{id}` - Update author
- `DELETE /authors/{id}` - Delete author
- `POST /authors/{id}/toggle-status` - Toggle active/inactive

### Profile
- `GET /profile/edit` - Edit profile form
- `POST /profile/update` - Update profile
- `GET /password/change` - Change password form
- `POST /password/update` - Update password


