<?php

namespace Kuai6\EventBus\Message;

use Kuai6\EventBus\Message\Header\GenericHeader;
use Kuai6\EventBus\Message\Header\HeaderInterface;

/**
 * Class Headers
 * @package Kuai6\EventBus\Message
 */
class Headers implements \Countable, \Iterator
{

    /**
     * @var array Array of header array information or Header instances
     */
    protected $headers = [];

    /**
     * @var HeaderLoader
     */
    protected $headerLoader;

    /**
     * @var array key names for $headers array
     */
    protected $headersKeys = [];

    /**
     * @param $string
     * @return static
     */
    public function fromString($string)
    {
        $headers = new static();
        $emptyLine = 0;
        $current = [];

        // iterate the header lines, some might be continuations
        foreach (explode("\r\n", $string) as $line) {
            // CRLF*2 is end of headers; an empty line by itself or between header lines
            // is an attempt at CRLF injection.
            if (preg_match('/^\s*$/', $line)) {
                // empty line indicates end of headers
                $emptyLine += 1;
                if ($emptyLine > 2) {
                    throw new Exception\RuntimeException('Malformed header detected');
                }
                continue;
            }

            if ($emptyLine) {
                throw new Exception\RuntimeException('Malformed header detected');
            }

            // check if a header name is present
            if (preg_match('/^(?P<name>[^()><@,;:\"\\/\[\]?={} \t]+):.*$/', $line, $matches)) {
                if ($current) {
                    // a header name was present, then store the current complete line
                    $headers->headersKeys[] = static::createKey($current['name']);
                    $headers->headers[]     = $current;
                }
                $current = [
                    'name' => $matches['name'],
                    'line' => trim($line)
                ];

                continue;
            }

            if (preg_match("/^[ \t][^\r\n]*$/", $line, $matches)) {
                // continuation: append to current line
                $current['line'] .= trim($line);
                continue;
            }

            // Line does not match header format!
            throw new Exception\RuntimeException(sprintf(
                'Line "%s" does not match header format!',
                $line
            ));
        }
        if ($current) {
            $headers->headersKeys[] = static::createKey($current['name']);
            $headers->headers[]     = $current;
        }
        return $headers;
    }

    /**
     * @return HeaderLoader
     */
    public function getHeaderLoader(): HeaderLoader
    {
        if ($this->headerLoader === null) {
            $this->headerLoader = new HeaderLoader();
        }

        return $this->headerLoader;
    }

    /**
     * @param HeaderLoaderInterface $headerLoader
     * @return $this
     */
    public function setHeaderLoader(HeaderLoaderInterface $headerLoader)
    {
        $this->headerLoader = $headerLoader;
        return $this;
    }

    /**
     * Add a raw header line, either in name => value, or as a single string 'name: value'
     *
     * This method allows for lazy-loading in that the parsing and instantiation of Header object
     * will be delayed until they are retrieved by either get() or current()
     *
     * @throws Exception\InvalidArgumentException
     * @param string $headerFieldNameOrLine
     * @param string $fieldValue optional
     * @return Headers
     */
    public function addHeaderLine($headerFieldNameOrLine, $fieldValue = null)
    {
        $matches = null;
        if (preg_match('/^(?P<name>[^()><@,;:\"\\/\[\]?=}{ \t]+):.*$/', $headerFieldNameOrLine, $matches)
            && $fieldValue === null) {
            // is a header
            $headerName = $matches['name'];
            $headerKey  = static::createKey($matches['name']);
            $line = $headerFieldNameOrLine;
        } elseif ($fieldValue === null) {
            throw new Exception\InvalidArgumentException('A field name was provided without a field value');
        } else {
            $headerName = $headerFieldNameOrLine;
            $headerKey  = static::createKey($headerFieldNameOrLine);
            if (is_array($fieldValue)) {
                $fieldValue = implode(', ', $fieldValue);
            }
            $line = $headerFieldNameOrLine . ': ' . $fieldValue;
        }

        $this->headersKeys[] = $headerKey;
        $this->headers[]     = ['name' => $headerName, 'line' => $line];

        return $this;
    }

    /**
     * Add a Header to this container, for raw values @see addHeaderLine() and addHeaders()
     *
     * @param  HeaderInterface $header
     * @return Headers
     */
    public function addHeader(HeaderInterface $header)
    {
        $this->headersKeys[] = static::createKey($header->getFieldName());
        $this->headers[]     = $header;

        return $this;
    }

    /**
     * Remove a header string
     *
     * @param string $header
     * @return bool
     */
    public function remove($header)
    {
        if ($this->has($header)) {
            $index = array_search($header, $this->headersKeys, true);
            if ($index !== false) {
                unset($this->headersKeys[$index], $this->headers[$index]);
                return true;
            }
        }
        return false;
    }

    /**
     * Remove a Header from the container
     *
     * @param HeaderInterface $header
     * @return bool
     */
    public function removeHeader(HeaderInterface $header)
    {
        $index = array_search($header, $this->headers, true);
        if ($index !== false) {
            unset($this->headersKeys[$index]);
            unset($this->headers[$index]);

            return true;
        }
        return false;
    }

    /**
     * Clear all headers
     *
     * Removes all headers from queue
     *
     * @return Headers
     */
    public function clearHeaders()
    {
        $this->headers = $this->headersKeys = [];
        return $this;
    }


    /**
     * Get all headers of a certain name/type
     *
     * @param  string $name
     * @return bool|HeaderInterface
     * @throws  \Kuai6\EventBus\Message\Exception\InvalidArgumentException
     */
    public function get($name)
    {
        $key = static::createKey($name);
        if (!in_array($key, $this->headersKeys)) {
            return false;
        }

        $index = array_search($key, $this->headersKeys);
        if ($index === false) {
            return false;
        }

        if (is_array($this->headers[$index])) {
            return $this->lazyLoadHeader($index);
        }
        return $this->headers[$index];
    }

    /**
     * Test for existence of a type of header
     *
     * @param  string $name
     * @return bool
     */
    public function has($name)
    {
        return in_array(static::createKey($name), $this->headersKeys);
    }

    /**
     * Return the current element
     */
    public function current()
    {
        $current = current($this->headers);
        if (is_array($current)) {
            $current = $this->lazyLoadHeader(key($this->headers));
        }
        return $current;
    }

    /**
     * Move forward to next element
     */
    public function next(): void
    {
        next($this->headers);
    }

    /**
     * Return the key of the current element
     */
    public function key()
    {
        return (key($this->headers));
    }

    /**
     * Checks if current position is valid
     */
    public function valid()
    {
        return (current($this->headers) !== false);
    }

    /**
     * Rewind the Iterator to the first element
     */
    public function rewind(): void
    {
        reset($this->headers);
    }

    /**
     * Count elements of an object
     */
    public function count(): int
    {
        return count($this->headers);
    }

    /**
     * Create array key from header name
     *
     * @param string $name
     * @return string
     */
    protected static function createKey($name)
    {
        return str_replace(['-', '_', ' ', '.'], '', strtolower($name));
    }

    /**
     * @param $index
     * @return mixed
     * @throws  \Kuai6\EventBus\Message\Exception\InvalidArgumentException
     */
    protected function lazyLoadHeader($index)
    {
        $current = $this->headers[$index];
        if ($current instanceof HeaderInterface) {
            return $current;
        }

        $key = $this->headersKeys[$index];
        /** @var HeaderInterface $class */
        $class = ($this->getHeaderLoader()->isLoaded($key)) ? $this->getHeaderLoader()->load($key) : false;
        if ($class === false) {
            $class = GenericHeader::class;
        }
        /** @var HeaderInterface $header */
        $header = $class::fromString($current['line']);

        $this->headers[$index] = $header;
        return $header;
    }

    /**
     * Render all headers at once
     *
     * This method handles the normal iteration of headers; it is up to the
     * concrete classes to prepend with the appropriate status/request line.
     *
     * @return string
     */
    public function toString()
    {
        $headers = '';
        foreach ($this->toArray() as $fieldName => $fieldValue) {
            $headers .= $fieldName . ': ' . $fieldValue . "\r\n";
        }
        return $headers;
    }

    /**
     * Return the headers container as an array
     *
     * @return array
     */
    public function toArray()
    {
        $headers = [];
        /* @var $header Header\HeaderInterface */
        foreach ($this->headers as $header) {
            if ($header instanceof Header\HeaderInterface) {
                $headers[$header->getFieldName()] = $header->getFieldValue();
            } else {
                $matches = null;
                preg_match('/^(?P<name>[^()><@,;:\"\\/\[\]?=}{ \t]+):\s*(?P<value>.*)$/', $header['line'], $matches);
                if ($matches) {
                    $headers[$matches['name']] = $matches['value'];
                }
            }
        }
        return $headers;
    }
}
