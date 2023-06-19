<?php

namespace App\Repository;

use App\Entity\URL;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<URL>
 *
 * @method URL|null find($id, $lockMode = null, $lockVersion = null)
 * @method URL|null findOneBy(array $criteria, array $orderBy = null)
 * @method URL[]    findAll()
 * @method URL[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class URLRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, URL::class);
    }

    public function save(URL $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(URL $entity, bool $flush = false): void
    {
        $em = $this->getEntityManager();
        $em->remove($entity->getAnalytics());
        $em->remove($entity);

        if ($flush) {
            $em->flush();
        }
    }
}
