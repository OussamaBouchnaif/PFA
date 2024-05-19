<?php

namespace App\Service\Api\Cameras;

interface CameraFetcherInterface
{
   /**
     * Retrieves a paginated list of all cameras.
     *
     * @param int $page The page number to retrieve.
     * @return array The list of cameras for the specified page.
     */
    public function getAllCamera(int $page): array;

    /**
     * Retrieves a camera by its ID.
     *
     * @param int $id The ID of the camera to retrieve.
     * @return mixed The camera corresponding to the specified ID, or null if no camera is found.
     */
    public function getCameraById(int $id);

    /**
     * Retrieves the total number of cameras.
     *
     * @return int The total number of cameras.
     */
    public function getItems(): int;

    /**
     * Searches for cameras based on the specified search criteria.
     *
     * @param array $searchCriteria The search criteria as an associative array.
     * @return array The list of cameras matching the search criteria.
     */
    public function searchBy(array $searchCriteria): array;

    /**
     * Retrieves the most recently added cameras.
     *
     * @return array The list of the most recently added cameras.
     */
    public function getLastCameras(): array;

    /**
     * Retrieves the most ordered cameras.
     *
     * @return array The list of cameras.
     */
    public function CameratheMostOrders():array;

    /**
     * Retrieves related cameras to a specific.
     *
     * @return array The list of cameras.
     */
    public function getRelatedCameras(int $id):array;
    
}
