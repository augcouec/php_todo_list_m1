<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskFormType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function all(SessionInterface $session)
    {
        $todo = $session->get('todo');
        return $this->render('/todo/index.html.twig', [
            'todo'=>$todo
        ]);
    }


    /**
     * @Route("/clear", name="clear_all")
     */
    public function clear(SessionInterface $session)
    {
        $todo = $session->set('todo',[]);

        return $this->render('/todo/index.html.twig', [
            'todo'=>$todo
        ]);
    }
    /**
     * @Route("/done", name="done_all")
     */
    public function done(SessionInterface $session)
    {
        $sessionTodo = $session->get('todo');
        foreach ($sessionTodo as $key => $value){
                    $sessionTodo[$key]->setDone(true);
                    $todo = $session->set('todo',$sessionTodo);
                }
        return $this->redirectToRoute('get_all');
    }

    /**
     * @Route("/add", name="add_task")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function new(Request $request, SessionInterface $session)
    {
        $form = $this->createForm(TaskFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $task = new Task();
            $task->setId(); 
            $task->setTitle($data['title']);
            $task->setContent($data['content']);


            $sessionTodo = $session->get('todo');
            if(is_null($sessionTodo) || !is_array($sessionTodo)){
                $sessionTodo = [];
            }
            $sessionTodo[] = $task;
            $session->set('todo', $sessionTodo);
            return $this->redirectToRoute('get_all');
        }

        return $this->render('/todo/addToDo.html.twig', [
            'taskForm'=>$form->createView()
        ]);
    }

    /**
     * @Route("/remove/{taskId}", name="remove_task") 
     */
    public function removeTask (SessionInterface $session, String $taskId) {
        $sessionTodo = $session->get('todo');
        foreach ($sessionTodo as $key => $value){
            $id = $value->getId();
                if ($id == $taskId){
                    unset($sessionTodo[$key]);
                    $todo = $session->set('todo',$sessionTodo);
                break;
                }
        }

        return $this->redirectToRoute('get_all');
    }

    /**
     * @Route("/done/{taskId}", name="change_status")
     */
    public function changeTaskStatus (SessionInterface $session, String $taskId) {
        $sessionTodo = $session->get('todo');
        foreach ($sessionTodo as $key => $value){
            $id = $value->getId();
                if ($id == $taskId){
                    $status =  $value->getDone();
                    $sessionTodo[$key]->setDone(!$status);
                    $todo = $session->set('todo',$sessionTodo);
                break;
                }
        }
        return $this->redirectToRoute('get_all');
    }


}
