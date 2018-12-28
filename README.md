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
### Test Coverage Screen Output:
[![N|Test Results](https://raw.githubusercontent.com/mustafaileri/search-aggregator/master/sample_outputs/test-results.png)](https://raw.githubusercontent.com/mustafaileri/search-aggregator/master/sample_outputs/test-results.png)

### Sample Result Screen Output:
[![N|Test Results](https://raw.githubusercontent.com/mustafaileri/search-aggregator/master/sample_outputs/sample-result.png)](https://raw.githubusercontent.com/mustafaileri/search-aggregator/master/sample_outputs/sample-result.png)

### Sample Overriden Result Screen Output (Added AOL and disabled other provider excluded Google):
[![N|Test Results](https://raw.githubusercontent.com/mustafaileri/search-aggregator/master/sample_outputs/sample-extended-result.png)](https://raw.githubusercontent.com/mustafaileri/search-aggregator/master/sample_outputs/sample-extended-result.png)

### How to use it?
You can use it after dwonload it via composer.

```php
$searcher = new Searcher();
$searcher->search('keyword');
```


#### How to add a new provider:
If you want add a new provider. inject your own providers.yaml file like below:

```yaml
...
...
new_search_engine:
  enabled: true # you can enable or disable search engine
  host: https://www.new-search-engine.com # host name
  searchPath: /search?q=%s #search query pattern
  selectors: # selectors
    row_selector: 'li.b_algo' # search item selector
    title_selector: 'h2 > a' # item title selector
    link_selector: 'h2 > a' # item lin selector
...
...
```

```php
$providerRepository = new ProviderRepository('YOUR_CONFIG_FILE PATH');
$search->setProviderRepository($providerRepository);
```
**Example**
There is a sample overriden config file. New provider added (AOL) and other providers disabled via overriden config file. You can run overrided config via test-tool:
```bash
docker-compose  exec app php bin/console test-tool "pointer brand protection" /app/config/providers_extended.yaml
```

#### Allowed modification via Listener:
There is an event listener mechanism. It allows to you modify or intervene before or after some events. It works event and provider based.

**beforeRequest**: 
If you want to modify a request or do anything before sending, you can use this event. For example, you can add a proxy for some providers.

**afterResponse**:
If you want to modify a response or do anything after a response, you can use this event. For example, you can log responses for providers.

**searchResultItemCallback**:
It means you can modify a searchResultItem, after when it created. For example Google provides url in a different format. You can clear that. It works for each of all searchResultItems.

**searchResultCallback**:
It means you can modify all search result data if you want, before the presentation.

If you want define a listener; you should create a class extended "AbstractProviderListener" abstract class. 

```php
class AOL extends AbstractProviderListener
```

Then you should define it in your config.
```yaml
aol:
    ...
    ...
    ...
    listener: [YOUR\NAME\SPACE\AOL]
```

### Quality Metrics:
You can check quality of library from sonarcloud:

https://sonarcloud.io/dashboard?id=mustafaileri_search-aggregator
