## SEGHIS PATIENT PORTAL

This Laravel application follows **MVC + Clean Architecture principles**, separating concerns into **Controllers**, **Services**, and **Repositories**. This ensures the codebase is modular, maintainable, and testable.

---

## 📂 MVC + Clean Architecture
<img width="543" height="733" alt="image" src="https://github.com/user-attachments/assets/3a2c17e1-e776-4d05-bf36-89995d435463" />

---

## 📂 Directory Structure
<img width="756" height="280" alt="image" src="https://github.com/user-attachments/assets/91254218-4d2a-4cf1-9521-b41330dac75c" />

---

## 🏗 Architecture Overview

This application separates responsibilities into layers:

1. **Controller Layer**  
   - Handles HTTP requests and responses.  
   - No business logic or database queries are performed here.  
   - Example: `DashboardController.php`

2. **Service Layer**  
   - Contains all business logic.  
   - Handles any data transformation, validation, or orchestration.  
   - Example: `DashboardService.php`

3. **Repository Layer**  
   - Handles all database access via Eloquent models.  
   - Provides a clean interface for services to retrieve or persist data.  
   - Examples: `AppointmentRepository.php`, `NotificationRepository.php`

---

## ✅ Benefits of this Clean Architecture

- **Separation of Concerns** – Each layer has a single responsibility.  
- **Testability** – Services and repositories can be tested independently of controllers.  
- **Reusability** – Business logic in services can be reused across different controllers or commands.  
- **Maintainability** – Easier to extend or modify without affecting other layers.  

---

## ⚡ Example Flow

1. `DashboardController` receives the HTTP request.  
2. It calls `DashboardService` to get business data.  
3. `DashboardService` fetches data from `AppointmentRepository` and `NotificationRepository`.  
4. The controller returns a Blade view with the formatted data.

---

## 🔧 Installation

```bash
git clone <repository-url>
cd project-folder
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
