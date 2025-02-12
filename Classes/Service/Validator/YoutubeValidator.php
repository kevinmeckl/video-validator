<?php

declare(strict_types=1);

namespace Ayacoo\VideoValidator\Service\Validator;

use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\OnlineMedia\Helpers\YouTubeHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class YoutubeValidator extends AbstractVideoValidator
{
    private YouTubeHelper $youtubeHelper;

    public function __construct(string $extension = '')
    {
        $this->youtubeHelper = GeneralUtility::makeInstance(YouTubeHelper::class, $extension);
    }

    /**
     * Get oEmbed url to retrieve oEmbed data
     * We use here the function 1:1 from the core, since this is unfortunately not public
     *
     * @param string $mediaId
     * @param string $format
     * @return string
     */
    public function getOEmbedUrl(string $mediaId, string $format = 'json'): string
    {
        return sprintf(
            'https://www.youtube.com/oembed?url=%s&format=%s',
            rawurlencode(sprintf('https://www.youtube.com/watch?v=%s', rawurlencode($mediaId))),
            rawurlencode($format)
        );
    }

    public function getOnlineMediaId(File $file): string
    {
        return $this->youtubeHelper->getOnlineMediaId($file);
    }

    public function buildUrl(string $mediaId): string
    {
        return 'https://www.youtube.com/watch?v=' . $mediaId;
    }
}
