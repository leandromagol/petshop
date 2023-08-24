# Petshop api

#Description 
Petshop api built using laravel framework 

## 💻 Setup
You will need docker installed in your environment to run this project properly

1.Copy the .env-example to .env and put your database credentials and your webhook to get the orders status updates 
```bash
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

#others env variables

TEAMS_WEBHOOK_URL=
```
2. Make sure docker engine is started
3. Run on your terminal
```bash 
    $ sudo chmod +x  container.sh
```
4. Run on your terminal
```bash
    ./container.sh
```

## Docs
You can access the swagger documentation and test the api through http://localhost/api/documentation
The builtin user is 
```json
{
  
  "email": "admin@buckhill.co.uk",
  "password": "admin",
  
  
}
```
