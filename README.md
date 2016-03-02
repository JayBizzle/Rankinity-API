# Rankinity API
[![Build Status](https://img.shields.io/travis/JayBizzle/Rankinity-API/master.svg?style=flat-square)](https://travis-ci.org/JayBizzle/Rankinity-API) [![StyleCI](https://styleci.io/repos/52999050/shield)](https://styleci.io/repos/52999050) [![Total Downloads](https://img.shields.io/packagist/dt/JayBizzle/Rankinity-API.svg?style=flat-square)](https://packagist.org/packages/jaybizzle/rankinity-api)
### Installation
Add `"jaybizzle/rankinity-api": "1.*"` to your composer.json.

### Usage
You can read the official Rankinity API documention here - http://my.rankinity.com/api.en

All the Rankinity API endpoints can be called by prefixing the name with `get` e.g

```php
use Jaybizzle\Rankinity;

$r = new Rankinity('YOUR_API_KEY');

// get all projects
$projects = $r->getProjects();
```

Most Rankinity API endpoints can accept query string parameters, such as `sort_property` to sort the results returned. Taking the above projects example, we can simply do this...

```php
$projects = $r->sortProperty('name')->getProjects();
```

These can also be chained...

```php
$projects = $r->sortProperty('name')->sortAscending('false')->getProjects();
```

Some more examples...

```php
//  list of competitors
$competitors = $r->project('project_id')->getCompetitors();

// list of keywords
$keywords = $r->project('project_id')->getKeywords();

// list of keyword groups
$groups = $r->project('project_id')->getGroups();

// list of ranks
$ranks = $r->project('project_id')->searchEngine('search_engine_id')->getRanks();
```

_NOTE: Query parameters are listed in the Rankinity API docs as `snake_case` but we access them using `camelCase` methods so all method calls have a consistent naming convention_
