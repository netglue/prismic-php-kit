<?php
declare(strict_types=1);

namespace Prismic\Document\Fragment\Link;

use Prismic\Document\Fragment\LinkInterface;
use Prismic\DocumentInterface;
use Prismic\LinkResolver;

class DocumentLink extends AbstractLink
{

    /** @var LinkResolver */
    private $linkResolver;

    /** @var string */
    private $id;

    /** @var string|null */
    private $uid;

    /** @var string */
    private $type;

    /** @var string|null */
    private $slug;

    /** @var array */
    private $tags;

    /** @var string|null */
    private $lang;

    /** @var bool */
    private $isBroken;

    public static function linkFactory($value, LinkResolver $linkResolver) : LinkInterface
    {
        /** @var DocumentLink $link */
        $link = new static();
        $link->linkResolver = $linkResolver;
        $value = isset($value->value) ? $value->value : $value;
        $link->isBroken = isset($value->isBroken) ? $value->isBroken : false;
        $data = isset($value->document) ? (array) $value->document : (array) $value;
        $keys = [
            'id', 'type', 'tags', 'slug', 'lang', 'uid', 'target'
        ];
        \array_walk($keys, function ($key) use ($data, $link) {
            $link->{$key} = isset($data[$key]) ? $data[$key] : null;
        });
        return $link;
    }

    public static function withDocument(DocumentInterface $document, LinkResolver $linkResolver) : DocumentLink
    {
        $link               = new static;
        $link->linkResolver = $linkResolver;
        $link->id           = $document->getId();
        $link->uid          = $document->getUid();
        $link->type         = $document->getType();
        $link->slug         = $document->getSlug();
        $link->tags         = $document->getTags();
        $link->lang         = $document->getLang();
        $link->isBroken     = false;
        return $link;
    }

    public function getUrl() :? string
    {
        return $this->linkResolver->resolve($this);
    }

    public function getId() :? string
    {
        return $this->id;
    }

    public function getUid() :? string
    {
        return $this->uid;
    }

    public function getType() :? string
    {
        return $this->type;
    }

    public function getTags() :? array
    {
        return $this->tags;
    }

    public function getSlug() :? string
    {
        return $this->slug;
    }

    public function getLang() :? string
    {
        return $this->lang;
    }

    public function getTarget() : ?string
    {
        return $this->target;
    }

    public function isBroken() : bool
    {
        return $this->isBroken;
    }
}
