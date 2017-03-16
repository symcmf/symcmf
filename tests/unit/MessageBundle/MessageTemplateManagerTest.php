<?php


use MessageBundle\Entity\MessageTemplateManager;

class MessageTemplateManagerTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testGetPagerDefault()
    {
        $self = $this;
        $this
            ->getMessageTemplateManager(function ($qb) use ($self) {
                $qb->expects($self->once())->method('orderBy')->with(
                    $self->equalTo('m.subject'),
                    $self->equalTo('ASC')
                );
            })
            ->getPager([], 1);
    }

    public function testGetPagerSort()
    {
        $self = $this;
        $this
            ->getMessageTemplateManager(function ($qb) use ($self) {
                $qb->expects($self->exactly(1))->method('orderBy')->with(
                    $self->logicalOr(
                        $self->equalTo('m.id')
                    ),
                    $self->logicalOr(
                        $self->equalTo('DESC')
                    )
                );
            })
            ->getPager([], 1, 10, [
                'id' => 'DESC',
            ]);
    }

    public function testGetPagerWithInvalidSort()
    {
        $self = $this;
        $this
            ->getMessageTemplateManager(function ($qb) use ($self) {
            })
            ->getPager([], 1, 10, ['invalid' => 'ASC']);
    }

    protected function getMessageTemplateManager($qbCallback)
    {
        $query = $this->getMockForAbstractClass('Doctrine\ORM\AbstractQuery', [], '', false, true, true, ['execute']);
        $query->expects($this->any())->method('execute')->will($this->returnValue(true));

        $qb = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')
            ->setConstructorArgs([
                $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock()
            ])
            ->getMock();

        $qb->expects($this->any())->method('select')->will($this->returnValue($qb));
        $qb->expects($this->any())->method('getQuery')->will($this->returnValue($query));
        $qb->expects($this->any())->method('getRootAliases')->will($this->returnValue([]));

        $qbCallback($qb);

        $repository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')->disableOriginalConstructor()->getMock();
        $repository->expects($this->any())->method('createQueryBuilder')->will($this->returnValue($qb));

        $metadata = $this->getMockBuilder('Doctrine\Common\Persistence\Mapping\ClassMetadata')
            ->getMock();

        $metadata->expects($this->any())->method('getFieldNames')->will($this->returnValue(array(
            'subject',
            'template',
        )));

        $em = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $em->expects($this->any())->method('getRepository')->will($this->returnValue($repository));
        $em->expects($this->any())->method('getClassMetadata')->will($this->returnValue($metadata));

        $registry = $this->getMockBuilder('Doctrine\Common\Persistence\ManagerRegistry')->getMock();
        $registry->expects($this->any())->method('getManagerForClass')->will($this->returnValue($em));

        return new MessageTemplateManager('MessageBundle\Entity\MessageTemplate', $registry);
    }
}