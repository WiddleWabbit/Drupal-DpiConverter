<?php

namespace Drupal\dpi_converter;

/**
 * Define a interface for the dpi converter class.
 */
interface DpiConverterHelperInterface {

    /**
     * Resave the image over itself with the new DPI defined
     *
     * @param string $imagepath
     * @param float $x_dpi
     * @param float $y_dpi
     * @return boolean
     */
    public function convertImage($imagepath, $x_dpi, $y_dpi);

}
