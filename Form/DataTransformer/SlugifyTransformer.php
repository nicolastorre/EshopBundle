<?php
// src/Nicolas/BlogBundle/Form/DataTransformer/SugifyTransformer.php
namespace Nicolas\BlogBundle\Form\DataTransformer;

use AppBundle\Entity\Issue;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class SlugifyTransformer implements DataTransformerInterface
{

    /**
     * Transforms an object (issue) to a string (number).
     *
     * @param  $slug
     * @return string
     */
    public function transform($slug)
    {

        return $slug;
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $slug
     * @return strig
     */
    public function reverseTransform($slug)
    {

        return str_replace(' ','-', $slug);
    }
}