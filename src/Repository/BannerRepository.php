<?php

declare(strict_types=1);

namespace Siganushka\BannerBundle\Repository;

use Siganushka\BannerBundle\Entity\Banner;
use Siganushka\GenericBundle\Repository\GenericEntityRepository;

/**
 * @extends GenericEntityRepository<Banner>
 *
 * @method Banner      createNew(...$args)
 * @method Banner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Banner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Banner[]    findAll()
 * @method Banner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BannerRepository extends GenericEntityRepository
{
}
