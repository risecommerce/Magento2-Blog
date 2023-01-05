<?php
/**
 * Copyright © Risecommerce (support@risecommerce.com). All rights reserved.
 * 
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Risecommerce\Blog\Api;

interface ShortContentExtractorInterface
{
    /**
     * Retrieve short filtered content
     * @param string$content
     * @param mixed $len
     * @param mixed $endCharacters
     * @return string
     * @throws \Exception
     */
    public function execute($content, $len = null, $endCharacters = null);

}
