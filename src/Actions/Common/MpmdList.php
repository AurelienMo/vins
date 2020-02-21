<?php

declare(strict_types=1);

namespace App\Actions\Common;

use App\Repository\SliderMPMDRepository;
use App\Responders\ViewResponder;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ma-premiere-methode-degustation", name="mpmd_list")
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

    public function __invoke(ViewResponder $responder)
    {
        $sliders = $this->sliderMpmdRepository->findAll();

        return $responder('mpmd/index.html.twig', ['sliders' => $sliders]);
    }
}
