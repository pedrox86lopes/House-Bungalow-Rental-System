# Bungalow Booking System - CESAE Digital

This is a web application for booking bungalows, built with the Laravel framework.

## Features

*   **User Authentication:** Secure user registration and login system.
*   **Bungalow Listings:** View available bungalows with details and images.
*   **Booking Management:** Users can book bungalows, view their bookings, and manage them.
*   **Payment Processing:** Integration with PayPal for secure online payments.
*   **Admin Dashboard:** Administrators can manage bungalows, bookings, users, and view system messages.
*   **Contact Form:** Users can send messages to administrators/Booking Management Team.

## Setup Instructions

1.  **Clone the repository:**
    ```bash
    git clone git@github.com:pedrox86lopes/House-Bungalow-Rental-System.git
    cd House-Bungalow-Rental-System
    ```
2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```
3.  **Set up environment variables:**
    - Copy the `.env.example` file to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Generate an application key:
      ```bash
      php artisan key:generate
      ```
    - Configure your database connection and PayPal API credentials in the `.env` file.
4.  **Run database migrations:**
    ```bash
    php artisan migrate (Just a reminder: All the migrations are inside database/migrations/Backup - Just move to ../
    ```
5.  **Seed the database (optional):**
    ```bash
    php artisan db:seed
    ```
6.  **Compile assets:**
    ```bash
    npm run dev
    ```
7.  **Start the development server:**
    ```bash
    php artisan serve
    ```

    The application should now be accessible at `http://localhost:8000`.

## Contributing

Contributions are welcome! Please feel free to submit a pull request or open an issue.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
