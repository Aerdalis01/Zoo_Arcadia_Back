<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Restaurant extends SousService
{
  public function getMenuPath(): ?string
    {
        foreach ($this->getImage() as $image) {
            if ($image->getNom() === 'menu_restaurant') {
                return $image->getImagePath();
            }
        }
        return null;
    }
}
