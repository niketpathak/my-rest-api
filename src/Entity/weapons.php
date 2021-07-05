<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ORM\Entity
 * @ORM\Table(name="weapons")
 * @ApiResource(
 *   collectionOperations={
 *     "get",
 *     "post" = {
 *       "openapi_context" = {
 *         "requestBody" = {
 *           "description" = "Create a new weapon",
 *           "content" = {
 *             "application/json" = {
 *               "schema" = {
 *                 "type" = "object",
 *                 "properties" = {
 *                   "name" = {
 *                     "type" = "string",
 *                     "description" = "The name of the weapon",
 *                     "example" = "hammer",
 *                   },
 *                   "image" = {
 *                     "description" = "A picture of the weapon. Accepts an ID pointing to the media entity",
 *                     "type" = "integer",
 *                     "example" = 1,
 *                   },
 *                 },
 *               },
 *             },
 *             "application/ld+json" = {
 *               "schema" = {
 *                 "type" = "object",
 *                 "properties" = {
 *                   "name" = {
 *                     "type" = "string",
 *                     "description" = "The name of the weapon",
 *                     "example" = "hammer",
 *                   },
 *                   "image" = {
 *                     "description" = "A picture of the weapon. Accepts an IRI pointing to the media entity",
 *                     "type" = "string",
 *                     "example" = "api/media/1",
 *                   },
 *                 },
 *               },
 *             },
 *           },
 *         },
 *       },
 *     },
 *   },
 * )
 */
class weapons
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(length=70)
     * @Assert\NotBlank()
     */
    public string $name;

    /**
     * @param media $img An image for this weapon
     *
     * @ORM\OneToOne(targetEntity="media", cascade={"persist", "remove"})
     * @ApiProperty(iri="http://schema.org/image")
     */
    public ?media $image = null;


    /******** METHODS ********/

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->name;
    }

}