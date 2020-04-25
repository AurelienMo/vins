<?php

namespace App\Domain\Common\Twig;

use App\Repository\BoxWineRepository;
use App\Repository\WineProfileRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class GetColorProductBoxExtension extends AbstractExtension
{
    /** @var BoxWineRepository */
    protected $boxRepository;

    /** @var WineProfileRepository */
    protected $profileRepository;

    public function __construct(BoxWineRepository $boxRepository, WineProfileRepository $profileRepository)
    {
        $this->boxRepository = $boxRepository;
        $this->profileRepository = $profileRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('applyColor', [$this, 'apply'])
        ];
    }

    public function apply(string $id, string $type)
    {
        switch ($type) {
            case 'box':
                $box = $this->boxRepository->find($id);

                return $box->getColor();
                break;
            case 'product':
                $profile = $this->profileRepository->find($id);

                return $profile->getColor();
                break;
        }
    }
}
