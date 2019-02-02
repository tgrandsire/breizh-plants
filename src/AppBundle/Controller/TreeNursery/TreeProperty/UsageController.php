<?php

namespace AppBundle\Controller\TreeNursery\TreeProperty;

use AppBundle\Entity\TreeNursery\TreeProperty\Usage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Usage controller.
 *
 * @Route("treenursery/usages")
 */
class UsageController extends Controller
{
    /**
     * Lists all usage entities.
     *
     * @Route("/", name="treenursery_usages_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usages = $em->getRepository('AppBundle:TreeNursery\TreeProperty\Usage')->findAll();

        return $this->render('treenursery/treeproperty/usage/index.html.twig', array(
            'usages' => $usages,
        ));
    }

    /**
     * Creates a new usage entity.
     *
     * @Route("/new", name="treenursery_usages_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usage = new Usage();
        $form = $this->createForm('AppBundle\Form\TreeNursery\TreeProperty\UsageType', $usage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usage);
            $em->flush();

            return $this->redirectToRoute('treenursery_usages_show', array('id' => $usage->getId()));
        }

        return $this->render('treenursery/treeproperty/usage/new.html.twig', array(
            'usage' => $usage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a usage entity.
     *
     * @Route("/{id}", name="treenursery_usages_show")
     * @Method("GET")
     */
    public function showAction(Usage $usage)
    {
        $deleteForm = $this->createDeleteForm($usage);

        return $this->render('treenursery/treeproperty/usage/show.html.twig', array(
            'usage' => $usage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing usage entity.
     *
     * @Route("/{id}/edit", name="treenursery_usages_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usage $usage)
    {
        $deleteForm = $this->createDeleteForm($usage);
        $editForm = $this->createForm('AppBundle\Form\TreeNursery\TreeProperty\UsageType', $usage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('treenursery_usages_edit', array('id' => $usage->getId()));
        }

        return $this->render('treenursery/treeproperty/usage/edit.html.twig', array(
            'usage' => $usage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a usage entity.
     *
     * @Route("/{id}", name="treenursery_usages_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usage $usage)
    {
        $form = $this->createDeleteForm($usage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usage);
            $em->flush();
        }

        return $this->redirectToRoute('treenursery_usages_index');
    }

    /**
     * Creates a form to delete a usage entity.
     *
     * @param Usage $usage The usage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usage $usage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('treenursery_usages_delete', array('id' => $usage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
