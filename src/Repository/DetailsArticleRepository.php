<?php

namespace App\Repository;

use App\Entity\DetailsArticle;
use App\Entity\ListeCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetailsArticle>
 *
 * @method DetailsArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailsArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailsArticle[]    findAll()
 * @method DetailsArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailsArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailsArticle::class);
    }

    public function save(DetailsArticle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DetailsArticle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function totalPrix($listeCourse):float|null
    {
        return $this->getEntityManager()->getConnection()->prepare(
            'SELECT SUM(prix_unitaire * quantite) 
                    FROM details_article 
                    join article on article_id=article.id
                    WHERE liste_course_id = :id'
            )->executeQuery(['id' => $listeCourse->getId()])->fetchOne();
    }

    public function maxPrix($listeCourse):array|null
    {
        return $this->getEntityManager()->getConnection()->prepare(
            'SELECT prix_unitaire * quantite, article.nom
                    FROM `details_article` 
                    JOIN article on article_id=article.id
                    WHERE (prix_unitaire * quantite) = 
                    (SELECT MAX(prix_unitaire * quantite) FROM `details_article`
                     JOIN article on article_id=article.id
                     where liste_course_id = :id)
                    AND liste_course_id = :id'
        )->executeQuery(['id' => $listeCourse->getId()])->fetchAllNumeric();
    }
    public function minPrix($listeCourse):array|null
    {
        return $this->getEntityManager()->getConnection()->prepare(
            'SELECT prix_unitaire * quantite, article.nom
                    FROM `details_article` 
                    JOIN article on article_id=article.id
                    WHERE (prix_unitaire * quantite) = 
                    (SELECT MIN(prix_unitaire * quantite) FROM `details_article`
                     JOIN article on article_id=article.id
                     where liste_course_id = :id)
                    AND liste_course_id = :id'
        )->executeQuery(['id' => $listeCourse->getId()])->fetchAllNumeric();
    }
    public function moyPrix($listeCourse):float|null
    {
        return $this->getEntityManager()->getConnection()->prepare(
            'SELECT ROUND(sum(prix_unitaire * quantite)/SUM(quantite),2)
                    FROM details_article
                    join article on article_id=article.id
                    WHERE liste_course_id = :id'
        )->executeQuery(['id' => $listeCourse->getId()])->fetchOne();
    }

    function prixTotalParType($listeCourse):array|null
    {
        return $this->getEntityManager()->getConnection()->prepare(
            'SELECT ROUND(sum(prix_unitaire * quantite),2), type.nom
                    FROM details_article
                    join article on article_id=article.id
                    join type on type_id=type.id
                    WHERE liste_course_id = :id
                    GROUP BY type.nom'
        )->executeQuery(['id' => $listeCourse->getId()])->fetchAllNumeric();
    }

//    /**
//     * @return DetailsArticle[] Returns an array of DetailsArticle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DetailsArticle
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function deleteByListeCourse(ListeCourse $listeCourse)
    {
        $this->getEntityManager()->getConnection()->prepare(
            'DELETE FROM details_article WHERE liste_course_id = :id'
        )->execute(['id' => $listeCourse->getId()]);
    }
}
