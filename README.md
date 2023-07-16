# Symfony - Behat 
This project will init a Symfony project with Docker to run behat test

## Requirements
- Docker
- Docker-compose
- Make

## Installation
- Edit variable ``PROJECT_PORT`` port in ``.env``
- ``make .env.local``
- Edit your ``.env.local``
- ``bash make install`` or ``make reset`` :)

## Execution modes
You can run test with

```bash
$ make behat
```
or
```bash
$ docker exec -t symfony_behat_php vendor/bin/behat
```

If you want to run specific test, add a tag before your scenario
```gherkin=
@javascript @demo @tag
Scenario: This is an example
```
Then run with your tag,
```bash
$ docker exec -t symfony_behat_php vendor/bin/behat --tags demo
```
### Browser

By default, the tests will execute with Chrome node.

![Chrome](https://raw.githubusercontent.com/alrra/browser-logos/main/src/chrome/chrome_24x24.png) Chrome
```bash
$ docker exec -t symfony_behat_php vendor/bin/behat --profile chrome
```
But you can execute with Firefox node

![Firefox](https://raw.githubusercontent.com/alrra/browser-logos/main/src/firefox/firefox_24x24.png) Firefox
```bash
$ docker exec -t symfony_behat_php vendor/bin/behat --profile firefox
```

### Preview
This project integrates a test visualization (headless) with Selenium Grid

![Selenium Grid](https://raw.githubusercontent.com/Kimouss/Symfony-Behat/main/doc/images/selenium_grid.png)

Go to ``Sessions`` on sidebar

![Selenium Session](https://raw.githubusercontent.com/Kimouss/Symfony-Behat/main/doc/images/selenium_session.png)

Then, you can have live preview thanks to VNC system

![Selenium VNC](https://raw.githubusercontent.com/Kimouss/Symfony-Behat/main/doc/images/selenium_vnc.png)

You can also record your test on .mp4 file in folder ``.docker/test/recording``

To do that: 
- run your chrome or firefox video image
- run test
- stop chrome or firefox video image
- wait a few minute and your video is ready !
