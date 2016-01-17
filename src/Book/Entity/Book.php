<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16.01.16
 * Time: 21:17
 */

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Silex\Application;

/**
 * Book
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="Entity\BookRepository")
 */
class Book
{
    private $app;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publication_at", type="datetime",
     * options={"comment" = "дата проведения экспорта данных"})
     */
    private $publicationAt;
    /**
     * @var string
     *
     * @ORM\Column(name="author_name", type="string", length=250, nullable=true)
     */
    private $authorName;
    /**
     * @var string
     *
     * @ORM\Column(name="author_ip", type="string", length=50, nullable=true)
     */
    private $authorIp;
    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;
    /**
     * @var integer
     *
     * @ORM\Column(name="likes_count", type="integer", length=10, nullable=true)
     */
    private $likesCount;
    /**
     * @var array
     *
     * @ORM\Column(name="like_ip", type="array", nullable=true)
     */
    private $likeIp;
    /**
     * @var integer
     */
    private $likeCount;

    function __construct(Application $app)
    {
        $this->publicationAt = new \DateTime();
        $this->app = $app;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getPublicationAt()
    {
        return $this->publicationAt;
    }

    /**
     * @param \DateTime $publicationAt
     */
    public function setPublicationAt($publicationAt)
    {
        $this->publicationAt = $publicationAt;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param string $authorName
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;
    }

    /**
     * @return string
     */
    public function getAuthorIp()
    {
        return $this->authorIp;
    }

    /**
     * @param string $authorIp
     */
    public function setAuthorIp($authorIp)
    {
        $this->authorIp = $authorIp;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getLikesCount()
    {
        return $this->likesCount;
    }

    /**
     * @return int
     */
    public function getLikeCount()
    {
        return count($this->likeIp);
    }

    /**
     * @param int $likesCount
     */
    public function setLikesCount($likesCount)
    {
        $this->likesCount = $likesCount;
    }

    /**
     * Add likeIp
     *
     * @param string $data
     *
     * @return boolean
     */
    public function addLikeIp($data)
    {
        $output = FALSE;
        $t = $this->likeIp ? $this->likeIp : [];
        if (!in_array($data, $t, TRUE)) {
            $this->likeIp[] = $data;
            $output = TRUE;
        }

        return $output;
    }

    /**
     * Get likeIp
     *
     * @return array
     */
    public function getLikeIp()
    {
        return $this->likeIp;
    }

    /**
     * Set likeIp
     *
     * @param array $likeIp
     *
     * @return Book
     */
    public function setLikeIp(array $likeIp)
    {
        $this->likeIp = array();

        foreach ($likeIp as $data) {
            $this->addLikeIp($data);
        }

        return $this;
    }
}