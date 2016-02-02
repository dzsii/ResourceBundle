<?php

namespace ThinkBig\Bundle\ResourceBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use ThinkBig\Bundle\ResourceBundle\Entity\File as FileEntity;
use ThinkBig\Bundle\ResourceBundle\Form\Type\FileType as FileResourceType;

class DefaultController extends Controller
{
    /**
     * @Route("/dropzone/upload", name="dropzone_upload", options={"expose"=true})
     * @Template()
     */
    public function indexAction(Request $request)
    {

        $em         = $this->getDoctrine()->getEntityManager();

        $filesystem = $this->get('oneup_flysystem.mount_manager')->getFilesystem('uploads');
    	$filenames  = array();

    	$file = $request->files->get('file_resource');

		if ($file->isValid()) {

            $entity     = new FileEntity();
            $entity->setFile($file);

            $em->persist($entity);
		
			$filenames[] = $entity->getUid();
		
		}

        $em->flush();
        
    	return new JsonResponse(array('fileName' => $filenames));
    
    }

    /**
     * @Route("/dropzone/uploader", name="dropzone_uploader", options={"expose"=true})
     * @Template()
     */
    public function uploaderAction(Request $request)
    {

        $resource = new FileEntity();
        $form = $this->createFormBuilder()
            ->add('file', 'file', array('multiple' => true, 'required' => true))
            ->add('file_x', new FileResourceType(), array('label' => false, 'data' => array('56ec2439d5e6f70f6ddffcca744418a22d7be6ab', '718453f14e13c16c015a9c28db67acc992685e33')))
            ->add('task', 'text')
            ->add('submit', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($resource);
            $em->flush();

            return $this->redirectToRoute('dropzone_uploader');
        }


        return array('form' => $form->createView());

    }



    /**
     * @Route("/dropzone/remove/{uid}", name="dropzone_remove", options={"expose"=true})
     */
    public function removeAction($uid) {

        $em = $this->getDoctrine()->getEntityManager();

        $resource = $em->getRepository('ThinkBigResourceBundle:File')->findOneBy(array('uid' => $uid));

        if ($resource) {

            $em->remove($resource);

            $em->flush();

        }

        return new JsonResponse(array('status' => 'ok'));

    }



}
