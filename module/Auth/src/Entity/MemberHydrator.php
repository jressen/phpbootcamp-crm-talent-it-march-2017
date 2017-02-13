<?php

namespace Auth\Entity;


use Zend\Hydrator\HydratorInterface;

class MemberHydrator implements HydratorInterface
{
    /**
     * @inheritDoc
     */
    public function extract($object)
    {
        if ($object instanceof MemberInterface) {
            return [
                'member_id' => $object->getMemberId(),
                'linkedin_id' => $object->getLinkedinId(),
                'access_token' => $object->getAccessToken(),
            ];
        }
        return [];
    }

    /**
     * @inheritDoc
     */
    public function hydrate(array $data, $object)
    {
        $class = get_class($object);
        return new $class($data['member_id'], $data['linkedin_id'], $data['access_token']);
    }

}