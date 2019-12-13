.DEFAULT_GOAL 		:= 	clear_cache
.PHONY				:	setup install
DOCKER 				= 	docker
DOCKER_COMPOSE 		= 	docker-compose
DOCKER_APP_ID		=	$(shell $(DOCKER_COMPOSE) ps -q app)
DOCKER_APP_EXEC		=	$(DOCKER) exec $(DOCKER_APP_ID)
DOCKER_APP_CONSOLE	=	$(DOCKER_APP_EXEC) php bin/console

install: # Vendor install
	$(DOCKER_APP_EXEC) composer install

update_database:
	$(DOCKER_APP_CONSOLE) doctrine:schema:update -f

clear_cache: #This is the default action
	$(DOCKER_APP_CONSOLE) cache:clear

image_cache:
	$(DOCKER_APP_CONSOLE) sulu:media:format:cache:clear

setup: install
	$(DOCKER_APP_CONSOLE) sulu:build dev

enter:
	$(DOCKER) exec -it $(DOCKER_APP_ID) bash

