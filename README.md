### Search Engine Aggregator
#### How to run:
##### Running with local php interpreter:
You have to have PHP7 or higher version.

Installation:
```bash
composer install
```
Running tests
```bash
./vendor/bin/phpunit
```
Get search results via console
```bash
php bin/console test-tool "pointer brand protection"
```

##### Running with docker-compose:
```bash
docker-compose up --build
```

Running tests:
Tests are running automatically when docker container up. You can rerun if you want:
```bash
docker-compose  exec app ./vendor/bin/phpunit
```

Get search results via console
```bash
docker-compose  exec app php bin/console test-tool "pointer brand protection"
```

#### How to add a new provider:
If you want add a new provider. You should define provider data to /config/providers.yaml like below:

```yaml
new_search_engine:
  enabled: true # you can enable or disable search engine
  host: https://www.new-search-engine.com # host name
  searchPath: /search?q=%s #search query pattern
  selectors: # selectors
    row_selector: 'li.b_algo' # search item selector
    title_selector: 'h2 > a' # item title selector
    link_selector: 'h2 > a' # item lin selector
```
Or you can inject your own providers.yaml file. 
```php
$providerRepository = new ProviderRepository('YOUR_CONFIG_FILE PATH');
$search->setProviderRepository($providerRepository);
```
**Example**
There is a sample overriden config file. New provider added (AOL) and other providers disabled via overriden config file. You can run overrided config via test-tool:
```bash
docker-compose  exec app php bin/console test-tool "pointerbrandprotection" /app/config/providers_extended.yaml
```

#### Allowed modification via Listener:
There is an event listener mechanism. It allows to you modify or intervene before or after some events. It works event and provider based.

**beforeRequest**: 
If you want to modify a request or do anything before sending, you can use this event. For example, you can add a proxy for some providers.

**afterResponse**
If you want to modify a response or do anything after a response, you can use this event. For example, you can log responses for providers.

**searchResultItemCallback**:
It means you can modify a searchResultItem, after when it created. For example Google provides url in a different format. You can clear that. It works for each of all searchResultItems.

**searchResultCallback**:
It means you can modify all search result data if you want, before the presentation.

If you want define a listener; you should create a class implements "ProviderListenerInterface" interface. 

```php
class AOL implements ProviderListenerInterface
```

Then you should define it in your config.
```yaml
aol:
    ...
    ...
    ...
    listener: [YOUR\NAME\SPACE\AOL]