<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use AppBundle\Entity\TaskInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ControllerAbstract extends Controller
{
    protected function getTaskByPrefix(string $prefix): TaskInterface
    {
        $class = $this->container->get('task_mapper')::getTargetClassName($prefix);
        return new $class;
    }


    /**
     * Creates a form to delete a dailyTask entity.
     *
     * @param TaskInterface $task The task entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm(TaskInterface $task)
    {
        return $this->createFormBuilder(null, ['csrf_protection' => false])
            ->setAction($this->generateUrl('task_delete', array(
                'prefix' => $this->container->get('task_mapper')::getPrefix($task),
                'id' => $task->getId()
            )))->add('delete', SubmitType::class, [
                'label' => 'delete'
            ])
            ->setMethod('DELETE')
            ->getForm();
    }

    protected function getPrefix(): string
    {
        return $this->get('request_stack')->getCurrentRequest()->get('prefix');
    }


    protected function getFormClass(TaskInterface $task): string
    {
        return 'AppBundle\\Form\\' . (new \ReflectionClass($task))->getShortName() . 'Type';
    }

    protected function getTask(string $prefix, string $id): ?TaskInterface
    {
        $em = $this->getDoctrine()->getManager();

        if (null === $task = $em->getRepository($this->container->get('task_mapper')->getTargetClassName($prefix))->find($id)) {
            throw $this->createNotFoundException('Task not found');
        }

        return $task;
    }

    protected function generateDeleteFormsViews(array $tasks): array
    {
        $delete_forms = [];
        foreach ($tasks as $task) {
            $delete_forms[$this->container->get('task_mapper')::getPrefix($task) . $task->getId()] = $this->createDeleteForm($task)->createView();
        }

        return $delete_forms;
    }

}
