## SQUARE1 BLOG

## Pre-Installation Steps
run `sudo nano /etc/hosts` and add
`127.0.0.1 db` to the  list of ips \
it is for the database docker service

## Installation Steps

Clone the project and run the following commands sequentially : \
`./develop start` \
`./develop bash service redis-server start` \
`./develop art key:generate` \
`./develop composer install` \
`./develop yarn install` \
`./develop yarn watch` \


### You are good to go

At this point you can take a look around the project to see it's bland state. \
Open `127.0.0.1:8080` on your browser

## To seed data
run `./develop art db:seed`

## To import posts from customer's alternative blog
run `./develop art posts:import`

## To access the linux container bash
run `./develop bash`

## To run test suite
run `./develop test`


### NB: 
if you face any gotchas, kindly shoot an email: ishukpong418@gmail.com

### Possible Additions: 
E2E tests using Laravel Dusk
