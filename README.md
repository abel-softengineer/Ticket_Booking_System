<img width="1920" height="971" alt="image" src="https://github.com/user-attachments/assets/85a16281-31b9-4fe0-9338-96a79ecf74e9" />


Ticket Booking System - Laravel Assignment

This is a simplified ticket booking application built for the Server-side Web Programming course at ELTE. The application allows users to browse events and purchase tickets with dynamic pricing, while providing an administrative interface for event and seat management.
🚀 Quick Start
Prerequisites

    PHP 8.2+

    Composer

    SQLite

Installation

    Clone or extract the project.

    Install dependencies:
    Bash

    composer install
    npm install && npm run build

    Environment setup:
    Bash

    cp .env.example .env
    # Ensure DB_CONNECTION is set to sqlite in .env
    touch database/database.sqlite

    Generate App Key:
    Bash

    php artisan key:generate

    Database Setup & Seeding:
    Bash

    php artisan migrate:fresh --seed

    Run the server:
    Bash

    php artisan serve

Project Structure

The application is built on the Laravel 12 framework, following the MVC (Model-View-Controller) pattern. Below is an overview of the key directories based on the implementation:
1. Models & Business Logic (app/Models/)

This directory contains the core entities and their relationships:

    Event.php: Manages event data, descriptions, and dynamic pricing toggles.

    Seat.php: Represents physical seating with unique identification (e.g., "A123").

    Ticket.php: Handles the logic for purchased tickets, linking users, events, and seats.

    User.php: The default Laravel user model, extended with an admin flag.

2. Database Schema & Migrations (database/migrations/)

The database structure is defined through version-controlled migration files:

    create_seats_table.php: Defines the unique seat numbering and base pricing.

    create_events_table.php: Sets up the fields for event timing, descriptions, and image paths.

    create_tickets_table.php: Ensures database-level integrity for unique ticket barcodes and foreign key constraints.

3. Data Seeding & Factories (database/seeders/ & database/factories/)

To ensure the application is ready for testing immediately after installation, the following are used:

    Factories: (EventFactory.php, SeatFactory.php, etc.) Use the Faker library to generate realistic, non-hardcoded data.

    Seeders: Populate the SQLite database while maintaining logical consistency (e.g., ensuring ticket sales start before the event begins).

4. Routing (routes/)

    web.php: This is the application's command center. It defines all public routes (Event list/details) and protected routes (Admin dashboard, ticket purchasing). Access control is managed here via middleware to ensure only administrators can reach sensitive management features.

5. User Interface (resources/views/)

    Contains the Blade templates. All features are accessible through a functional frontend, including seat selection, the admin dashboard, and scannable barcode displays.

🛠 Implemented Features

    Database & Models: Fully relational schema with SQLite.

    Dynamic Seeding: Automated data generation with consistent relationships.

    Event Homepage: Future events list with pagination and availability indicators.

    Detailed Event View: Full event information accessible to all users.

    Ticket Purchase: Seat selection system with purchase limits and real-time validation.

    Dynamic Pricing: Implementation of the supply-demand pricing formula.

    My Tickets: Grouped list of purchased tickets with scannable barcode display.

    Admin Dashboard: Statistics on sales, revenue, and seat popularity.

    Event CRUD: Full administrative control over event creation and modification.

    Seat Management: Dedicated interface for managing venue seating.

    Ticket Validation: Admin tool for "scanning" barcodes and logging entry timestamps.
The system uses the following core models:

    User: Extended with an admin boolean flag.

    Event: Stores event details, description (max 1000 chars), dates, and dynamic pricing toggle.

    Seat: Defines available seats with a unique code (e.g., A123) and base price.

    Ticket: Links users, events, and seats. Stores final price, barcode (9 digits), and admission timestamp.

Dynamic Pricing Logic

If an event has is_dynamic_price enabled, the ticket price is calculated using the following formula:
Price=BasePrice×(1+DaysUntil+11​)×(1+Occupancy)
Administrative Functions

    Dashboard: High-level statistics (total sales, revenue, top 3 seats).

    Event Management: Create, Edit, and Delete events (with restrictions if sales have started).

    Seat Management: CRUD operations for venue seats.

    Ticket Validation: Admin interface to scan/input barcodes and record entry times.

Technologies Used

    Framework: Laravel 12

    Database: SQLite

    Authentication: Laravel Breeze (Starter Kit)

    Frontend: Blade templates with Tailwind CSS

Screenshots

Event menu
<img width="1920" height="971" alt="image" src="https://github.com/user-attachments/assets/3fd68abb-d24c-4f6a-9d0d-3399411d9d34" />

Seats
white: free black: taken grey: selected
<img width="1920" height="971" alt="image" src="https://github.com/user-attachments/assets/61cdbc03-0b4f-4007-b9a1-c5e99a9c611a" />

Bought tickets
<img width="1920" height="971" alt="image" src="https://github.com/user-attachments/assets/f85dd0b5-fdb9-4124-a389-f72d761fd1a0" />

Admin Board with:
  Event add/modify/delete
  Seat: add/modify/delete
<img width="1920" height="971" alt="image" src="https://github.com/user-attachments/assets/f3f44379-d7a4-44bf-a67e-f6a822387a66" />

Adding new event
<img width="1920" height="971" alt="image" src="https://github.com/user-attachments/assets/0822b4b6-2771-4210-b1b4-723993efb583" />


  
