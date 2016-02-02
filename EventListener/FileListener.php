<?php

// src/AppBundle/EventListener/SearchIndexerSubscriber.php
namespace ThinkBig\Bundle\ResourceBundle\EventListener;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;

use ThinkBig\Bundle\ResourceBundle\Entity\File as FileEntity;

class FileListener
{ 

    protected $mountManager; 

    public function __construct($mountManager) {

        $this->filesystem = $mountManager->getFilesystem('uploads');

    }

    public function prePersist(FileEntity $resource, LifecycleEventArgs $event)
    {

        if (null !== $resource->getFile()) {
            
            // do whatever you want to generate a unique name
            $uid = sha1(uniqid(mt_rand(), true));

            $resource->setUid($uid);

            $resource->setExtension($resource->getFile()->guessExtension());
            $resource->setMimeType($resource->getFile()->getMimeType());
            $resource->setName($resource->getFile()->getClientOriginalName());
            $resource->setSize($resource->getFile()->getClientSize());
            $resource->setPath(sprintf('%s.%s', $uid, $resource->getExtension()));
        
        }

    }

    public function postPersist(FileEntity $resource, LifecycleEventArgs $args)
    {

        if (null === $resource->getFile()) {
            return;
        }

        $stream     = fopen($resource->getFile()->getRealPath(), 'r+');
        $this->filesystem->writeStream($resource->getPath(), $stream);
                
        fclose($stream);

        $resource->setfile(null);
        

    }

    public function postRemove(FileEntity $resource, LifecycleEventArgs $event) {

        $this->filesystem->deleteDir(sprintf('/%s',$resource->getUid()));

    }
}