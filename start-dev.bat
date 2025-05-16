@echo off
REM Start XAMPP Control Panel
start "" "C:\xampp\xampp-control.exe"

REM Start Laravel development server
start "" powershell -NoExit -Command "cd /d C:\xampp\htdocs\fssv2; php artisan serve"

REM Start Vite development server
start "" powershell -NoExit -Command "cd /d C:\xampp\htdocs\fssv2; npm run dev"

echo.
echo XAMPP, Laravel, and Vite dev servers started.
echo Please ensure Apache and PostgreSQL are running in XAMPP Control Panel if needed.
echo Open your browser and go to: http://localhost:8000
pause
