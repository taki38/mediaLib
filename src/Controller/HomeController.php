<?php

namespace App\Controller;

use App\Entity\Task;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'MEDIA LIB',
        ]);
    }

    /**
     * @Route("/user/tasks", name="display_user_tasks")
     */
    public function tasksUser(Request $request, PaginatorInterface $paginator)
    {
        $datas = $this->getDoctrine()->getRepository(Task::class)->findAll();
        $tasks = $paginator -> paginate(
            $datas,
            $request->query->getInt('page', 1), //numéro de la page en cours par defaut
            10
        );
        return $this->render('user/myTasks.html.twig', [
            'tasks' => $tasks
        ]);
    }
}
