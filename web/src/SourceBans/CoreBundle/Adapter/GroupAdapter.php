<?php

namespace SourceBans\CoreBundle\Adapter;

use Pagerfanta\Pagerfanta;
use SourceBans\CoreBundle\Entity\EntityInterface;
use SourceBans\CoreBundle\Entity\Group;
use SourceBans\CoreBundle\Event\AdapterEvents;
use SourceBans\CoreBundle\Event\GroupAdapterEvent;
use SourceBans\CoreBundle\Exception\InvalidFormException;
use SourceBans\CoreBundle\Form\GroupForm;

/**
 * GroupAdapter
 */
class GroupAdapter extends AbstractAdapter
{
    /**
     * @inheritdoc
     * @return Pagerfanta
     */
    public function all($limit = 25, $page = 1, $sort = null, $order = null, array $options = [])
    {
        $query = $this->repository->createQueryBuilder('webGroup')
            ->orderBy(sprintf('webGroup.%s', $sort ?: 'name'), $order)
            ->getQuery();

        $pager = static::queryToPager($query);

        return $pager->setCurrentPage($page)->setMaxPerPage($limit);
    }

    /**
     * @inheritdoc
     * @return Group
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * @inheritdoc
     * @return Group
     */
    public function create(array $parameters)
    {
        $entity = new $this->entityClass;

        $this->processForm($entity, $parameters);
        $this->dispatcher->dispatch(AdapterEvents::GROUP_CREATE, new GroupAdapterEvent($entity));

        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function update(EntityInterface $entity, array $parameters)
    {
        $this->processForm($entity, $parameters);
        $this->dispatcher->dispatch(AdapterEvents::GROUP_UPDATE, new GroupAdapterEvent($entity));
    }

    /**
     * @inheritdoc
     */
    public function delete(EntityInterface $entity)
    {
        $this->objectManager->remove($entity);
        $this->objectManager->flush();
        $this->dispatcher->dispatch(AdapterEvents::GROUP_DELETE, new GroupAdapterEvent($entity));
    }

    /**
     * @param EntityInterface $entity
     * @param array $parameters
     * @throws InvalidFormException
     */
    protected function processForm(EntityInterface $entity, array $parameters)
    {
        $this->submitForm(GroupForm::class, $entity, $parameters);

        $this->objectManager->persist($entity);
        $this->objectManager->flush();
    }
}
