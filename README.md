## PET MANAGEMENT SYSTEM

Made with Laravel 10, Codeigniter and MySql.

![Dashboard](https://github.com/ReuAzel181/PetFurme/blob/main/public/assets/img2/image.png)

## 💀 Design Database
![Diagram Class](https://github.com/fajarghifar/inventory-management-system/assets/71541409/0c7d4163-96f5-4724-8741-4615e52ecf98)

## 😎 Features
- **Pet Management**
  - Add, update, and delete pet profiles
  - View pet details and history
- **Pet Owners**
  - Manage pet owner profiles
  - Link pets to their respective owners
- **Appointments**
  - Schedule and manage appointments for pets
  - View appointment history
- **Products**
  - Manage pet-related products
  - View product details and stock levels
- **Orders**
  - Create and manage orders
  - View order status and history
- **Reports**
  - Generate reports on pets, orders, and products
- **User Management**
  - Admin and sub-admin roles
  - Manage user access and permissions

## Environemt & Dependencies
  - Composer
  - Node.js

## List of Installed Packages
    - @tabler/core@1.0.0-beta20
    - autoprefixer@10.4.16
    - axios@1.6.2
    - js-beautify@1.15.1
    - laravel-datatables-vite@0.5.2
    - laravel-vite-plugin@0.7.8
    - postcss@8.4.31
    - tailwindcss@3.3.5
    - vite-plugin-static-copy@0.17.1
    - vite@4.5.3

## 🚀 How to Use

1. Clone Repository

```bash
git clone https://github.com/fajarghifar/inventory-management-system
```

2. Go into the repository 

```bash
cd inventory-management-system
```

3. Install Packages 

```bash
composer install
```


4. Copy `.env` file 

```bash

cp .env.example .env

```

5. Generate app key 

```bash
php artisan key:generate
```

6. Setting up your database credentials in your `.env` file.
7. Seed Database: 

```bash

php artisan migrate:fresh --seed

```
8. Create Storage Link

```bash
php artisan storage:link
```

9. Install NPM dependencies 

```bash

npm install && npm run dev

```
10. Run 

```bash

php artisan serve

```
11. Try login with email: 

```bash

1. admin@admin.com
2. quest@quest.com
3. user@user.com

```
and password: 

```bash

1. password
2. quest
3. user
```
# 🤝 License

### [MIT](LICENSE)
> Orig Repo from @fajarghifar
> Github [@fajarghifar](https://github.com/fajarghifar) &nbsp;&middot;&nbsp;
> Instagram [@fajarghifar](https://instagram.com/fajarghifar)
