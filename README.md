# Music Artist and Album Web Application

This web application allows users to search and view information about music artists and their albums. Users can sign up, log in using their Google account, search for artists and albums, view detailed information, save favorite artists and albums, and more.

## Features

- User authentication: Users can sign up, log in, and log out using their Google account.
- Artist search: Users can search for artists by name and view their top tracks, albums, and related artists.
- Album search: Users can search for albums by name and view their artist, release date, and track list.
- Favorite artists and albums: Logged-in users can save their favorite artists and albums to their profile and view them later.
- User-friendly interface: The user interface is intuitive and designed to make it easy for users to search for artists and albums, view details, and manage favorites.

## Technologies Used

- PHP 8.1 >
- Laravel: Backend framework for building the web application.
- InertiaJS(Vue3): A Javscript Library for creating a responsive user interface by leveraging the simplicity of VueJS Frontend framework .
- Last.fm API: Integration with the Last.fm API to retrieve artist and album information.
- Docker: Containerization of the application for easy deployment and scalability.
- Git: Version control system for managing the project's source code.

## Setup and Installation

### 1. Clone the repository:
    git clone https://github.com/Cank256/music-app.git music-app

### 2. Install dependencies:
    cd music-app

    composer install

### 3. Create a database and Configure environment variables:

If you are going to run it locally
- Rename the `.env.example` file in the root folder  to `.env` and generate the app key.

    ```
    cp .env.example .env

    php artisan key:generate

- Open the `.env` file and set the necessary configurations, such as app name, database connection, Google Auth Credentials and Last.fm API credentials.
- Create a new database and update the DB_DATABASE configuration in `.env` to match the name of the created database.

If you are going to run it in docker
- Copy the `.env` file in the docker folder.
- Open the docker folder `.env` file and make sure that the DB_HOST is db and remove the DB_SOCKET variable e.g 
    
    ```
    DB_HOST=db
    ...
    DB_SOCKET=

#### NB: 
i) For Google Auth Credentials, follow the instruction here (link below) under Get Google Client ID and Secret (the redirection url port must be 8000).

[positroniX.io - Laravel 9 Socialite Login with Google](https://www.positronx.io/laravel-9-socialite-login-with-google-example-tutorial)

ii) For GMAIL (you can use any other Mail Server) use the instruction below to setup your account to send emails.

- VIDEO https://www.youtube.com/watch?v=hul-ko5_MT4&t=43s

ii) For LASTFM API credentials, you can visit this link.

- LAST API and DOCS https://www.last.fm/api 

### 4. Build and run the application with Docker:

If going to run it locally run:

    npm i

    npm run build

    php artisan migrate

    php artisan serve

If going to run it in docker, build and start the Docker containers run:

    docker-compose up -d --build

    docker-compose exec app npm i

    docker-compose exec app npm run build

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
