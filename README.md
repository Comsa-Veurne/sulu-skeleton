# Getting started with Sulu
## Installation
- **git clone** this repository inside your `~/Sites` directory
- Clear git repository `rm -rf .git/*` and start a new one using `git init` and create your first commit **Initial commit**
- Execute `composer install` using version **PHP7.3 or higher**
- Create your webspace, following tutorial http://docs.sulu.io/en/2.0/book/getting-started.html#webspaces
- Start your database using Docker, `docker-compose up -d` and change your `DATABASE_URL` in a new file called `.env.local`
- Install Sulu using: `bin/adminconsole sulu:build dev`
- Start a webserver using `bin/console server:start`, if this doesn't work you can always using MAMP as a fallback for now
## Installation webpack
- Go inside `assets/website` and run `npm install`
## Usage
- Make sure your database is always up, using `docker-compose up -d`
- Run your webpack dev server, using `npm run dev`
- Now visit http://127.0.0.1:8000 and your website should be visible
