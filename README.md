# Project setup: Training EMS

## Some default accounts

<p>Admin</p>

```
Email: admin@gmail.com | Password: admin
```

<p>Staff</p>

```
Email: staff@gmail.com | Password: staff
```

<p>Trainer</p>

```
Email: trainer@gmail.com | Password: trainer
```

<p>Trainee</p>

```
Email: trainee@gmail.com | Password: trainee
```

### Install packages (Laravel)

```
composer i
```

### Install packages (Vue.js)

```
npm i
```

### Setup .env file as .env.example file (Here are some more things to change)

```
DB_DATABASE=(Your database)
DB_USERNAME=(Your username)
DB_PASSWORD=(Your password)
```

### Migrate Database

```
php artisan migrate:fresh --seed
```

### Compiles and hot-reloads for development (Execute 2 parallel commands)

```
npm run watch
```

```
php artisan serve
```

### Compiles and minifies for production

```
npm run production
```

### Lints and fixes files

```
npm run lint -- --fix
```
