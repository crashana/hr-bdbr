## Requirement
- **composer**
- **php 7.4**
- **mysql 8**
- **redis**

## Deployment
Copy and configure .env.example file to .env, <br>
run command:
- **composer install**
- **php artisan migrate**
- **php artisan key:generate (on first deploy)**
- **php artisan storage:link (on first deploy)**
- **php artisan db:seed**
- **php artisan optimize:clear**


 
