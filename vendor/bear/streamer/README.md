# BEAR.Streamer

### A HTTP stream responder

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bearsunday/BEAR.Streamer/badges/quality-score.png)](https://scrutinizer-ci.com/g/bearsunday/BEAR.Streamer/)
[![codecov](https://codecov.io/gh/bearsunday/BEAR.Streamer/branch/1.x/graph/badge.svg?token=eh3c9AF4Mr)](https://codecov.io/gh/koriym/BEAR.Streamer)
[![Type Coverage](https://shepherd.dev/github/bearsunday/BEAR.Streamer/coverage.svg)](https://shepherd.dev/github/bearsunday/BEAR.Streamer)
![Continuous Integration](https://github.com/bearsunday/BEAR.Streamer/workflows/Continuous%20Integration/badge.svg)

Assign stream resource to resource-body.

```php
class Image extends ResourceObject
{
    use StreamTransferInject;

    public function onGet(string $name = 'inline image') : ResourceObject
    {
        $fp = fopen(__DIR__ . '/BEAR.jpg', 'r');
        stream_filter_append($fp, 'convert.base64-encode'); // image base64 format
        $this->body = [
            'name' => $name,
            'image' => $fp
        ];

        return $this;
    }
}
```

Or assign entire body.

```php
class Download extends ResourceObject
{
    use StreamTransferInject;

    public $headers = [
        'Content-Type' => 'image/jpeg',
        'Content-Disposition' => 'attachment; filename="image.jpg"'
    ];

    public function onGet() : ResourceObject
    {
        $fp = fopen(__DIR__ . '/BEAR.jpg', 'r');
        $this->body = $fp;

        return $this;
    }
}
```

Http body will not be output at once with "echo", Instead streamed with low memory consumption.
