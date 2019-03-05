# Yii2 REST API + Angular 6 Boilerplate

This is a boilerplate project for future use. The project consists of REST API developed by Yii2 and backend/frontend developed by Angular 6 with Bootstrap 4. Frontend project is compatible to provide server-side rendering(Angular Universal) using [@ng-toolkit/universal](https://github.com/maciejtreder/ng-toolkit).

The project involves:
* API
    - Yii2 REST API, Yii2 RBAC, JWT (JSON Web Token), Memcached, *Basic Unit & Functional Test using Codeception*
* Backend: Staff/Administrator dashboard to manage staffs, users and settings
    - Angular 6, Bootstrap 4, JWT (JSON Web Token), *Basic Unit test using 
    Karma+Jasmine*, Moment.js, Sweet Alert, Underscore.js
* Frontend: User website to support user registration, login and account management 
    - Angular 6, [@ng-toolkit/universal](https://github.com/maciejtreder/ng-toolkit), Bootstrap 4, JWT (JSON Web 
    Token), *Basic Unit using Karma+Jasmine, Basic E2E test using Protractor+Jasmine*, Moment.js, Sweet Alert

**Architecture Diagram**

![Architecture Diagram](screenshots/network-diagram.png)

## Features
- API
    * User Controller
        - GET/POST/PUT/DELETE /v1/user
        - POST /v1/user/login
        - POST /v1/user/signup
        - POST /v1/user/confirm
        - POST /v1/user/password-reset-request
        - POST /v1/user/password-reset-token-verification
        - POST /v1/user/password-reset
        - GET/POST /v1/me
        - GET /v1/page/sse
    * Staff Controller
        - GET/POST/PUT/DELETE /v1/staff
        - POST /v1/staff/login
        - GET /v1/staff/get-permissions
    * Setting Controller
        - GET/POST/PUT/DELETE /v1/setting
        - GET /v1/setting/public
- Backend
    * Staff Login/Logout
        - API generates JWT(JSON Web Token) upon successful login.
    * Dashboard
        - Currently, dashboard is empty page.
    * Staff Management
        - Admin or staff who has a permission 'manageStaffs' can create/update/delete staff information.
        - Staff role can configure permissions for managing staff, user and setting.
    * User Management
        - Admin or staff who has a permission 'manageUsers' can create/update/delete user information.
    * Setting Management
        - Admin or staff who has a permission 'manageSettings' can create/update/delete setting information.
- Frontend
    * Support Angular Universal/server-side rendering
    * User Login/Logout     
        - User can login with username and password.
        - API generates JWT(JSON Web Token) upon successful login.
        - Frontend will store JWT in local storage and use for all requests.
        - API will validate submitted access token prior to process any request. 
    * User Registration
        - User can register new account.
        - API will submit verification email to the email. Note that current API system will use swift mailer component with file transport. You can check the email content in debug module.  
    * User Email Confirmation 
        - Frontend will confirm the auth key and update account status if auth key is valid.
    * User Reset Password
        - User can reset their password.
        - API will send password reset email to the requested email.
        - Frontend will display the password reset page if password reset token is valid.
    * User Account 
        - User can change email address. If change email address, the API will send confirmation email to verify email address.
        - User can change password.

## How to start

To run the application, you will need `docker` and `docker-compose` installed. 

Open the console and execute following commands.

Pull the source code

```
git clone https://github.com/asatrya/yii2-ngx-boilerplate.git
```

Go to project directory, copy and set environment file
```
cd yii2-ngx-boilerplate 
cp .env-dist .env
```

### Build Docker Image

```
docker build -t asatrya/yii2_ngx_api:1.0 ./api/
docker build -t asatrya/yii2_ngx_backend:1.0 ./backend/
docker build -t asatrya/yii2_ngx_frontend:1.0 ./frontend/
docker build -t asatrya/yii2_ngx_nginx:1.0 ./nginx/
```

### Run Docker Container

For production

```
docker-compose up -d
```

For development

```
docker-compose -f docker-compose.dev.yml up -d
```

### Install modules and Run Database Migration

Access Docker Container's Bash
```
docker exec -it yii2_ngx_api bash
```

Inside the container, run:
```
composer install
```

Make sure your database is accessible form inside the container. Then run migration
```
php yii migrate --migrationPath=@yii/rbac/migrations --interactive=0
php yii migrate/up --interactive=0
```

### Generate Code

Generate model class

```
php yii gii/model \
    --tableName=guitar \
    --modelClass=Guitar
```

## Component

* **REST API - Yii 2**: [http://localhost/api/debug](http://localhost/api/debug)
    - To make sure API is working, go to [http://localhost/api/ping](http://localhost/api/ping). You must see `pong` message.
    - To access docker container, use following command:
        ```
        docker exec -it yii2_ngx_api bash
        ```
    - To run code sniffer, use following command:
        ```
        docker exec yii2_ngx_api composer run sniff
        ```
    - To run unit test, use following command:
        ```
        docker exec yii2_ngx_api composer run test:unit
        ```
        
* **Backend - Angular**: [http://localhost/backend](http://localhost/backend)
    - Administrator username: `admin`, password: `123456`
    - Staff username: `staff`, password: `123456`
    - To see compile process, use following command:
        ```
        docker logs yii2_ngx_backend --follow
        ```
    - To access docker container, use following command:
        ```
        docker exec -it yii2_ngx_backend /bin/sh
        ```
    - Note that the **live reloading feature has been disabled** due to restriction. 
    - Please open **Developer Tool** to prevent caching. The changes will be checked every 1s. Please refer `/backend/image-files/usr/local/bin/docker-entrypoint-dev.sh`.
    - To run unit test, use following command:
        ```
        cd frontend
        npm run test
        ``` 
    
* **Frontend - Angular**: [http://localhost/frontend](http://localhost/frontend)
    - Username: `user`, password `123456`
    - To see compile process, use following command:
        ```
        docker logs yii2_ngx_frontend --follow
        ```
    - To access docker container, use following command:
        ```
        docker exec -it yii2_ngx_frontend /bin/sh
        ```
    - Note that the **live reloading feature has been disabled** due to restriction. 
    - Please open **Developer Tool** to prevent caching. The changes will be checked every 1s. Please refer `/frontend/image-files/usr/local/bin/docker-entrypoint-dev.sh`.
    - To run unit test, use following command:
        ```
        cd frontend
        npm run test
        ```
    - To run E2E test, use following command:
        ```
        cd frontend
        npm run e2e
        ```

## Files & Folders structures

- **.env**: contains environment settings
- **docker-compose.yml**: contains docker container specifications
- **api**: Yii2 
    - `image-files`: contains nginx config, php.ini, composer and `docker-entrypoint.sh`
- **backend**: Angular Backend
    - `image-files`: contains nginx config, `docker-entrypoint-dev.sh` and `docker-entrypoint.sh`
- **frontend**: Angular Frontend
    - `image-files`: contains nginx config, `docker-entrypoint-dev.sh` and `docker-entrypoint.sh`
- **nginx**: Load Balancer
    - `image-files`: contains nginx config


## Troubleshooting

**I changed backend/frontend code, but I cannot see changes in the browser.**

As mentioned earlier, you have to open `Developer Tool` to prevent cache if you are using Chrome. Or clear browser cache and reload again.

## Cleanup

```
docker stop yii2_nginx yii2_backend yii2_frontend yii2_memcached yii2_api
docker rm yii2_nginx yii2_backend yii2_frontend yii2_memcached yii2_api
```