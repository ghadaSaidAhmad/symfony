<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ToDoController extends Controller
{
    /**
     * @Route("/todos", name="todo_list")
     */
    public function indexAction(Request $request)
    {
      return $this->render('todo/index.html.twig', array(
          'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
      ));
    }
    /**
     * @Route("/todo/create", name="todo_create")
     */
    public function createAction(Request $request)
    {
      return $this->render('todo/create.html.twig', array(
          'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
      ));
    }
    /**
     * @Route("/todo/edit/{id}", name="todo_edit")
     */
    public function editAction(Request $request)
    {
      return $this->render('todo/edit.html.twig', array(
          'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
      ));
    }
    /**
     * @Route("/todo/details/{id}", name="todo_details")
     */
    public function detailsAction($id)
    {
      return $this->render('todo/details.html.twig', array(
          'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
      ));
    }
}
