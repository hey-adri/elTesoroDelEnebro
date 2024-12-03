# [El Tesoro del Enebro](https://enebro.fr.to/)

![El Tesoro del Enebro](https://enebro.fr.to/assets/img/homeImages/landingThumb.png)

El Tesoro del Enebro is a web application designed to create and enjoy real-world treasure hunts or scavenger hunts, face-to-face with other participants. It combines the excitement of a classic treasure hunt with modern QR code technology to offer a unique and memorable experience.

[Deployed URL](https://enebro.fr.to/)

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)

## Features

El Tesoro del Enebro offers the following features:

- **Treasure Hunts**: Users can create treasure hunts, each containing multiple clues.
- **Clues**: Clues can contain text, images, and YouTube videos. Clues with images or videos are considered PRO clues.
- **QR Codes**: Generate unique QR codes for each clue. Participants can scan these codes to access clues.
- **Administration**: Admin users can manage and delete offensive content, manage users, and control the number of PRO clues available to users.

## Technologies Used


- **Backend**: Laravel 10, PHP >= 8.1
- **Frontend**: JavaScript, npm for dependencies
- **Database**: MySQL or any database supported by Laravel
- **Server**: Apache or Nginx

## Requirements

To run this application, you will need:

- PHP >= 8.1
- Composer
- npm
- SSH access for running artisan commands and setting up symbolic links
- Apache or Nginx server with proper configuration
- imagick extension for PHP
- At least 2 CPU cores and 1GB RAM for optimal performance

## Installation

1. **Clone the repository:**

    ```sh
    git clone https://github.com/yourusername/el-tesoro-del-enebro.git
    cd el-tesoro-del-enebro
    ```

2. **Install dependencies:**

    ```sh
    composer install
    npm install
    ```

3. **Set up environment variables:**

   Copy the `.env.example` file to `.env` and update the necessary configurations such as database credentials and mail settings.

    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

4. **Set file permissions:**

    ```sh
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache
    ```

5. **Run migrations:**

    ```sh
    php artisan migrate
    ```

6. **Link storage to /public:**

    ```sh
    php artisan storage:link       
    ```

6. **Start the development server:**

    ```sh
    php artisan serve
    ```

## Usage


1. **Create an account** or **log in**.
2. **Create a treasure hunt** by providing a title.
3. **Add clues** to the treasure hunt. Clues can be simple text or PRO clues with images and videos.
4. **Generate QR codes** for each clue and hide them in the physical world.
5. **Scan QR codes** to reveal clues and enjoy the treasure hunt.

## License

© 2024 [Adrian Garcia](https://heyadri.fr.to/). All rights reserved.
