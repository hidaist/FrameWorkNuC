# FrameworkbyDMZ - Project Context

## Tech Stack
- Language: PHP (Native / Custom MVC Framework)
- Architecture: Model-View-Controller (MVC)
- Server Environment: Laragon (Apache/Nginx, MySQL)

## Core Directories
- Application: `App/`
- Controllers: `App/Controls/`
- Models: `App/Models/`
- Views: `App/Views/`
- Custom Libraries: `Librari/`
- Routing: `App/Route/`
- Entry Point: `index.php`
- Database Scripts: `database/`

## Authentication
- Session-based login
- Guard: `Librari/auth.guard.php`
- Session: `Librari/inc.session.php`
- Login View: `App/Views/login.view.php`
- Auth Controller: `App/Controls/auth.control.php`
- Auth Model: `App/Models/auth.model.php`
- Tabel: `tb_user`

### Default Login
- Username: `admin`
- Password: `admin123`

### Auth Routes
- Login page: `?page=views&views=loginViews`
- Login process: POST `?page=controls&controls=authControl`
- Logout: `?page=controls&controls=authControl&logout=1`

## Build & Development Commands
- Serve: Run via Laragon Virtual Host (e.g., http://frameworkbydmz.test)
- Setup database: Import `database/tb_user.sql` ke database `frameworkbydmz`
