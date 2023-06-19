# URL shortener
This project implements a simple website to shorten URLs. Users register and authenticate to use the service and it allows to manage and see and manage what URLs have they shortened previously.

## Setup Instructions

Follow these steps to set up the project locally:

### Prerequisites

- PHP version 8.1 or higher
- Composer installed

### Installation

1. Clone the repository:

    ```bash
     git clone https://github.com/trahvex/URL-shortener
    ```

2. Navigate to the project directory:

    ```bash
     cd url_shortener
    ```

3. Install the dependencies using Composer:

    ```bash
     composer install
    ```

### Configuration

1. Create a new database for the project.

2. Open the `.env` file and update the `DATABASE_URL` line with your database credentials:

    ```
    DATABASE_URL="mysql://your_username:your_password@your_host/your_database"
    ```

   Replace `your_username`, `your_password`, `your_host`, and `your_database` with your actual database connection details.

3. Run the database migrations to set up the required tables:

    ```bash
     php bin/console doctrine:migrations:migrate
    ```

### Run the Application

You can now start the local development server to run the application:

```bash
 symfony server:start
```

Open your browser and visit http://localhost:8000 to access the application.
