## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## About Project
This project is a Laravel application integrated with Stripe using Laravel Cashier. The application provides users with an additional 30-days of access to the application by extending their trial period or billing schedule by 30 days.

## Getting Started
 # Prerequisites
    PHP ^7.4 or higher
    Composer
    Stripe account
    Laravel cashier package
    Installing
    Clone the repository to your local machine
    bash
    
# Copy code
    git clone https://RanaTanvi@github.com/RanaTanvi/laravel-cashier-with-stripe.git
    
# Install dependencies using composer
    bash
     cd [repository-name]
     composer install
# Set up the database
    Set up the database by copying the .env.example file and updating the DB_ fields with your database credentials

    run the command below to terminal
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    Configure Stripe credentials in .env file by adding the following keys:
    vbnet

# set env variable
    STRIPE_KEY=your-stripe-public-key
    STRIPE_SECRET=your-stripe-secret-key

## Usage
    Register a new user by clicking on the Register button or link on the home page.
    Enter the registration details.
    Upon successful registration, the user is redirected to the Subscription page.
    In Subscription page select the plan you want to subscribe then click on Checkout button
    In Checkout page fill payment details.
    After successfully subscription you are redirected to dashboard.
    The Dashboard page displays the user's profile details, access expiration date, and options to extend access.
    Click on the Extend Access button to extend access by 30 days.

    Running the Tests
    To run the unit tests, execute the following command:

vendor/bin/phpunit

## Unit Tests
test_user_can_register_and_subscribe - Test that a new user can register and subscribe successfully.
test_user_can_extend_access_by_30_days - Test that a user can extend access by 30 days successfully.
## Built With
    Laravel - The PHP framework for web artisans
    Stripe - The payments infrastructure for the internet
    Laravel Cashier - A package for Stripe integration in Laravel