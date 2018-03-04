<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ToDoController extends Controller
{
    /**
     * @Route("/todos", name="todo_list")
     */
    public function indexAction(Request $request)
    {
      $todos=$this->getDoctrine()->getRepository('AppBundle:Todo')->findAll();
      return $this->render('todo/index.html.twig', array(
          'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
          'todos' => $todos,
      ));
    }
    /**
     * @Route("/todo/create", name="todo_create")
     */
    public function createAction(Request $request)
    {
        $todo = new Todo;
        $atrributes = array('class' => 'form-control' , 'style' => 'margin-bottom:15px');
        $choices = array('Low' => 'Low', 'Normal' => 'Normal', 'High' => 'High');
        $form = $this->createFormBuilder($todo)
                ->add('name',get_class(new TextType), array('attr' => $atrributes))
                ->add('category',get_class(new TextType), array('attr' => $atrributes))
                ->add('description',get_class(new TextareaType), array('attr' => $atrributes))
                ->add('due_data',get_class(new DateTimeType), array('attr' => array('style' => 'margin-bottom:15px')))
                ->add('save',get_class(new SubmitType), array('label' => 'Create Todo', 'attr' => array('class' => 'btn btn-primary')))
                ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $todo->setName($form['name']->getData());
            $todo->setCategory($form['category']->getData());
            $todo->setDescription($form['description']->getData());
            $todo->setDueData($form['due_data']->getData());
            // $todo->setCreateDate(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();

            $this->addFlash('notice', 'Todo Added');

            return $this->redirectToRoute('todo_list');
        }

        return $this->render('todo/create.html.twig', array(
            'form' => $form->createView()
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
