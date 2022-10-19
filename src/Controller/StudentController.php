<?php

namespace App\Controller;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
class StudentController extends AbstractController
{
#[Route('/student', name: 'app_student')]
public function listStudet (StudentRepository $repository)
{
    $student= $repository->findAll();
    return $this->render("student/listStudent.html.twig",
        array("tabStudent"=>$student));
}
#[Route('/addStudent', name: 'app_addstudent')]
public function addStudent(StudentRepository $repository ,Request $request,ManagerRegistry $doctrine)
{
    $student= new Student();
    $form= $this->createForm(StudentType::class,$student);
    $form->handleRequest($request);
    if ($form->isSubmitted()){
        $repository->add($student,true);
        return $this->redirectToRoute("app_student");    }
    return $this->renderForm("student/add.html.twig",array("formStudent"=>$form));

}
}