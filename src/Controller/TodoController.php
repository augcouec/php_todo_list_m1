<?php

namespace App\Controller;

use App\Document\Task;
use App\Form\TaskFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class TodoController extends AbstractController
{

    /**
     * @Route("/", name="get_all")
     */
    public function all(DocumentManager $dm)
    {
        $repo = $dm->getRepository(Task::class);
        $todo = $repo->findAll();

        return $this->render('/todo/index.html.twig', [
            'todo' => $todo
        ]);
    }


    /**
     * @Route("/clear", name="clear_all")
     */
    public function clear(DocumentManager $dm)
    {
        $repo = $dm->getRepository(Task::class);
        $todo = $repo->findAll();

        return $this->render('/todo/index.html.twig', [
            'todo'=>$todo
        ]);
    }
    /**
     * @Route("/done", name="done_all")
     */
    public function done(DocumentManager $dm)
    {
        $repo = $dm->getRepository(Task::class);
        $todo = $repo->findAll();

        foreach ($todo as $task){
            $task->setDone(true);
            $dm->persist($task);
            $dm->flush();
        }

        return $this->redirectToRoute('get_all');
    }

    /**
     * @Route("/add", name="add_task")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function new(Request $request, DocumentManager $dm)
    {
        $form = $this->createForm(TaskFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $task = new Task();
            $task->setTitle($data['title']);
            $task->setContent($data['content']);
            $dm->persist($task);
            $dm->flush();

            return $this->redirectToRoute('get_all');
        }

        return $this->render('/todo/addToDo.html.twig', [
            'taskForm'=>$form->createView()
        ]);
    }

    /**
     * @Route("/remove/{taskId}", name="remove_task") 
     */
    public function removeTask (DocumentManager $dm, $taskId) {
        $repo = $dm->getRepository(Task::class);
        $task = $repo->findBy(['id' => $taskId]);
        $dm->remove($task);
        $dm->flush();

        return $this->redirectToRoute('get_all');
    }

    /**
     * @Route("/done/{taskId}", name="change_status")
     */
    public function changeTaskStatus (DocumentManager $dm, $taskId) {
        $repo = $dm->getRepository(Task::class);
        $task = $repo->findBy(['id' => $taskId]);
        $status = $task->getStatus();
        $task->setStatus(!$status);
        $dm->flush();
        
        return $this->redirectToRoute('get_all');
    }
}
