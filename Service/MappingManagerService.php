<?php

namespace ThinkBig\Bundle\ResourceBundle\Service;

use ThinkBig\Bundle\ResourceBundle\Entity\Mapping;
use Doctrine\Common\Util\ClassUtils;

/**
* 
*/
class MappingManagerService
{

	private $em;
	
	function __construct($doctrine)
	{
		
		$this->em = $doctrine->getManager();

	}

	public function addResource($object, $resource, $context = null) {

		$mapping 	= new Mapping();
		
		$mapping->setObjectClass(ClassUtils::getClass($object));
		$mapping->setObjectId($object->getId());
		$mapping->setFile($resource);

		if ($context) {

			$mapping->setMapping($context);

		}

		$this->em->persist($mapping);

		return $mapping;

	}

	public function getResources($object, $mapping = null) {

		$objectClass = ClassUtils::getClass($object);
		$objectId 	 = $object->getId();

		$qb 		 = $this->em->createQueryBuilder();

		$qb->select('f')->from('ThinkBigResourceBundle:File', 'f');

		$qb->innerJoin('f.Mappings', 'm', 'WITH', "m.objectId = :id AND m.objectClass = :class");

		if ($mapping) {

			$qb->andWhere('m.mapping = :mapping')->setParameter('mapping', $mapping);

		}

		$qb->orderBy('f.id', 'DESC');

		$qb->setParameter('class', $objectClass);
		$qb->setParameter('id', $objectId);

		return $qb->getQuery()->getResult();

	}

	public function getLatestResource($object, $mapping = null) {

		$resources = $this->getResources($object, $mapping);

		if ($resources) {

			return $resources[0];

		}
		else {

			$qb = $this->em->createQueryBuilder();

			$qb->select('f')->from('ThinkBigResourceBundle:File', 'f');

			$qb->innerJoin('f.Mappings', 'm', 'WITH', "m.objectId = :id AND m.objectClass = :class");
			
			if ($mapping) {

				$qb->andWhere('m.mapping = :mapping')->setParameter('mapping', $mapping);

			}
			
			$qb->setParameter('id', $object->getId());
			$qb->setParameter('class', ClassUtils::getClass($object));

			$qb->orderBy('f.id', 'ASC');
			$qb->setMaxResults(1);

			return $qb->getQuery()->getOneOrNullResult();

		}

	}

	public function getFavoriteResources($user) {

		$qb 		 = $this->em->createQueryBuilder();

		$qb->select('f')->from('ThinkBigResourceBundle:File', 'f');

		$qb->innerJoin('f.Favorites', 'u', 'WITH', "u.id = :id");

		$qb->setParameter('id', $user->getId());

		return $qb->getQuery()->getResult();

	}


	public function hasResource($object, $resource, $context = null) {




	}

	public function removeResource($resource, $object = null) {

		$file = $this->em->getRepository('ThinkBigResourceBundle:File')->findOneBy(array('uid' => $resource));

		$em->remove($file);
		$em->flush();

	}

}



