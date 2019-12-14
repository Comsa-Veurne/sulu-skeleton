# Getting started with Sulu
## Requirements
- You need to have `Docker` installed and configured
- You need to have `make` installed
- You need to have `node` installed
## Installation
- Perform a `git clone` in your `~/Sites` directory, `git clone https://github.com/Comsa-Veurne/sulu-skeleton <my-sites-directory>`
- Create a new git repository with `make clear_git resository=<name-of-repo>`
- Create your webspace following tutorial http://docs.sulu.io/en/2.0/book/getting-started.html#webspaces
- Build your project with `make setup`
## Usage
- Run your webpack dev server, using `make dev`
- Now visit http://localhost and your website should be visible
- Now visit http://localhost/admin and login with both username and password: **admin**