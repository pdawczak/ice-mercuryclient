<?php
namespace Ice\MercuryClientBundle\External\Entity;

interface CourseInterface
{
    /**
     * The four letter CUFS cost centre for this course's fees
     *
     * @return string
     */
    public function getCostCentre();

    /**
     * Course start date (00:00 on the first day the course runs)
     *
     * @return \DateTime
     */
    public function getStartDate();

    /**
     * Course title
     *
     * @return string
     */
    public function getTitle();
}