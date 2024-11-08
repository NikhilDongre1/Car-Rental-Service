# Vehicle Rental Booking System

A web-based application that allows users to rent vehicles, including cars and bikes, through a seamless and user-friendly booking process. The system features user authentication, a catalog of available vehicles, and a booking functionality that enables users to reserve vehicles based on their preferred dates and locations. This application is built with PHP, MySQL, and HTML/CSS, making it ideal for managing vehicle rentals effectively.

## Features

- **User Authentication**: Secure login and registration system for user account management.
- **Vehicle Catalog**: Displays available vehicles with details like make, model, year, and rental price.
- **Booking System**: Users can select their desired vehicle, enter booking details (dates and location), and confirm the booking.
- **Most Preferred Vehicle Display**: Highlights the most frequently booked vehicle on the homepage.
- **Responsive Design**: Optimized for desktop and mobile devices.
- **Admin Section** *(Optional)*: Manage vehicle inventory and view bookings.

## Project Structure

- `index.php`: Home page displaying welcome message, popular vehicle, and vehicle types.
- `category.php`: Lists available vehicles for booking.
- `booking.php`: Form for users to enter booking details.
- `orders.php`: Shows user's booking history.
- `vehicle.php`: API endpoint to fetch vehicles based on type.
- `database.php`: Database connection file.
- `login.php` & `signup.php`: User authentication pages.
- `confirmation.php`: Processes and confirms bookings.

## Database Schema

The application uses a MySQL database with the following key tables:

1. **Users**: Stores user information (user ID, username, password, etc.).
2. **Vehicles**: Contains vehicle details (vehicle ID, make, model, year, price, availability, etc.).
3. **Bookings**: Tracks each booking made by users (booking ID, user ID, vehicle ID, start and end dates, location).

## Installation

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/yourusername/vehicle-rental-booking-system.git
