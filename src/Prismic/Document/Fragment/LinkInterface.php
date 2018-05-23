<?php
declare(strict_types=1);

namespace Prismic\Document\Fragment;

interface LinkInterface extends FragmentInterface
{

    public function getUrl() :? string;

    public function getId() :? string;

    public function getUid() :? string;

    public function getType() :? string;

    public function getTags() :? array;

    public function getSlug() :? string;

    public function getLang() :? string;

    public function getTarget() :? string;

    public function isBroken() : bool;

    public function __toString() : string;

    public function openTag() : ?string;

    public function closeTag() :? string;
}
