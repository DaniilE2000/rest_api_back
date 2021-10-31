<?php

namespace API;

use classes\UniqueID;

const STORE_LOCATION = 'store/ids.json';

/**
 * Get a store contents.
 * 
 * @return array A current store state.
 */
function getStore(): array
{
    if (file_exists(STORE_LOCATION)) {
        $jsonStore = \json_decode(\file_get_contents(STORE_LOCATION), true);
        if ($jsonStore !== null) {
            return $jsonStore;
        }
    } else {
        $directory = \explode('/', STORE_LOCATION)[0];
        if (!is_dir($directory)) {
            \mkdir($directory);
        }
    }

    return [];
}

/**
 * Override existing store state.
 * 
 * @param array $newStoreState A store state to upload.
 * 
 * @return void
 */
function setStore(array $newStoreState): void
{
    \file_put_contents(STORE_LOCATION, \json_encode($newStoreState), LOCK_EX);
}

/**
 * Generates new number and uploads it to the store.
 * 
 * @param int $boundStart A starting bound of output number.
 * @param int $boundEnd   An ending bound of output number.
 * 
 * @return string An id of uploaded number.
 */
function generate(int $boundStart, int $boundEnd): string
{
    $uId = new UniqueID($boundStart, $boundEnd);
    $jsonStore = getStore();

    $jsonStore[$uId->id] = $uId->number;
    setStore($jsonStore);
    return $uId->id;
}

/**
 * Get a number from store by id.
 * 
 * @param string|null $id An id by which to retrieve number.
 * 
 * @return int|null A number, if there any, or null otherwise.
 */
function get(string|null $id): int|null
{
    if (isset($id)) {
        $jsonStore = getStore();
        if (isset($jsonStore[$id])) {
            return $jsonStore[$id];
        }
    }

    return null;
}

?>
