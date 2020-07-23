<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RapperCard;
use App\Entity\OracleCard;
use App\Repository\RapperCardRepository;
use App\Repository\OracleCardRepository;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     */
    public function index(RapperCardRepository $rapperCardRepository, OracleCardRepository $oracleCardRepository)
    {
        $rappers = $rapperCardRepository->findAll();

        /*$randomKey = array_rand($rappers, 1);
        $rapperCard = $rappers[$randomKey];*/
        
        return $this->render('card/index.html.twig', [
            'rapperCard' => $rapperCard,
        ]);
    }
}
