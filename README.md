# Music Artist and Album Web Application

This web application allows users to search and view information about music artists and their albums. Users can sign up, log in using their Google account, search for artists and albums, view detailed information, save favorite artists and albums, and more.

## Features

- User authentication: Users can sign up, log in, and log out using their Google account.
- Artist search: Users can search for artists by name and view their top tracks, albums, and related artists.
- Album search: Users can search for albums by name and view their artist, release date, and track list.
- Favorite artists and albums: Logged-in users can save their favorite artists and albums to their profile and view them later.
- User-friendly interface: The user interface is intuitive and designed to make it easy for users to search for artists and albums, view details, and manage favorites.

## Technologies Used

- Laravel: Backend framework for building the web application.
- VueJS: Frontend framework for creating a responsive user interface.
- Last.fm API: Integration with the Last.fm API to retrieve artist and album information.
- Docker: Containerization of the application for easy deployment and scalability.
- Git: Version control system for managing the project's source code.

## Setup and Installation

### 1. Clone the repository:
    git clone https://github.com/Cank256/music-app.git

### 2. Install dependencies:
    cd music-app
    composer install
    npm i

### 3. Configure environment variables:

If you are going to run it locally
- Rename the `.env.example` file in the root folder  to `.env`.
- Open the `.env` file and set the necessary configurations, such as app name, database connection, Google Auth Credentials and Last.fm API credentials.

If you are going to run it in docker
- Rename the `.env.example` file in the docker folder  to `.env`.
- Open the `.env` file and set the necessary configurations, such as app name, database connection, Google Auth Credentials and Last.fm API credentials.

#### NB: For Google Auth Credentials, follow the instruction here (link below) under Get Google Client ID and Secret.
- [positroniX.io - Laravel 9 Socialite Login with Google](https://www.positronx.io/laravel-9-socialite-login-with-google-example-tutorial)

### 4. Build and run the application with Docker:
If going to run it locally:

    php artisan serve

If going to run it in docker:
- Build and start the Docker containers:
    `docker-compose up -d --build`

### 5. Access the application in your browser:
    http://localhost:8000

## Usage
- Sign up or log in using your Google account.
- Use the search functionality to find music artists and albums.
- View detailed information about artists and albums, including top tracks, release dates, and track lists.
- Save your favorite artists and albums to your profile.
- Manage your favorite artists and albums (CRUD operations) from your profile.

## Contributing

Contributions are always welcome!

See `contributing.md` for ways to get started.

Please adhere to this project's `code of conduct`.


## Authors

- [Caleb Nkunze](https://www.github.com/Cank256)


## License

[MIT](https://choosealicense.com/licenses/mit/)
