<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/users", name="display_users")
     */
    public function usersDisplay(Request $request, PaginatorInterface $paginator)
    {
        $datas = $this->getDoctrine()->getRepository(User::class)->findAll();
        $users = $paginator -> paginate(
            $datas,
            $request->query->getInt('page', 1), //numéro de la page en cours par defaut
            10
        );
        $tasks = $this->getDoctrine()->getRepository(Task::class)->findAll();
        return $this->render('admin/displayUsers.html.twig', [
            'users' => $users,
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="delete_user")
     */
    public function deleteUser(User $user, EntityManagerInterface $entityManager)
    {
        $entityManger = $this->getDoctrine()->getManager();
        $entityManger->remove($user);
        $entityManger->flush();
        $this->addFlash('success', "Votre utilisateur a été supprimé avec succès.");

        return $this->redirectToRoute('display_users');
    }

    /**
     * @Route("/admin/add/task", name="add_task")
     */
    public function addTask(Request $request)
    {
        // On instancie un nouvel objet User
        $task = new Task();
        // on fait appel au formulaire d'inscription qui a été déja crée gràce à la commande php bin/console make:form
        $form = $this->createForm(TaskType::class,$task);
        $form->handleRequest($request);
        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // c'est la méthode la plus importante dans doctrine, Responsable de sauvegarder des donnéees ou de les
            //récupérer de la base donées
            $entityManager = $this->getDoctrine()->getManager();

            $task = $form->getData();

            // demander à doctrine de préparer l'objet avant l'insérer dans la base de données
            $entityManager->persist($task);
            //c'est en appelant cette méthode qu'on va insérer les données dans la base
            $entityManager->flush();

            $this->addFlash('success', "Votre tache a été ajoutée avec succès.");

            return $this->redirectToRoute('app_home');

        }



        return $this->render('admin/addTask.html.twig', [
            'taskForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/tasks", name="display_tasks")
     */
    public function tasksDisplay(Request $request, PaginatorInterface $paginator)
    {
        $datas = $this->getDoctrine()->getRepository(Task::class)->findAll();
        $tasks = $paginator -> paginate(
            $datas,
            $request->query->getInt('page', 1), //numéro de la page en cours par defaut
            10
        );
        return $this->render('admin/displayTasks.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/admin/delete//task/{id}", name="delete_task")
     */
    public function deleteTask(User $task, EntityManagerInterface $entityManager)
    {
        $entityManger = $this->getDoctrine()->getManager();
        $entityManger->remove($task);
        $entityManger->flush();
        $this->addFlash('success', "Votre tache a été supprimé avec succès.");

        return $this->redirectToRoute('display_tasks');
    }

}
