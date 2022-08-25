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

