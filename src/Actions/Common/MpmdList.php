<?php

declare(strict_types=1);

namespace App\Actions\Common;

use App\Entity\SliderMPMD;
use App\Repository\SliderMPMDRepository;
use App\Responders\ViewResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ma-premiere-methode-degustation", name="mpmd_list")
 * @Route("/les-daygusts", name="daygust_list")
 */
class MpmdList
{
    /** @var SliderMPMDRepository */
    protected $sliderMpmdRepository;

    public function __construct(
        SliderMPMDRepository $sliderMpmdRepository
    ) {
        $this->sliderMpmdRepository = $sliderMpmdRepository;
    }

    public function __invoke(Request $request, ViewResponder $responder)
    {
        $type = $request->attributes->get('_route') === 'mpmd_list' ? SliderMPMD::MPMD : SliderMPMD::DAYGUST;
        $sliders = $this->sliderMpmdRepository->findBy(['type' => $type]);

        return $responder('mpmd/index.html.twig', ['sliders' => $sliders]);
    }
}
