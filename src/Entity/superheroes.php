<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\SuperheroBySlug;
use App\Controller\SuperheroCoverController;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="superheroes")
 * @ApiResource(
 *   normalizationContext={"groups" = {"read"}},
 *   denormalizationContext={"groups" = {"write"}},
 *   collectionOperations={
 *     "get",
 *     "post" = {
 *       "controller" = SuperheroCoverController::class,
 *       "deserialize" = false,
 *       "openapi_context" = {
 *         "requestBody" = {
 *           "description" = "File upload to an existing resource (superheroes)",
 *           "required" = true,
 *           "content" = {
 *             "multipart/form-data" = {
 *               "schema" = {
 *                 "type" = "object",
 *                 "properties" = {
 *                   "name" = {
 *                     "description" = "The name of the superhero",
 *                     "type" = "string",
 *                     "example" = "Clark Kent",
 *                   },
 *                   "slug" = {
 *                     "description" = "The slug of the superhero",
 *                     "type" = "string",
 *                     "example" = "superman",
 *                   },
 *                   "featured" = {
 *                     "description" = "Whether this superhero should be featured or not",
 *                     "type" = "boolean",
 *                   },
 *                   "file" = {
 *                     "type" = "string",
 *                     "format" = "binary",
 *                     "description" = "Upload a cover image of the superhero",
 *                   },
 *                 },
 *               },
 *             },
 *           },
 *         },
 *       },
 *     },
 *   },
 *   itemOperations={
 *     "get",
 *     "patch",
 *     "delete",
 *     "put",
 *     "get_by_slug" = {
 *       "method" = "GET",
 *       "path" = "/superhero/{slug}",
 *       "controller" = SuperheroBySlug::class,
 *       "read"=false,
 *       "openapi_context" = {
 *         "parameters" = {
 *           {
 *             "name" = "slug",
 *             "in" = "path",
 *             "description" = "The slug of your superhero",
 *             "type" = "string",
 *             "required" = true,
 *             "example"= "superman",
 *           },
 *         },
 *       },
 *     },
 *   }
 * )
 */
class superheroes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private ?int $id = null;

    /**
     * @ORM\Column(length=70)
     * @Assert\NotBlank()
     * @Groups({"read", "write"})
     */
    public string $name;

    /**
     * @ORM\Column(length=70, unique=true)
     * @Assert\NotBlank()
     * @Groups({"read", "write"})
     */
    public string $slug;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"read", "write"})
     */
    public bool $featured = false;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read"})
     */
    public ?\DateTime $created_at = null;

    /**
     * @param string $cover A cover image for this superhero
     *
     * @ORM\Column()
     * @Groups({"read", "write"})
     * @ApiProperty(
     *   iri="http://schema.org/image",
     *   attributes={
     *     "openapi_context"={
     *       "type"="string",
     *     }
     *   }
     * )
     */
    public ?string $cover = null;


    /******** METHODS ********/

    public function getId()
    {
        return $this->id;
    }

    /**
     * Prepersist gets triggered on Insert
     * @ORM\PrePersist
     */
    public function updatedTimestamps()
    {
        if ($this->created_at == null) {
            $this->created_at = new \DateTime('now');
        }
    }

    public function __toString()
    {
        return $this->name;
    }

}