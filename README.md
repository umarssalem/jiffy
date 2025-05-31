Booking API and management system built with Laravel and MySQL in microservice architecture. 

# 🚀 Running the Application

This project runs in **Docker** containers, so the only requirement to get started is having Docker installed.

1. Navigate to the root folder:
```bash
cd path-to-your-project
```
2. Build the app
```bash
cd path-to-your-project
```
3. Start the containers
```bash
docker compose build --no-cache
```
4. Run database migrations:
```bash
docker compose up -d
```
5. Run auth migrations:
```bash
docker compose exec auth bash
php artisan migrate
exit
```
6. Run properties migrations:
```bash
docker compose exec properties bash
php artisan migrate
exit
```

## 🤖 Allowing Dialogflow Interaction

To enable Dialogflow to send requests to your local API, we're using **Ngrok** to expose the service publicly.

A reserved Ngrok endpoint is set up to forward traffic directly to the **Properties API** running locally.

### 🔌 Steps to Enable Ngrok Tunnel

1. Enter the Properties container:
```bash
docker compose exec properties bash
```
2. Authenticate Ngrok (only needed once):
```bash
ngrok config add-authtoken 2xp8tXuCNsKlUNwIqoaGHirHc2w_5MwEmEgjmjCVet24P33L
```
3. start the tunnel using reserved domain:
```bash
ngrok http --url=able-lamprey-optimal.ngrok-free.app 80
```
now the chatbot is able to query availabilities

__________________________________________________________________________________________
## 📚 API Docs

### 🔐 API Authentication

The API uses **Basic Authentication**. To access the API, you need to create an account first:

1. Navigate to the Auth service signup page:  
   `http://localhost:8081/signup`

2. Register with your email and password.

3. For API requests, include the **Authorization** header using Basic Auth format:
Example: if your email is `user@example.com` and password is `mypassword`, encode `user@example.com:mypassword` in base64 and include it in the header.



