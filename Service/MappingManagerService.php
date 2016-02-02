<?php

namespace ThinkBig\Bundle\ResourceBundle\Service;

use ThinkBig\Bundle\ResourceBundle\Entity\Mapping;

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

		$mapping = new Mapping();

		$mapping->setObjectClass(get_class($object));
		$mapping->setObjectId($object->getId());
		$mapping->setFile($resource);

		if ($context) {

			$mapping->setMapping($context);

		}

		$this->em->persist($mapping);

		return $mapping;

	}

	public function getResources($object, $mapping = null) {

		$objectClass = get_class($object);
		$objectId 	 = $object->getId();

		$qb 		 = $this->em->createQueryBuilder();

		$qb->select('f')->from('ThinkBigResourceBundle:File', 'f');

		$qb->innerJoin('f.Mappings', 'm', 'WITH', "m.objectId = :id");

		if ($mapping) {

			$qb->andWhere('m.mapping = :mapping')->setParameter('mapping', $mapping);

		}

		$qb->orderBy('f.id', 'DESC');

		//$qb->setParameter('class', $objectClass);
		$qb->setParameter('id', $objectId);

		return $qb->getQuery()->getResult();

	}

	public function getLatestResource($object, $mapping = null, $default = 'profile') {

		$resources = $this->getResources($object, $mapping);
		$objectId  = $object->getId();

		if ($resources) {

			return $resources[0];

		}
		else {

			$qb = $this->em->createQueryBuilder();

			$qb->select('f')->from('ThinkBigResourceBundle:File', 'f');

			$qb->innerJoin('f.Mappings', 'm', 'WITH', "m.objectId = :id");
			
			if ($mapping) {

				$qb->andWhere('m.mapping = :mapping')->setParameter('mapping', $mapping);

			}
			
			$qb->setParameter('id', $objectId);

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



