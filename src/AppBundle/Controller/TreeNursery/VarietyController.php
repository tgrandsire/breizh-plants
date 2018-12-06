<?php

namespace AppBundle\Controller\TreeNursery;

use AppBundle\Entity\TreeNursery\Variety;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Variety controller.
 *
 * @Route("/treenursery/varieties")
 */
class VarietyController extends Controller
{
    /**
     * Lists all variety entities.
     *
     * @Route("/", name="treenursery_varieties_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $varieties = $em->getRepository('AppBundle:TreeNursery\Variety')->findAll();

        return $this->render('treenursery/variety/index.html.twig', array(
            'varieties' => $varieties,
        ));
    }

    /**
     * Creates a new variety entity.
     *
     * @Route("/new", name="treenursery_varieties_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $variety = new Variety();
        $form = $this->createForm('AppBundle\Form\TreeNursery\VarietyType', $variety);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($variety);
            $em->flush();

            return $this->redirectToRoute('treenursery_varieties_show', array('id' => $variety->getId()));
        }

        return $this->render('treenursery/variety/new.html.twig', array(
            'variety' => $variety,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a variety entity.
     *
     * @Route("/{id}", name="treenursery_varieties_show")
     * @Method("GET")
     */
    public function showAction(Variety $variety)
    {
        $deleteForm = $this->createDeleteForm($variety);

        return $this->render('treenursery/variety/show.html.twig', array(
            'variety' => $variety,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing variety entity.
     *
     * @Route("/{id}/edit", name="treenursery_varieties_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Variety $variety)
    {
        $deleteForm = $this->createDeleteForm($variety);
        $editForm = $this->createForm('AppBundle\Form\TreeNursery\VarietyType', $variety);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('treenursery_varieties_edit', array('id' => $variety->getId()));
        }

        return $this->render('treenursery/variety/edit.html.twig', array(
            'variety' => $variety,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a variety entity.
     *
     * @Route("/{id}", name="treenursery_varieties_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Variety $variety)
    {
        $form = $this->createDeleteForm($variety);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($variety);
            $em->flush();
        }

        return $this->redirectToRoute('treenursery_varieties_index');
    }

    /**
     * Creates a form to delete a variety entity.
     *
     * @param Variety $variety The variety entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Variety $variety)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('treenursery_varieties_delete', array('id' => $variety->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
