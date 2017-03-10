<?php

namespace MessageBundle\Serializer;

use Sonata\CoreBundle\Serializer\BaseSerializerHandler;

/**
 * Class MessageSerializerHandler
 * @package MessageBundle\Serializer
 */
class MessageSerializerHandler extends BaseSerializerHandler
{
    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return 'sonata_message_message_id';
    }
}
