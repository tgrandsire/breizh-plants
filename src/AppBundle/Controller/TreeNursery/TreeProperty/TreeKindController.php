<?php

namespace AppBundle\Controller\TreeNursery\TreeProperty;

use AppBundle\Entity\TreeNursery\TreeProperty\TreeKind;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Treekind controller.
 *
 * @Route("treenursery/treekinds")
 */
class TreeKindController extends Controller
{
    /**
     * Lists all treeKind entities.
     *
     * @Route("/", name="treenursery_treekind_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $treeKinds = $em->getRepository('AppBundle:TreeNursery\TreeKind')->findAll();

        return $this->render('treenursery/treekind/index.html.twig', array(
            'treeKinds' => $treeKinds,
        ));
    }

    /**
     * Creates a new treeKind entity.
     *
     * @Route("/new", name="treenursery_treekind_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $treeKind = new Treekind();
        $form = $this->createForm('AppBundle\Form\TreeNursery\TreeKindType', $treeKind);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($treeKind);
            $em->flush();

            return $this->redirectToRoute('treenursery_treekind_show', array('id' => $treeKind->getId()));
        }

        return $this->render('treenursery/treekind/new.html.twig', array(
            'treeKind' => $treeKind,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a treeKind entity.
     *
     * @Route("/{id}", name="treenursery_treekind_show")
     * @Method("GET")
     */
    public function showAction(TreeKind $treeKind)
    {
        $deleteForm = $this->createDeleteForm($treeKind);

        return $this->render('treenursery/treekind/show.html.twig', array(
            'treeKind' => $treeKind,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing treeKind entity.
     *
     * @Route("/{id}/edit", name="treenursery_treekind_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TreeKind $treeKind)
    {
        $deleteForm = $this->createDeleteForm($treeKind);
        $editForm = $this->createForm('AppBundle\Form\TreeNursery\TreeKindType', $treeKind);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('treenursery_treekind_edit', array('id' => $treeKind->getId()));
        }

        return $this->render('treenursery/treekind/edit.html.twig', array(
            'treeKind' => $treeKind,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a treeKind entity.
     *
     * @Route("/{id}", name="treenursery_treekind_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TreeKind $treeKind)
    {
        $form = $this->createDeleteForm($treeKind);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($treeKind);
            $em->flush();
        }

        return $this->redirectToRoute('treenursery_treekind_index');
    }

    /**
     * Creates a form to delete a treeKind entity.
     *
     * @param TreeKind $treeKind The treeKind entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TreeKind $treeKind)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('treenursery_treekind_delete', array('id' => $treeKind->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
