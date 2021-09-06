<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Entity\Events;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class EventsController extends AbstractController
{
// ===============================displaying all events======================
    public function index(): Response
    {
        $events = $this->getDoctrine()->getRepository('App:Events')->findAll();
        return $this->render('events/index.html.twig', 
            array('eventsAll'=>$events)
        );
    }
// =========================displaying details about the events======================
     public function details($id): Response
     {
         $events = $this->getDoctrine()->getRepository('App:Events')->find($id);
         return $this->render('events/details.html.twig', 
             array('events'=>$events)
         );
     }
//=================================================== creating events to database=========
    public function create(Request $request): Response
    {   
        $events = new Events;
        $form = $this->createFormBuilder($events)
            ->add('name', TextType::class, array('attr' => array('placeholder'=>'Name of the Event','class'=>"form-control fw-light border-1 border-muted rounded-pill bg-light shadow-sm mt-3 text-muted" , 'style'=>'margin-bottom:15px')))        
            ->add('description', TextType::class, array('attr' => array('placeholder'=>'Description of the Event','class'=>"form-control fw-light border-1 border-muted rounded-pill bg-light shadow-sm mt-3 text-muted" , 'style'=>'margin-bottom:15px')))        
            ->add('image', TextType::class, array('attr' => array('placeholder'=>'Event Image URL','class'=>"form-control fw-light border-1 border-muted rounded-pill bg-light shadow-sm mt-3 text-muted" , 'style'=>'margin-bottom:15px')))        
            ->add('capacity', TextType::class, array('attr' => array('placeholder'=>'What is the max. capacity ?','class'=>"form-control fw-light border-1 border-muted rounded-pill bg-light shadow-sm mt-3 text-muted" , 'style'=>'margin-bottom:15px')))        
            ->add('email', TextType::class, array('attr' => array('placeholder'=>'Enter email','class'=>"form-control fw-light border-1 border-muted rounded-pill bg-light shadow-sm mt-3 text-muted" , 'style'=>'margin-bottom:15px')))        
            ->add('phone', TextType::class, array('attr' => array('placeholder'=>'Phone Number','class'=>"form-control fw-light border-1 border-muted rounded-pill bg-light shadow-sm mt-3 text-muted" , 'style'=>'margin-bottom:15px')))        
            ->add('address', TextareaType::class, array('attr' => array('placeholder'=>'Enter the full Address','class'=>"form-control fw-light border-1 border-muted rounded-pill bg-light shadow-sm mt-3 text-muted" , 'style'=>'margin-bottom:15px')))
            ->add('url', TextType::class, array('attr' => array('placeholder'=>'Enter Website','class'=>"form-control fw-light border-1 border-muted rounded-pill bg-light shadow-sm mt-3 text-muted" , 'style'=>'margin-bottom:15px')))        
            ->add('date_time', DateTimeType::class, array('attr' => array('class'=>'','style'=>'margin-bottom:15px')))
            ->add('type', ChoiceType::class, array('choices'=>array('music'=>'music', 'sport'=>'sport', 'movie'=>'movie', 'theater'=>'theater'),'attr' => array('class'=>"form-control fw-light border-1 border-muted rounded-pill bg-light shadow-sm mt-3 text-muted" , 'style'=>'margin-botton:15px')))
            ->add('save', SubmitType::class, array('label'=> 'Create new Event', 'attr' => array('class'=> 'btn-danger mt-2 mb-2', 'style'=>'margin-bottom:15px')))
            ->getForm();

            $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $name = $form['name']->getData();
            $description = $form['description']->getData();
            $image = $form['image']->getData();
            $capacity = $form['capacity']->getData();
            $email = $form['email']->getData();
            $phone = $form['phone']->getData();
            $address = $form['address']->getData();
            $url = $form['url']->getData();
            $date_time = $form['date_time']->getData();
            $type = $form['type']->getData();


            $events->setName($name);
            $events->setDescription($description);
            $events->setImage($image);
            $events->setCapacity($capacity);
            $events->setEmail($email);
            $events->setPhone($phone);
            $events->setAddress($address);
            $events->setUrl($url);
            $events->setDateTime($date_time);
            $events->setType($type);

            $em = $this->getDoctrine()->getManager();    

            $em->persist($events);
            $em->flush();

            $this->addFlash( 'notice', 'New Event Added' );
            return $this->redirectToRoute('index');
        }
        return $this->render('events/create.html.twig', 
            array('form'=>$form->createView())
        );
    }
// =============================================================editing events ======================
    public function edit(Request $request, $id): Response
    {
        $events = $this->getDoctrine()->getRepository('App:Events')->find($id);

    
        $form = $this->createFormBuilder($events)
            ->add('name', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
            ->add('description', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))        
            ->add('image', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))        
            ->add('capacity', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))        
            ->add('email', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))        
            ->add('phone', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))        
            ->add('address', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))
            ->add('url', TextType::class, array('attr' => array('class'=> 'form-control', 'style'=>'margin-bottom:15px')))        
            ->add('date_time', DateTimeType::class, array('attr' => array('style'=>'margin-bottom:15px')))
            ->add('type', ChoiceType::class, array('choices'=>array('music'=>'music', 'sport'=>'sport', 'movie'=>'movie', 'theater'=>'theater'),'attr' => array('class'=> 'form-control', 'style'=>'margin-botton:15px')))
            ->add('save', SubmitType::class, array('label'=> 'Save Changes', 'attr' => array('class'=> 'btn-danger mt-2 mb-2', 'style'=>'margin-bottom:15px')))
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          

            $events->setName($events->getName());
            $events->setDescription($events->getDescription());
            $events->setImage($events->getImage());
            $events->setCapacity($events->getCapacity());
            $events->setEmail($events->getEmail());
            $events->setPhone($events->getPhone());
            $events->setAddress($events->getAddress());
            $events->setUrl($events->getUrl());
            $events->setType($events->getType());
            $events->setDateTime($events->getDateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($events);
            $em->flush();

            $this->addFlash(
                'notice',
                'Event has been succesfuly changed'
            );
            return $this->redirectToRoute('index');
        }
        return $this->render('events/edit.html.twig',
            array('events' => $events, 'form' => $form->createView())
        );
    }

// =========================================================deleting events======================
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('App:Events')->find($id);   
        $em->remove($events);
        $em->flush();
        $this->addFlash(
            'notice',
            'Event has been deleted'
        );
        return $this->redirectToRoute('index');     
    } 
//==================================================Basic function for filtering Events=========
    public function indexFilt(string $type): Response {
        $repository = $this->getDoctrine()->getRepository('App:Events');
        $events  = $repository->findAll();

        if($type == 'music') {
            $events  = $repository->findBy(['type'=>'music']);
        } else if($type == 'sport'){
            $events  = $repository->findBy(['type'=>'sport']);
        } else if($type == 'movie'){
            $events  = $repository->findBy(['type'=>'movie']);
        } else if($type == 'theater'){
            $events  = $repository->findBy(['type'=>'theater']);
        }             
        return $this->render('events/index.html.twig', 
        array('eventsAll'=>$events)
        );
    }
}
