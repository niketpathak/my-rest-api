# Define colors
BK="tput setaf 0"
RD="tput setaf 1"
GN="tput setaf 2"
YW="tput setaf 3"
BL="tput setaf 4"
MG="tput setaf 5"
CY="tput setaf 6"
WT="tput setaf 7"
bold="tput bold"

# Define Functions

define reset_colors
  tput sgr0 && "${GN}" && tput el
endef

define highlightText
  tput bold && "${CY}" && tput setab 4
endef

###### Recipes ######

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

install:	## install project dependencies
	@"${bold}" && "${YW}" && echo "*** Initiating Installation ***"  && $(call reset_colors)
	composer install --optimize-autoloader --prefer-dist

dev-server:	## start development server
	@"${bold}" && "${YW}" && echo "*** Starting Development Server ***"  && $(call reset_colors)
	symfony server:start --no-tls

refresh:	## refresh caches in dev env
	@"${bold}" && "${YW}" && echo "*** Clearing and warming up cache for Dev ***" && $(call reset_colors)
	php bin/console cache:clear --no-warmup --env=dev
	php bin/console cache:warmup --env=dev

checkdb:	## print pending sql queries
	@"${bold}" && "${YW}" && echo "*** Verifying Database ***" && $(call reset_colors)
	php bin/console doctrine:schema:update --dump-sql

syncdb: ## sync/update database
	@"${bold}" && "${YW}" && echo "*** Initiate Database Sync ***" && $(call reset_colors)
	php bin/console doctrine:schema:update --force
