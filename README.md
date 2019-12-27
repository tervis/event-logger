# EventLogger
Monolog database logger


## install

Add repository to composer.json
```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/tervis/event-logger.git"
    }
]
```

require

```
composer require tervis/event-logger

```
## Configuration

Import Services and set default channel name

```yaml
#config/services.yaml
parameters:
    channel_name: 'userActivity' #userActivityLogger

services:
...
    application.utils.logger.doctrine_handler:
        class: 'Tervis\EventLoggerBundle\UserActivityLogger'
        arguments:
            - "@doctrine.orm.entity_manager"
            - "%channel_name%"
```

Configure Monolog to use custom channel...

```yaml
#config/packages/config.yaml
monolog:
  channels: ["%channel_name%"]
  handlers:
    main:
      channels: ["!%channel_name%"]
    userActivity:
      type: stream
      path: "%kernel.logs_dir%/%channel_name%.%kernel.environment%.log"
      level: debug
      channels: ["%channel_name%"]

    doctrine_channel:
      type: service
      id: application.utils.logger.doctrine_handler
      level: debug
      channels: ["%channel_name%"]
```

Create Log entity

```
bin/console make:entity Log
```

Edit Log entity with default fields 

```php
//src/Entity/log.php

namespace App\Entity;

use Tervis\EventLoggerBundle\UserActivityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LogRepository")
 * @ORM\Table(name="log")
 * @ORM\HasLifecycleCallbacks
 */
class Log
{
    // add fields with trait
    use UserActivityTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
```

## Usage

```php
use Tervis\EventLoggerBundle\UserActivityLogger;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class Controller
{
    private $logger;

    public function __construct(LoggerInterface $userActivityLogger)
    {
        $this->logger = $userActivityLogger;
    }
    
    public function indexAction(): Response
    {
        $this->logger->info(UserActivityLogger::MESSAGE,['data3'=> new \DateTime()]);
        return new Response('example');
    }
}
```