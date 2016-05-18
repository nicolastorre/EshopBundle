<?php

namespace Nicolas\EshopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

use Nicolas\EshopBundle\Entity\Product;
use Nicolas\BlogBundle\Entity\Image;
use Gregwar\Image\Image as ImageTool;


class DefaultController extends Controller
{

	protected function zoomCrop(Product $product) {

		$imagePath = __dir__.Image::UPLOAD_DIR . $product->getImage()->getId() .'.'. $product->getImage()->getUrl();
		chmod($imagePath, 0755);
		ImageTool::open($imagePath)
			->zoomCrop(300, 300,"#346A85","center","center")
			->save($imagePath);
	}

	protected function deleteForm($route, $id = NULL) {

		return $this->createFormBuilder(array('id' => $id))
			->setAction($this->generateUrl($route, array('id' => $id)))
			->add('id', HiddenType::class)
			->getForm();
	}

	/**
	 * @param $route
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function deleteFormAction($route, $id) {
		$form = $this->deleteForm($route, $id)
			->createView();

		return $this->render('NicolasBlogBundle:Partials/Elements:DeleteForm.html.twig', array(
			'deleteForm' => $form
		));
	}
}
