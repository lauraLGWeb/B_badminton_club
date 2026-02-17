# 🏸 Blois Badminton Club

[![Symfony](https://img.shields.io/badge/Symfony-7.4-000000?style=flat&logo=symfony&logoColor=white)](https://symfony.com)
[![PHP](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)](https://www.mysql.com)
[![MongoDB](https://img.shields.io/badge/MongoDB-6.0-47A248?style=flat&logo=mongodb&logoColor=white)](https://www.mongodb.com)
[![Docker](https://img.shields.io/badge/Docker-20.10-2496ED?style=flat&logo=docker&logoColor=white)](https://www.docker.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat)](LICENSE)

> A comprehensive web application for managing a badminton club, developed as a final graduation project. This platform enables members to register, book training sessions, purchase equipment with size and gender variants, and stay updated with club news.

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
- [Testing](#-testing)
- [Professional Skills Validated](#-professional-skills-validated)
- [Roadmap](#️-roadmap)
- [License](#-license)
- [Contact](#-contact)

---

## 🎯 About the Project

**Blois Badminton Club** is a full-stack web application built with **Symfony 7.4**, combining both SQL and NoSQL databases. The project demonstrates modern web development practices including user authentication, role-based access control, e-commerce functionality with product variants (size/gender), secure online payment, and comprehensive testing.

This project is developed as part of my web development training program and aims to validate **8 professional competencies** required for the **Web and Mobile Web Application Developer** certification.

---

## ✨ Features

### 🌐 For All Users

- **Multilingual Support**: Switch between French and English
- **Dark Mode**: Toggle between light and dark themes
- **Responsive Design**: Optimized for desktop and mobile devices
- **Training Schedules**: View available time slots and pricing
- **News Feed**: Real-time updates stored in MongoDB
- **Contact Form**: Get in touch with the club with email notifications
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
- Purchase shuttlecocks and t-shirts with size and gender selection
- Secure online payment via Stripe
- Cart management with product variants
- Order history
- book an internship

### 👨‍🏫 For Trainers

- **All Member privileges** +
- Access to their training session schedules
- View registered participants for each session
- Send emails to participants or call them

### 👑 For Administrators

- **All previous role privileges** +
- **Member Management**: Register, modify, and delete members
- **Training Session Management**: Create and manage sessions with capacity limits
- **Registration Management**: Enroll members or external players to sessions
- **Inventory Management**: Add, modify, or delete products
- **News Management**: Create, edit, and delete news posts stored in MongoDB
- **Members Management** :  Accept new member, modify, or delete members
- **Full CRUD operations** on all entities

---

## 🛠️ Technologies Used

### Backend
- ![Symfony](https://img.shields.io/badge/Symfony-7.4-black?style=flat-square&logo=symfony) **Symfony 7.4** - PHP framework
- ![MySQL](https://img.shields.io/badge/MySQL-8.0-blue?style=flat-square&logo=mysql) **MySQL 8.0** - Relational database for users, products, orders
- ![MongoDB](https://img.shields.io/badge/MongoDB-6.0-green?style=flat-square&logo=mongodb) **MongoDB 6.0** - NoSQL database for news/actualités
- **Doctrine ORM** - SQL database abstraction layer
- **Doctrine MongoDB ODM** - MongoDB document mapper

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling with neomorphism design
- **Vanilla JavaScript** - Client-side interactivity and form validation
- **Responsive Design** - Mobile-first approach with CSS

### Payment Integration
- **Stripe API** - Secure online payment processing for shop purchases

### Testing
- **PHPUnit** - Unit and functional testing
- **Test fixtures** - Automated test data generation
- **Separate test database** - Isolated test environment env.test.local

### Development Environment
- **Docker & Docker Compose** - Containerized development environment
- **PHP 8.1** - Modern PHP features
- **Composer** - PHP dependency management
- **Git/GitHub** - Version control with feature branches workflow

---

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

| Requirement | Version |
|------------|---------|
| **Docker** | 20.10+ |
| **Docker Compose** | 2.0+ |
| **Git** | Latest version |

*All other dependencies (PHP, Composer, MySQL, MongoDB) are handled by Docker.*

---

## 🚀 Installation

### 1️⃣ Clone the repository
```bash
git clone https://github.com/lauraLGWeb/blois-badminton-club.git
cd blois-badminton-club
```

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
```bash
cp .env .env.local
```

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
php bin/console doctrine:migrations:migrate

# Load fixtures (optional - for test data)
php bin/console doctrine:fixtures:load
```

### 6️⃣ Access the application

✅ **Application**: `http://localhost:8081`  
✅ **phpMyAdmin**: `http://localhost:8899`

**Default test accounts** (if fixtures loaded):
- **Admin**: `buisson.francois@example.com` / Password: `Motdepasse123`
- **Trainer**: `buisson.francois@example.com` / Password: `Motdepasse123`
- **Member**: `dguillon@example.net` / Password: `Motdepasse123`

---

## 🗄️ Database Configuration

### 💾 SQL Database (MySQL)

The relational database handles:

- User accounts and authentication (Security)
- Member profiles and roles (User, roles)
- Training sessions and registrations (Stage, Inscription)
- Products with variants (Product, hasSize)
- Shopping cart with size/gender (Cart, CartItem with size/gender fields)
- Orders and transactions (Cart, isPaid)
- Partners and sponsors

### 📊 NoSQL Database (MongoDB)

The NoSQL database handles:

- News posts and announcements (Actualite document)
- Article metadata (title, description, dates)


---

## 👥 User Roles

The application implements **three distinct user roles** with specific permissions:

| Role | Description | Access Level |
|------|-------------|--------------|
| **👤 Visitor** | No ROLE | Non-authenticated user | View public pages, contact form, registration links |
| **🏅 Member** | ROLE_MEMBRE | Authenticated club member | Visitor access + shop with cart and payment + internship access|
| **👨‍🏫 Trainer** | ROLE_ENTRAINEUR | Club trainer | Member access + session schedules and participant contact |
| **👑 Admin** | ROLE_ADMIN | Administrator | Full access - all CRUD operations |

### 📊 Role Hierarchy
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
## 🧪 Testing

The application includes comprehensive **PHPUnit tests** covering critical features.

### Running Tests
```bash
# Inside the PHP container
docker compose exec php bash

# Run all tests
php bin/phpunit

# Run specific test exemple
php bin/phpunit tests/Controller/HomeControllerTest.php
```
---

## 🎓 Professional Skills Validated

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

---

## 🗓️ Roadmap

### ✅ Phase 1: Design & Planning (Completed)

- [x] Create MCD (Conceptual Data Model)
- [x] Create MLD (Logical Data Model)
- [x] Create MPD (Physical Data Model)
- [x] Activity diagrams (shopping, registration, news)
- [x] Use case diagrams
- [x] Homepage wireframe and zoning
- [x] Shop page wireframe and zoning

### ✅ Phase 2: Development (100% Completed)

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

- [x] Multilingual support (FR/EN) - i18n
- [x] Social media feed integration (Facebook asked by the Club Manager)
- [ ] Email notifications for training sessions

**🎯 Coding deadline**: January 20, 2025  
**📅 Final examination**: February 25, 2025

---

## 📝 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

---

## 📧 Contact

**Project developed by**: Laura Le Gall

- 🐙 **GitHub**: [@lauraLGWeb](https://github.com/lauraLGWeb)
- 💼 **LinkedIn**: [Laura Le Gall - Web Developer](https://www.linkedin.com/in/laura-le-gall-web-dev/)

**🎓 Training Program**: Web and Mobile Web Application Developer (DWWM - Niveau 5)  
**🏫 Institution**: École Européenne du Numérique  
**📚 Project Type**: Final Graduation Project

---

<div align="center">

*This project demonstrates full-stack web development competencies including Symfony framework mastery, dual database architecture (SQL + NoSQL), secure payment integration, comprehensive testing, and Docker containerization.*

**Made with ❤️, Symfony and Docker**

</div>