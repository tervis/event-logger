<?php


namespace Tervis\EventLoggerBundle;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait UserActivityTrait
 * @package App\UserActivityLogger
 */
trait UserActivityTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $message;

    /**
     * @var array
     * @ORM\Column(type="json_array", nullable=true)
     */
    protected $context=[];

    /**
     * @ORM\Column(name="level", type="smallint")
     */
    protected $level;

    /**
     * @ORM\Column(name="level_name", type="string", length=50)
     */
    protected $levelName;

    /**
     * @ORM\Column(name="extra", type="array", nullable=true)
     */
    protected $extra=[];

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * UserActivityTrait constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setContext(string $key, $value) : self
    {
        $this->context[$key] = $value;

        return $this;
    }

    /**
     * @param string|null $key
     * @param string|null $default
     * @return mixed
     */
    public function getContext(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->context;
        }
        if (!isset($this->context[$key])) {
            return $default;
        }

        return $this->context[$key];
    }

    /**
     * @return array|null
     */
    public function getExtra(): ?array
    {
        return $this->extra;
    }

    /**
     * @param mixed $extra
     * @return UserActivityTrait
     */
    public function setExtra(array $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     * @return UserActivityTrait
     */
    public function setLevel($level): self
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLevelName()
    {
        return $this->levelName;
    }

    /**
     * @param mixed $levelName
     * @return UserActivityTrait
     */
    public function setLevelName($levelName): self
    {
        $this->levelName = $levelName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
