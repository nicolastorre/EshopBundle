<?php
// src/Nicolas/BlogBundle/Repository/ArticleRepository.php
namespace Nicolas\EshopBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Nicolas\EshopBundle\Entity\Product;

/**
 * Class ProductRepository
 * @package Nicolas\ProductBundle\Entity
 */
class ProductRepository extends EntityRepository
{
	/**
	 * @return array
	 */
	public function findPublishedAndOrdered()
	{

		$qb = $this->createQueryBuilder('p');

		$qb
			->where('p.published = :published')
			->setParameter('published', Product::PUBLISHED_PRODUCT)
			->orderBy('p.publishedDate', 'DESC')
		;

		return $qb
			->getQuery()
			->getResult()
		;
	}

	public function countAllPublished() {

		return $this->createQueryBuilder('a')
			->select('COUNT(a.id)')
			->where('a.published = :published')
			->setParameter('published', Product::PUBLISHED_PRODUCT)
			->getQuery()
			->getSingleScalarResult();
	}
}