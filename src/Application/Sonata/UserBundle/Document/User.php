<?php

/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Document;

use EmailBundle\Entity\EmailUser;
use Sonata\UserBundle\Document\BaseUser as BaseUser;

/**
 * This file has been generated by the Sonata EasyExtends bundle.
 *
 * @link https://sonata-project.org/bundles/easy-extends
 *
 * References :
 *   working with object : http://www.doctrine-project.org/projects/orm/2.0/docs/reference/working-with-objects/en
 *
 * @author <yourname> <youremail>
 */
class User extends BaseUser
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\OneToMany(targetEntity="EmailUser", mappedBy="user", cascade={"remove"}, orphanRemoval=true)
     */
    private $emails;

    /**
     * @param EmailUser $email
     */
    public function addEmail(EmailUser $email)
    {
        $this->emails->add($email);
    }

    /**
     * @param EmailUser $email
     */
    public function removeEmail(EmailUser $email)
    {
        $this->emails->removeElement($email);
    }

    /**
     * @return array
     */
    public function getEmails()
    {
        return $this->emails->toArray();
    }
}