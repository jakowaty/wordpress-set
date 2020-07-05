<?php declare(strict_types = 1);

namespace Jak\Wordpress\Util\Image;

class ImageViewHelper
{
    public static function create(int $postId): self
    {
        $post = get_post($postId);

        if (!($post instanceof \WP_Post)) {
            throw new \Exception("Post $postId not exists");
        }

        return new static(\jakit_get_post_images_array($post));
    }

    private $images = [];
    private $imagesAsKeys = [];
    private $current = null;
    private $currentNumeric = null;

    private function __construct(array $images)
    {
        $this->images = $images;
        $this->imagesAsKeys = \array_keys($images);
    }

    public function setCurrent(string $current): self
    {
        if (!\array_key_exists($current, $this->images)) {
            throw new \Exception("Current key must exist");
        }

        $this->current = $current;
        $this->currentNumeric = \array_flip($this->imagesAsKeys)[$current];
        return $this;
    }

    public function getNextLink(): ?array
    {
        if (null === $this->current || null === $this->currentNumeric) {
            return null;
        }

        if (($this->currentNumeric + 1) >= \count($this->images)) {
            return null;
        }

        return [
            $this->imagesAsKeys[$this->currentNumeric + 1] =>
                $this->images[$this->imagesAsKeys[$this->currentNumeric + 1]]
        ];
    }

    public function getPreviousLink(): ?array
    {
        if (null === $this->current || null === $this->currentNumeric) {
            return null;
        }

        if ($this->currentNumeric <= 0) {
            return null;
        }

        return [
            $this->imagesAsKeys[$this->currentNumeric - 1] =>
                $this->images[$this->imagesAsKeys[$this->currentNumeric - 1]]
        ];
    }
}