# Cloudflare Cache Buster 💥

This mini-app will let you purge all cache for a given Cloudflare Site (zone). This is especially useful when used during the deployment of your app/site as some sites won't show your changes within a new deployment unless you clear the Cloudflare cache. This app helps you avoid frustration by debugging why changes are being made or by going into the Cloudflare dashboard.

## Installation

Clone this repo, and then add it as a new site on your favourite deployment service (e.g Laravel Forge). Once setup set the following API keys:

```text
CLOUDFLARE_TOKEN=
CLOUDFLARE_MIDDLEWARE_AUTH=
```

- `CLOUDFLARE_TOKEN` is the API token which is used in the API request to clear a site's cache. Generate a token and give it the "Cache busting for all zones" privilege.
- `CLOUDFLARE_MIDDLEWARE_AUTH` should be a randomly generated string token used to lock-down the webhook.

## Usage

Add this to the end of your site's deployment script. Don't forget to change the URL, Zone ID, and auth token.
The auth token is the same token as you generated and placed in the `CLOUDFLARE_MIDDLEWARE_AUTH` env variable.

```text
curl https://cloudflare-cache-buster.test/clear-zone/{ZONE-ID}?auth={CLOUDFLARE_MIDDLEWARE_AUTH}
```

## Queues

It is recommended you set up a queue for this process, as this will improve the performance of the webhook. I recommend using the database queue.

## Logging

Logs are generated in the `storage/logs/cloudflare-cache-result.log` log file. If you would like to disable logging, provide the `CLOUDFLARE_LOGGING_ENABLED=false` variable in your `.env` file.
