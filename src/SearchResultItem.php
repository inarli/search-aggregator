<?php


namespace SearchAggregator;

/**
 * Class SearchResultItem
 * @package SearchAggregator
 */
class SearchResultItem
{
    /** @var string */
    private $url;

    /** @var string */
    private $title;

    /** @var array */
    private $source = [];

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array
     */
    public function getSource(): array
    {
        return $this->source;
    }

    /**
     * @param string $source
     * @return $this
     */
    public function addSource(string $source): self
    {
        $this->source[] = $source;
        return $this;
    }
}
