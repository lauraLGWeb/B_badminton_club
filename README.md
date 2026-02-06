# 🏸 Blois Badminton Club

[![Symfony](https://img.shields.io/badge/Symfony-7.4-000000?style=flat&logo=symfony&logoColor=white)](https://symfony.com)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com)
[![MongoDB](https://img.shields.io/badge/MongoDB-6.0-47A248?style=flat&logo=mongodb&logoColor=white)](https://www.mongodb.com)
<<<<<<< HEAD
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat)](LICENSE)

> A comprehensive web application for managing a badminton club, developed as a final graduation project. This platform enables members to register, book training sessions, purchase equipment, and stay updated with club news.
=======
[![Docker](https://img.shields.io/badge/Docker-20.10-2496ED?style=flat&logo=docker&logoColor=white)](https://www.docker.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat)](LICENSE)

> A comprehensive web application for managing a badminton club, developed as a final graduation project. This platform enables members to register, book training sessions, purchase equipment with size and gender variants, and stay updated with club news.
>>>>>>> dev

---

## 📋 Table of Contents

- [About the Project](#-about-the-project)
- [Features](#-features)
- [Technologies Used](#️-technologies-used)
- [Prerequisites](#-prerequisites)
- [Installation](#-installation)
- [Database Configuration](#️-database-configuration)
- [User Roles](#-user-roles)
- [Project Structure](#-project-structure)
<<<<<<< HEAD
=======
- [Testing](#-testing)
>>>>>>> dev
- [Professional Skills Validated](#-professional-skills-validated)
- [Roadmap](#️-roadmap)
- [License](#-license)
- [Contact](#-contact)

---

## 🎯 About the Project

<<<<<<< HEAD
**Blois Badminton Club** is a full-stack web application built with **Symfony 7.4**, combining both SQL and NoSQL databases. The project demonstrates modern web development practices including user authentication, role-based access control, e-commerce functionality, and social media integration.
=======
**Blois Badminton Club** is a full-stack web application built with **Symfony 7.4**, combining both SQL and NoSQL databases. The project demonstrates modern web development practices including user authentication, role-based access control, e-commerce functionality with product variants (size/gender), secure online payment, and comprehensive testing.
>>>>>>> dev

This project is developed as part of my web development training program and aims to validate **8 professional competencies** required for the **Web and Mobile Web Application Developer** certification.

---

## ✨ Features

### 🌐 For All Users

- **Multilingual Support**: Switch between French and English
- **Dark Mode**: Toggle between light and dark themes
- **Responsive Design**: Optimized for desktop and mobile devices
- **Training Schedules**: View available time slots and pricing
<<<<<<< HEAD
- **News Feed**: Real-time updates from social media (Facebook/Instagram integration)
- **Contact Form**: Get in touch with the club
=======
- **News Feed**: Real-time updates stored in MongoDB
- **Contact Form**: Get in touch with the club with email notifications
>>>>>>> dev
- **FAQ Section**: Accordion-style frequently asked questions
- **Partner Showcase**: View sponsors with clickable redirects
- **Junior Badminton**: Dedicated page for children's programs

### 👤 For Visitors (Non-authenticated)

- View club information and schedules
- Register for club membership (redirect to FFBAD website)
- Request a trial session via contact form

### 🏅 For Members (Authenticated)

- **All Visitor privileges** +
- Access to the club shop
<<<<<<< HEAD
- Purchase shuttlecocks and t-shirts
- Online payment or pre-order for in-person payment

=======
- Purchase shuttlecocks and t-shirts with size and gender selection
- Secure online payment via Stripe
- Cart management with product variants
- Order history
>>>>>>> dev

### 👨‍🏫 For Trainers

- **All Member privileges** +
- Access to their training session schedules
- View registered participants for each session
- Send emails to participants

### 👑 For Administrators

- **All previous role privileges** +
- **Member Management**: Register, modify, and delete members
- **Training Session Management**: Create and manage sessions with capacity limits
- **Registration Management**: Enroll members or external players to sessions
- **Inventory Management**: Add, modify, or delete products
<<<<<<< HEAD
- **News Management**: Create, edit, and delete news posts
- **Stock Management**: Track product availability
=======
- **News Management**: Create, edit, and delete news posts stored in MongoDB
- **Members Management** :  Accept new member, modify, or delete members
>>>>>>> dev
- **Full CRUD operations** on all entities

---

## 🛠️ Technologies Used

### Backend
<<<<<<< HEAD
- ![Symfony](https://img.shields.io/badge/Symfony-7.4-black?style=flat-square&logo=symfony) **Symfony 8.0** - PHP framework
- ![MySQL](https://img.shields.io/badge/MySQL-8.0-blue?style=flat-square&logo=mysql) **MySQL** - Relational database (via MAMP)
- ![MongoDB](https://img.shields.io/badge/MongoDB-6.0-green?style=flat-square&logo=mongodb) **MongoDB** - NoSQL database for news/posts
- **Doctrine ORM** - Database abstraction layer

### Frontend
- **HTML5** - Markup language
- **CSS3** - Styling
- **Vanilla JavaScript** - Client-side interactivity
- **No framework** - Pure JavaScript implementation

### Payment Integration
- Online payment gateway for credit card transactions *(implementation in progress)*

### Additional Tools
- **Composer** - PHP dependency management
- **Docker** - development environment
- **Git/GitHub** - Version control
=======
- ![Symfony](https://img.shields.io/badge/Symfony-7.4-black?style=flat-square&logo=symfony) **Symfony 7.4** - PHP framework
- ![MySQL](https://img.shields.io/badge/MySQL-8.0-blue?style=flat-square&logo=mysql) **MySQL 8.0** - Relational database for users, products, orders
- ![MongoDB](https://img.shields.io/badge/MongoDB-6.0-green?style=flat-square&logo=mongodb) **MongoDB 6.0** - NoSQL database for news/actualités
- **Doctrine ORM** - SQL database abstraction layer
- **Doctrine MongoDB ODM** - MongoDB document mapper

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling with neomorphism design
- **Vanilla JavaScript** - Client-side interactivity and form validation
- **Responsive Design** - Mobile-first approach

### Payment Integration
- **Stripe API** - Secure online payment processing for shop purchases

### Testing
- **PHPUnit** - Unit and functional testing
- **Test fixtures** - Automated test data generation
- **Separate test database** - Isolated test environment

### Development Environment
- **Docker & Docker Compose** - Containerized development environment
- **PHP 8.1** - Modern PHP features
- **Composer** - PHP dependency management
- **Git/GitHub** - Version control with feature branches workflow
>>>>>>> dev

---

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

| Requirement | Version |
|------------|---------|
<<<<<<< HEAD
| **PHP** | 7.4 or higher |
| **Composer** | Latest version |
| **MySQL** | 8.0 or higher (via MAMP or standalone) |
| **MongoDB** | 6.0 or higher |
| **Node.js & NPM** | For potential frontend dependencies |
| **Docker** |
=======
| **Docker** | 20.10+ |
| **Docker Compose** | 2.0+ |
| **Git** | Latest version |

*All other dependencies (PHP, Composer, MySQL, MongoDB) are handled by Docker.*

>>>>>>> dev
---

## 🚀 Installation

### 1️⃣ Clone the repository
<<<<<<< HEAD

=======
>>>>>>> dev
```bash
git clone https://github.com/lauraLGWeb/blois-badminton-club.git
cd blois-badminton-club
```

<<<<<<< HEAD
### 2️⃣ Install PHP dependencies

```bash
composer install
```

### 3️⃣ Configure environment variables

Copy the `.env` file and configure your database credentials:

=======
### 2️⃣ Start Docker containers
```bash
docker compose up -d
```

This will start:
- PHP 8.1 container
- MySQL 8.0 container
- MongoDB 6.0 container
- phpMyAdmin (accessible at `http://localhost:8899`)

### 3️⃣ Install PHP dependencies
```bash
docker compose exec php bash
composer install
```

### 4️⃣ Configure environment variables

The `.env` file is already configured for Docker. For production deployment, copy and modify:
>>>>>>> dev
```bash
cp .env .env.local
```

<<<<<<< HEAD
Edit `.env.local` and update the following variables:

```env
# MySQL Configuration
DATABASE_URL="mysql://db_user:db_password@database/blois_badminton?serverVersion=8.0"

# MongoDB Configuration
MONGODB_URL="mongodb://localhost:27017"
MONGODB_DB="blois_badminton_news"

# Mailer Configuration (for contact forms)
MAILER_DSN=smtp://localhost

# Payment Gateway Configuration (to be configured)
PAYMENT_API_KEY=your_payment_api_key
```

### 4️⃣ Create the databases

```bash
# Create MySQL database
php bin/console doctrine:database:create

# Run migrations
=======
Key environment variables:
```env
# MySQL Configuration (Docker)
DATABASE_URL="mysql://root:root@database:3306/blois_badminton?serverVersion=8.0.32"

# MongoDB Configuration (Docker)
MONGODB_URL=mongodb://mongodb:27017
MONGODB_DB=blois_badminton

# Stripe Payment Configuration
STRIPE_PUBLIC_KEY=your_stripe_public_key
STRIPE_SECRET_KEY=your_stripe_secret_key

# Mailer Configuration
MAILER_DSN=gmail+smtp://your-email@gmail.com:your-app-password@default

# Test Key environment variables
# .env.test for test configuration
APP_ENV=test

# .env.test.local  -connection to the database
DATABASE_URL="mysql://root:root@database:3306/blois_badminton_test?serverVersion=8.0.32"
```

### 5️⃣ Create the databases
```bash
# Inside the PHP container
php bin/console doctrine:database:create
>>>>>>> dev
php bin/console doctrine:migrations:migrate

# Load fixtures (optional - for test data)
php bin/console doctrine:fixtures:load
```

<<<<<<< HEAD
⚠️ **Important**: Ensure your MongoDB service is running before proceeding.

### 5️⃣ Start the development server

**Using Symfony CLI** *(recommended)*:
```bash
symfony server:start
```

**Or using PHP's built-in server**:
```bash
php -S localhost:8000 -t public/
```

✅ The application should now be accessible at `http://localhost:8000`
=======
### 6️⃣ Access the application

✅ **Application**: `http://localhost:8081`  
✅ **phpMyAdmin**: `http://localhost:8899`

**Default test accounts** (if fixtures loaded):
- **Admin**: `genevieve50@example.com` / Password: `motdepasse123!`
- **Trainer**: `audrey04@example.net` / Password: `motdepasse123!`
- **Member**: `aime.meyer@example.org` / Password: `motdepasse123!`
>>>>>>> dev

---

## 🗄️ Database Configuration

### 💾 SQL Database (MySQL)

The relational database handles:

<<<<<<< HEAD
- User accounts and authentication
- Member profiles and roles
- Training sessions and registrations
- Products and inventory
- Orders and transactions
=======
- User accounts and authentication (Security)
- Member profiles and roles (User, roles)
- Training sessions and registrations (Stage, Inscription)
- Products with variants (Product, hasSize)
- Shopping cart with size/gender (Cart, CartItem with size/gender fields)
- Orders and transactions (Cart, isPaid)
>>>>>>> dev
- Partners and sponsors

### 📊 NoSQL Database (MongoDB)

The NoSQL database handles:

<<<<<<< HEAD
- News posts and announcements
- Social media feed integration
- Real-time event updates
=======
- News posts and announcements (Actualite document)
- Article metadata (title, description, dates)

>>>>>>> dev

---

## 👥 User Roles

<<<<<<< HEAD
The application implements **four distinct user roles** with specific permissions:

| Role | Description | Access Level |
|------|-------------|--------------|
| **👤 Visitor** | Non-authenticated user | View public pages, contact form, registration links |
| **🏅 Member** | Authenticated club member | Visitor access + shop access |
| **👨‍🏫 Trainer** | Club trainer | Member access + session schedules and participant lists with email contact |
| **👑 Admin** | Administrator | Full access - manage users, sessions, products, registrations, and news |

### 📊 Role Hierarchy

=======
The application implements **three distinct user roles** with specific permissions:

| Role | Description | Access Level |
|------|-------------|--------------|
| **👤 Visitor** | No ROLE | Non-authenticated user | View public pages, contact form, registration links |
| **🏅 Member** | ROLE_MEMBRE | Authenticated club member | Visitor access + shop with cart and payment |
| **👨‍🏫 Trainer** | ROLE_ENTRAINEUR | Club trainer | Member access + session schedules and participant contact |
| **👑 Admin** | ROLE_ADMIN | Administrator | Full access - all CRUD operations |

### 📊 Role Hierarchy
>>>>>>> dev
```
        👑 Admin
           ↓
      👨‍🏫 Trainer
           ↓
       🏅 Member
           ↓
       👤 Visitor
```

---
<<<<<<< HEAD

## 📁 Project Structure

```
blois-badminton-club/
├── 📂 config/              # Configuration files
├── 📂 public/              # Public assets (CSS, JS, images)
│   ├── 📂 css/
│   ├── 📂 js/
│   └── 📂 images/
├── 📂 src/
│   ├── 📂 Controller/      # Symfony controllers
│   ├── 📂 Entity/          # Doctrine entities
│   ├── 📂 Form/            # Form types
│   ├── 📂 Repository/      # Database repositories
│   └── 📂 Service/         # Business logic services
├── 📂 templates/           # Twig templates
├── 📂 migrations/          # Database migrations
├── 📂 var/                 # Cache and logs
├── 📂 vendor/              # Composer dependencies
├── 📄 .env                 # Environment variables template
├── 📄 .env.local           # Local environment variables (not committed)
├── 📄 composer.json        # PHP dependencies
└── 📄 README.md            # This file
=======
## 🧪 Testing

The application includes comprehensive **PHPUnit tests** covering critical features.

### Running Tests
```bash
# Inside the PHP container
docker compose exec php bash

# Run all tests
php bin/phpunit

# Run specific test exemple
php bin/phpunit tests/Controller/CartControllerTest.php
```

### Test Configuration

Tests use a dedicated test database configured in `phpunit.xml.dist`:
```xml

>>>>>>> dev
```

---

## 🎓 Professional Skills Validated

<<<<<<< HEAD
This project validates the following **8 professional competencies (UC)** required for the **Web and Mobile Web Application Developer** certification:

### 📱 Activity Type 1: Develop the front-end of a secure web or mobile web application

| CP | Competency |
|----|------------|
| **CP1** | Install and configure the work environment according to the web or mobile web project |
| **CP2** | Create mockups for web or mobile web user interfaces |
| **CP3** | Develop static web or mobile web user interfaces |
| **CP4** | Develop the dynamic part of web or mobile web user interfaces |

### ⚙️ Activity Type 2: Develop the back-end of a secure web or mobile web application

| CP | Competency |
|----|------------|
| **CP5** | Set up a relational database (MySQL) |
| **CP6** | Develop data access components for SQL and NoSQL (MySQL + MongoDB) |
| **CP7** | Develop server-side business components (Symfony services) |
| **CP8** | Document the deployment of a dynamic web or mobile web application |
=======
This project validates the following **8 professional competencies (UC)** required for the **Web and Mobile Web Application Developer** certification (DWWM - Niveau 5):

### 📱 Activity Type 1: Develop the front-end of a secure web or mobile web application

| CP | Competency | Implementation |
|----|------------|----------------|
| **CP1** | Install and configure the work environment | Docker environment with PHP, MySQL, MongoDB |
| **CP2** | Create mockups for user interfaces | Wireframes and zoning for all pages |
| **CP3** | Develop static user interfaces | HTML5/CSS3 with neomorphism design |
| **CP4** | Develop dynamic user interfaces | JavaScript form validation and interactivity |

### ⚙️ Activity Type 2: Develop the back-end of a secure web or mobile web application

| CP | Competency | Implementation |
|----|------------|----------------|
| **CP5** | Set up a relational database | MySQL with migrations and fixtures |
| **CP6** | Develop data access components (SQL/NoSQL) | Doctrine ORM + MongoDB ODM repositories |
| **CP7** | Develop server-side business components | Symfony services and controllers |
| **CP8** | Document application deployment | Complete README with Docker setup |
>>>>>>> dev

---

## 🗓️ Roadmap

### ✅ Phase 1: Design & Planning (Completed)

- [x] Create MCD (Conceptual Data Model)
- [x] Create MLD (Logical Data Model)
- [x] Create MPD (Physical Data Model)
<<<<<<< HEAD
- [x] Homepage wireframe and zoning
- [x] Second page wireframe and zoning

### 🚧 Phase 2: Development (In Progress)

- [ ] Database setup (SQL + NoSQL)
- [ ] User authentication system
- [ ] Role-based access control
- [ ] Training session management
- [ ] Shop and product catalog
- [ ] Payment integration
- [ ] News feed with MongoDB
- [ ] Multilingual support (FR/EN)
- [ ] Dark mode implementation
- [ ] Contact form and FAQ
- [ ] Social media integration

### 🎯 Phase 3: Testing & Deployment

- [ ] Unit tests
- [ ] Integration tests
- [ ] User acceptance testing
- [ ] Documentation completion
- [ ] Deployment preparation

**🎯 Target completion**: End of January 2025  
**📅 Final submission**: End of February 2025
=======
- [x] Activity diagrams (shopping, registration, news)
- [x] Use case diagrams
- [x] Homepage wireframe and zoning
- [x] Shop page wireframe and zoning

### ✅ Phase 2: Development (90% Completed)

- [x] Docker environment setup
- [x] Database setup (MySQL + MongoDB)
- [x] User authentication system with Symfony Security
- [x] Role-based access control (4 roles)
- [x] Training session management (CRUD)
- [x] Shop with product variants (size, gender)
- [x] Shopping cart with variant management
- [x] Payment integration with Stripe API
- [x] News feed with MongoDB and Doctrine ODM
- [x] Contact form with email notifications
- [x] FAQ accordion section
- [x] Dark mode implementation
- [x] Neomorphism design system
- [x] Git workflow with feature branches

### 🚧 Phase 3: Testing & Finalization (In Progress)

- [x] PHPUnit configuration
- [x] Test database setup
- [x] Functional tests for CartController
- [x] Complete functional tests for ActualityController
- [x] User acceptance testing
- [x] Professional documentation (dossier de projet)
- [ ] Oral presentation preparation
- [ ] Final code review and refactoring

### 🎯 Phase 4: Optional Enhancements

- [ ] Multilingual support (FR/EN) - i18n
- [x] Social media feed integration (Facebook asked by the Club Manager)
- [ ] Advanced stock management
- [ ] Email notifications for training sessions

**🎯 Coding deadline**: January 20, 2025  
**📅 Final examination**: February 25, 2025
>>>>>>> dev

---

## 📝 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

---

## 📧 Contact

**Project developed by**: Laura Le Gall

- 🐙 **GitHub**: [@lauraLGWeb](https://github.com/lauraLGWeb)
- 💼 **LinkedIn**: [Laura Le Gall - Web Developer](https://www.linkedin.com/in/laura-le-gall-web-dev/)

<<<<<<< HEAD
**🎓 Training Program**: Web and Mobile Web Application Developer  
=======
**🎓 Training Program**: Web and Mobile Web Application Developer (DWWM - Niveau 5)  
>>>>>>> dev
**🏫 Institution**: École Européenne du Numérique  
**📚 Project Type**: Final Graduation Project

---

<div align="center">

<<<<<<< HEAD
*This project is part of a professional certification training program and demonstrates competencies in full-stack web development, database management, and secure application architecture.*

**Made with ❤️ and Symfony**

</div>
=======
*This project demonstrates full-stack web development competencies including Symfony framework mastery, dual database architecture (SQL + NoSQL), secure payment integration, comprehensive testing, and Docker containerization.*

**Made with ❤️, Symfony and Docker**

</div>
>>>>>>> dev
