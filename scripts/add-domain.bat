@echo off

:: Check if the domain is provided
if "%1"=="" (
    echo Error: No domain specified.
    exit /b 1
)

SET domain=%1

:: Check if domain is already in hosts file
findstr /c:"%domain%.multitenancyapp.test" C:\Windows\System32\drivers\etc\hosts > nul
if %errorlevel%==0 (
    echo Domain already exists in hosts file.
) else (
    echo 127.0.0.1 %domain%.multitenancyapp.test >> C:\Windows\System32\drivers\etc\hosts
    if %errorlevel% neq 0 (
        echo Error writing to hosts file >> C:\laragon\add-subdomain-log.txt
        exit /b 1
    )
    echo [%date% %time%] Added %domain%.multitenancyapp.test >> C:\laragon\add-subdomain-log.txt
)

exit


