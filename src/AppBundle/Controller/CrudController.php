<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\{
    Configuration\Method, Configuration\Route
};
use Symfony\Component\HttpFoundation\Request;

/**
 * Lists all Task entities.
 *
 * @Route("/{prefix}", requirements={"prefix":"daily_tasks|events|todo|until|ponder|periodical"})
 */
class CrudController extends ControllerAbstract
{

    /**
     * Lists all Task entities.
     *
     * @Route("/", name="tasks_index")
     * @Method("GET")
     */
    public function indexAction(string $prefix)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $this->getTaskByPrefix($prefix);
        $tasks = $em->getRepository(get_class($task))->findAll();


        return $this->render('@App/' . $prefix . '/index.html.twig', array(
            'tasks' => $tasks,
            'delete_forms' => $this->generateDeleteFormsViews($tasks),
        ));
    }


    /**
     * Creates a new dailyTask entity.
     *
     * @Route("/new", name="task_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, string $prefix)
    {
        $form = $this->createForm($this->getFormClass($task = $this->getTaskByPrefix($prefix)), $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('task_show',
                array('prefix' => $prefix, 'id' => $task->getId()));
        }

        return $this->render('@App/' . $prefix . '/new.html.twig', array(
            'task' => $task,
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/{id}/switch_done", name="task_switch_done")
     * @Method("GET")
     */
    public function switchDoneAction(Request $request, string $prefix, string $id)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository($this->container->get('task_mapper')::getTargetClassName($prefix))->find($id);

        $date = new \DateTime($request->get('date'));
        if ($task->checkDone()) {
            $task->markUndone($date);
        } else {
            $task->markAsDone($date);
        }

        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Finds and displays a dailyTask entity.
     *
     * @Route("/{id}", name="task_show")
     * @Method("GET")
     *
     * //TODO: how entity was injected here?
     */
    public function showAction(string $prefix, string $id)
    {
        $delete_form = $this->createDeleteForm($task = $this->getTask($prefix, $id));

        return $this->render('@App/' . $prefix . '/show.html.twig', array(
            'task' => $task,
            'delete_form' => $delete_form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing dailyTask entity.
     *
     * @Route("/{id}/edit", name="task_edit")
     * @Method({"GET", "POST"})
     *
     */
    public function editAction(Request $request, string $prefix, string $id)
    {
        $delete_form = $this->createDeleteForm($task = $this->getTask($prefix, $id));
        $edit_form = $this->createForm($this->getFormClass($task), $task);
        $edit_form->handleRequest($request);

        if ($edit_form->isSubmitted() && $edit_form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('task_show',
                array(
                    'prefix' => $prefix,
                    'id' => $task->getId()
                ));
        }

        return $this->render('@App/' . $prefix . '/edit.html.twig', array(
            'dailyTask' => $task,
            'edit_form' => $edit_form->createView(),
            'delete_form' => $delete_form->createView(),
        ));
    }


    /**
     * Deletes a Task entity.
     *
     * @Route("/{id}", name="task_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, string $prefix, string $id)
    {
        $form = $this->createDeleteForm($task = $this->getTask($prefix, $id));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();
        }

        $show_url = $this->generateUrl('task_show', ['id' => $id, 'prefix' => $prefix ]);
        $edit_url = $this->generateUrl('task_edit', ['id' => $id, 'prefix' => $prefix ]);
        $source = $request->headers->get('referer');

        if (
            strpos(strrev($source), strrev($show_url)) === 0 ||
            strpos(strrev($source), strrev($edit_url)) === 0
        ) {
            return $this->redirectToRoute('tasks_index', ['prefix' => $prefix]);
        }

        return $this->redirect($source);
    }


    /**
     * Hide entry.
     *
     * @Route("/{id}/hide", name="task_hide")
     * @Method("GET")
     */
    public function hide(Request $request, string $prefix, string $id)
    {
        $em = $this->getDoctrine()->getManager();
        $task = $em->getRepository($this->container->get('task_mapper')::getTargetClassName($prefix))->find($id);

        $task->setShow(false);

        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }


}
