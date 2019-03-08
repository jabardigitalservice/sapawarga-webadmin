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
