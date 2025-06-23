# PetFurme - Pet Management System

A comprehensive pet management system built with Laravel 10, featuring pet profiles, appointments, products, orders, and user management.

![Dashboard](https://github.com/ReuAzel181/PetFurme/blob/main/public/assets/img2/image8.png)

![Dashboard](https://github.com/ReuAzel181/PetFurme/blob/main/public/assets/img2/image9.png)

## 🚀 Features

### Core Functionality
- **🐾 Pet Management:** Add, update, delete pet profiles with detailed information and history tracking
- **👥 Pet Owners:** Manage owner profiles and link pets to their respective owners
- **📅 Appointments:** Schedule and manage veterinary appointments with history tracking
- **🛍️ Products:** Manage pet products with inventory tracking and stock management
- **📦 Orders:** Create and manage orders with status tracking and order history
- **📊 Reports:** Generate comprehensive reports on pets, orders, and products
- **👤 User Management:** Role-based access control with admin and sub-admin permissions

### Additional Features
- **🔐 Authentication:** Secure user authentication and authorization
- **📱 Responsive Design:** Mobile-friendly interface using modern UI components
- **📈 Analytics:** Dashboard with key metrics and insights
- **🔔 Notifications:** Email notifications for appointments and system alerts
- **📄 Invoice Generation:** Automatic invoice creation for orders
- **🖼️ File Management:** Image upload and storage for pets and products

## 🛠️ Technology Stack

### Backend
- **Laravel 10** - PHP framework
- **MySQL** - Database
- **PHP 8.1+** - Server-side language

### Frontend
- **Tailwind CSS** - Utility-first CSS framework
- **Tabler UI** - Modern UI components
- **Livewire** - Full-stack framework for Laravel
- **Alpine.js** - Lightweight JavaScript framework

### Development Tools
- **Vite** - Build tool and development server
- **Composer** - PHP dependency management
- **Node.js & NPM** - JavaScript package management

## 📦 Dependencies

### UI & Styling
- `@tabler/core` - Modern UI kit
- `tailwindcss` - Utility-first CSS framework
- `autoprefixer` - CSS vendor prefixing
- `postcss` - CSS processing

### HTTP & Data
- `axios` - HTTP client for API requests
- `laravel-datatables-vite` - DataTables integration
- `laravel-vite-plugin` - Laravel Vite integration

### Development
- `js-beautify` - Code formatting
- `vite` - Build tool

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & NPM
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Step-by-Step Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/ReuAzel181/PetFurme.git
   cd PetFurme
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```
   
   Update your `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=petfurme
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Run Database Migrations & Seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Install NPM Dependencies**
   ```bash
   npm install
   ```

8. **Build Assets**
   ```bash
   npm run dev
   ```

9. **Start Development Server**
   ```bash
   php artisan serve
   ```

10. **Access the Application**
    Visit `http://localhost:8000` in your browser

## 🔐 Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@admin.com` | `password` |
| Quest | `quest@quest.com` | `quest` |
| User | `user@user.com` | `user` |

## 📁 Project Structure

```
PetFurme/
├── app/
│   ├── Http/Controllers/    # Application controllers
│   ├── Models/             # Eloquent models
│   ├── Livewire/           # Livewire components
│   └── ...
├── database/
│   ├── migrations/         # Database migrations
│   ├── seeders/           # Database seeders
│   └── factories/         # Model factories
├── resources/
│   ├── views/             # Blade templates
│   ├── css/               # Stylesheets
│   └── js/                # JavaScript files
├── routes/                # Application routes
└── public/                # Public assets
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

If you encounter any issues or have questions:

1. Check the [Issues](https://github.com/ReuAzel181/PetFurme/issues) page
2. Create a new issue with detailed information
3. Contact the maintainers

## 🙏 Acknowledgments

- Laravel team for the amazing framework
- Tabler UI for the beautiful components
- All contributors who helped improve this project

---

**Made with ❤️ by the PetFurme Team**