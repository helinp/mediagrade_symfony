<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;



use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motto;

    /**
     * @ORM\OneToMany(targetEntity=Course::class, mappedBy="teacher", orphanRemoval=true)
     */
    private $courses;

    /**
     * @ORM\OneToMany(targetEntity=Project::class, mappedBy="teacher")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity=SelfAssessmentQuestion::class, mappedBy="teacher")
     */
    private $selfAssessmentQuestions;


    private $classe;

    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatarUrl;

    /**
     * @ORM\ManyToMany(targetEntity=Achievement::class, inversedBy="users")
     */
    private $achievements;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=Submission::class, mappedBy="student", orphanRemoval=true)
     */
    private $submissions;

    /**
     * @ORM\OneToMany(targetEntity=SelfAssessmentAnswer::class, mappedBy="student", orphanRemoval=true)
     */
    private $selfAssessmentAnswers;

    /**
     * @ORM\OneToMany(targetEntity=StudentClasse::class, mappedBy="student", orphanRemoval=true, cascade={"persist"})
     */
    private $studentClasses;

    /**
     * @ORM\OneToMany(targetEntity=Result::class, mappedBy="student", orphanRemoval=true)
     */
    private $results;

    /**
     * @ORM\OneToMany(targetEntity=Attendance::class, mappedBy="student", orphanRemoval=true)
     */
    private $attendances;

    /**
     * @ORM\OneToMany(targetEntity=AttendanceGrid::class, mappedBy="teacher")
     */
    private $attendanceGrids;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=UserAvatar::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $userAvatar;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->selfAssessmentQuestions = new ArrayCollection();
        $this->achievements = new ArrayCollection();
        $this->submissions = new ArrayCollection();
        $this->selfAssessmentAnswers = new ArrayCollection();
        $this->classe = new ArrayCollection();
        $this->studentClasses = new ArrayCollection();
        $this->results = new ArrayCollection();
        $this->attendances = new ArrayCollection();
        $this->attendanceGrids = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function hasRole(string $role)
    {
        if (in_array($role, $this->getRoles())) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_STUDENT';

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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMotto(): ?string
    {
        return $this->motto;
    }

    public function setMotto(?string $motto): self
    {
        $this->motto = $motto;

        return $this;
    }


    /**
     * @return Collection|Course[]
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function getOrderedCourses(): Collection
    {
    $criteria = Criteria::create()
    ->orderBy(['name' => 'ASC'])
    ;
    return $this->getCourses()->matching($criteria);
    }

    public function addCourse(Course $course): self
    {
        if (!$this->courses->contains($course)) {
            $this->courses[] = $course;
            $course->setTeacher($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): self
    {
        if ($this->courses->contains($course)) {
            $this->courses->removeElement($course);
            // set the owning side to null (unless already changed)
            if ($course->getTeacher() === $this) {
                $course->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): self
    {
        if (!$this->projects->contains($project)) {
            $this->projects[] = $project;
            $project->setTeacher($this);
        }

        return $this;
    }

    public function removeProject(Project $project): self
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getTeacher() === $this) {
                $project->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SelfAssessmentQuestion[]
     */
    public function getSelfAssessmentQuestions(): Collection
    {
        return $this->selfAssessmentQuestions;
    }

    public function addSelfAssessmentQuestion(SelfAssessmentQuestion $selfAssessmentQuestion): self
    {
        if (!$this->selfAssessmentQuestions->contains($selfAssessmentQuestion)) {
            $this->selfAssessmentQuestions[] = $selfAssessmentQuestion;
            $selfAssessmentQuestion->setTeacher($this);
        }

        return $this;
    }

    public function removeSelfAssessmentQuestion(SelfAssessmentQuestion $selfAssessmentQuestion): self
    {
        if ($this->selfAssessmentQuestions->contains($selfAssessmentQuestion)) {
            $this->selfAssessmentQuestions->removeElement($selfAssessmentQuestion);
            // set the owning side to null (unless already changed)
            if ($selfAssessmentQuestion->getTeacher() === $this) {
                $selfAssessmentQuestion->setTeacher(null);
            }
        }

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(?string $avatarUrl): self
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    /**
     * @return Collection|Achievement[]
     */
    public function getAchievements(): Collection
    {
        return $this->achievements;
    }

    public function addAchievement(Achievement $achievement): self
    {
        if (!$this->achievements->contains($achievement)) {
            $this->achievements[] = $achievement;
        }

        return $this;
    }

    public function removeAchievement(Achievement $achievement): self
    {
        if ($this->achievements->contains($achievement)) {
            $this->achievements->removeElement($achievement);
        }

        return $this;
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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|Submission[]
     */
    public function getSubmissions(): Collection
    {
        return $this->submissions;
    }

    public function addSubmission(Submission $submission): self
    {
        if (!$this->submissions->contains($submission)) {
            $this->submissions[] = $submission;
            $submission->setStudent($this);
        }

        return $this;
    }

    public function removeSubmission(Submission $submission): self
    {
        if ($this->submissions->contains($submission)) {
            $this->submissions->removeElement($submission);
            // set the owning side to null (unless already changed)
            if ($submission->getStudent() === $this) {
                $submission->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SelfAssessmentAnswer[]
     */
    public function getSelfAssessmentAnswers(): Collection
    {
        return $this->selfAssessmentAnswers;
    }

    public function addSelfAssessmentAnswer(SelfAssessmentAnswer $selfAssessmentAnswer): self
    {
        if (!$this->selfAssessmentAnswers->contains($selfAssessmentAnswer)) {
            $this->selfAssessmentAnswers[] = $selfAssessmentAnswer;
            $selfAssessmentAnswer->setStudent($this);
        }

        return $this;
    }

    public function removeSelfAssessmentAnswer(SelfAssessmentAnswer $selfAssessmentAnswer): self
    {
        if ($this->selfAssessmentAnswers->contains($selfAssessmentAnswer)) {
            $this->selfAssessmentAnswers->removeElement($selfAssessmentAnswer);
            // set the owning side to null (unless already changed)
            if ($selfAssessmentAnswer->getStudent() === $this) {
                $selfAssessmentAnswer->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StudentClasse[]
     */
    public function getStudentClasses(): Collection
    {
        return $this->studentClasses;
    }

    public function getCurrentClasse()
    {
        $criteria = Criteria::create()
            ->andWhere(Criteria::expr()->eq('schoolyear', \App\Utils\SchoolYear::getSchoolYear()));
            $result = $this->getStudentClasses()->matching($criteria)->last();
        
        if($result === false)
        {

            return $this->getStudentClasses()->last();
             
        }
        else
        {
            return $result;
            
        }
        
    }

    public function addStudentClass(StudentClasse $studentClass): self
    {
        if (!$this->studentClasses->contains($studentClass)) {
            $this->studentClasses[] = $studentClass;
            $studentClass->setStudent($this);
        }

        return $this;
    }

    public function removeStudentClass(StudentClasse $studentClass): self
    {
        if ($this->studentClasses->contains($studentClass)) {
            $this->studentClasses->removeElement($studentClass);
            // set the owning side to null (unless already changed)
            if ($studentClass->getStudent() === $this) {
                $studentClass->setStudent(null);
            }
        }

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return Collection|Result[]
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(Result $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results[] = $result;
            $result->setStudent($this);
        }

        return $this;
    }

    public function removeResult(Result $result): self
    {
        if ($this->results->contains($result)) {
            $this->results->removeElement($result);
            // set the owning side to null (unless already changed)
            if ($result->getStudent() === $this) {
                $result->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Attendance[]
     */
    public function getAttendances(): Collection
    {
        return $this->attendances;
    }

    public function addAttendance(Attendance $attendance): self
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances[] = $attendance;
            $attendance->setStudent($this);
        }

        return $this;
    }

    public function removeAttendance(Attendance $attendance): self
    {
        if ($this->attendances->contains($attendance)) {
            $this->attendances->removeElement($attendance);
            // set the owning side to null (unless already changed)
            if ($attendance->getStudent() === $this) {
                $attendance->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AttendanceGrid[]
     */
    public function getAttendanceGrids(): Collection
    {
        return $this->attendanceGrids;
    }

    public function addAttendanceGrid(AttendanceGrid $attendanceGrid): self
    {
        if (!$this->attendanceGrids->contains($attendanceGrid)) {
            $this->attendanceGrids[] = $attendanceGrid;
            $attendanceGrid->setTeacher($this);
        }

        return $this;
    }

    public function removeAttendanceGrid(AttendanceGrid $attendanceGrid): self
    {
        if ($this->attendanceGrids->contains($attendanceGrid)) {
            $this->attendanceGrids->removeElement($attendanceGrid);
            // set the owning side to null (unless already changed)
            if ($attendanceGrid->getTeacher() === $this) {
                $attendanceGrid->setTeacher(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }



     public function getUserAvatar(): ?UserAvatar
    {
        return $this->userAvatar;
    }

    public function setUserAvatar(UserAvatar $userAvatar): self
    {
        $this->userAvatar = $userAvatar;

        // set the owning side of the relation if necessary
        if ($userAvatar->getUser() !== $this) {
            $userAvatar->setUser($this);
        }

        return $this;
    }
}
