<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Siganushka\BannerBundle\Entity\Banner;
use Siganushka\Contracts\Doctrine\SortableInterface;

/**
 * @extends ServiceEntityRepository<Banner>
 *
 * @method Banner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Banner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Banner[]    findAll()
 * @method Banner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @psalm-method list<Banner>    findAll()
 * @psalm-method list<Banner>    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BannerRepository extends ServiceEntityRepository
{
    public function createQueryBuilderWithSorted(): QueryBuilder
    {
        return $this->createQueryBuilder('b')
            ->addOrderBy('b.sorted', 'DESC')
            ->addOrderBy('b.createdAt', 'DESC')
            ->addOrderBy('b.id', 'DESC')
        ;
    }

    public function createNew(): Banner
    {
        $ref = new \ReflectionClass($this->_entityName);

        /** @var Banner */
        $entity = $ref->newInstance();
        $entity->setSorted(SortableInterface::DEFAULT_SORTED);
        $entity->setEnabled(true);

        return $entity;
    }
}
