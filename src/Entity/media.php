<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\media;
use App\Controller\MediaController;

/**
 * @ORM\Entity
 * @ORM\Table(name="media")
 * @ApiResource(
 *   iri="http://schema.org/ImageObject",
 *   normalizationContext={"groups" = {"read"}},
 *   collectionOperations={
 *     "get",
 *     "post" = {
 *       "controller" = MediaController::class,
 *       "deserialize" = false,
 *       "openapi_context" = {
 *         "requestBody" = {
 *           "description" = "File Upload",
 *           "required" = true,
 *           "content" = {
 *             "multipart/form-data" = {
 *               "schema" = {
 *                 "type" = "object",
 *                 "properties" = {
 *                   "file" = {
 *                     "type" = "string",
 *                     "format" = "binary",
 *                     "description" = "File to be uploaded",
 *                   },
 *                 },
 *               },
 *             },
 *           },
 *         },
 *       },
 *     },
 *   },
 *   itemOperations={"get", "delete"}
 * )
 */
class media
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id
     * @Groups({"read"})
     */
    private ?int $id = null;

    /**
     * @ORM\Column(nullable=true)
     * @ApiProperty(iri="http://schema.org/contentUrl")
     * @Groups({"read"})
     */
    public ?string $filePath = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}