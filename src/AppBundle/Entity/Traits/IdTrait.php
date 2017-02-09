<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Class IdTrait
 * @package EmailBundle\Entity\Traits
 */
trait IdTrait
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"sonata_api_read", "sonata_api_write"})
     */
    private $id;

    /**
     * Get id
     * @Groups({"sonata_api_read", "sonata_api_write"})
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
