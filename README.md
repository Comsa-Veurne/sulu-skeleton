# Getting started with Sulu
## Requirements
- You need to have `Docker` installed and configured
- You need to have `make` installed
- You need to have `node` installed
- Optionally install the setup-project tool found [here](http://lab.comsa.be:1234/tools/setup-project)
## Installation
### Using setup-project (needs setup-project tool)
- Execute `setup-project` and follow the instructions
- During the setup you will have to [setup up your webspace](http://docs.sulu.io/en/2.0/book/getting-started.html#webspaces).
### Manually
- Perform a `git clone` in your `~/Sites` directory, `git clone https://github.com/Comsa-Veurne/sulu-skeleton <my-sites-directory>`
- Create a new git repository with `make clear_git repository=<name-of-repo>`
- Create your webspace following tutorial http://docs.sulu.io/en/2.0/book/getting-started.html#webspaces
- Build your project with `make setup`
## Usage
- Run your webpack dev server, using `make dev`
- Now visit http://localhost and your website should be visible
- Now visit http://localhost/admin and login with both username and password: **admin**
## Easy commands

| Command  | Description    |
|---|---|
| `make install` | Executes a `composer install` within your Docker container |
| `make update_database` | Executes `bin/console doctrine:schema:update -f` inside your Docker container |
| `make clear_cache` | Clears the cache |
| `make image_cache` | Clears the image cache ( formats ) |
| `make docker_setup` | Stops all other containers, and starts/build yours |
| `make setup` | Sets up the DB connection in `env.local`, creates Sulu DB and builds your node packages |
| `make enter` | Enters your Docker container with bash |
| `make clear_git repository=<your-repo-name>` | Recreates your Git repository and adds a new remote with the given repository name |
| `make dev` | Starts your webpack-dev-server |
