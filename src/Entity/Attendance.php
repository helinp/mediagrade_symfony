<?php

namespace App\Entity;

use App\Repository\AttendanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass=AttendanceRepository::class)
*/
class Attendance
{
	/**
	* @ORM\Id
	* @ORM\GeneratedValue
	* @ORM\Column(type="integer")
	*/
	private $id;

	/**
	* @ORM\ManyToOne(targetEntity=User::class, inversedBy="attendances")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $student;

	/**
	* @ORM\ManyToOne(targetEntity=AttendanceGrid::class, inversedBy="attendances")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $attendanceGrid;

	/**
	* @ORM\Column(type="boolean", nullable=true)
	*/
	private $isPresent;

	/**
	* @ORM\Column(type="boolean", nullable=true)
	*/
	private $isAbsent;

	/**
	* @ORM\Column(type="boolean", nullable=true)
	*/
	private $isLate;

	/**
	* @ORM\Column(type="boolean", nullable=true)
	*/
	private $isExcused;

	/**
	* @ORM\Column(type="string", length=10)
	*/
	private $status;

	public function __construct()
	{
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getStudent(): ?User
	{
		return $this->student;
	}

	public function setStudent(?User $student): self
	{
		$this->student = $student;

		return $this;
	}

	public function getSchoolHour(): ?int
	{
		return $this->schoolHour;
	}

	public function setSchoolHour(int $schoolHour): self
	{
		$this->schoolHour = $schoolHour;

		return $this;
	}

	public function getAttendanceGrid(): ?AttendanceGrid
	{
		return $this->attendanceGrid;
	}

	public function setAttendanceGrid(?AttendanceGrid $attendanceGrid): self
	{
		$this->attendanceGrid = $attendanceGrid;

		return $this;
	}

	public function getIsPresent(): ?bool
	{
		return $this->isPresent;
	}

	public function setIsPresent(?bool $isPresent): self
	{
		$this->isPresent = $isPresent;

		return $this;
	}

	public function getIsAbsent(): ?bool
	{
		return $this->isAbsent;
	}

	public function setIsAbsent(?bool $isAbsent): self
	{
		$this->isAbsent = $isAbsent;

		return $this;
	}

	public function getIsLate(): ?bool
	{
		return $this->isLate;
	}

	public function setIsLate(?bool $isLate): self
	{
		$this->isLate = $isLate;

		return $this;
	}

	public function getIsExcused(): ?bool
	{
		return $this->isExcused;
	}

	public function setIsExcused(?bool $isExcused): self
	{
		$this->isExcused = $isExcused;

		return $this;
	}

	public function getStatus(): ?string
	{
		return $this->status;
	}

	public function setStatus(string $status): self
	{
		$this->status = $status;

		switch ($status) {
			case 'P':
			$this->setIsPresent(true);
			$this->setIsAbsent(FALSE);
			$this->setIsExcused(FALSE);
			$this->setIsLate(FALSE);
			break;

			case 'A':
			$this->setIsPresent(FALSE);
			$this->setIsAbsent(true);
			$this->setIsExcused(FALSE);
			$this->setIsLate(FALSE);
			break;

			case 'R':
			$this->setIsPresent(true);
			$this->setIsAbsent(FALSE);
			$this->setIsExcused(true);
			$this->setIsLate(FALSE);
			break;

			case 'E':
			$this->setIsPresent(FALSE);
			$this->setIsAbsent(true);
			$this->setIsExcused(true);
			$this->setIsLate(FALSE);
			break;
		}

		return $this;
	}
}
