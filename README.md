# EONX Coding Test

## Configuration

# Database
Create a MySQL Database Schema, copy the name and replace the DATABASE_URL snippet below with your created schema name
DATABASE_URL="mysql://root:@127.0.0.1:3306/!DatabaseName!?serverVersion=5.7"

# .env
In root folder of the project create a .env file based from .env.local
Add this following line of code on the last line along with your created schema name
DATABASE_URL="mysql://root:@127.0.0.1:3306/!DatabaseName!?serverVersion=5.7"

# Run the following commands
To install dependencies run the command below:
composer install

To create database table run the command below:
php bin/console doctrine:migrations:migrate

To run the application run the command below:
symfony server:start

# To generate customers
On your browser go to this URL:
GET http://127.0.0.1:8000/generate-customers

# To display list of customers
On your browser go to this URL:
GET http://127.0.0.1:8000/customers

# To display a specific customer
On your browser go to this URL and add the customer id on the last part:
GET http://127.0.0.1:8000/customers/{id}