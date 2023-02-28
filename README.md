## Requirements
- PHP
- Composer
- Node/NPM

## How to Run
1. Setup .env variables:
```
copy .env.example .env
or
cp .env.example .env
```
Then update Database and Mail variables.

2. Install dependencies:
```
composer install && npm install
```
3. Generate application key:
```
php artisan key:generate
```
4. Run the migrations:
```
php artisan migrate
```

5. Build UI:
```
npm run build
```

6. Run the application:
```
php artisan serve
```

7. Run queue jobs in a different terminal/cmd:
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