<?php

namespace App\Entity;

use App\Entity\Type\TimesTamp;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 */
class Image
{
    use TimesTamp;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $imageName;

    /**
     * @var UploadedFile
     */
    private UploadedFile $file;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $imageName
     * @return Image
     */
    public function setImageName(string $imageName): Image
    {
        $this->imageName = $imageName;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageName(): string
    {
        return $this->imageName;
    }

    /**
     * @param UploadedFile $file
     * @return Image
     */
    public function setFile(UploadedFile $file): Image
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getFile(): UploadedFile
    {
        return $this->file;
    }
}
