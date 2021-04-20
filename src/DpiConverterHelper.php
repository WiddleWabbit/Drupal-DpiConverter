<?php

namespace Drupal\dpi_converter;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\File\FileSystemInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Drupal\dpi_converter\DpiConverterHelperInterface;
use Imagick;

class DpiConverterHelper implements DpiConverterHelperInterface {

    /**
     * @var FileSystemInterface
     */
    private $fileSystem;

    /**
     * DpiConverterHelper Constructor
     * @param ConfigFacytoryInterface $config_factory
     * @param FileSystemInterface $file_system
     * @param LoggerChannelFactoryInterface $logger
     */
    public function __construct(LoggerChannelFactoryInterface $logger) {
        $this->loggerFactory = $logger;
    }

    /**
     * Resave the image over itself with the new DPI defined
     *
     * @param string $imagepath
     * @param float $x_dpi
     * @param float $y_dpi
     * @return boolean
     */
    public function convertImage($imagepath, $x_dpi, $y_dpi) {

        // Check the file exists
        if (!file_exists($imagepath)) {
            $this->loggerFactory->get('dpi_converter')->error('The file %imagepath does not exist or is not accessible.', ['%imagepath' => $imagepath]);
            return FALSE;
        }

        // Check the file/directory is writeable
        if (!is_writable($imagepath)) {
            $this->loggerFactory->get('dpi_converter')->error('The file %imagepath is not writable.', ['%imagepath' => $imagepath]);
            return FALSE;
        }

        // Create a new imagick instance
        $this->imagick = new Imagick();
        // Read the image given
        $this->imagick->readImage($imagepath);
        // Set the image resolution
        $this->imagick->setImageResolution($x_dpi, $y_dpi);
        // Set the image format to save to
        $this->imagick->setImageFormat("jpeg");
        // Resave the image over itself
        file_put_contents($imagepath, $this->imagick);

        return TRUE;

    }

}
