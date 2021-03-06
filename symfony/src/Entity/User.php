<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *      attributes={"security"="is_granted('ROLE_USER')"},
 *      collectionOperations={
 *          "post"
 *      },
 *      itemOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_ADMIN') or object == user"
 *          },
 *          "get_me"={
 *              "method"="GET",
 *              "route_name"="api_users_get_me_item",
 *              "openapi_context"={
 *                  "summary"="Retrieves the current User resource.",
 *                  "parameters"={}
 *              },
 *          },
 *          "patch"={
 *              "security"="is_granted('ROLE_ADMIN') or object == user"
 *          },
 *      },
 *      normalizationContext={"groups"={"read"}},
 *      denormalizationContext={"groups"={"write"}}
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"read", "write"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"write"})
     */
    private $password;

    /**
     * @var ToDo[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\ToDo", mappedBy="owner", cascade={"persist", "remove"})
     * @ApiSubresource
     */
    private $todos; 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     *  Get ToDos list.
     *
     * @return ArrayCollection
     */
    public function getToDos(): ?ArrayCollection
    {
        return $this->todos;
    }

    /**
     * @param ToDo $toDo
     *
     * @return User
     */
    public function addToDo(ToDo $ToDo): self
    {
        if (false === $this->todos->contains($toDo)) {
            $this->todos->add($toDo);
        }

        return $this;
    }

    /**
     * @param $toDos
     *
     * @return User
     */
    public function setToDos($toDos): self
    {
        $this->todos= $toDos;

        return $this;
    }

    /**
     * @param ToDo $toDo
     *
     * @return User
     */
    public function removeToDo(ToDo $toDo): self
    {
        $this->todos->removeElement($toDo);

        return $this;
    }
}
