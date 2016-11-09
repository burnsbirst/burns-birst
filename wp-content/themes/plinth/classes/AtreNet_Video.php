<?php
/**
 * Container for constants identifying various video platforms.
 *
 */
class AtreNet_VideoPlatform {
  /**
   * Identifier for Vimeo video platform
   *
   * @var int
   */
  const VIMEO = 1;

  /**
   * Identifier for Youtube video platform
   *
   * @var int
   */
  const YOUTUBE = 2;
}

/**
 * Class to manage video details pulled via video platform APIs.
 *
 * Currently supports Vimeo and YouTube.
 *
 * @package AtreNet
 */
class AtreNet_Video {
  /**
   * The URL of this video
   *
   * @var string
   */
  private $videoUrl;

  /**
   * The ID of this video (assigned by the platform on which it is hosted)
   *
   * @var string
   */
  private $videoId;

  /**
   * The details of this video (assigned by the platform on which it is hosted)
   *
   * @var array
   */
  private $videoDetails;

  /**
   * Platform on which this video is hosted.
   *
   * One of the class constants defined in AtreNet_VideoPlatform
   *
   * @var int
   */
  private $videoPlatform;

  /**
   * Constructor
   *
   * @param string $videoUrl URL of video
   */
  public function __construct($videoUrl) {
    $this->videoUrl = $videoUrl;
    $this->videoId = self::parseVideoIdFromUrl($videoUrl);
    $this->videoPlatform = self::parseVideoPlatformFromUrl($videoUrl);
  }

  /**
   * Parse video ID from a givel URL
   *
   * @param string $videoUrl URL to parse
   *
   * @return string
   * @throws RuntimeException upon failure to determine video ID
   */
  public static function parseVideoIdFromUrl($videoUrl) {
    if(strpos($videoUrl, 'vimeo.com') !== false || strpos($videoUrl, 'youtu.be') !== false) {
      if(1 === preg_match('/(?:vimeo\.com|youtu\.be)(?:\/.+)*\/([^?\/]+).*?$/', $videoUrl, $matches)) {
        return $matches[1];
      }
    } elseif(strpos($videoUrl, 'youtube.com') !== false) {
      if(1 === preg_match('/v=([^&\/]+)/', $videoUrl, $matches)) {
        return $matches[1];
      }
    }

    throw new RuntimeException('Failed to determine video ID from URL.');
  }

  /**
   * Parse video platform from a given URL
   *
   * @param string $videoUrl URL to parse
   *
   * @return int One of the constants defined in AtreNet_VideoPlatform
   * @throws RuntimeException upon failure to determine video platform
   */
  public static function parseVideoPlatformFromUrl($videoUrl) {
    if(strpos($videoUrl, 'vimeo.com') !== false) {
      return AtreNet_VideoPlatform::VIMEO;
    }
    if(strpos($videoUrl, 'youtu.be') !== false || strpos($videoUrl, 'youtube.com') !== false) {
      return AtreNet_VideoPlatform::YOUTUBE;
    }

    throw new RuntimeException('Failed to determine video platform from URL.');
  }

  /**
   * Get HTML embed code for this video
   *
   * @param int $width  Desired width of embedded video
   * @param int $height Desired height of embedded video
   *
   * @return string
   */
  public function getEmbedCode($width = '', $height = '') {
    if($this->getVideoPlatform() === AtreNet_VideoPlatform::VIMEO) {
      return sprintf('<iframe width="%s" height="%s" src="//player.vimeo.com/video/%s" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>',
        empty($width) ? 500 : $width,
        empty($height) ? 281 : $height,
        $this->getVideoCode()
      );
    } elseif($this->getVideoPlatform() === AtreNet_VideoPlatform::YOUTUBE) {
      return sprintf('<iframe width="%s" height="%s" src="//www.youtube.com/embed/%s" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>',
        empty($width) ? 560 : $width,
        empty($height) ? 315 : $height,
        $this->getVideoId()
      );
    }

    return '';
  }

  /**
   * Getter for video ID
   *
   * @return string
   */
  public function getVideoId() {
    return $this->videoId;
  }

  /**
   * Getter for video platform
   *
   * @return int
   */
  public function getVideoPlatform() {
    return $this->videoPlatform;
  }

  /**
   * Getter for video URL
   *
   * @return string
   */
  public function getVideoUrl() {
    return $this->videoUrl;
  }

  /**
   * Get video details via video platform API
   *
   * @return array
   * @throws RuntimeException If video details could not be retrieved or parsed
   */
  public function getVideoDetails() {
    if($this->getVideoPlatform() === AtreNet_VideoPlatform::VIMEO) {
      if(false !== ($data = file_get_contents(sprintf('http://vimeo.com/api/v2/video/%s.php', $this->getVideoId())))) {
        $data = unserialize($data);
        return array(
          'url'         => $this->getVideoUrl(),
          'title'       => $data[0]['title'],
          'width'       => $data[0]['width'],
          'height'      => $data[0]['height'],
          'duration'    => $data[0]['duration'],
          'description' => $data[0]['description'],
          'thumbnail'   => $data[0]['thumbnail_large'],
        );
      }
    } elseif($this->getVideoPlatform() === AtreNet_VideoPlatform::YOUTUBE) {
      if(false !== ($data = file_get_contents(sprintf('https://gdata.youtube.com/feeds/api/videos/%s?v=2&alt=json', $this->getVideoId())))) {
        if($data = json_decode($data)) {
          return array(
            'url'         => $this->getVideoUrl(),
            'title'       => $data->entry->title->{'$t'},
            'duration'    => $data->entry->{'media$group'}->{'yt$duration'}->seconds,
            'description' => $data->entry->{'media$group'}->{'media$description'}->{'$t'},
            #'thumbnail'   => $data->entry->{'media$group'}->{'media$thumbnail'}[1]->url
            'thumbnail'   => sprintf('//img.youtube.com/vi/%s/mqdefault.jpg', $this->getVideoId())
          );
        }
      }
    }

    throw new RuntimeException('Failed to retrieve video details.');
  }
}

