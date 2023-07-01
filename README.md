This is an example app for [this blog post](https://kayneth.dev/blog/symfony-request-id-handler).

# Example app

- Open this project as a Github Codespace
- `docker compose up -d`
- `php -S 0.0.0.0:8080 -t public`
- In another terminal, run `bin/console messenger:consume async -v`
- Open the preview app on the `/` route.
- See the logs in `var/log/dev/log`