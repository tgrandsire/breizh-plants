<?php

namespace AppBundle\Controller\TreeNursery\TreeProperty;

use AppBundle\Entity\TreeNursery\TreeProperty\FlowerColor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Flowercolor controller.
 *
 * @Route("treenursery/flower-colors")
 */
class FlowerColorController extends Controller
{
    /**
     * Lists all flowerColor entities.
     *
     * @Route("/", name="treenursery_flower-colors_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $flowerColors = $em->getRepository('AppBundle:TreeNursery\TreeProperty\FlowerColor')->findAll();

        return $this->render('treenursery/treeproperty/flowercolor/index.html.twig', array(
            'flowerColors' => $flowerColors,
        ));
    }

    /**
     * Creates a new flowerColor entity.
     *
     * @Route("/new", name="treenursery_flower-colors_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $flowerColor = new Flowercolor();
        $form = $this->createForm('AppBundle\Form\TreeNursery\TreeProperty\FlowerColorType', $flowerColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($flowerColor);
            $em->flush();

            return $this->redirectToRoute('treenursery_flower-colors_show', array('id' => $flowerColor->getId()));
        }

        return $this->render('treenursery/treeproperty/flowercolor/new.html.twig', array(
            'flowerColor' => $flowerColor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a flowerColor entity.
     *
     * @Route("/{id}", name="treenursery_flower-colors_show")
     * @Method("GET")
     */
    public function showAction(FlowerColor $flowerColor)
    {
        $deleteForm = $this->createDeleteForm($flowerColor);

        return $this->render('treenursery/treeproperty/flowercolor/show.html.twig', array(
            'flowerColor' => $flowerColor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing flowerColor entity.
     *
     * @Route("/{id}/edit", name="treenursery_flower-colors_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FlowerColor $flowerColor)
    {
        $deleteForm = $this->createDeleteForm($flowerColor);
        $editForm = $this->createForm('AppBundle\Form\TreeNursery\TreeProperty\FlowerColorType', $flowerColor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('treenursery_flower-colors_edit', array('id' => $flowerColor->getId()));
        }

        return $this->render('treenursery/treeproperty/flowercolor/edit.html.twig', array(
            'flowerColor' => $flowerColor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a flowerColor entity.
     *
     * @Route("/{id}", name="treenursery_flower-colors_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FlowerColor $flowerColor)
    {
        $form = $this->createDeleteForm($flowerColor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($flowerColor);
            $em->flush();
        }

        return $this->redirectToRoute('treenursery_flower-colors_index');
    }

    /**
     * Creates a form to delete a flowerColor entity.
     *
     * @param FlowerColor $flowerColor The flowerColor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FlowerColor $flowerColor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('treenursery_flower-colors_delete', array('id' => $flowerColor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
