<?php

namespace App\Service;

use App\Repository\CotisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class PayslipService extends AbstractController {

	private $cotisationRepository;

	public function __construct(CotisationRepository $cotisationRepository) {
        $this->cotisationRepository = $cotisationRepository;
    }

	public function getPmssByYear() {
        $allYears = $this->cotisationRepository->findAll();
        $uniqueYears = array();
        foreach($allYears as $year) {
            $current = $year->getYear();
            if(!in_array($current, $uniqueYears)) {
                array_push($uniqueYears, $current);
            }
        }
        foreach($uniqueYears as $year) {
            $pmssByYear = $this->cotisationRepository->findOneBy(array('year' => $year), array('month' => 'ASC'));
            $pmss = $pmssByYear->getPmssAmount();
            $cotisationToUpdate = $this->cotisationRepository->findBy(array('year' => $year));
            foreach($cotisationToUpdate as $cotisation) {
                $cotisation->setPmssAmount($pmss);
            }
        }
	}
}