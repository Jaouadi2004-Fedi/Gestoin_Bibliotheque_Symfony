<?php

namespace App\Controller;
use App\Entity\BookSearch;
use App\Form\BookSearchType;   
use App\Entity\Borrowing;
use App\Repository\BorrowingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
final class ReportController extends AbstractController
{
#[Route('/most-popular-book', name: 'most_popular_book')]
    public function index(BorrowingRepository $borrowingRepository): Response
    {
        $books = $borrowingRepository->findMostPopularBooks();
        return $this->render('report/index.html.twig', [
            'books' => $books,
        ]);
    }
    public function BorrowingBook(Request $request, BorrowingRepository $repository) {
$bookSearch = new BookSearch();
$form = $this->createForm(BookSearchType::class,$bookSearch);
$form->handleRequest($request);
$borrowings= [];
if($form->isSubmitted() && $form->isValid()) {
$book = $bookSearch->getBook();
if ($book!="")
$borrowings=$repository->findBy( array('book' => $book) );
else
$borrowings= $repository->findAll();
}
return $this->render('report/BorrowingBook.html.twig',
['form' => $form->createView(),'borrowings' => $borrowings]);
}
}

