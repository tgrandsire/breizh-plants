<?php

namespace AppBundle\Controller\TreeNursery;

use AppBundle\Entity\TreeNursery\Sort;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Sort controller.
 *
 * @Route("/treenursery/sorts")
 */
class SortController extends Controller
{
    /**
     * Lists all sort entities.
     *
     * @Route("/", name="treenursery_sorts_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sorts = $em->getRepository('AppBundle:TreeNursery\Sort')->findAll();

        return $this->render('treenursery/sort/index.html.twig', array(
            'sorts' => $sorts,
        ));
    }

    /**
     * Creates a new sort entity.
     *
     * @Route("/new", name="treenursery_sorts_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $sort = new Sort();
        $form = $this->createForm('AppBundle\Form\TreeNursery\SortType', $sort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sort);
            $em->flush();

            return $this->redirectToRoute('treenursery_sorts_show', array('id' => $sort->getId()));
        }

        return $this->render('treenursery/sort/new.html.twig', array(
            'sort' => $sort,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sort entity.
     *
     * @Route("/{id}", name="treenursery_sorts_show")
     * @Method("GET")
     */
    public function showAction(Sort $sort)
    {
        $deleteForm = $this->createDeleteForm($sort);

        return $this->render('treenursery/sort/show.html.twig', array(
            'sort' => $sort,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sort entity.
     *
     * @Route("/{id}/edit", name="treenursery_sorts_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Sort $sort)
    {
        $deleteForm = $this->createDeleteForm($sort);
        $editForm = $this->createForm('AppBundle\Form\TreeNursery\SortType', $sort);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('treenursery_sorts_edit', array('id' => $sort->getId()));
        }

        return $this->render('treenursery/sort/edit.html.twig', array(
            'sort' => $sort,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sort entity.
     *
     * @Route("/{id}", name="treenursery_sorts_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sort $sort)
    {
        $form = $this->createDeleteForm($sort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sort);
            $em->flush();
        }

        return $this->redirectToRoute('treenursery_sorts_index');
    }

    /**
     * Creates a form to delete a sort entity.
     *
     * @param Sort $sort The sort entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sort $sort)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('treenursery_sorts_delete', array('id' => $sort->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
