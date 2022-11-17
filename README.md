# NEWS Parser
This is a simple news parsing service that gets news resource from a website with RSS Feed. The service also have a page displaying the list of downloaded news and a CLI command to start parsing.

## Tasks
 - Only authenticated users can view the posts
 - Only a user with ROLE_ADMIN should be able to delete a post
 - Parsing is done in several parallel processes via RabbitMQ
 - CLI command to start parsing posts from the RSS feed

## How to Setup
 - Clone repo
 - The app is dockerized. To start, ensure you have docker on your system
 - run `docker-compose up -d --build` to build the docker image.
 - bash into the docker container `docker exec -it news-parser.php bash`
 - run `php bin/console doctrine:migrations:migrate` to run migration
 - if you have issues with migrating, run `php bin/console doctrine:database:create` 
 - run `php bin/console doctrine:fixtures:load` to load data fixtures
 - an admin account is setup already with details email: admin@symfony.com password: password 
 - a moderator account is setup already with details email: moderator@symfony.com password: password
 - run `php bin/console app:post-parser` to run the parser command
 - run `php bin/console messenger:consume async -vv` to consume messages from the rabbitmq worker
