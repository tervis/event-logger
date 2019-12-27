<?php


namespace Tervis\EventLoggerBundle;


use App\Entity\Log;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Handler\AbstractProcessingHandler;


/**
 * Class UserActivityLogger
 * @package App\Utils\Logger
 */
class UserActivityLogger extends AbstractProcessingHandler
{

    const MESSAGE = 'activity';
    const LEVEL = 'INFO';

    /**
     * @var
     */
    private $initialized;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var string
     */
    private $channel;


    /**
     * UserActivityLogger constructor.
     * @param EntityManagerInterface $em
     * @param string $channelName
     */
    public function __construct(EntityManagerInterface $em, string $channelName)
    {
        parent::__construct();

        $this->em = $em;
        $this->channel = $channelName;

    }

    protected function write(array $record) : void
    {
        /*if (!$this->initialized) {
            $this->initialize();
        }*/

        if ($this->channel != $record['channel']) {
            return;
        }

        // @TODO log only level 'INFO' and message 'activity' to db
        if($record['level_name'] !== self::LEVEL || $record['message'] !== self::MESSAGE){
            return;
        }


        //dd($record['context']);

        $logEntry = new Log();
        $logEntry->setMessage($record['message']);
        $logEntry->setLevel($record['level']);
        $logEntry->setLevelName($record['level_name']);
        $logEntry->setExtra($record['extra']);
        $logEntry->setContext('data',$record['context']);

        $this->em->persist($logEntry);
        $this->em->flush();

        // @TODO Log Entity
        /*$log = new \stdClass(); //new Log();
        $log->message = $record['message'];
        $log->context = $record['context'];
        $log->level = $record['level_name'];*/
        //dd($log);
    }

    private function initialize()
    {
        $this->initialized = true;
    }
}
