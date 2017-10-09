<?php
declare(strict_types=1);

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\{
    Method, Route
};
use Symfony\Component\HttpFoundation\{
    Request, Response
};

class DefaultController extends ControllerAbstract
{
    /**
     * @Route("/")
     * @Method("GET")
     */
    public function showMainAction(Request $request): Response
    {
        $date = $request->get('day') ?? (new \DateTime())->format('Y-m-d');
        return $this->showDayAction($date);
    }


    /**
     * @Route("/{date}", requirements={"date": "\d{4}\-\d{2}\-\d{2}"})
     * @Method("GET")
     */
    public function showDayAction(string $date_str): Response
    {
        $date_obj = new \DateTime($date_str);
        $daily = $this->getDoctrine()->getRepository('AppBundle:DailyTask')->getForDay($date_obj);

        $events = $this->getDoctrine()->getRepository('AppBundle:Event')->getForDay($date_obj);

        $todo = array_merge($this->getDoctrine()->getRepository('AppBundle:Todo')->
        getForDay($date_obj),
            $this->getDoctrine()->getRepository('AppBundle:DailyTask')->
            getTodoForDay($date_obj),
            $this->getDoctrine()->getRepository('AppBundle:Periodical')->
            getForDay($date_obj));

        return $this->render('@App/default/show_day.html.twig',
            [
                'tasks' => $tasks = array_merge($daily, $events),
                'date' => $date_obj,
                'todo' => $todo,
                'delete_forms' => $this->generateDeleteFormsViews(array_merge($tasks, $todo))
            ]);
    }

    public function loadNotesAction(): Response
    {
        $until_weekend = $this->getDoctrine()->getRepository('AppBundle:Until')->getWeekTarget();

        $expiring = $this->getDoctrine()->getRepository('AppBundle:Until')->getExpiring(365);

        $ponder = $this->getDoctrine()->getRepository('AppBundle:Ponder')->findBy(['show' => 1]);

        return $this->render('@App/default/inc/notes.html.twig',
            [
                'until_weekend' => $until_weekend,
                'expiring' => $expiring,
                'ponder' => $ponder,
                'delete_forms' => $this->generateDeleteFormsViews(array_merge($until_weekend, $expiring, $ponder)),
                'date' => new \DateTime
            ]);
    }


    /**
     * @Route("/upcoming")
     * @Method("GET")
     */
    public function showUpcomingAction(Request $request): Response
    {
        $start_date = new \DateTime($request->get('start') ?? 'now');
        $end_date = $request->get('end') ?
            new \DateTime($request->get('end'))
            : new \DateTime('+2 weeks');

        $tasks = array_merge(
            $this->getDoctrine()->getRepository('AppBundle:Event')->getForPeriod($start_date, $end_date),
            $this->getDoctrine()->getRepository('AppBundle:Todo')->getForPeriod($start_date, $end_date)
        );


        return $this->render('@App/default/upcoming.html.twig',
            [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'tasks' => $tasks
            ]);


    }

}
