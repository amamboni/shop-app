## Requirements
- PHP
- Composer
- Node/NPM

## How to Run
- Setup .env variables
- Install dependencies:
```
composer install
npm install
```

- Run the migrations:
```
php artisan migrate
```

- Run the application:
```
php artisan serve
```

- Run queue jobs
```
php artisan queue:work 
```

## Testing
Run tests using:
```
php artisan test
```

## Registering a user
### Administrator
- Check the Administrator checkbox to set user to administrator
- Administrators can access the Products page to add/edit/delete products.

### Ordinary User
- Uncheck the Administrator checkbox to register an ordinary user.

## Adding to cart and checkout
- Go to Dashboard page to see the products list
- Click Add to Cart
- Click Cart Items link in menu to see added items
- Click Checkout button
- View orders at Orders page