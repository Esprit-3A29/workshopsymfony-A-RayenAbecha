<?php

namespace App\Controller;
use App\Entity\Student;
use App\Form\StudentType;
use App\Form\SearchStudentType;
use App\Repository\StudentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
class StudentController extends AbstractController
{
#[Route('/student', name: 'app_student')]
public function listStudet (Request $request,StudentRepository $repository)
{
    $student= $repository->findAll();
    $sortByMoyenne=$repository->sortByMoyenne();
    $formSearch= $this->createForm(SearchStudentType::class);
    $formSearch->handleRequest($request);
    if($formSearch->isSubmitted()){
        $nce= $formSearch->get('nce')->getData();
        //var_dump($nce).die();
        $result= $repository->searchStudent($nce);
        return $this->renderForm("student/listStudent.html.twig",
            array("tabStudent"=>$result,
                "sortByMoyenne"=>$sortByMoyenne,
                "searchForm"=>$formSearch));
    }
    return $this->renderForm("student/listStudent.html.twig", array("tabStudent"=>$student,
        "sortByMoyenne"=>$sortByMoyenne,
         "searchForm"=>$formSearch ));
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